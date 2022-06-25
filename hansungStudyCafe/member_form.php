<!DOCTYPE html>
<html lang="ko">
<head> 
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/member.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="./js/check_form.js"></script> <!--폼 입력 검증 및 처리 함수-->
    <script type="text/javascript" src="./js/check_id.js"></script> <!--중복 아이디 체크 함수-->
    <script type="text/javascript" src="./js/reset_form.js"></script> <!--폼 리셋 처리 함수-->
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
	<section>
    <div id="top">
        <nav class="navbar bg-light">
            <div class="container-fluid">
                <a href = "index.php">
                <span class="navbar-text mb-0 h3"><i class="fa-solid fa-book"></i> 한성 스터디카페 <i class="fa-solid fa-pencil"></i></span>
                </a>
            </div>
        </nav>
    </div>
    </header>
    
    <div class = "container"> 
        <div class = "row">
        <div class = "col-md-3">
        </div>
        <div class = "col-md-8">
      		<div id="row">
          	<form name="member_form" method="post" action="member_insert.php"> <!--POST방식으로 서버로 보내고 member_insert.php로 데이터를 전송-->
			    <h2>회원 가입</h2>                                              <!--member_insert.php가 데이터베이스에 유저 정보를 업로드 시킴-->
    		    	<div class="form id">
				        <div class="col1">아이디</div>
				        <div class="col2">
							<input type="text" name="id">
                            <a href="#"><img src="./img/check_id.gif" 
				        		onclick="check_id()"></a>                       <!--member_insert.php에서 id를 불러올 때 $_POST['id']을 사용하면 됨-->
				        </div>  
			       	</div>
			       	<div class="clear"></div>

			       	<div class="form">
				        <div class="col1">비밀번호</div>
				        <div class="col2">
							<input type="password" name="pass">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">비밀번호 확인</div>
				        <div class="col2">
							<input type="password" name="pass_confirm">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">
				        <div class="col1">이름</div>
				        <div class="col2">
							<input type="text" name="name">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form email">
				        <div class="col1">이메일</div>
				        <div class="col2">
							<input type="text" name="email1">@<input type="text" name="email2">
                            <img style="cursor:pointer" src="./img/button_save.gif" onclick="check_form()">&nbsp;<!-- cursor:pointer는 해당 범위에 마우스를 가져다 대면 마우스의 형태가 변하도록 만듬 -->
                  		    <img id="reset_button" style="cursor:pointer" src="./img/button_reset.gif"
                  			    onclick="reset_form()">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="bottom_line"> </div>
           	</form>
        	</div> <!-- join_box -->
        </div> <!-- main_content -->
        <div class = "col-md-2">
        </div>
        </div>
    </div>
	</section>
</body>
</html>

