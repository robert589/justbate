$(document).ready(function() {
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
