function reset_form() {                      // 회원가입 페이지의 모든 정보를 삭제
    document.member_form.id.value = "";       // 사용자가 '취소하기'를 눌렀을 때 실행하는 것이 목적
    document.member_form.pass.value = "";
    document.member_form.pass_confirm.value = "";
    document.member_form.name.value = "";
    document.member_form.email1.value = "";
    document.member_form.email2.value = "";
    document.member_form.id.focus();
    return;
 }