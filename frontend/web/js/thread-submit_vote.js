function disagreeButton(){

    $('#hiddenInputVoteThread').val(-1);

    $('#submitThreadVoteForm').submit();


}

function agreeButton(){
    $('#hiddenInputVoteThread').val(1);
    $('#submitThreadVoteForm').submit();

}

function beginLoginModal(){
    $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
}