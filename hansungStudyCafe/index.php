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
?>                  <a href="member_form.php">회원가입 </a>
                    <a href="login_form.php"> 로그인</a>
                    
                
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
                            <a class="nav-link active h4" aria-current="page" href="index.php">홈</a>
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
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">관리자에게 문의하기</button>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                    <!-- 모달을 통한 쪽지 보내기 form 구현 (post 방식으로 message_insert.php로 해당 폼 전송)-->
                        <form name = "message_form" method="post" action="message_insert.php">
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
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading">한성 스터디카페에 방문해주셔서 감사합니다</div>
                <div class="masthead-heading text-uppercase">Welcome To HANSUNG STUDY CAFE!</div>
            </div>
        </header>
    </header>

    <main>
        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container">
                <div><br></div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <a href="status.php">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-solid fa-chair fa-stack-1x fa-inverse"></i>
                        </span>
                        </a>
                        <p class="my-3 h3">좌석 현황</p>
                        <p class="text-muted">우리 카페의 현재 좌석 현황을 볼 수 있어요. <br>미리 예약과 퇴실 신청도 할 수 있습니다.</p>
                    </div>
                    <div class="col-md-4">
                        <a href="chat.php">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-thin fa-comments fa-stack-1x fa-inverse"></i>
                        </span>
                        </a>
                        <p class="my-3 h3">실시간 고객 소통</h4>
                        <p class="text-muted">실시간 이용중이신 고객님들과 소통하실 수 있습니다.<br>간단한 요청사항을 바로 피드백 해드립니다. </p>
                    </div>
                    <div class="col-md-4">
                        <a href="location.php">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas fa-solid fa-location-dot fa-stack-1x fa-inverse"></i>
                        </span>
                        </a>
                        <p class="my-3 h3">지점 위치</p>
                        <p class="text-muted">우리 지점의 위치 입니다</p>
                    </div>
                </div>
            </div>
        </section>
        <footer class="pt-3 mt-4 text-muted border-top">
            <p class="text-center"style="font-size:small">2022 웹서버프로그래밍 기말과제 - PKD</p>
        </footer>
    </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>