<?php
    $id = $_GET["id"];  // member_modify_form에서 userid는 GET방식으로 전달함

    $pass = $_POST["pass"]; // member_modify_form에서 pass, name, email은 GET방식으로 전달함
    $name = $_POST["name"];
    $email1  = $_POST["email1"];
    $email2  = $_POST["email2"];

    $email = $email1."@".$email2;
          
    $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");
    $sql = "update members set pass='$pass', name='$name' , email='$email'";
    $sql .= " where id='$id'";      // sql 문을 윗줄에 이어서 작성
    mysqli_query($con, $sql);       // query를 실행

    mysqli_close($con);     

    echo "
	      <script>
	          location.href = 'index.php';
	      </script>
	  ";
?>

   
