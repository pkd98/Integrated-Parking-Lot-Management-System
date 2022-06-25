<!DOCTYPE html>
<head>
<meta charset="utf-8">
<style>
h3 {
   padding-left: 5px;
   border-left: solid 5px #edbf07;
}
#close {
   margin:20px 0 0 80px;
   cursor:pointer;
}
</style>
</head>
<body>
<h3>아이디 중복체크</h3>
<p>
<?php
   $id = $_GET["id"];

   if(!$id) // 사용자가 아이디를 입력하지 않았으면 실행
   {
      echo("<li>아이디를 입력해 주세요!</li>");
   }
   else
   {
      $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");

 
      $sql = "select * from members where id='$id'";  // members 테이블의 id 값이 사용자가 입력한 id값이 있는 레코드를 추출
      $result = mysqli_query($con, $sql);             // 사용자가 입력한 id 값이 members 테이블에 있다면 result에 레코드를 저장

      $num_record = mysqli_num_rows($result);         // mysqli_num_rows는 추출된 record의 개수를 추출하는 함수

      if ($num_record)                                // num_record에 값이 저장되어 있다면 members 테이블에 id값이 이미 존재함
      {
         echo "<li>".$id." 아이디는 중복됩니다.</li>";
         echo "<li>다른 아이디를 사용해 주세요!</li>";
      }
      else
      {
         echo "<li>".$id." 아이디는 사용 가능합니다.</li>";
      }
    
      mysqli_close($con);
   }
?>
</p>
<div id="close">
   <img src="./img/close.png" onclick="javascript:self.close()">
</div>
</body>
</html>

