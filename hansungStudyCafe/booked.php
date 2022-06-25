<meta charset='utf-8'>
<?php
session_start();
//$seat = $_POST["seatList"];	
$seat = $_POST["bookWhere"];	// POST 방식으로 수신
$userid = $_SESSION["userid"];
$username = $_SESSION["username"];

if (!isset($userid) || $userid == "") {
	echo ("
		<script>
		  window.alert('로그인하세요')
		  location.href = 'login_form.php';                                          // 이전 페이지로 이동
		</script>
	  ");
} else {

	$regist_day = date("Y-m-d (H:i)");  // 현재의 '년-월-일-시-분'을 저장

	$con = mysqli_connect("localhost", "root", "", "hansung_studycafe");		// hansung_studycafe DB와 연결
	$sql = "select * from status where seat = '$seat'";
	$result = mysqli_query($con, $sql);
	$row = mysqli_fetch_array($result);
	if (isset($row["checkin_time"])) {
		mysqli_close($con);
		echo ("
		<script>
		  window.alert('이미 예약된 자리입니다.')
		  history.go(-1)                                         // 이전 페이지로 이동
		</script>
	  ");
	} else {
		$sql = "update status SET id = '$userid', name = '$username', checkin_time = '$regist_day' WHERE seat = '$seat'";
		mysqli_query($con, $sql);
	}

	mysqli_close($con);                // DB 연결 끊기

	// 예약한뒤에  status.php으로 이동

	echo "
	   <script>
	   location.href = 'status.php';
	   </script>
	";
}
?>