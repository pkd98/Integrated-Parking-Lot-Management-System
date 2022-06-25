<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="./js/check_input.js"></script> <!--관리자에게 문의하기 모달 처리 함수-->
    <!-- bootstrap 사용 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css"
      rel="stylesheet"/>
    <link rel="stylesheet" href="css/style.css">
    <!-- 구글 웹폰트 적용 (DoHyeon 폰트)-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
    <title>한성 스터디카페</title>
    <!-- font Awesome 로고 사용-->
    <script src="https://kit.fontawesome.com/9404168568.js" crossorigin="anonymous"></script>
    <style>
        p {font-family: 'Do Hyeon', sans-serif;}
        p.a {
        font-weight: 400;}
        p.b {
        font-weight: 700;}
        p.c {
        font-weight: 800;}
        p.d {
        font-weight: bold;}
        a{font-family: 'Do Hyeon', sans-serif;} span{font-family: 'Do Hyeon', sans-serif;}
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
    if(!$userid) {
?>                  <a href="member_form.php">회원가입 </a> <!-- member_form 작성 요망-->
                    <a href="login_form.php"> 로그인</a>  <!-- login_form 작성요망-->
                    
                
<?php
    }   else    {
            $logged = $username."님 안녕하세요";
        ?>
                    <?=$logged?>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample05"
                    aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarsExample05">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 h4">
                        <li class="nav-item">
                            <a class="nav-link h4" aria-current="page" href="index.php">홈</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link h4" href="status.php">좌석 현황</a> <!-- status.php 정의-->
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
                            <a class="nav-link active h4" href="admin_main.php">관리자</a> <!-- 관리자 페이지 정의 -->
                        </li>
                    <?php
                        }
                    ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main>
    <section>
        <div class="container">
            <div><br></div>
            <p class = "h2 text-center"> 스터디 카페 현황</p>
        </div>

        <div class="container">
        <?php
            $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");		// hansung_studycafe DB에 접근
            $sql = "select * from members";                                                 // member 테이블에 회원이 몇 명 있는지 확인하기 위한 쿼리
            $result = mysqli_query($con, $sql);
            $num_record = mysqli_num_rows($result);								            // 해당 record가 몇 개 인지 확인
        ?>
            <table class="table text-nowrap table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">회원 수</th>
                            <td><?=$num_record?></td>
                    </tr>
                    <?php
                        mysqli_close($con);                // DB 연결 끊기

                        $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");		// hansung_studycafe DB에 접근
                        $sql = "select * from status where id IS NOT NULL";                             // status 테이블에서 id 값이 있는 record를 추출
                        $result = mysqli_query($con, $sql);
                        $num_record = mysqli_num_rows($result);								            // 해당 record가 몇 개 인지 확인
                    ?>
                    <tr>
                        <th scope="row">사용 중인 좌석</th>
                            <td><?=$num_record?>/10</td>
                    </tr>
                    <?php
                        mysqli_close($con);                // DB 연결 끊기
                    ?>
                </tbody>
            </table>
        </div>

        <div class="container">
            <div><br></div>
            <p class = "h2 text-center"> 퇴실처리</p>
            <div><br></div>
        </div>

        <div class="container">
        <?php
        $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");		// hansung_studycafe DB에 접근
        $sql = "select * from status where id IS NOT NULL";                             // status 테이블에 회원이 몇 명 있는지 확인하기 위한 쿼리(id 값을 이용)
        $result = mysqli_query($con, $sql);
        $num_record = mysqli_num_rows($result);								            // 해당 record가 몇 개 인지 확인
        ?>
            <table class="table table-striped text-nowrap table-bordered">
                <thead>
                    <tr>
                        <th scope="col">번호</th>
                        <th scope="col">이름</th>
                        <th scope="col">좌석</th>
                        <th scope="col">등록 시간</th>
                        <th scope="col">퇴실</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    while ($i <= $num_record)                            // message 테이블에 있는 record의 개수만큼 반복
                    {
                        $row = mysqli_fetch_array($result);             // 하나의 레코드 가져오기
                        $name = $row["name"];                           // message 테이블에서 각각 이름, 좌석, 등록시간을 추출
                        $seat = $row["seat"];                           
                        $checkin_time = $row["checkin_time"];

                        echo "<tr>";
                        echo "<td>$i</td>";                             // cell 마다 해당 데이터를 삽입
                        echo "<td>$name</td>";
                        echo "<td>$seat</td>";
                        echo "<td>$checkin_time</td>";
                        echo "<td>"
                
                ?>
                        <button type = "button" onclick = "location.href='admin_member_delete.php?seat=<?=$seat?>'">퇴실</button>    <!-- 삭제 버튼 클릭하면 admin_member_delete.php로 seat을 GET 방식으로 전송 -->
                <?php
                        echo "</td>";
                        echo "</tr>";
                        $i++;
                    }
                ?>
                <?php
                    mysqli_close($con);                // DB 연결 끊기
                ?>
                </tbody>
            </table>
        </div>

        <div class="container">
            <div><br></div>
            <p class = "h2 text-center"> 보고된 문의 사항</p>
            <div><br></div>
        </div>

        <div class="container">
        <?php
            $con = mysqli_connect("localhost", "root", "", "hansung_studycafe");		// hansung_studycafe DB에 접근
            $sql = "select * from message";                                                 // message 테이블의 있는 record를 추출
            $result = mysqli_query($con, $sql);
            $num_record = mysqli_num_rows($result);								            // message 테이블의 있는 record의 개수를 추출
        ?>
        <table class="table table-striped text-nowrap table-bordered">
            <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">이름</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">제목</th>
                    <th scope="col">문의 사항</th>
                    <th scope="col">삭제</th>
                </tr>
            </thead>
            <tbody>
    
            <?php
                $i = 0;
                while ($i < $num_record)                            // message 테이블에 있는 record의 개수만큼 반복
                {
                    $row = mysqli_fetch_array($result);             // 하나의 레코드 가져오기
                    $num = $row["num"];                             // message 테이블에서 각각 번호, 이름, 이메일 등을 추출
                    $name = $row["send_name"];
                    $email = $row["email"];
                    $subject = $row["subject"];
                    $content = $row["content"];

                    echo "<tr>";
                    echo "<td>$num</td>";                           // cell 마다 해당 데이터를 삽입
                    echo "<td>$name</td>";
                    echo "<td>$email</td>";
                    echo "<td>$subject</td>";
                    echo "<td>$content</td>";
                    echo "<td>"
            ?>
                    <button type = "button" onclick = "location.href='admin_message_delete.php?num=<?=$num?>'">삭제</button>    <!-- 삭제 버튼 클릭하면 admin_member_delete.php로 seat을 GET 방식으로 전송 -->
            <?php
                echo "</td>";
                echo "</tr>";

                $i++;
                }
            ?>
            <?php
                mysqli_close($con);                // DB 연결 끊기
            ?>
        </tbody>
        </table>
        </div>
    </section>


            <footer class="pt-3 mt-4 text-muted border-top">
                <p class="text-center"style="font-size:small">2022 웹서버프로그래밍 기말과제 - PKD</p>
            </footer>
    </main>
</body>
</html>