# 주차장 통합 관리 시스템
2022-1 한성대학교 전자 정보시스템 트랙 17조
영상 : 추후 업로드
## 개요
 * 차량의 번호판을 인식하여 차량의 입차와 출차를 자동화한다.
 * 라즈베리파이 카메라 모듈을 이용하여 주차장의 공간을 인식하여 주차 빈 자리를 효율적으로 찾는다.
 * Web/App으로 주차장 현황을 서비스하여 언제 어디서나 주차장 현황과 주차된 내차량 정보를 실시간으로 확인 가능하게 한다.
 * 본 프로젝트에서는 OpenCV를 이용하여 번호판과 주차공간 인식을 하고 라즈베리 파이와 아두이노를 이용하여 각 센서 제어, 아마존 AWS의 EC2 우분투 서버를 이용하여 Web과 App으로 서비스한다.
 * * *
## 시스템 구성
#### [시스템 구성도](https://github.com/pkd98/Integrated-Parking-Lot-Management-System/blob/master/Integrated-Parking-Lot-Management-System/%EC%8B%9C%EC%8A%A4%ED%85%9C%EA%B5%AC%EC%84%B1%EB%8F%84.png) - 전체시스템은 3가지 모듈로 이루어져 있다.
 1. [입차모듈](https://github.com/pkd98/Integrated-Parking-Lot-Management-System/blob/master/Integrated-Parking-Lot-Management-System/python-raspberryPi/parkingIn_2.py) (방문 차량의 입차를 담당.)
    - 아두이노와 연결된 센서값들을 라즈베리파이는 시리얼통신으로 값을 받아오는 상태이고, 아두이노에 연결된 초음파센서로 차량 접근을 감지하면 라즈베리파이가 카메라로 차량 전방을 촬영합니다. 이때 촬영한 사진에서 opencv를 이용하여 번호판 구역을 판단하고 구글의 Tesseract OCR로 글자를 인식합니다.
인식된 번호판과 현재시간 정보를 아마존AWS EC2 우분투 서버에 구축된 mysql 데이터베이스에 저장된 후 서보모터를 작동시켜 차단기를 올립니다. 차량이 진입되면 차단기를 내리고
또한 주차가 완료되면 IR센서 값의 변화 변동을 통해 주차 위치를 파악하고 파악된 위치또한 데이터베이스에 업데이트 하고 다시 차량 감지 단계로 되돌아 갑니다.
