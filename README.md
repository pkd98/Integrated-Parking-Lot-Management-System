# 주차장 통합 관리 시스템
2022-1 한성대학교 전자 정보시스템 트랙 종합설계프로젝트 17조  
시연 영상 : 추후 업로드
## 개요
 * 차량의 번호판을 인식하여 차량의 입차와 출차를 자동화한다.
 * 라즈베리파이 카메라 모듈을 이용하여 주차장의 공간을 인식하여 주차 빈 자리를 효율적으로 찾는다.
 * Web/App으로 주차장 현황을 서비스하여 언제 어디서나 주차장 현황과 주차된 내차량 정보를 실시간으로 확인 가능하게 한다.
 * 본 프로젝트에서는 OpenCV를 이용하여 번호판과 주차공간 인식을 하고 라즈베리 파이와 아두이노를 이용하여 각 센서 제어, 아마존 AWS의 EC2 우분투 서버를 이용하여 Web과 App으로 서비스한다.
 * * *
## 시스템 구성
#### [시스템 구성도](https://github.com/pkd98/Integrated-Parking-Lot-Management-System/blob/master/Integrated-Parking-Lot-Management-System/%EC%8B%9C%EC%8A%A4%ED%85%9C%EA%B5%AC%EC%84%B1%EB%8F%84.png) - 전체시스템은 3가지 모듈로 이루어져 있다.
 1. [입차모듈](https://github.com/pkd98/Integrated-Parking-Lot-Management-System/blob/master/Integrated-Parking-Lot-Management-System/python-raspberryPi/parkingIn_2.py)
    - 아두이노와 연결된 센서값들을 라즈베리파이는 시리얼통신으로 값을 받아오는 상태이고, 아두이노에 연결된 초음파센서로 차량 접근을 감지하면 라즈베리파이가 카메라로 차량 전방을 촬영합니다.
    - 촬영한 사진에서 opencv를 이용하여 번호판 구역을 판단하고 구글의 Tesseract OCR로 글자를 인식합니다.
    - 인식된 번호판과 현재시간 DB에 저장 후 서보모터를 작동시켜 차단기를 올립니다.
    - 차량 진입이 완료되면 차단기를 내리고 주차가 완료되면 IR센서 값의 변화 변동을 통해 주차 위치를 파악합니다.
    - 파악된 위치또한 데이터베이스에 업데이트 하고 다시 차량 감지 단계로 되돌아 갑니다.

2. [출차모듈](https://github.com/pkd98/Integrated-Parking-Lot-Management-System/blob/master/Integrated-Parking-Lot-Management-System/python-raspberryPi/parkingOut_2.py)
    - 우측의 출차 모듈또한 아두이노에 연결된 초음파 센서로 차량 접근을 감지하면 라즈베리파이가 카메라로 차량 전방을 촬영합니다.
    - 촬영한 사진에서 opencv를 이용한 번호판 구역 판단, 테서랙트 OCR로 글자를 인식합니다.
    - 인식된 번호판을 통해 입차시간과 출차시간을 데이터베이스에서 쿼리하여 요금을 계산하고 인식된 번호판의 주차 정보를 데이터베이스 주차 정보 테이블에서 해당 레코드를 지우고 로그 테이블에 기록을 남깁니다.
    - 아두이노를 통해 서보모터를 작동시켜 차단기를 올리고 초음파센서를 통해 차량이 완전히 나간것이 확인되면 차단기를 내리고 차량 감지 단계로 되돌아 갑니다.

3. [자리체크모듈](https://github.com/pkd98/Integrated-Parking-Lot-Management-System/blob/master/Integrated-Parking-Lot-Management-System/python-raspberryPi/lineCheck.py)
    - 라즈베리파이가 주기적으로 주차장을 촬영하고 촬영한 사진에서 주차공간으로 파악되는 컨투어 내부의 컨투어 수를 이용하여 주차 공간에 차량이 있는지 파악합니다.
    - 차량이 있는 공간에 LED를 점등하고 LCD 화면에 빨간색으로 GUI로 표시하며 차량이 없는 공간에는 LED를 소등하고 화면에 파란색으로 표시합니다.
    - 라즈베리 파이가 DB에 주차공간 상태를 갱신합니다.

#### [Web]()

#### [Android App](https://github.com/pkd98/Integrated-Parking-Lot-Management-System/tree/master/Integrated-Parking-Lot-Management-System/Android-WebViewApplication)
    - WebView 위젯을 이용하여 반응형 웹으로 구현된 웹사이트를 바로 보여주는 기능을 합니다.
    


## 참고 문헌
- [Install OpenCV 4.5 on Raspberry Pi 4](https://qengineering.eu/install-opencv-4.5-on-raspberry-pi-4.html)
- [GitHub - Mactto/License_Plate_Recognition](https://github.com/Mactto/License_Plate_Recognition)
- [OpenCV modules](https://docs.opencv.org/4.x/index.html)
- [tesseract-ocr · GitHub](https://github.com/tesseract-ocr)
- [Bootstrap](https://getbootstrap.com/)
- [android-developer](https://developer.android.com/docs)
