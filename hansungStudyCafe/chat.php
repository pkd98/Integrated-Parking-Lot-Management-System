<!DOCTYPE html>
<html lang="ko">
<head>
    <!-- php 채팅 구현 참고 : https://github.com/jgs901221/phpchattingsite -->
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
        div.chat_content {
        padding: 10px; /* 테두리와 내용물 사이의 여백 : 10px */
        height:20em;
        background-color: white;}
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
                            <a class="nav-link h4 active" href="chat.php">실시간 고객 소통</a> <!-- 고객 소통 채팅방 정의-->
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
    </header>

    <main>
        <!-- 채팅방 구현 -->
        <section class="page-section" id="chatsection">
        <div class="container">
                <div class="row text-center">
                    <div><br></div>
                    <p class=" h2">실시간 고객 채팅방<br></p>
                </div>
                <div name= "chat_content" class="chat_content mb-3" style="border:1px solid; line-height: 1.5em; overflow-y:auto" id="chat_content"></div>
    <!-- 채팅창 구역 스타일은 테두리 1px 실선. 줄간격 1.5em. y축 스크롤은 자동. 이 태그는 chat_content라는 아이디 값을 가짐. -->

                <div class="mb-3">
                    <textarea name="user_input" class="form-control" id="user_input" rows="2" placeholder="채팅 입력 창 입니다." onkeyup="replace()"></textarea>
                </div>
                <div class="d-grid gap-2 col-12 mx-auto">
                    <button class="btn btn-primary" type="button" onclick="apply()">메세지 전송</button>
                </div>
                <div>
                    <input type="hidden" id="userid" value="<?=$userid?>">
                </div>
        </div>
        </section>
        <footer class="pt-3 mt-4 text-muted border-top">
            <p class="text-center"style="font-size:small">2022 웹서버프로그래밍 기말과제 - PKD</p>
        </footer>
    </main>
        <script>
            var count = 1; //변수 count의 초기값은 1
            var a,b,txt = ""; //a와 b라는 이름의 변수 선언
            var height, height2, height3, height4; //height~height4까지의 이름을 지닌 변수 선언
            var l1, l2; //l1,l1라는 이름의 변수 선언
            var myVar = setInterval(myTimer, 1000); //myVar변수는 Interval 셋팅값에 의해 1초 간격으로 myTimer()함수 실행한다.
            function myTimer() {//myTimer()함수
                //obj, dbParam, xmlhttp, myObj, x라는 이름의 변수 선언 및 txt변수의 경우 초기 함수실행시마다 초기 값으로 빈값을 가짐.
                var obj, dbParam, xmlhttp, myObj, x;
                obj = {"table":"tableforchat"}; //obj에 자바스크립트 객체 값을 저장함
                dbParam = JSON.stringify(obj); //dbParam에 obj에 담긴 자바스크립트 객체의 값을 JSON형식의 문자열로 저장함.
                xmlhttp = new XMLHttpRequest(); //서버에 데이터를 요청한 값을 xmlhttp변수에 저장함
                /* 채팅이 채팅창에 즉시 반영될 수 있도록 함*/
                xmlhttp.onreadystatechange = function() {
                //onreadystatechange는 xmlhttpRequest 객체의 상태가 변할 때마다 자동으로 호출할 Lambda 익명 함수를 저장함.
                if (this.readyState == 4 && this.status == 200) {//readyState 값이 4이고, status값이 200이라면 if문 안에 있는 내용을 실행함
                    myObj = JSON.parse(this.responseText);//응답받은 JSON형식의 문자열을  자바스크립트 객체 값으로 myObj에 저장
                    l1 = myObj.length;//myObj객체에 담긴 배열의 길이를 l1에 저장
                    if(l1 != l2) txt=""; //l1과 l2의 값이 같지 않을 경우 txt는 빈값을 가지게 만듦.
                    if(txt=="") {
                        for (x in myObj) { //myObj 객체의 배열의 길이 값만큼 반복
                            txt +=
                                "<span style='font-size: 15px;'>"+myObj[x].chatuser.replace(/ /g,"&nbsp").replace(/</g,"&lt")
                            .replace(/>/g,"&gt")+" :<br>"+"</span>"
                            //닉네임(아이디)의 글자를 15px 크기로 화면에 표시한다. 닉네임의 공백을 &nbsp로 <는 &lt로, >는 &gt로 각각 변경
                            //닉네임 : 형식으로 표시해준 후 줄바꿈을 해준다.
                            +myObj[x].chattext.replace(/ /g,"&nbsp").replace(/</g,"&lt")
                            .replace(/>/g,"&gt").replace(/\n/g,"<br>")
                            .replace(/\r\n/g,"<br>")
                            //채팅창에 채팅 내용 담긴 띄어쓰기 값은 &nbps로, <는 &lt로, >는 &gt로, \n 및 \r\n은 <br>로,
                            //화면에 표시해준 후 줄바꿈을 해준다.
                            +"<span style='font-size: 10px;'>"+myObj[x].chattime+"</span>"+"<br>";
                            //채팅을 했던 날짜 및 시간 정보를 10px크기로 화면에 표시해준 후 줄바꿈을 해준다.
                        }
                    }
                    document.getElementById("chat_content").innerHTML = txt; //chat_content 입력창 내용에 html콘텐츠 값을 txt에 저장된 값으로 바꾸어준다.
                    height2 = document.getElementById("chat_content").scrollTop; //height2는 chat_content 아이디를 가진 요소의 스크롤 탑 값을 저장한다.
                    height4 = document.getElementById("chat_content").scrollHeight; //heigt4는 chat_content 아이디를 가진 요소의 스크롤 높이 값을 저장한다.
                    if(height2 < height) {count = 0;}//height2의 값이 height의 값보다 작다면 count의 값은 0이 된다.
                    if((height2 + height3 + 10)>= height4) { //height2+height3+10을 더한 값이 height4보다 크거나 같다면 count의 값은 1이 된다.
                        count = 1;
                    }
                    if(count == 1) {//count의 값이 1이 된다면, 채팅창 구역이 스크롤 탑과 스크롤 높이 값이 같은 값을 가지도록 함
                        document.getElementById("chat_content").scrollTop =  
                            document.getElementById("chat_content").scrollHeight;
                        test(); //test()함수를 실행한다.
                    }
                    l2=l1;//12는 l1의 값을 가진다.
                    }
                };
                xmlhttp.open("GET", "json_demo_db.php?content=" + dbParam, true);
                //요청 유형을 지정한다.(get방식, url, 비동기 방식)
                xmlhttp.send();
                //서버에 요청을 보낸다.
            }

            function test() { //test() 함수
                height = document.getElementById("chat_content").scrollTop; //height는 채팅창의 스크롤 탑 값을 가진다.
                height2 = height; //height2는 height의 값을 가진다.
                height3 = document.getElementById("chat_content").scrollHeight 
                - document.getElementById("chat_content").scrollTop;
                //height3는 demo 아이디 값을 가진 요소의 (스크롤 높이 - 스크롤 탑)의 값을 가진다.
            }

            function apply() { //apply() 함수
                var x2 = document.getElementById("user_input").value; //x2는 사용자 입력 내용 값을 저장
                var x3 = document.getElementById("userid").value; // x3는 로그인된 아이디 저장

                const now = new Date();
                const utcNow = now.getTime() + (now.getTimezoneOffset() * 60 * 1000); // 현재 시간을 utc로 변환한 밀리세컨드값
                const koreaTimeDiff = 18 * 60 * 60 * 1000; // 한국 시간은 UTC보다 9시간 빠름(9시간의 밀리세컨드 표현)
                const x4 = new Date(utcNow + koreaTimeDiff); // utc로 변환된 값을 한국 시간으로 변환시키기 위해 9시간(밀리세컨드)를 더함
                
                var obj, dbParam, xmlhttp; //obj, dbParam, xmlhttp 라는 이름을 지닌 변수
                obj = {"table":"tableforchat","chatuser":x3,"chattext":x2,"chattime":x4};//obj에 데이터베이스에 저장할 속성에 맞는 각 객체 값을 저장함
                dbParam = JSON.stringify(obj); //dbParam에 obj에 담긴 자바스크립트 객체의 값을 JSON형식의 문자열로 저장함.
                xmlhttp = new XMLHttpRequest(); //서버에 데이터를 요청한 값을 xmlhttp변수에 저장함

                if (x2.trim() == "") { //입력 값 없음
                    alert("입력된 텍스트가 없습니다.");
                    return false;
                }

                else { //정상적으로 텍스트 전송
                    count = 1; //전역변수 count의 값은 1이 된다.
                    document.getElementById("user_input").innerHTML = "";
                    document.getElementById("chat_content").scrollTop =  document.getElementById("chat_content")
                    .scrollHeight;
                    xmlhttp.open("GET", "json_demo_db2.php?content=" + dbParam, true);
                    //요청 유형을 지정한다.(get방식, url, 비동기 방식)
                    xmlhttp.send(); //서버에 요청을 보낸다.
                }
            }

            function replace() { //replace() 함수
                document.getElementById("user_input").value=document.getElementById("user_input").value
                .replace("+","＋").replace(/#/g,"＃").replace(/&/g,"＆").replace(/=/g,"＝")
                .replace(/\\/g,"＼");
                //사용자 입력창 내용중 특수문자들을 교체 +는 ＋로, #은 ＃로, &는 ＆로, =은 ＝로,\는 ＼로 교체된다.
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>