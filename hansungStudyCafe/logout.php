<!-- 생성된 세션을 삭제하면 로그아웃 처리가 됨 -->
<?php
  session_start();
  unset($_SESSION["userid"]);       // 세션을 삭제
  unset($_SESSION["username"]);
  unset($_SESSION["userlevel"]);
  
  echo("
       <script>
          location.href = 'index.php';
         </script>
       ");
?>
