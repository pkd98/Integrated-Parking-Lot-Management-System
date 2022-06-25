<?php
//php 채팅 구현 참고 : https://github.com/jgs901221/phpchattingsite

header("Content-Type: application/json; charset=UTF-8"); //json형식, UTF-8 인코딩 정의
$obj = json_decode($_GET["content"], false); //json형식의 get방식으로 받아온 값을 해석하여 저장. false로 해야 화면에 값 표시 가능.
$conn = new mysqli("localhost", "root", "", "hansung_studycafe");
mysqli_query ($conn,'SET NAMES utf8');
$stmt = $conn->prepare("SELECT * FROM $obj->table"); //테이블에 담긴내용 불러옴
$stmt->execute();
$result = $stmt->get_result(); //결과값 저장
$outp = $result->fetch_all(MYSQLI_ASSOC); //한 레코드씩 fetch하여 불러옴
echo json_encode($outp); //불러온 값을 json방식으로 인코딩하여 출력
?>