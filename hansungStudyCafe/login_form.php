<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/common.css">	<!-- CSS 파일 불러오기 -->
<link rel="stylesheet" type="text/css" href="./css/login.css">
<script type="text/javascript" src="./js/login.js"></script>	<!-- 자바 스크립트 파일 불러오기, 이 파일은 로그인 페이지의 아이디와 비밀번호 입력창에 데이터가 있는지 검사 후 경고창을 출력함. 데이터가 제대로 입력되었다면 login.php으로 이동 -->
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
</head>
<body> 
	<header>
    </header>
	<section>
	<div id="top">
        <nav class="navbar bg-light">
            <div class="container-fluid">
                <a href = "index.php">
                <span class="navbar-text mb-0 h3"><i class="fa-solid fa-book"></i> 한성 스터디카페 <i class="fa-solid fa-pencil"></i> </span>
                </a>
            </div>
        </nav>
    </div>
        <div id="main_content">
      		<div id="login_box">
	    		<div id="login_title">
		    		<span>로그인</span>
	    		</div>
	    		<div id="login_form">											<!-- form 문의 스타일을 지정하기 위한 id 설정 -->
          		<form  name="login_form" method="post" action="login.php">		<!-- POST방식으로 login.php에 전송 -->       	
                  	<ul>
                    <li><input type="text" name="id" placeholder="아이디" ></li>	<!-- login.php에서 'id' 변수명으로 불러옴 -->
                    <li><input type="password" id="pass" name="pass" placeholder="비밀번호" ></li> <!-- login.php에서 'pass' 변수명으로 불러옴 -->
                  	</ul>
                  	<div id="login_btn">
                      	<a href="#"><img src="./img/login.png" onclick="check_input()"></a>	<!-- 버튼을 클릭하면 login.js의 check_input()이 실행, 이 함수는 아이디와 비밀번호 입력창에 데이터가 입력되었는지 검사함. 데이터가 입력되었으면 <form> 문의 action 속성에 설정된 login.php로 이동-->
                  	</div>		    	
           		</form>
        		</div> <!-- login_form -->
    		</div> <!-- login_box -->
        </div> <!-- main_content -->
	</section> 
</body>
</html>

