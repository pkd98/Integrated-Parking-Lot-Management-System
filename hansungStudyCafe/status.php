<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="./js/check_input.js"></script> <!--관리자에게 문의하기 모달 처리 함수-->
    <script type="text/javascript" src="./js/check_booking.js"></script> <!--예약 처리 함수-->
    <script type="text/javascript" src="./js/check_unbooking.js"></script> <!--퇴실 처리 함수-->
    <!-- bootstrap 사용 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
    <!-- 구글 웹폰트 적용 (DoHyeon 폰트)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
    <title>한성 스터디카페</title>
    <!-- font Awesome 로고 사용-->
    <script src="https://kit.fontawesome.com/9404168568.js" crossorigin="anonymous"></script>
    <style>
        p {
            font-family: 'Do Hyeon', sans-serif;
        }
        p.a {
            font-weight: 400;
        }
        p.b {
            font-weight: 700;
        }
        p.c {
            font-weight: 800;
        }
        p.d {
            font-weight: bold;
        }
        a {
            font-family: 'Do Hyeon', sans-serif;
        }
        span {
            font-family: 'Do Hyeon', sans-serif;
        }
    </style>
    <?php include 'session_start.php'; ?> <!--세션 검사후 로그인 유지 처리-->
</head>
<body>
    <header>
        <!-- Top부분, 회원가입, 로그인 구현 -->
        <div id="top">
            <!-- As a heading -->
            <nav class="navbar bg-light">
                <div class="container-fluid">
                    <span class="navbar-text mb-0 h3"><i class="fa-solid fa-book"></i> 한성 스터디카페 <i class="fa-solid fa-pencil"></i>
                    </span>
                    <span class="navbar-text h6">
                        <?php
                        if (!$userid) {
                        ?> <a href="member_form.php">회원가입 </a> <!-- member_form 작성 요망-->
                            <a href="login_form.php"> 로그인</a> <!-- login_form 작성요망-->


                        <?php
                        } else {
                            $logged = $username."님 안녕하세요";
                        ?>
                            <?= $logged ?>
                            <a href="logout.php">로그아웃</a>
                            <a href="member_modify_form.php">내 정보수정</a>
                        <?php
                        }
                        ?>
                    </span>
                </div>
            </nav>
        </div>

        <!-- nav bar 구현 -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Fifth navbar example">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"> <i class="fa-solid fa-graduation-cap h4"></i></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample05">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 h4">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">홈</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active h4" aria-current="page" href="status.php">좌석 현황</a> <!-- status.php 정의-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h4" href="chat.php">실시간 고객 소통</a> <!-- 고객 소통 채팅방 정의-->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h4" href="location.php">지점 위치</a> <!-- 고객 소통 채팅방 정의-->
                        </li>
                        <?php
                        if ($userlevel == 1) {      // userlevel이 1일 때만 '관리자' 메뉴가 표시
                        ?>
                            <li class="nav-item">
                                <a class="nav-link h4" href="admin_main.php">관리자</a> <!-- 관리자 페이지 정의 -->
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                    </li>
                    </ul>
                    <span class="navbar-text h6">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal1">관리자에게 문의하기</button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- 모달을 통한 쪽지 보내기 form 구현 (post 방식으로 message_insert.php로 해당 폼 전송)-->
                                    <form name="message_form" method="post" action="message_insert.php">
                                        <div class="modal-header" style="color:black">
                                            <h5 class="modal-title" id="exampleModalLabel">관리자에게 문의하기</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="color:black">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label"> 이름</label>
                                                <input name="name" type="text" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">회신받을 이메일</label>
                                                <input name="email" type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label"> 제목</label>
                                                <input name="subject" type="text" class="form-control" id="exampleFormControlInput1">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleFormControlTextarea1" class="form-label">문의 내용</label>
                                                <textarea name="content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                            <button type="button" class="btn btn-primary" onclick="check_input()">메시지 보내기</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </nav>
        <header>
            <!--header-->
        </header>
    </header>
    <main>
        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container">
                <?php
                $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");     //mysqli_connect는 데이터베이스와 연결하는 함수

                $sql = "SELECT * FROM status WHERE seat LIKE 'a%' ORDER BY seat ASC";
                //SELECT * FROM table1 WHERE col_1 IS NOT NULL;
                $rs = mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
                ?>
                <div class="row text-center">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                    <br>
                    <p class="my-3 h1">좌석 현황</p>
                    <br>
                    <!--테이블-->
                    <table class="table table-striped text-nowrap table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" class=" text-center h3">A1</th>
                                <th scope="col" class=" text-center h3">A2</th>
                                <th scope="col" class=" text-center h3">A3</th>
                                <th scope="col" class=" text-center h3">A4</th>
                                <th scope="col" class=" text-center h3">A5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--쿼리한 테이블은 자리 순으로 레코드를 불러옴-->
                            <tr height="75px">
                                <?php
                                while ($board = mysqli_fetch_array($rs)) {
                                    if (is_null($board['id']))
                                        //null이면 1이고, 그 자리가 비어있으므로 파란배경의 O
                                        echo '<td class ="table-primary text-center align-middle h1">' . "O" . "</td>";
                                    else
                                        //null이 아니면 0이고, 그 자리가 차있으므로 빨간 배경의 O
                                        echo '<td class="table-danger text-center align-middle h1">' . "X" . "</td>";
                                }
                                ?>
                            </tr>
                            <tr>
                                <th scope="col" class=" text-center h3">B1</th>
                                <th scope="col" class=" text-center h3">B2</th>
                                <th scope="col" class=" text-center h3">B3</th>
                                <th scope="col" class=" text-center h3">B4</th>
                                <th scope="col" class=" text-center h3">B5</th>
                            </tr>
                            <?php
                            $sql = "SELECT * FROM status WHERE seat LIKE 'b%' ORDER BY seat ASC ";
                            //SELECT * FROM table1 WHERE col_1 IS NOT NULL;
                            $rs = mysqli_query($con, $sql);  // $sql 에 저장된 명령 실행
                            mysqli_close($con);
                            ?>
                            <!--쿼리한 테이블은 주차자리 순으로 레코드를 불러오고, 주차여부는 1과 0으로 저장되어있음-->
                            <tr height="75px">
                                <?php
                                while ($board = mysqli_fetch_array($rs)) {
                                    if (is_null($board['id']))
                                        //null이면 1이고, 그 자리가 비어있으므로 파란배경의 O
                                        echo '<td class ="table-primary text-center align-middle h1">' . "O" . "</td>";
                                    else
                                        //null이 아니면 0이고, 그 자리가 차있으므로 빨간 배경의 O
                                        echo '<td class="table-danger text-center align-middle h1">' . "X" . "</td>";
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container">
                <div><br></div>
                <div class="row text-center center block">
                    <div class="col-md-6">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-solid fa-times fa-stack-1x fa-inverse"></i>
                        </span>
                        <p class="my-3 h3">퇴실</p>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal2">퇴실하기</button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- 모달을 통한 퇴실 form 구현 (post 방식으로 unbooked.php로 해당 폼 전송)-->
                                    <form name="unbooking_form" method="post" action="unbooked.php">
                                        <div class="modal-header" style="color:black">
                                            <h5 class="modal-title" id="exampleModalLabel">퇴실하기</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="color:black">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">
                                                    <?php echo $username ?>님 안녕하세요.
                                                </label>
                                            </div>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='a1' autocomplete="off"> A1
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='a2' autocomplete="off"> A2
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='a3' autocomplete="off"> A3
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='a4' autocomplete="off"> A4
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='a5' autocomplete="off"> A5
                                                </label>
                                            </div>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary active">
                                                    <input type="radio" name="unbookWhere" id="" value='b1' autocomplete="off"> B1
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='b2' autocomplete="off"> B2
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='b3' autocomplete="off"> B3
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='b4' autocomplete="off"> B4
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="unbookWhere" id="" value='b5' autocomplete="off"> B5
                                                </label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                            <button type="button" class="btn btn-primary" onclick="check_unbooking()">퇴실하기</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-solid fa-bookmark fa-stack-1x fa-inverse"></i>
                        </span>
                        <p class="my-3 h3">좌석 예약</p>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal3">좌석 예약하기</button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- 모달을 통한 좌석 예약 form 구현 (post 방식으로 booked.php로 해당 폼 전송)-->
                                    <form name="booking_form" method="post" action="booked.php">
                                        <div class="modal-header" style="color:black">
                                            <h5 class="modal-title" id="exampleModalLabel">좌석 예약하기</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" style="color:black">
                                            <div class="mb-3">
                                                <label for="exampleFormControlInput1" class="form-label">
                                                    <?php echo $username ?>님 안녕하세요.
                                                    <br>예약하실 좌석을 선택해주세요.
                                                </label>
                                            </div>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='a1' autocomplete="off"> A1
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='a2' autocomplete="off"> A2
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='a3' autocomplete="off"> A3
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='a4' autocomplete="off"> A4
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='a5' autocomplete="off"> A5
                                                </label>
                                            </div>
                                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                <label class="btn btn-secondary active">
                                                    <input type="radio" name="bookWhere" id="" value='b1' autocomplete="off"> B1
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='b2' autocomplete="off"> B2
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='b3' autocomplete="off"> B3
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='b4' autocomplete="off"> B4
                                                </label>
                                                <label class="btn btn-secondary">
                                                    <input type="radio" name="bookWhere" id="" value='b5' autocomplete="off"> B5
                                                </label>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                                            <button type="button" class="btn btn-primary" onclick="check_booking()">예약하기</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
        <footer class="pt-3 mt-4 text-muted border-top">
            <p class="text-center" style="font-size:small">2022 웹서버프로그래밍 기말과제 - PKD</p>
        </footer>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>