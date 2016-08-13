$(document).ready(function() {
    
    
    $(document).on('click', '.child-comment-list-button-load', function(e) {
        var id = $(this).data('id');
        var comment_id = $(this).data('comment_id');
        var limit = 5;
        var $widget = $("#" + id);
        var $loading_area = $widget.find('.child-comment-list-loading');
        var $button_area = $widget.find('.child-comment-list-button');
        var $last_time = $widget.find('.child-comment-list-last-time');
        var $total_remaining = $widget.find('.child-comment-list-total-remaining');
        var total_remaining = parseInt($total_remaining.text());
        $loading_area.removeClass('child-comment-list-hide');
        var last_time = $last_time.val();
        var $comment_area = $widget.find('.child-comment-list-area-comment-area');
        $.ajax({
            url: $("#base-url").val() + '/comment/get-new-child-comment',
            type: 'post',
            data: {comment_id: comment_id, last_time: last_time, limit: limit },
            success: function(data) {
                var parsedData = JSON.parse(data);
                $comment_area.append(parsedData['view']);
                $last_time.val(parsedData['last_time']);
                if(total_remaining - limit > 0) {
                    $total_remaining.text(total_remaining - limit);
                }
                else {
                    $button_area.addClass('child-comment-list-hide');
                }
                $loading_area.addClass('child-comment-list-hide');
            }
        });
    });
});