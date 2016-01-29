function disagreeButton(){
    $('#hiddenInputVoteThread').val(-1);

    $('#submitThreadVoteForm').submit();

}

function agreeButton(){
    $('#hiddenInputVoteThread').val(1);
    $('#submitThreadVoteForm').submit();

}