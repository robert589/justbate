
$(document).ready(function(){
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

    $(document).on('click',".comment-input-anonymous-btn", function(event){
        if(checkGuest()) {
            return false;
        }
        var id = $(this).data('id');
        var thread_id = $(this).data('thread_id');
        var $widget = $("#" + id);
        var $anonymous_section = $widget.find('.comment-input-anonymous-section-anonymous');
        var $anonymous_non_section = $widget.find('.comment-input-anonymous-section-non-anonymous');
        var $loading_section = $widget.find('.comment-input-anonymous-loading-section');
        $loading_section.removeClass('comment-input-anonymous-hide');
        $anonymous_non_section.addClass('comment-input-anonymous-hide');
        var base_url = $("#base-url").val();

        $.ajax({
            type:'post',
            url: base_url + "/thread/request-anonymous",
            data: {thread_id: thread_id},
            success: function(data){
                if(data === '1'){
                    $anonymous_section.removeClass('comment-input-anonymous-hide');
                    $anonymous_non_section.addClass('comment-input-anonymous-hide');
                }
                $loading_section.addClass('comment-input-anonymous-hide');

            }
        })
    });

    $(document).on('click', '.comment-input-anonymous-cancel-btn', function(event){
        if(checkGuest()) {
            return false;
        }
        var id = $(this).data('id');
        var thread_id = $(this).data('thread_id');
        var $widget = $("#" + id);
        var $anonymous_section = $widget.find('.comment-input-anonymous-section-anonymous');
        var $anonymous_non_section = $widget.find('.comment-input-anonymous-section-non-anonymous');
        var $loading_section = $widget.find('.comment-input-anonymous-loading-section');
        $loading_section.removeClass('comment-input-anonymous-hide');
        $anonymous_section.addClass('comment-input-anonymous-hide');

        var base_url = $("#base-url").val();
        
        $.ajax({
            type:'post',
            url: base_url + "/thread/cancel-anonymous",
            data: {thread_id: thread_id},
            success: function(data){
                if(data === '1'){
                    $anonymous_section.addClass('comment-input-anonymous-hide');
                    $anonymous_non_section.removeClass('comment-input-anonymous-hide');
                }
                $loading_section.addClass('comment-input-anonymous-hide');
            }
        });
    });
});