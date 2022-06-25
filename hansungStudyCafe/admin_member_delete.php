<?php
    session_start();
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];     // 세션 값을 받아와 userlevel이 설정되어 있으면 그 값을 받아옴
    else $userlevel = "";                                                       // 없으면 NULL로 처리

    if ( $userlevel != 1 )      // 관리자가 아니면(userlevel = 1이면 관리자)
    {
        echo("
            <script>
            alert('관리자가 아닙니다! 회원 삭제는 관리자만 가능합니다!');
            history.go(-1)
            </script>
        ");
        exit;
    }

    $seat = $_GET["seat"];    // admin_main에서 seat를 GET 방식으로 전송했으므로 GET 방식으로 받음
    
    $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");                       // hansung_studycafe DB에 접근
    $sql = "UPDATE status set name = NULL, checkin_time = NULL, id = NULL where seat = '$seat'";    // admin_main에서 전송한 seat값과 같은 record의 id, name, checkin_time에 NULL을 삽입
    mysqli_query($con, $sql);   // 쿼리 실행

    mysqli_close($con);         // DB 연결 해제
 
    echo "
	     <script>
	         location.href = 'admin_main.php';
	     </script>
	   ";   // 삭제를 한 뒤에 admin_main.php으로 이동
?>

