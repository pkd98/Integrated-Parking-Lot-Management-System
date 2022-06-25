<?php
    $id   = $_POST["id"];   //member_form.php에서 보내준 데이터를 받아옴
    $pass = $_POST["pass"];
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];

    $email = $email1."@".$email2;
    $regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

    $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");     //mysqli_connect는 데이터베이스와 연결하는 함수

	$sql = "insert into members(id, pass, name, email, regist_day, level) ";
	$sql .= "values('$id', '$pass', '$name', '$email', '$regist_day', 9)";

	mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'index.php';      // index.php으로 위치를 이동하라는 명령
	      </script>
	  ";
?>

   
