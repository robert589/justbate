                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $(document).ready(function() {

    // some script to define the height of edit, delete, share, and comment button
    var x1 = $("#first-part").height();
    var x2 = $("#first-part").width();
    var xTab = $("#first-part  div.col-xs-12 li");
    var y = $("div#comment-tab div.tabs-above ul.nav-tabs");
    var yChild = $("div#comment-tab div.tabs-above ul.nav-tabs li");

    yChild.width(xTab.width());
    var w1 = ($("div#first-part").width()/(y.children.length+1));

    if ($(window).innerWidth() < 768) {
        // DOM style for description and vote
        $("div#action-button-thing").width($("div#first-part").width()/4);
        $("#action-button").removeclass("col-xs-6");
    }

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

    //menu bar
    $("#loginMenu").click(function(){
        $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
    });

    $("div#create-thread-dropdown").click(function() {
        $("div#create-thread-form").slideToggle("fast");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-down");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-up");
    });

    // site_home
    $("#comment_hide_list_thread_btn").click(function(){
        if($(this).text() == 'Comment'){
            $("#list_thread_comment_part").show();
            $('#comment_hide_list_thread_btn').text('Hide');
        } else {
            $("#list_thread_comment_part").hide();
            $('#comment_hide_list_thread_btn').text('Comment');
        }
    });

    // thread
    $("#edit_thread").click(function(){
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

    $("#cancel_edit_thread_button").click(function(){
        $("#shown_part").show();
        $("#edit_part").hide();
    });

    function beginProfilePicModal(){
        $("#uploadProfilePicModal").modal("show")
        .find('#uploadProfilePicModal')
        .load($(this).attr("value"));
    }
    $("li#notif-expansion").click(function() {
        //the reason of length 0 instead of 1 because this code is executed first then the notifcation is opened
        if($('#notif-expansion').parent().find('.open').length == 0){
            $("#notification-form").submit();
        }
    });

    function beginLoginModal(){
        $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
    }

    $("#login_link").click(function(){
        beginLoginModal();
        return false;
    });
});

$("button#comment_post").click(function() {
    $("div#w6-container").slideToggle("fast");
});
