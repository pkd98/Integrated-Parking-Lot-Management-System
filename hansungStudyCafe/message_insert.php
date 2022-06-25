<meta charset='utf-8'>
<?php
    $name = $_POST['name'];		// POST 방식으로 수신
    $email = $_POST['email'];
    $subject = $_POST['subject'];
	$content = $_POST['content'];

	$subject = htmlspecialchars($subject, ENT_QUOTES);		// htmlspecialchars는 특수문자를 처리해주는 함수
	$content = htmlspecialchars($content, ENT_QUOTES);
	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	$con = mysqli_connect("localhost", "root", "", "hansung_studycafe");		// hansung_studycafe DB와 연결
	$sql = "insert into message (send_name, email, subject, content, regist_day)";
	$sql .= "values('$name', '$email', '$subject', '$content', '$regist_day')";
	$result = mysqli_query($con, $sql);

	mysqli_close($con);                // DB 연결 끊기
	
	// 관리자에게 쪽지를 보낸 뒤 index.php으로 이동
	echo "
	   <script>
	    location.href = 'index.php';
	   </script>
	";
?>