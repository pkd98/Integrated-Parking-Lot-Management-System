<!-- 웹 페이지에서 로그인 상태를 검사하기 위해 세션 관련 코드를 삽입 -->
<?php
    session_start();                                                         // 로그인 상태를 검사하기 위함
    if (isset($_SESSION["userid"])) $userid = $_SESSION["userid"];           // 세션이 설정되어 있으면 변수로 끄집어 냄(로그인 정보를 유지)
    else $userid = "";                                                       // 세션이 설정되어 있지 않으면 NULL으로 설정
    if (isset($_SESSION["username"])) $username = $_SESSION["username"];
    else $username = "";
    if (isset($_SESSION["userlevel"])) $userlevel = $_SESSION["userlevel"];
    else $userlevel = "";
?>