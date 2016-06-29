$(document).ready(function(){

    //banned thread button
    $(".banned_thread_button").click(function(e){
        e.preventDefault();
        var id = $(this).data('service')       ;
        krajeeDialog.confirm("Are you sure you want to ban thread =" + id + " ?", function (result) {
            if (result) {
                return window.location.href = window.location.href + '/../../thread/banned?id=' + id;
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
                return window.location.href = window.location.href + '/../../issue/banned?name=' + name;
            }


        });
        return false;
    })

})
