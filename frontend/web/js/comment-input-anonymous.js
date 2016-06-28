
$(document).ready(function(){
    $(document).on('click',".comment-input-anonymous-btn", function(event){
        var thread_id = $(this).data('service');
        var base_url = $("#base-url").val();
        var user_id = $("#user-login-id").val();
        $("#comment-input-anonymous-btn-" + thread_id).text("Loading..").prop("disabled", true);

        $.ajax({
            type:'post',
            url: base_url + "/thread/request-anonymous",
            data: {thread_id: thread_id, user_id: user_id},
            success: function(data){
                if(data === '1'){
                    $("#comment-input-anonymous-section-anonymous-" + thread_id).show();
                    $("#comment-input-anonymous-section-non-anonymous-" + thread_id).hide();
                }
                $("#comment-input-anonymous-btn-" + thread_id).text("Go Anonymous").prop("disabled", false);

            }
        })
    });

    $(document).on('click', '.comment-input-anonymous-cancel-btn', function(event){
        var thread_id = $(this).data('service');
        var base_url = $("#base-url").val();
        var user_id = $("#user-login-id").val();

        $("#comment-input-anonymous-cancel-btn-" + thread_id).text("Loading..").prop("disabled", true);

        $.ajax({
            type:'post',
            url: base_url + "/thread/cancel-anonymous",
            data: {thread_id: thread_id, user_id: user_id},
            success: function(data){
                if(data === '1'){
                    console.log("show");
                    $("#comment-input-anonymous-section-anonymous-" + thread_id).hide();
                    $("#comment-input-anonymous-section-non-anonymous-" + thread_id).show();
                }
                $("#comment-input-anonymous-cancel-btn-" + thread_id).text("Cancel").prop("disabled", false);

            }
        })


    });
});