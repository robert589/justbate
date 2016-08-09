/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
   
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


    $(document).on('click', '.child-comment-input-box-submit-button', function(event) {
        var id = $(this).data('id');
        var widget = $("#" + id);
        var text_area = widget.find('.child-comment-input-box-text-area');
        var new_comment_area = widget.find('.child-comment-input-box-new-comment-list');
        var text_to_submit = text_area.val();
        if(text_to_submit.trim() === null || text_to_submit.trim() === ''){
            return false;
        }
        var data ={comment_id: 0,
                    first_name: $("#user-login-first-name").val(),
                    last_name: $("#user-login-last-name").val(),
                    total_like: 0, total_dislike: 0,
                    photo_path: $("#user-login-photo-path").val(),
                    username: $("#user-login-username").val(),
                    comment: text_to_submit};

        var html_data = applyTemplate(data);
        text_area.val("");
        new_comment_area.prepend(html_data);

        $.ajax({
            url: $("#base-url").val() + "/comment/submit-child-comment",
            type: 'post',
            data : {comment_id: comment_id, text: text_to_submit},
            success: function(data) {
            }
        });

    }); 
});