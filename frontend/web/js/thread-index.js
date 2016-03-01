$(document).on('click', '#edit_thread', function(){
    $("#shown_part").hide();
    $("#edit_part").show();
});

$("#delete_thread").on("click", function() {
    krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
        if (result) {
            $("#delete_thread_form").submit();
            return false;
        }
    });
});


$(document).on('click', '#cancel_edit_thread_button', function(){
    $("#shown_part").show();
    $("#edit_part").hide();
});