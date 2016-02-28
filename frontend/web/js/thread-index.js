$(document).on('click', '#edit_thread', function(){
    $("#shown_part").hide();
    $("#edit_part").show();
});


$(document).on('click', '#cancel_edit_thread_button', function(){
    $("#shown_part").show();
    $("#edit_part").hide();
});