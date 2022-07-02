import cv2
import numpy as np
import pymysql
import spidev
import RPi.GPIO as GPIO

# SPI, mysql을 사용하기 위한 초기화.
spi = spidev.SpiDev()
spi.open(0, 0)
spi.max_speed_hz = 1000000

db = None
cur = None


# LED 점등용 함수.
def led_on(pin):
    GPIO.setmode(GPIO.BOARD)
    GPIO.setup(pin, GPIO.OUT)
    GPIO.output(pin, True)


# LED 소등용 함수.
def led_off(pin):
    GPIO.setmode(GPIO.BOARD)
    GPIO.setup(pin, GPIO.OUT)
    GPIO.cleanup(pin)


# list를 통해 LED 점등, 소등 제어 함수.
def led_control(plist):
    if plist[0] == 1:
        led_on(40)
    elif plist[0] == 0:
        led_off(40)
    if plist[1] == 1:
        led_on(38)
    elif plist[1] == 0:
        led_off(38)
    if plist[2] == 1:
        led_on(37)
    elif plist[2] == 0:
        led_off(37)
    if plist[3] == 1:
        led_on(36)
    elif plist[3] == 0:
        led_off(36)
    if plist[4] == 1:
        led_on(35)
    elif plist[4] == 0:
        led_off(35)
    if plist[5] == 1:
        led_on(33)
    elif plist[5] == 0:
        led_off(33)


# 주차여부 시각화 화면 초기화.
parking_state = [0, 0, 0, 0, 0, 0]
WIN_WIDTH, WIN_HEIGHT = 800, 480
parking_visual = np.full((WIN_HEIGHT, WIN_WIDTH, 3), (255, 255, 255), dtype=np.uint8)
cv2.namedWindow('parking state')
cv2.moveWindow('parking state', 0, 0)
cv2.resizeWindow('parking state', WIN_WIDTH, WIN_HEIGHT)


# 주차여부 시각화 갱신용 함수.
def draw_state(state):
    # 글씨, 공간 틀 넣기.
    visual = np.full((WIN_HEIGHT, WIN_WIDTH, 3), (255, 255, 255), dtype=np.uint8)
    cv2.putText(visual, 'parking state', (int(WIN_WIDTH / 2 - 200), int(WIN_HEIGHT * 2 / 10)),
                cv2.FONT_HERSHEY_SIMPLEX, 2, (0, 0, 0), 2, cv2.LINE_AA)
    cv2.rectangle(visual, (int(WIN_WIDTH / 10), int(WIN_HEIGHT * 3 / 10)),
                  (int(WIN_WIDTH * 9 / 10), int(WIN_HEIGHT * 7 / 10)), (0, 0, 0), 10, cv2.LINE_AA)
    cv2.line(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 / 6), int(WIN_HEIGHT * 3 / 10)),
             (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 / 6), int(WIN_HEIGHT * 7 / 10)), (0, 0, 0), 10, cv2.LINE_AA)
    cv2.line(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 2 / 6), int(WIN_HEIGHT * 3 / 10)),
             (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 2 / 6), int(WIN_HEIGHT * 7 / 10)), (0, 0, 0), 10, cv2.LINE_AA)
    cv2.line(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 3 / 6), int(WIN_HEIGHT * 3 / 10)),
             (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 3 / 6), int(WIN_HEIGHT * 7 / 10)), (0, 0, 0), 10, cv2.LINE_AA)
    cv2.line(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 4 / 6), int(WIN_HEIGHT * 3 / 10)),
             (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 4 / 6), int(WIN_HEIGHT * 7 / 10)), (0, 0, 0), 10, cv2.LINE_AA)
    cv2.line(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 5 / 6), int(WIN_HEIGHT * 3 / 10)),
             (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 5 / 6), int(WIN_HEIGHT * 7 / 10)), (0, 0, 0), 10, cv2.LINE_AA)

    # 주차여부 표현.
    if state[0] == 1:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (0, 0, 255), cv2.FILLED, cv2.LINE_AA)
    elif state[0] == 0:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (255, 0, 0), cv2.FILLED, cv2.LINE_AA)
    if state[1] == 1:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 2 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (0, 0, 255), cv2.FILLED, cv2.LINE_AA)
    elif state[1] == 0:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 2 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (255, 0, 0), cv2.FILLED, cv2.LINE_AA)
    if state[2] == 1:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 2 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 3 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (0, 0, 255), cv2.FILLED, cv2.LINE_AA)
    elif state[2] == 0:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 2 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 3 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (255, 0, 0), cv2.FILLED, cv2.LINE_AA)
    if state[3] == 1:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 3 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 4 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (0, 0, 255), cv2.FILLED, cv2.LINE_AA)
    elif state[3] == 0:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 3 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 4 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (255, 0, 0), cv2.FILLED, cv2.LINE_AA)
    if state[4] == 1:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 4 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 5 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (0, 0, 255), cv2.FILLED, cv2.LINE_AA)
    elif state[4] == 0:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 4 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 5 / 6) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (255, 0, 0), cv2.FILLED, cv2.LINE_AA)
    if state[5] == 1:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 5 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH * 9 / 10) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (0, 0, 255), cv2.FILLED, cv2.LINE_AA)
    elif state[5] == 0:
        cv2.rectangle(visual, (int(WIN_WIDTH / 10 + WIN_WIDTH * 8 / 10 * 5 / 6) + 10, int(WIN_HEIGHT * 3 / 10) + 10),
                      (int(WIN_WIDTH * 9 / 10) - 10, int(WIN_HEIGHT * 7 / 10) - 10),
                      (255, 0, 0), cv2.FILLED, cv2.LINE_AA)
    return visual


# 주차여부 시각화 화면 표시.
parking_visual = draw_state(parking_state)
cv2.imshow('parking state', parking_visual)
cv2.waitKey(1000)

# 메인 반복구간.
while True:
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

    # 주차자리의 특성을 가진 컨투어를 선별.
    MIN_AREA = 400
    MIN_WIDTH, MIN_HEIGHT = 20, 20
    MIN_RATIO, MAX_RATIO = 0, 1.2

    possible_contours = []

    cnt = 0
    for d in contours_dict:
        area = d['w'] * d['h']
        ratio = d['w'] / d['h']

        if area > MIN_AREA and d['w'] > MIN_WIDTH and d['h'] > MIN_HEIGHT and MIN_RATIO < ratio < MAX_RATIO:
            d['idx'] = cnt
            cnt += 1
            possible_contours.append(d)

    # 주차자리 컨투어의 왼쪽 위 좌표가 오는 구역을 설정
    PARK_X1, PARK_X2, PARK_X3, PARK_X4, PARK_X5, PARK_X6 = 0, 90, 190, 275, 355, 435
    PARK_Y1, PARK_Y2, PARK_Y3, PARK_Y4, PARK_Y5, PARK_Y6 = 200, 200, 200, 200, 200, 200
    PARK_WIDTH, PARK_HEIGHT = 60, 60
    parking_space = [0, 0, 0, 0, 0, 0]

    # 주차자리 컨투어 후보에서 내부에 다른 컨투어가 7개 이상 생성되면 주차된 차량이 있음.
    parked_contours = []

    for p in possible_contours:
        CinC = 0

        for d in contours_dict:
            if p['x'] < d['cx'] < p['x'] + p['w'] and p['y'] < d['cy'] < p['y'] + p['h']:
                CinC += 1

        if CinC > 7:
            parked_contours.append(p)

    # 주차된 차량이 있는 컨투어가 어느 자리인지 확인하여 주차정보 변경.
    for d in parked_contours:
        if PARK_X1 < d['x'] < PARK_X1 + PARK_WIDTH and PARK_Y1 < d['y'] < PARK_Y1 + PARK_HEIGHT \
                and parking_space[0] == 0:
            parking_space[0] = 1
        if PARK_X2 < d['x'] < PARK_X2 + PARK_WIDTH and PARK_Y2 < d['y'] < PARK_Y2 + PARK_HEIGHT \
                and parking_space[1] == 0:
            parking_space[1] = 1
        if PARK_X3 < d['x'] < PARK_X3 + PARK_WIDTH and PARK_Y3 < d['y'] < PARK_Y3 + PARK_HEIGHT \
                and parking_space[2] == 0:
            parking_space[2] = 1
        if PARK_X4 < d['x'] < PARK_X4 + PARK_WIDTH and PARK_Y4 < d['y'] < PARK_Y4 + PARK_HEIGHT \
                and parking_space[3] == 0:
            parking_space[3] = 1
        if PARK_X5 < d['x'] < PARK_X5 + PARK_WIDTH and PARK_Y5 < d['y'] < PARK_Y5 + PARK_HEIGHT \
                and parking_space[4] == 0:
            parking_space[4] = 1
        if PARK_X6 < d['x'] < PARK_X6 + PARK_WIDTH and PARK_Y6 < d['y'] < PARK_Y6 + PARK_HEIGHT \
                and parking_space[5] == 0:
            parking_space[5] = 1

    print('a6:{0}, a5:{1}, a4:{2}, a3:{3}, a2:{4}, a1:{5}'
          .format(parking_space[0], parking_space[1], parking_space[2],
                  parking_space[3], parking_space[4], parking_space[5]))
    print(parking_space)

    # LED, 화면에 주차여부 반영.
    parking_state = parking_space

    parking_visual = draw_state(parking_state)
    led_control(parking_state)

    cv2.imshow('parking state', parking_visual)
    cv2.waitKey(1000)

    # DB에 주차여부 내용을 업데이트.
    db = pymysql.connect(host='AWS 호스팅된 아이피', user='Mysql계정', password='비밀번호', db='데이터베이스', charset='utf8')

    try:
        cur = db.cursor()

        data = (parking_space[0], 'a6')
        sql = "UPDATE `camera_space` SET `주차여부` = %s WHERE `주차자리` = %s;"
        cur.execute(sql, data)
        db.commit()

        data = (parking_space[1], 'a5')
        sql = "UPDATE `camera_space` SET `주차여부` = %s WHERE `주차자리` = %s;"
        cur.execute(sql, data)
        db.commit()

        data = (parking_space[2], 'a4')
        sql = "UPDATE `camera_space` SET `주차여부` = %s WHERE `주차자리` = %s;"
        cur.execute(sql, data)
        db.commit()

        data = (parking_space[3], 'a3')
        sql = "UPDATE `camera_space` SET `주차여부` = %s WHERE `주차자리` = %s;"
        cur.execute(sql, data)
        db.commit()

        data = (parking_space[4], 'a2')
        sql = "UPDATE `camera_space` SET `주차여부` = %s WHERE `주차자리` = %s;"
        cur.execute(sql, data)
        db.commit()

        data = (parking_space[5], 'a1')
        sql = "UPDATE `camera_space` SET `주차여부` = %s WHERE `주차자리` = %s;"
        cur.execute(sql, data)
        db.commit()

    finally:
        db.close()
