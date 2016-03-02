$(document).ready(function() {

    //on profile/index
    $("img#avatar").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("button#upload-image").css("opacity","1");
    });

    $("button#upload-image").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("button#upload-image").css("opacity","1");
    });

    $("button#upload-image").mouseout(function() {
        $("img#avatar").css("opacity","1");
        $("button#upload-image").css("opacity","0");
    });

    $("img#avatar").mouseout(function() {
        $("img#avatar").css("opacity","1");
        $("button#upload-image").css("opacity","0");
    });

    $("#loginMenu").click(function(){
        $("#loginModal").modal("show")
            .find('#loginModal')
            .load($(this).attr("value"));
    });

    // $("button#create-button").mouseenter(function(){
    //     $('span#create-button-label').css("text-decoration","underline");
    // });
    //
    // $("button#create-button").mouseleave(function(){
    //     $('span#create-button-label').css("text-decoration","none");
    // });
    $("div#create-thread-dropdown").click(function() {
        $("div#create-thread-form").slideToggle("fast");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-down");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-up");
    });

})

//site_home
$(document).on('click', '#comment_hide_list_thread_btn', function(){
    if($(this).text() == 'Comment'){
        $("#list_thread_comment_part").show();
        $('#comment_hide_list_thread_btn').text('Hide');

    }
    else{
        $("#list_thread_comment_part").hide();
        $('#comment_hide_list_thread_btn').text('Comment');
    }
});
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



function beginProfilePicModal(){
    $("#uploadProfilePicModal").modal("show")
        .find('#uploadProfilePicModal')
        .load($(this).attr("value"));
}

$(document).click(function() {
    //the resason of length 0 instead of 1 because this code is executed first then the notifcation is opened
    if($('#notif-expansion').parent().find('.open').length == 0){
        $("#notification-form").submit();
    }
});




function beginLoginModal(){
    $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
}

$(document).on('click', '#login_link', function(){
    beginLoginModal();
    return false;
});

