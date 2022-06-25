function check_unbooking() {
    if (!document.unbooking_form.unbookWhere.value) {
        alert("퇴실할 곳을 골라주세요");
        document.unbooking_form.unbookWhere.focus();
        return;
    }
    document.unbooking_form.submit();
}