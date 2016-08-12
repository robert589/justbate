$(document).ready(function() {
    
    
    $(document).on('click', '.child-comment-list-button-load', function(e) {
        var id = $(this).data('id');
        var comment_id = $(this).data('comment_id');
        
        var $widget = $("#" + id);
        var $loading_area = $widget.find('.child-comment-list-loading');
        var $last_time = $widget.find('.child-comment-list-last-time');
        $loading_area.removeClass('child-comment-list-hide');
        var last_time = $last_time.val();
        var $comment_area = $widget.find('.child-comment-list-area-comment-area');
        $.ajax({
            url: $("#base-url").val() + '/comment/get-new-child-comment',
            type: 'post',
            data: {comment_id: comment_id, last_time: last_time, limit: 5 },
            success: function(data) {
                var parsedData = JSON.parse(data);
                $comment_area.append(parsedData['view']);
               $last_time.val(parsedData['last_time']);
                $loading_area.addClass('child-comment-list-hide');
            }
        });
    });
});