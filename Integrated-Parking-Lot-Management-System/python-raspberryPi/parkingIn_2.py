import cv2
import numpy as np
import pytesseract
from datetime import datetime
import time
import pymysql
import serial
import spidev
import pygame

# SPI, mysql, 시리얼통신, sound 재생을 사용하기 위한 초기화.
spi = spidev.SpiDev()
spi.open(0, 0)
spi.max_speed_hz = 1000000

db = None
cur = None

ser = serial.Serial('/dev/ttyACM0', 9600)
ser.reset_input_buffer()

parking_state = [0, 0, 0, 0, 0, 0]

pygame.init()
sound1 = pygame.mixer.Sound('/home/pi/mp3/01wait.wav')
pygame.mixer.music.load('/home/pi/mp3/02impossible.wav')
sound_control = True
time.sleep(1.)

# 메인 반복구간.
while True:
    # 시리얼 통신으로 차량 접근 감지.
    while True:
        # 시리얼 통신으로 잘못된 데이터가 넘어왔을 경우의 오류를 방지하기 위한 try except.
        try:
            dustVal = ser.readline().rstrip()
            print(dustVal)
            r = dustVal.split()
            ir = r[1:]
            ir_int = list(map(int, ir))
            # 주차자리가 꽉찬 상태에서 초음파센서 정보가 10보다 작으면.
            if sum(ir_int) == 6 and float(r[0]) < 10:
                # 재생중이 아닐때만 진입불가 음성 재생하고 continue로 재시도.
                if not pygame.mixer.music.get_busy():
                    pygame.mixer.music.play()
                time.sleep(1.)
                continue
            # 초음파센서 정보가 10보다 작으면 다음 단계로.
            if float(r[0]) < 10:
                time.sleep(1.)
                break
        except:
            continue

    # 사운드재생이 가능한 상태일때 대기사운드 재생하고 재생 방지.
    if sound_control:
        sound1.play()
        sound_control = False

    # 번호판 인식중 오류가 발생할 경우를 방지하기 위한 try except.
    try:
        # 카메라로 사진을 찍어 640*480의 graysacle로 변환.
        cap = cv2.VideoCapture(0, cv2.CAP_V4L)

        if not cap.isOpened():
            print('[!] camera open failed!')
            continue

        while True:
            ret, frame = cap.read()
            if ret:
                img_ori = frame.copy()
                break
        cap.release()

        img_ori = cv2.resize(img_ori, (640, 480))

        height, width, channel = img_ori.shape
        print(height, width, channel)

        gray = cv2.cvtColor(img_ori, cv2.COLOR_BGR2GRAY)

        # 가우시안블러를 사용하여 노이즈를 줄인 후 이미지의 이진화 수행.
        img_blurred = cv2.GaussianBlur(gray, ksize=(5, 5), sigmaX=0)

        img_blur_thresh = cv2.adaptiveThreshold(
            img_blurred,
            maxValue=255.0,
            adaptiveMethod=cv2.ADAPTIVE_THRESH_GAUSSIAN_C,
            thresholdType=cv2.THRESH_BINARY_INV,
            blockSize=19,
            C=9
        )

        # 가우시안블러 없이 이미지의 이진화 수행.
        img_thresh = cv2.adaptiveThreshold(
            gray,
            maxValue=255.0,
            adaptiveMethod=cv2.ADAPTIVE_THRESH_GAUSSIAN_C,
            thresholdType=cv2.THRESH_BINARY_INV,
            blockSize=19,
            C=9
        )

        # 이미지에서 컨투어(윤곽선) 찾기.
        contours, _ = cv2.findContours(
            img_blur_thresh,
            mode=cv2.RETR_LIST,
            method=cv2.CHAIN_APPROX_SIMPLE
        )

        # 컨투어를 감싸는 사각형을 구하고 좌표 정보 저장.
        contours_dict = []

        for contour in contours:
            x, y, w, h = cv2.boundingRect(contour)

            contours_dict.append({
                'contour': contour,
                'x': x,
                'y': y,
                'w': w,
                'h': h,
                'cx': x + (w / 2),
                'cy': y + (h / 2)
            })

        # 숫자의 특성을 가진 컨투어를 선별하기 위한 값.
        MIN_AREA = 500  # 컨투어의 최소 넓이.
        MIN_WIDTH, MIN_HEIGHT = 2, 8  # 컨투어의 최소 너비, 높이.
        MIN_RATIO, MAX_RATIO = 0.25, 1.0  # 컨투어의 최소, 최대 가로세로 비율.

        # 넓이와 비율을 만족하는 컨투어 중에 최소 너비, 높이보다 큰 컨투어를 선택.
        possible_contours = []

        cnt = 0
        for d in contours_dict:
            area = d['w'] * d['h']
            ratio = d['w'] / d['h']

            if area > MIN_AREA and d['w'] > MIN_WIDTH and d['h'] > MIN_HEIGHT and MIN_RATIO < ratio < MAX_RATIO:
                d['idx'] = cnt
                cnt += 1
                possible_contours.append(d)

        # 번호판의 특성을 가지는 컨투어집합을 선별하기 위한 값.
        MAX_DIAG_MULTIPLYER = 5  # 컨투어간 거리제한.(대각선 길이의 배수)
        MAX_ANGLE_DIFF = 12.0  # 컨투어간 각도차이.
        MAX_AREA_DIFF = 0.5  # 컨투어간 영역차이.
        MAX_WIDTH_DIFF = 0.8  # 컨투어간 너비차이.
        MAX_HEIGHT_DIFF = 0.2  # 컨투어간 높이차이.
        MIN_N_MATCHED = 3  # 컨투어 최소 개수.

        # 번호판 영역을 찾는 함수.
        def find_chars(contour_list):
            matched_result_idx = []

            for d1 in contour_list:
                matched_contours_idx = []
                # 같은 컨투어는 건너 뜀.
                for d2 in contour_list:
                    if d1['idx'] == d2['idx']:
                        continue

                    # 컨투어 중심간의 거리 x, y의 차이를 구함.
                    dx = abs(d1['cx'] - d2['cx'])
                    dy = abs(d1['cy'] - d2['cy'])

                    # 컨투어의 대각선 길이와 비교할 컨투어와의 거리를 구함.
                    diagonal_length1 = np.sqrt(d1['w'] ** 2 + d1['h'] ** 2)
                    distance = np.linalg.norm(np.array([d1['cx'], d1['cy']]) - np.array([d2['cx'], d2['cy']]))

                    # dx dy를 통해 컨투어간 각도 계산.
                    if dx == 0:
                        angle_diff = 90
                    else:
                        angle_diff = np.degrees(np.arctan(dy / dx))

                    # 면적, 너비, 높이의 차이 계산.
                    area_diff = abs(d1['w'] * d1['h'] - d2['w'] * d2['h']) / (d1['w'] * d1['h'])
                    width_diff = abs(d1['w'] - d2['w']) / d1['w']
                    height_diff = abs(d1['h'] - d2['h']) / d1['h']

                    # 모든 차이값이 위에서 정한 수치보다 작으면 두 컨투어를 후보군으로 결정.
                    if distance < diagonal_length1 * MAX_DIAG_MULTIPLYER and angle_diff < MAX_ANGLE_DIFF \
                            and area_diff < MAX_AREA_DIFF and width_diff < MAX_WIDTH_DIFF \
                            and height_diff < MAX_HEIGHT_DIFF:
                        matched_contours_idx.append(d2['idx'])

                matched_contours_idx.append(d1['idx'])

                # 후보군의 컨투어 개수가 적으면 탈락, 충분하면 최종 후보군으로 결정.
                if len(matched_contours_idx) < MIN_N_MATCHED:
                    continue

                matched_result_idx.append(matched_contours_idx)

                # 최종 후보군이 아닌 컨투어들을 따로 모아 재귀적 탐색.
                unmatched_contour_idx = []
                for d4 in contour_list:
                    if d4['idx'] not in matched_contours_idx:
                        unmatched_contour_idx.append(d4['idx'])

                unmatched_contour = np.take(possible_contours, unmatched_contour_idx)

                recursive_contour_list = find_chars(unmatched_contour)

                # 재귀적 탐색에서 선택된 컨투어도 최종 후보군으로 결정.
                for idx in recursive_contour_list:
                    matched_result_idx.append(idx)

                break

            return matched_result_idx


        # 만든 함수를 통해 번호판의 특성을 가지는 컨투어 집합을 탐색.
        result_idx = find_chars(possible_contours)

        matched_result = []
        for idx_list in result_idx:
            matched_result.append(np.take(possible_contours, idx_list))

        # 번호판으로 추정된 영역을 잘라내기 위한 값.
        PLATE_WIDTH_PADDING = 1.3  # 너비 여분.
        PLATE_HEIGHT_PADDING = 1.5  # 높이 여분.
        MIN_PLATE_RATIO = 3  # 번호판 가로세로비 최소값.
        MAX_PLATE_RATIO = 10  # 번호판 가로세로비 최대값.

        plate_imgs = []
        plate_infos = []

        for i, matched_chars in enumerate(matched_result):
            # 후보군의 컨투어들을 x방향 순서로 정렬.
            sorted_chars = sorted(matched_chars, key=lambda x: x['cx'])

            # 컨투어 집합의 중심좌표, 너비, 높이를 구함.
            plate_cx = (sorted_chars[0]['cx'] + sorted_chars[-1]['cx']) / 2
            plate_cy = (sorted_chars[0]['cy'] + sorted_chars[-1]['cy']) / 2

            plate_width = (sorted_chars[-1]['x'] + sorted_chars[-1]['w'] - sorted_chars[0]['x']) * PLATE_WIDTH_PADDING

            sum_height = 0
            for d in sorted_chars:
                sum_height += d['h']

            plate_height = int(sum_height / len(sorted_chars) * PLATE_HEIGHT_PADDING)

            # 컨투어 집합의 기울어진 정도를 구함.
            triangle_height = sorted_chars[-1]['cy'] - sorted_chars[0]['cy']
            triangle_hypotenus = np.linalg.norm(
                np.array([sorted_chars[0]['cx'], sorted_chars[0]['cy']]) -
                np.array([sorted_chars[-1]['cx'], sorted_chars[-1]['cy']])
            )

            angle = np.degrees(np.arcsin(triangle_height / triangle_hypotenus))

            # 구한 각도를 통해 회전행렬을 구해 똑바로 회전시키고 번호판 부분만을 잘라냄.
            rotation_matrix = cv2.getRotationMatrix2D(center=(plate_cx, plate_cy), angle=angle, scale=1.0)

            img_rotated = cv2.warpAffine(img_thresh, M=rotation_matrix, dsize=(width, height))

            img_cropped = cv2.getRectSubPix(
                img_rotated,
                patchSize=(int(plate_width), int(plate_height)),
                center=(int(plate_cx), int(plate_cy))
            )

            # 잘라낸 이미지가 번호판의 모양을 만족하는지 체크하고 아니면 넘어가고 맞다면 list에 이미지와 좌표정보 저장.
            if img_cropped.shape[1] / img_cropped.shape[0] < MIN_PLATE_RATIO \
                    or img_cropped.shape[1] / img_cropped.shape[0] < MIN_PLATE_RATIO > MAX_PLATE_RATIO:
                continue

            plate_imgs.append(img_cropped)
            plate_infos.append({
                'x': int(plate_cx - plate_width / 2),
                'y': int(plate_cy - plate_height / 2),
                'w': int(plate_width),
                'h': int(plate_height)
            })

        # 잘라낸 영역에 대해 다시 한번 번호판이 맞는지 확인하고 글자를 읽음.
        longest_idx, longest_text = -1, 0
        plate_chars = []

        for i, plate_img in enumerate(plate_imgs):
            # 잘라낸 영역을 다시 이진화.
            plate_img = cv2.resize(plate_img, dsize=(0, 0), fx=1.6, fy=1.6)
            _, plate_img = cv2.threshold(plate_img, thresh=0.0, maxval=255.0, type=cv2.THRESH_BINARY | cv2.THRESH_OTSU)

            # 위에서와 같은 방식으로 컨투어를 찾음.
            contours, _ = cv2.findContours(plate_img, mode=cv2.RETR_LIST, method=cv2.CHAIN_APPROX_SIMPLE)

            plate_min_x, plate_min_y = plate_img.shape[1], plate_img.shape[0]
            plate_max_x, plate_max_y = 0, 0

            for contour in contours:
                x, y, w, h = cv2.boundingRect(contour)

                area = w * h
                ratio = w / h

                # 찾은 컨투어로 글자로 판단되는 부분만을 잘라냄.
                if area > MIN_AREA and w > MIN_WIDTH and h > MIN_HEIGHT and MIN_RATIO < ratio < MAX_RATIO:
                    if x < plate_min_x:
                        plate_min_x = x
                    if y < plate_min_y:
                        plate_min_y = y
                    if x + w > plate_max_x:
                        plate_max_x = x + w
                    if y + h > plate_max_y:
                        plate_max_y = y + h

            img_result = plate_img[plate_min_y:plate_max_y, plate_min_x:plate_max_x]

            # 글자로 판단되는 부분을 가우시안블러를 사용하여 노이즈를 줄인 후 이미지의 이진화 수행.
            img_result = cv2.GaussianBlur(img_result, ksize=(3, 3), sigmaX=0)
            _, img_result = cv2.threshold(img_result, thresh=0.0, maxval=255.0,
                                          type=cv2.THRESH_BINARY | cv2.THRESH_OTSU)
            # 딱 맞게 잘라줬으므로 이미지에 약간의 여백을 줌.
            img_result = cv2.copyMakeBorder(img_result, top=10, bottom=10, left=10, right=10,
                                            borderType=cv2.BORDER_CONSTANT, value=(0, 0, 0))

            # tesseract를 통해 이미지에서 글자를 읽음.(한국어를 한줄로 읽고 legacy engine 사용)
            # legacy engine을 사용해야 문자를 그대로 읽음. 최근 엔진은 문맥 유추를 시도함.
            chars = pytesseract.image_to_string(img_result, lang='kor', config='--psm 7 --oem 0')
            print(chars)

            # 읽은 글자에서 숫자가 존재하는 경우만을 남기며 특수문자가 인식된 것을 지움.
            result_chars = ''
            has_digit = False
            for c in chars:
                if ord('가') <= ord(c) <= ord('힣') or c.isdigit():
                    if c.isdigit():
                        has_digit = True
                    result_chars += c

            print(result_chars)
            plate_chars.append(result_chars)

            # 결과 중에서 가장 긴것을 번호판으로 봄.
            if has_digit and len(result_chars) > longest_text:
                longest_idx = i

        # 번호판의 내용보다 많은 내용을 읽었을 경우 숫자3한글1숫자4의 내용만을 남김.
        info = plate_infos[longest_idx]
        chars = plate_chars[longest_idx]
        check = [0, 0, 0, 0, 0, 0, 0, 0]
        p_start = -1
        for i, c in enumerate(chars):
            if c.isdigit():
                if p_start == -1:
                    p_start = i
                check[i - p_start] = 1
            elif p_start != -1 and (i - p_start) == 3 and not c.isdigit():
                check[i - p_start] = 2
        if sum(check) == 9:
            chars = chars[p_start:(p_start+8)]
        else:
            continue

        print(chars)
    except:
        continue

    # 현재 시간과 번호판을 DB의 로그 테이블과 주차상태 테이블에 추가.
    db = pymysql.connect(host='AWS 호스팅된 아이피', user='Mysql계정', password='비밀번호', db='데이터베이스', charset='utf8')

    try:
        cur = db.cursor()

        # 시간을 DB에 등록하기 위해 iso포맷으로 변경하고 sql문에 사용할 데이터 묶음을 만듦.
        now_int = datetime.now()
        now = now_int.strftime('%Y-%m-%d %H:%M:%S')
        data = (chars, now)

        sql = "INSERT INTO `parking_status` (`번호판`, `입차시간`) VALUES (%s, %s);"
        cur.execute(sql, data)
        db.commit()

        sql = "INSERT INTO `admin_log` (`번호판`, `입차시간`) VALUES (%s, %s);"
        cur.execute(sql, data)
        db.commit()

    finally:
        db.close()

    ser_check = True
    # 시리얼 통신으로 잘못된 값이 넘어올 때의 오류를 처리하기 위한 반복문과 try except.
    while ser_check:
        try:
            # IR의 변경을 감지하기 위해 현재 값 저장.
            before = []
            after = []
            dustVal = ser.readline().rstrip()
            print(dustVal)
            a = dustVal.split()
            before = a[1:]
            before_int = list(map(int, before))
            # 현재 IR값이 주차상태와 일치하지 않으면 다른 작업중 출차가 일어났으므로 주차상태 갱신.
            if sum(before_int) != sum(parking_state):
                parking_state = before_int
            ser_check = False
        except:
            continue

    # 차단기 open 신호를 아두이노에 전송.
    for i in range(2):
        permission = 'YES'
        if permission == "YES":
            ser.write(b'YES\n')
            time.sleep(1)

    # IR 변경 감지.
    while True:
        try:
            dustVal = ser.readline().rstrip()
            print(dustVal)
            b = dustVal.split()
            after = b[1:]
            after_int = list(map(int, after))
            # 이전 IR값이 현재 IR값과 다르면 주차완료.
            if before != after:
                # 그중 이전 IR값의 합이 클 때는 출차가 일어난 것으로 이전 IR값과 주차상태를 갱신하고 다시 변경 감지.
                if sum(before_int) > sum(after_int):
                    before = after
                    before_int = after_int
                    parking_state = before_int
                    continue
                break
            time.sleep(.2)
        except:
            continue
    # 주차가 완료되었으므로 주차상태 갱신.
    parking_state = after_int

    # 어느 위치의 IR이 변경되었는지 알기 위해 이전 IR값과 현재 IR값을 xor연산으로 비교.
    parking_diff = [ord(x) ^ ord(y) for x, y in zip(before, after)]

    print(parking_diff)

    # xor연산 결과로 주차 위치를 결정.
    if parking_diff[0]:
        parking = 'a1'
        parking_state[0] = 1
    elif parking_diff[1]:
        parking = 'a2'
        parking_state[1] = 1
    elif parking_diff[2]:
        parking = 'a3'
        parking_state[2] = 1
    elif parking_diff[3]:
        parking = 'a4'
        parking_state[3] = 1
    elif parking_diff[4]:
        parking = 'a5'
        parking_state[4] = 1
    elif parking_diff[5]:
        parking = 'a6'
        parking_state[5] = 1

    # 대기 음성을 재생 가능하게 변경.
    sound_control = True

    # DB에서 방금 들어간 차량 레코드(주차자리가 NULL)에 주차자리 정보를 업데이트.
    db = pymysql.connect(host='AWS 호스팅된 아이피', user='Mysql계정', password='비밀번호', db='데이터베이스', charset='utf8')

    try:
        cur = db.cursor()

        sql = "UPDATE `parking_status` SET `주차자리` = %s WHERE `주차자리` IS NULL;"
        cur.execute(sql, parking)
        db.commit()

        sql = "UPDATE `admin_log` SET `주차자리` = %s WHERE `주차자리` IS NULL;"
        cur.execute(sql, parking)
        db.commit()

    finally:
        db.close()
