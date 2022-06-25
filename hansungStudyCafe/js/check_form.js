function check_form()
{
   if (!document.member_form.id.value) { //사용자가 아이디를 입력하지 않으면 실행
       alert("아이디를 입력하세요!");    
       document.member_form.id.focus();  //해당 위치로 커서가 이동
       return;
   }

   if (!document.member_form.pass.value) {   //사용자가 비밀번호를 입력하지 않으면 실행
       alert("비밀번호를 입력하세요!");    
       document.member_form.pass.focus();
       return;
   }

   if (!document.member_form.pass_confirm.value) {
       alert("비밀번호확인을 입력하세요!");    
       document.member_form.pass_confirm.focus();
       return;
   }

   if (!document.member_form.name.value) {
       alert("이름을 입력하세요!");    
       document.member_form.name.focus();
       return;
   }

   if (!document.member_form.email1.value) {
       alert("이메일 주소를 입력하세요!");    
       document.member_form.email1.focus();
       return;
   }

   if (!document.member_form.email2.value) {
       alert("이메일 주소를 입력하세요!");    
       document.member_form.email2.focus();
       return;
   }

   if (document.member_form.pass.value != 
         document.member_form.pass_confirm.value) {  //입력한 비밀번호가 서로 다르면 실행
       alert("비밀번호가 일치하지 않습니다.\n다시 입력해 주세요!");
       document.member_form.pass.focus();
       document.member_form.pass.select();   //입력한 내용을 모두 선택되게 함
       return;
   }

   document.member_form.submit();            // 회원가입 페이지의 모든 정보를 서버로 전송
}                                            // 실제로 모든 정보가 이 때 서버로 넘어감
