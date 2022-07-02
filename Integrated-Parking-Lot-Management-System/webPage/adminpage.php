<html>
<html lang="ko">

<head>
</head>

<body>
    <main>
        <div id="mid" class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center">
            <div class="col-md-5 p-lg-5 mx-auto my-5">
                </head>
                <?php
                //mysql 접속
                $host = "localhost";
                $user = "user1";
                $pw = "1771356";
                $dbName = "testtest";
                $mysql = new mysqli($host, $user, $pw, $dbName);
                //admin_main.html에서 post로 보낸 아이디와 비밀번호 정보를 받음
                $id = $_POST["id"];
                $password = $_POST["password"];
                if (!$mysql) {
                    echo "MySQL 서버 접속 실패.\n 다음에 다시 시도해주세요.";
                }
                //mysql 서버 접속 성공시 하는것
                else {
                    //받은 아이디와 비밀번호가 있는지 체크하기 위해 admin_id에 쿼리를 함
                    $admin_id = "select * from admin_id where id = '$id' and 패스워드 = '$password'";
                    $result_id = mysqli_query($mysql, $admin_id);
                    $num_match = mysqli_num_rows($result_id);
                    //쿼리를 하여 아이디와 비밀번호가 일치하는 레코드가 데이터베이스에 없다면
                    if (!$num_match) {
                        echo ("
                            <script>
                                window.alert('등록되지 않은 계정입니다!')
                                history.go(-1)
                            </script>");
                    }
                    //쿼리를 하여 아이디와 비밀번호가 일치하는 레코드가 있다면 로그인에 성공한 것이므로 admin_viewlog.php로 이동함
                    else
                        echo ("
                                <script>
                                    location.href = 'admin_viewlog.php';
                                </script>
                              ");
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>