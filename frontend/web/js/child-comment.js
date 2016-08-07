/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function checkGuest() {
    var login_id = $("#user-login-id").val();
    if(login_id === ''  || login_id === null || login_id === undefined ) {
        beginLoginModal();
        return true;
    }

    return false;
}
function beginLoginModal() {
    $("#loginModal").modal("show")
    .find('#loginModal')
    .load($(this).attr("value"));

}

$(document).on("mouseenter", ".child-comment-container", function() {
    $(this).find(".child-comment-action-wrapper").removeClass("child-comment-hide");
});

$(document).on("mouseleave", ".child-comment-container", function() {
    $(this).find(".child-comment-action-wrapper").addClass("child-comment-hide");
});

 $(document).on('click', '.child-comment-input-box-submit-button', function(event){
        if(checkGuest() === true){
            return false;
        };
        var comment_id = $(this).data('service');
        var text_to_submit = $("#child-comment-input-box-text-area-" + comment_id).val();
        if(text_to_submit.trim() === null || text_to_submit.trim() === ''){
            return false;
        }
        var data ={comment_id: comment_id,
                    first_name: $("#user-login-first-name").val(),
                    last_name: $("#user-login-last-name").val(),
                    total_like: 0, total_dislike: 0,
                    photo_path: $("#user-login-photo-path").val(),
                    username: $("#user-login-username").val(),
                    comment: text_to_submit};

        var html_data = applyTemplate(data);
        $("#child-comment-input-box-text-area-" + comment_id).val("");
        $("#child-comment-list-new-comment-" + comment_id).prepend(html_data);

        $.ajax({
            url: $("#base-url").val() + "/comment/submit-child-comment",
            type: 'post',
            data : {comment_id: comment_id, text: text_to_submit},
            success: function(data) {
            }
        });


    });



    function applyTemplate(data){
        var copied = $("#child-comment-template").html();
        copied = copied .replaceAll('~comment_id', data.comment_id)
            .replaceAll('~first_name', data.first_name)
            .replaceAll('~last_name', data.last_name)
            .replaceAll('~total_like', data.total_like)
            .replaceAll('~total_dislike', data.total_dislike)
            .replaceAll('default.png', data.photo_path)
            .replaceAll('~username', data.username)
            .replaceAll('~comment', data.comment);
        return copied;

    }


    $(document).on('click', '.retrieve-child-comment-link', function(event){
        var comment_id = $(this).data('service');
        if($("#comment_part_" + comment_id).length === 1){
            event.preventDefault();
            if($("#comment_part_" + comment_id).is(":visible")){
                $("#comment_part_" + comment_id).css("display", "none");
                $(".col-xs-12.text-center").css("display", "none");
            }
            else{
                $("#comment_part_" + comment_id).css("display", "inline");
                $(".col-xs-12.text-center").css("display", "inline");
            }
        }
        else{
            $.pjax.click(event,{container: "#child_comment_" + comment_id,
                push:false,
                scrollTo : false,
                timeout:false,
                skipOuterContainers:true});
        }
    });
