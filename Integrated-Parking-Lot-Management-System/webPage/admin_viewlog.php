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
                        <a class="nav-link" href="client_info_main.html">내 차량</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="admin_main.html">관리자</a>
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
                //mysql 접속
                $host = "localhost";
                $user = "user1";
                $pw = "1771356";
                $dbName = "testtest";
                $mysql = new mysqli($host, $user, $pw, $dbName);
                //입차시간 내림차순으로 admin_log에서 테이블을 쿼리
                $query = "select * from admin_log order by 입차시간 desc";
                $rs = mysqli_query($mysql, $query);
                ?>
                <h1 class="display-3">주차 로그</h1>
                <br>
                <!--테이블-->
                <table class="table">
                    <!--모바일 환경에서 줄바꿈의 문제가 있어 text-nowrap 추가-->
                    <thead class="thead-light text-nowrap">
                        <tr>
                            <th scope="col" class="align-middle align-center">자리</th>
                            <th scope="col" class="align-middle align-center">번호판</th>
                            <th scope="col" class="align-middle align-center">입차시간</th>
                            <th scope="col" class="align-middle align-center">출차시간</th>
                            <th scope="col" class="align-middle align-center">금액</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /*mysqli_fetch_array는 mysqli_query에서 얻은 result set에서 레코드를 하나씩 리턴해주기에 
                        while문으로 쿼리한 데이터를 반복하여 모두 테이블에 보여줌*/
                        while ($board = mysqli_fetch_array($rs)) {
                        ?>

                            <tr>
                                <th class="align-middle align-center" scope="row"> <?php echo $board['주차자리'] ?> </th>
                                <td class="align-middle align-center"> <?php echo $board['번호판'] ?> </td>
                                <td class="align-middle align-center"> <?php echo substr($board['입차시간'], 5, 11) ?> </td>
                                <td class="align-middle align-center"> <?php echo substr($board['출차시간'], 5, 11) ?> </td>
                                <td class="text-nowrap align-middle align-center"> <?php echo $board["금액"]; ?>
                                    <?php if ($board["금액"] != "") echo '원' ?> </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <footer class="pt-3 mt-4 text-muted border-top">
            한성대학교 2022 전자, 정보시스템 트랙 종합설계프로젝트 17조
        </footer>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>