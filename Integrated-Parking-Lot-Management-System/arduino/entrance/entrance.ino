#include <Servo.h>

Servo servo;        //서보 모터 객체 생성
int value = 0;      //서보 모터 각도

int trigPin = 12;   //초음파 센서 출력핀
int echoPin = 10;   //초음파 센서 입력핀

int irPin1 = 13;    //적외선 센서 입력핀1
int val1;           
int irPin2 = 2;     //적외선 센서 입력핀2
int val2;
int irPin3 = 7;     //적외선 센서 입력핀3
int val3;
int irPin4 = 4;     //적외선 센서 입력핀4
int val4;
int irPin5 = 3;     //적외선 센서 입력핀5
int val5;
int irPin6 = 6;     //적외선 센서 입력핀6
int val6;

unsigned long previousMillis = 0;   //서보모터 시간 제어
const long delayTime = 10000;        //서보모터 동작 주기=5sec

void setup() {
  
  Serial.begin(9600);         //시리얼 속도 설정
  pinMode(trigPin, OUTPUT);   //초음파 트리거 핀을 출력으로 설정
  pinMode(echoPin, INPUT);    //초음파 에코 핀을 입력으로 설정
  pinMode(irPin1, INPUT);     //적외선 핀을 입력으로 설정
  servo.attach(8);            //서보모터를 8핀으로 설정
  pinMode(8, OUTPUT);         //서보모터를 출력으로 설정
}

void loop() {
  unsigned long currentMillis = millis();   //현재 시간 값을 가져옴
  
  //초음파 센서 작동
  digitalWrite(trigPin, HIGH);
  delay(10);
  digitalWrite(trigPin, LOW);

  float duration = pulseIn(echoPin, HIGH);
  float distance = ((float)(340 * duration) / 10000) / 2;

  //while(Serial.available() > 0)
  //{
    if(distance != 0)
    {
    Serial.print(distance);
    Serial.print(" ");

    //적외선 센서 작동
    val1 = digitalRead(irPin1);
    if (val1 == HIGH) {
      Serial.print("1 ");
    }
    else {
      Serial.print("0 ");
    } 

    val2 = digitalRead(irPin2);
    if (val2 == HIGH) {
      Serial.print("1 ");
    }
    else {
      Serial.print("0 ");
    }

    val3 = digitalRead(irPin3);
    if (val3 == HIGH) {
      Serial.print("1 ");
    }
    else {
      Serial.print("0 ");
    }

    val4 = digitalRead(irPin4);
    if (val4 == HIGH) {
      Serial.print("1 ");
    }
    else {
      Serial.print("0 ");
    }

    val5 = digitalRead(irPin5);
    if (val5 == HIGH) {
      Serial.print("1 ");
    }
    else {
      Serial.print("0 ");
    }

    val6 = digitalRead(irPin6);
    if (val6 == HIGH) {
      Serial.println("1");
    }
    else {
      Serial.println("0");
    } 
    }
    //Serial.print("cm   ");

    

    String data = Serial.readStringUntil('\n');
    //data = "YES";
    if (data == "YES")        // 차량이 들어오는 것이 허가 되면
    {
      if (distance)
      {
        if (distance < 10 && distance > 1)    //15cm 이내로 들어오면 서보 모터 90도
        {
          value = 0;
          servo.write(value);
        } 
      }
      //Serial.print("Operation");
    }
    
    if(currentMillis - previousMillis >= delayTime && distance > 10)   //서보 모터가 동작한지 5초가 지났는지 확인
    {
      previousMillis = currentMillis;             //현재 시간을 저장
      value = 90;                                 //서보 모터를 원위치
      servo.write(value);
    }
    
    else if (data == "NO")    //차량이 들어오는 것이 허가되지 않을 때
    {
      //Serial.print("CLOSED");
    }
  
  delay(300);
}
