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
                //client_info_main.html에서 post방식으로 넘겨준 번호판의 값을 받음
                $plate = $_POST["plate"];
                //client_viewlog.php에서 번호판의 값을 사용해야 하기에 세션으로 그 값을 보냄
                session_start();
                $_SESSION['plate'] = $plate;
                if (!$mysql) {
                    echo "MySQL 서버 접속 실패.\n 다음에 다시 시도해주세요.";
                }
                //mysql 서버 접속 성공시 쿼리
                else {
                    //parking_status에서 번호판의 값이 일치하는 레코드를 쿼리
                    $plate = "select * from parking_status where 번호판 = '$plate'";
                    $result = mysqli_query($mysql, $plate);
                    $num_match = mysqli_num_rows($result);

                    //쿼리를 하여 나온 레코드가 없으면(=검색한 번호판의 차량이 주차를 하지 않았으면) 경고문 출력
                    if (!$num_match) {
                        echo ("
                            <script>
                                window.alert('주차장에 차가 없습니다')
                                history.go(-1)
                            </script>");
                    } else { //쿼리를 하여 나온 레코드가 있으면(=검색한 번호판의 차량이 주차를 했으면) 쿼리한 번호판의 차량의 정보를 보여주는 client_viewlog.php로 이동
                        echo ("
                                <script>
                                    location.href = 'client_viewlog.php';
                                </script>
                              ");
                    }
                }
                ?>
            </div>
        </div>
        <footer class="pt-3 mt-4 text-muted border-top">
            한성대학교 2022 전자, 정보시스템 트랙 종합설계프로젝트 17조
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>