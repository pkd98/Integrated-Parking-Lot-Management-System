function check_input()
{
    if (!document.login_form.id.value)  // id 값이 입력되지 않았으면 실행
    {
        alert("아이디를 입력하세요");    
        document.login_form.id.focus(); // 커서가 id 부분으로 이동
        return;
    }

    if (!document.login_form.pass.value)    // pass 값이 입력되지 않았으면 실행
    {
        alert("비밀번호를 입력하세요");    
        document.login_form.pass.focus();   // 커서가 id 부분으로 이동
        return;
    }
    document.login_form.submit();       // submit 기능의 의해서 데이터베이스로 id와 pass가 전송
}