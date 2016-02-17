$(document).ready(function() {
    $("img#avatar").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("div#upload-image").css("opacity","1");
    });

    $("div#upload-image").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("div#upload-image").css("opacity","1");
    });

    $("div#upload-image").mouseout(function() {
        $("img#avatar").css("opacity","1");
        $("div#upload-image").css("opacity","0");
    });

    $("img#avatar").mouseout(function() {
        $("img#avatar").css("opacity","1");
        $("div#upload-image").css("opacity","0");
    });

    $("#loginMenu").click(function(){
        $("#loginModal").modal("show")
            .find('#loginModal')
            .load($(this).attr("value"));
    });
})
