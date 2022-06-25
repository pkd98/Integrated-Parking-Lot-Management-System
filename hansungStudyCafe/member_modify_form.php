<!DOCTYPE html>
<html>
<head> 
<meta charset="utf-8">
<title>PHP 프로그래밍 입문</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">
<link rel="stylesheet" type="text/css" href="./css/member.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script type="text/javascript" src="./js/member_modify.js"></script><!-- 이 파일은 회원정보 수정 페이지의 아이디와 비밀번호 등이 입력창에 데이터가 있는지 검사 후 경고창을 출력함. 데이터가 제대로 입력되었다면 member_modify.php으로 이동 -->
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
		<?php    
			$con = mysqli_connect("localhost", "root", "", "hansung_studycafe");		// 현재 로그인된 userid를 통해 DB에 연결
			$sql    = "select * from members where id='$userid'";
			$result = mysqli_query($con, $sql);
			$row    = mysqli_fetch_array($result);			// 한 레코드로 변환해서 저장

			$pass = $row["pass"];							// mysqli_fetch_array()함수를 사용하면 $row으로 레코드의 한 필드에 따로 접근 가능
			$name = $row["name"];

			$email = explode("@", $row["email"]);			// @ 기호를 기준으로 문자열을 분리
			$email1 = $email[0];							// 이메일 아이디 저장
			$email2 = $email[1];							// 이메일 도메인 저장
			mysqli_close($con);
		?>
</head>
<body>
	<section>
        <div id="main_content">
      		<div id="join_box">
          	<form  name="member_form" method="post" action="member_modify.php?id=<?=$userid?>">		<!-- member_modify.php에 POST 방식으로 전달, but userid는 GET 방식으로 전달 -->
			    <h2>회원 정보수정</h2>
    		    	<div class="form id">
				        <div class="col1">아이디</div>
				        <div class="col2">
							<?=$userid?>
				        </div>                 
			       	</div>
			       	<div class="clear"></div>

			       	<div class="form">					<!-- 수정할 내용은 form 문으로 지정 -->
				        <div class="col1">비밀번호</div>
				        <div class="col2">
							<input type="password" name="pass" value="<?=$pass?>">	<!-- 초기 값으로 기존의 비밀번호가 입력되어 있음 -->
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">					<!-- 수정할 내용은 form 문으로 지정 -->
				        <div class="col1">비밀번호 확인</div>
				        <div class="col2">
							<input type="password" name="pass_confirm" value="<?=$pass?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form">					<!-- 수정할 내용은 form 문으로 지정 -->
				        <div class="col1">이름</div>
				        <div class="col2">
							<input type="text" name="name" value="<?=$name?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="form email">			<!-- 수정할 내용은 form 문으로 지정 -->
				        <div class="col1">이메일</div>
				        <div class="col2">
							<input type="text" name="email1" value="<?=$email1?>">@<input 
							       type="text" name="email2" value="<?=$email2?>">
				        </div>                 
			       	</div>
			       	<div class="clear"></div>
			       	<div class="bottom_line"> </div>
			       	<div class="buttons">
	                	<img style="cursor:pointer" src="./img/button_save.gif" onclick="check_input()">&nbsp;
                  		<img id="reset_button" style="cursor:pointer" src="./img/button_reset.gif"
                  			onclick="reset_form()">
	           		</div>
           	</form>
        	</div> <!-- join_box -->
        </div> <!-- main_content -->
	</section>
</body>
</html>