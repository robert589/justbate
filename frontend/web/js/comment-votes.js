/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function() {
    $(document).on('click', '.comment-votes-button' , function(event) {
        var id = $(this).data('id');
        var comment_id = $(this).data('comment_id');
        var $widget = $("#" + id);
        var value = parseInt($(this).val());
       
        var $comment_vote_total_dislike = $widget.find('.comment-votes-total-dislike');
        var $comment_vote_total_like = $widget.find('.comment-votes-total-like');
        var $comment_vote_old_value = $widget.find('.comment-votes-old-value');
        var comment_vote_button_up = $widget.find('.comment-votes-button-up');
        var comment_vote_button_down = $widget.find('.comment-votes-button-down');
        var total_like = parseInt($comment_vote_total_like.text());
        var total_dislike = parseInt($comment_vote_total_dislike.text());
        var old_value = parseInt($comment_vote_old_value.val());
        if(old_value === value) {
            return false;
        } 
        if(value === 1) {
            comment_vote_button_up.prop('disabled', true);
            comment_vote_button_down.prop('disabled', false);
            $comment_vote_total_like.text(total_like + 1);
            if(old_value !== null  && !isNaN(old_value) && old_value !== 0) {
                $comment_vote_total_dislike.text(total_dislike - 1);

            }
            
        } else {
            comment_vote_button_up.prop('disabled', false);
            comment_vote_button_down.prop('disabled', true);
            $comment_vote_total_dislike.text(total_dislike + 1);
            if(old_value !== null  && !isNaN(old_value) && old_value !== 0) {
                $comment_vote_total_like.text(total_like - 1);

            }
        }
        
        $.ajax({
            url: $("#base-url").val() + '/comment/comment-vote',
            type: 'post',
            data: {comment_id: comment_id, vote: value},
            success: function(data) {
                if(data) {
                    
                } else {
                    
                }
            }
        });

        $comment_vote_old_value.val(value); 
    });
});