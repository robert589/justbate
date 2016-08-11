/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
    
    $(document).on('input',  '.thread-comment-input-box-comment-container', function() {
        var id = $(this).data('id');        
        var widget = $("#" + id);
        var value = widget.find('.redactor-editor').text();
        console.log(value);
        if(value.trim() === '' || value.trim() === null || value === '""') {
            widget.find('.thread-comment-input-box-button').attr('disabled', 'disabled');
        }
        else {
            widget.find('.thread-comment-input-box-button').removeAttr('disabled');

        }
    });
    
    $(document).on('click', '.thread-comment-input-box-button', function(event) {
        var id = $(this).data('id');
        var thread_id = $(this).data('thread_id');
        var $widget = $("#" + id);
        
        var html_text = $widget.find('.redactor-editor').html();
        
        $.ajax({
            url: $("#base-url").val() + '/thread/submit-comment',
            type: 'post',
            data: {'thread_id':  thread_id, 'comment' : html_text},
            success: function(data) {
                if(data !== false) {
                    $widget.html(data);
                    $widget.addClass("thread-comment-input-box-white-bg");
                } else {
                    
                }
            }
        })
    });
});

