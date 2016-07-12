$(document).ready(function(){

    //banned thread button
    $(".banned_thread_button").click(function(e){
        e.preventDefault();
        var id = $(this).data('service')       ;
        krajeeDialog.confirm("Are you sure you want to ban thread =" + id + " ?", function (result) {
            if (result) {
                return window.location.href = $("#base-url").val() + '/thread/banned?id=' + id;
            }


        });
        return false;
    })

    //banned issue button
    $(".banned_issue_button").click(function(e){
        e.preventDefault();
        var name = $(this).data('service')       ;
        krajeeDialog.confirm("Are you sure you want to ban issue \"" + name + "\" ?", function (result) {
            if (result) {
                return window.location.href = $("#base-url").val() + '/issue/banned?name=' + name;
            }
        });
        return false;
    })

    //banned thread-comment button
    $(".banned_comment_button").click(function(e){
        e.preventDefault();
        var id = $(this).data('service')       ;
        krajeeDialog.confirm("Are you sure you want to ban comment " + id + "?", function (result) {
            if (result) {
                return window.location.href =  $("#base-url").val() + '/comment/banned?id=' + id;
            }
        });
        return false;
    })

})
