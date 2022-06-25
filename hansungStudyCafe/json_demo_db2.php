<?php
//php 채팅 구현 참고 : https://github.com/jgs901221/phpchattingsite

header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($_GET["content"], false);
$conn = new mysqli("localhost", "root", "", "hansung_studycafe");
mysqli_query ($conn, 'SET NAMES utf8');
$chatuser = addslashes($obj->chatuser); //사용자 아이디 받아옴 (addslashes는 역슬래시 더해서 받아옴)
$chattext = addslashes($obj->chattext); //사용자 입력내용
$chattime = addslashes($obj->chattime); //사용자 입력 시간
$stmt = $conn->
prepare("INSERT INTO $obj->table(chatuser,chattext,chattime) 
VALUES ('$chatuser','$chattext','$chattime')"); //DB 쿼리 (채팅창에 사용자 아이디,내용,비밀번호 저장)
$stmt->execute();
$result = $stmt->get_result();
$outp = $result->fetch_all(MYSQLI_ASSOC); //결과값 한 레코드씩 받아와서 담음
echo json_encode($outp);
?>