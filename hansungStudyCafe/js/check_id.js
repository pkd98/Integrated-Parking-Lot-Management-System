function check_id() {                        // 중복된 아이디를 체크하는 것이 목적
    window.open("member_check_id.php?id=" + document.member_form.id.value,     // member_check_id.php 파일에서 담당, GET방식으로 전달
        "IDcheck",                             // IDcheck는 새로운 윈도우의 타이틀
         "left=700,top=300,width=350,height=200,scrollbars=no,resizable=yes"); // 새로 만들어진 윈도우의 설정
  }