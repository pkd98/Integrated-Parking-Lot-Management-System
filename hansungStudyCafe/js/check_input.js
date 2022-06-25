function check_input() {
      if (!document.message_form.name.value)
    {
        alert("이름을 입력해주세요");
        document.message_form.name.focus();
        return;
    }
    if (!document.message_form.email.value)
    {
        alert("회신받을 이메일을 입력해주세요");
        document.message_form.email.focus();
        return;
    }
    if (!document.message_form.subject.value)
    {
        alert("제목을 입력해주세요");    
        document.message_form.subject.focus();
        return;
    }
    if (!document.message_form.content.value)
    {
        alert("내용이 없습니다");    
        document.message_form.content.focus();
        return;
    }
    document.message_form.submit();
    alert("접수되었습니다!");
 }