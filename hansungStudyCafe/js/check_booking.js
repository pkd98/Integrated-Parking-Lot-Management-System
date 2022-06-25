function check_booking() {
    if (!document.booking_form.bookWhere.value) {
        alert("예약할 곳을 골라주세요");
        document.booking_form.bookWhere.focus();
        return;
    }
    document.booking_form.submit();
}