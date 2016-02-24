function getNotification(){
    //the resason of length 0 instead of 1 because this code is executed first then the notifcation is opened
    if($('#notif-expansion').parent().find('.open').length == 0){
       $("#notification-form").submit();
    }
}

function beginLoginModal(){
    $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
}

$(document).on('click', '#login_link', function(){
    beginLoginModal();
    return false;
});
