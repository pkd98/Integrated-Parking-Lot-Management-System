<html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>한성주차통합서비스</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">한성 주차통합서비스</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsExample05">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.html">홈</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="parking_status.php">주차현황</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="client_info_main.html">내 차량</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_main.html">관리자</a>
                    </li>
                </ul>
                </li>
                </ul>

            </div>
        </div>
    </nav>
    <main>
        <div id="mid" class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center">
            <div class="col-md-5 p-lg-5 mx-auto my-5">
                </head>
                <?php
                //mysql 접속------
                $host = "localhost";
                $user = "user1";
                $pw = "1771356";
                $dbName = "testtest";
                $mysql = new mysqli($host, $user, $pw, $dbName);
                //clientpage.php에서 세션으로 저장한 번호판의 값을 받아옴
                session_start();
                $plate = $_SESSION['plate'];
                //parking_status에서 번호판의 값이 일치하는 레코드를 불러옴
                $query = "select * from parking_status where 번호판='$plate'";
                $rs = mysqli_query($mysql, $query);
                $board = mysqli_fetch_array($rs);
                ?>
                <h1 class="display-8">
                    <?php
                    echo '<p class = "text- nowrap">' . $plate . '</p>';
                    ?>
                </h1>

                <br>
                <!--테이블-->
                <table class="table table-striped text-nowrap table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class=" text-center">A6</th>
                            <th class="text-center">A5</th>
                            <th class="text-center">A4</th>
                            <th class="text-center">A3</th>
                            <th class="text-center">A2</th>
                            <th class="text-center">A1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!--쿼리한 레코드의 주차자리를 파악하여 그 자리에 해당하는 자리는 파란색과 HERE로 표시함-->
                            <?php
                            if ($board['주차자리'] == 'a6')
                                echo '<td class="bg-primary text-center text-white">' . "HERE" . "</td>";
                            else
                                echo "<td>" . "" . "</td>";
                            ?>

                            <?php
                            if ($board['주차자리'] == 'a5')
                                echo '<td class="bg-primary text-center text-white">' . "HERE" . "</td>";
                            else
                                echo "<td>" . "" . "</td>";
                            ?>

                            <?php
                            if ($board['주차자리'] == 'a4')
                                echo '<td class="bg-primary text-center text-white">' . "HERE" . "</td>";
                            else
                                echo "<td>" . "" . "</td>";
                            ?>

                            <?php
                            if ($board['주차자리'] == 'a3')
                                echo '<td class="bg-primary text-center text-white">' . "HERE" . "</td>";
                            else
                                echo "<td>" . "" . "</td>";
                            ?>

                            <?php
                            if ($board['주차자리'] == 'a2')
                                echo '<td class="bg-primary text-center text-white">' . "HERE" . "</td>";
                            else
                                echo "<td>" . "" . "</td>";
                            ?>

                            <?php
                            if ($board['주차자리'] == 'a1')
                                echo '<td class="bg-primary text-center text-white">' . "HERE" . "</td>";
                            else
                                echo "<td>" . "" . "</td>";
                            ?>

                        </tr>
                    </tbody>
                </table>
                주차 시간 :
                <?php
                //쿼리한 데이터의 입차시간을 $parking_time에 저장함
                $parking_time = $board['입차시간'];
                echo $parking_time . "<br>";
                date_default_timezone_set('Asia/Tokyo');
                $current_time = date("Y-m-d H:i:s");
                //현재 시간을 특정 포맷에 맞게 불러옴
                echo "현재 일시 : " . $current_time . "<br/>";
                echo "요금 : ";
                /*현재 시간 - 입차시간을 하여 그 차이를 구함
                실제 주차장은 시간당 요금과 일당 최고 요금이 있는데, 시연에서 이를 보여줄수 없으니
                초당 요금과 1시간이상 지나면 최고 요금을 산정함*/
                $someTime = strtotime($current_time) - strtotime($parking_time);
                if ($someTime < 3600) {
                    $fee = floor($someTime) * 300;
                    echo $fee . "원" . "<br>";
                } else {
                    $fee = 20000;
                    echo $fee . "원" . "<br>";
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