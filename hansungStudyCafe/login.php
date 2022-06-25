<!-- login.php파일은 사용자가 입력한 아이디와 비밀번호가 11장에서 생성한 members 테이블에 존재하는지 검사하여
로그인 가능 여부를 판단하고 처리 -->

<?php
    $id   = $_POST["id"];
    $pass = $_POST["pass"];

   $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");   // 데이터베이스 연결
   $sql = "select * from members where id='$id'";                              // 사용자가 입력한 아이디가 DB에 있는지 확인하는 SQL형태로 저장
   $result = mysqli_query($con, $sql);                                         // SQL을 실행하여 결과로 리턴된 레코드를 result에 저장

   $num_match = mysqli_num_rows($result);                                      // 리턴된 레코드가 몇 개 인지 확인

   if(!$num_match)                                                             // 리턴된 레코드가 없으면 실행(사용자가 입력한 아이디가 DB에 없으면)
   {
     echo("
           <script>
             window.alert('등록되지 않은 아이디입니다!')
             history.go(-1)                                         // 이전 페이지로 이동
           </script>
         ");
    }
    else                                                            // 리턴된 레코드가 존재할 때 실행
    {
        $row = mysqli_fetch_array($result);                         // 하나의 레코드를 가져옴
        $db_pass = $row["pass"];                                    // 추출한 레코드에서 비밀번호 부분을 꺼냄

        mysqli_close($con);

        if($pass != $db_pass)                                       // pass = 사용자가 입력한 암호, db_pass = 방금 전에 추출한 DB에 저장되어 있는 암호
        {

           echo("
              <script>
                window.alert('비밀번호가 틀립니다!')
                history.go(-1)
              </script>
           ");
           exit;
        }
        else                                                        // 비밀번호가 서로 일치할 때
        {
            session_start();                                        // 세션을 시작
            $_SESSION["userid"] = $row["id"];                       // 사용자 정보를 서버에 저장
            $_SESSION["username"] = $row["name"];
            $_SESSION["userlevel"] = $row["level"];
           
            echo("
              <script>
                location.href = 'index.php';                        
              </script>
            ");
        }
     }        
?>
