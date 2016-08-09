$(function(){
    function checkGuest() {
        var login_id = $("#user-login-id").val();
        if(login_id === ''  || login_id === null || login_id === undefined ) {
            beginLoginModal();
            return true;
        }

        return false;
    }
    
    function isCommentInputBoxRetrieved(widget) {
        var input_box_area = widget.find('.thread-vote-comment-input-box');
        var input_box_area_content = input_box_area.html().trim();
        return !(input_box_area_content === null || input_box_area_content === '')  ;
    }

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };
    
    $(document).ready(function() {
       
        $(document).on("click", ".thread-vote-comment-radio-button", function(element) {
            var id = $(this).data('id');
            var widget = $("#" + id);
            var vote_area = widget.find('.thread-vote-comment-vote-area');
            var selected_value_hidden_input = vote_area.find('.thread-comment-vote-area-selected-value');
            var old_choice_value = selected_value_hidden_input.val();
            var vote_item = vote_area.find('.thread-vote-comment-radio-button');
            var new_choice_value = $(this).data('label');
            if(old_choice_value === new_choice_value) {
                return false;
            }

            var new_choice_value_section =vote_item.find('.simple-button-group-label-' + new_choice_value.replaceAll(' ' , '-'));
            var new_choice_text = new_choice_value_section.text();                
            var new_choice_total_comments = new_choice_text.substring(new_choice_text.lastIndexOf("(")+1,
              new_choice_text.lastIndexOf(")"));

            var new_new_choice_text = new_choice_value + " (" + (parseInt(new_choice_total_comments) + 1) + ")";
            new_choice_value_section.text(new_new_choice_text);
            new_choice_value_section.parent().addClass(" active disabled");

            // update old choice text
            if(old_choice_value !== null) {
                var old_choice_label_section = vote_item.find('.simple-button-group-label-' 
                                                                + old_choice_value.replaceAll(' ' , '-'));
                var old_choice_label_text = old_choice_label_section.text();
                var old_choice_total_comments = old_choice_label_text.substring(old_choice_label_text.lastIndexOf("(")+1,
                 old_choice_label_text.lastIndexOf(")"));
                var new_old_choice_text = old_choice_value + " (" + (parseInt(old_choice_total_comments) - 1) + ")";
                old_choice_label_section.text(new_old_choice_text);
                old_choice_label_section.parent().removeClass("disabled");

            }  
            $.ajax({
                url: $("#base-url").val() + '/thread/submit-vote',
                type: 'post',
                data: {thread_id: $(this).data('thread_id'), vote: new_choice_value},
                success: function(data) {
                    if(data) {
                        var comment_area = widget.find('.thread-vote-comment-button-container');
                        comment_area.find('.thread-vote-comment-comment').click();
                        widget.find('.thread-vote-comment-vote-area').addClass('thread-vote-comment-hide');
                        widget.find('.thread-vote-comment-button-container').removeClass('thread-vote-comment-hide');
                    } else {
                    }
                }
            });
            selected_value_hidden_input.val(new_choice_value);

        });
        
        $(document).on('click', '.thread-vote-comment-comment', function(event) {
            var id = $(this).data('id');
            var widget = $("#" + id);
            var loading_gif = widget.find('.thread-vote-comment-input-box-loading');
            var input_box_area =  widget.find('.thread-vote-comment-input-box');
            if( !isCommentInputBoxRetrieved(widget) ) {
                loading_gif.removeClass('thread-vote-comment-hide');
                $.ajax({
                    url: $("#base-url").val() + '/thread/retrieve-comment-input',
                    type: 'post',
                    data: {thread_id: $(this).data('thread_id')},
                    success: function(data) {
                        loading_gif.addClass('thread-vote-comment-hide');
                        input_box_area.html(data);
                        
                    }
                });
            } else {
                if(input_box_area.is(':visible')) {
                    input_box_area.hide(200);
                    
                } else {
                    input_box_area.show(200);
                }
            }
        });
        
        $(document).on('click', '.thread-vote-comment-change-vote', function(event) {
            var id = $(this).data('id');
            var widget = $("#" + id);
            widget.find('.thread-vote-comment-vote-area').removeClass('thread-vote-comment-hide');
            widget.find('.thread-vote-comment-button-container').addClass('thread-vote-comment-hide');
        });
 
    });
    
});