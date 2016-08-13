$(function(){
    
    
    function beginLoginModal(){
        $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
    }
    
    function checkGuest() {
        var login_id = $("#user-login-id").val();
        if(login_id === ''  || login_id === null || login_id === undefined ) {
            beginLoginModal();
            return true;
        }

        return false;
    }
    
    function isCommentInputBoxRetrieved(widget) {
        var input_box_area = widget.find('.thread-section-bottom-input-box');
        var input_box_area_content = input_box_area.html().trim();
        return !(input_box_area_content === null || input_box_area_content === '')  ;
    }

    String.prototype.replaceAll = function(search, replacement) {
        var target = this;
        return target.replace(new RegExp(search, 'g'), replacement);
    };
    
    $(document).ready(function() {
       
        $(document).on("click", ".thread-section-bottom-radio-button", function(element) {
            if(checkGuest()) {
                return false;
            }
            var id = $(this).data('id');
            var widget = $("#" + id);
            var vote_area = widget.find('.thread-section-bottom-vote-area');
            var selected_value_hidden_input = vote_area.find('.thread-section-bottom-area-selected-value');
            var old_choice_value = selected_value_hidden_input.val();
            var vote_item = vote_area.find('.thread-section-bottom-radio-button');
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
                        var comment_area = widget.find('.thread-section-bottom-button-container');
                        comment_area.find('.thread-section-bottom-comment').click();
                        widget.find('.thread-section-bottom-vote-area').addClass('thread-section-bottom-hide');
                        widget.find('.thread-section-bottom-button-container').removeClass('thread-section-bottom-hide');
                    } else {
                    }
                }
            });
            selected_value_hidden_input.val(new_choice_value);

        });
        
        $(document).on('click', '.thread-section-bottom-comment', function(event) {
            var id = $(this).data('id');
            var widget = $("#" + id);
            var loading_gif = widget.find('.thread-section-bottom-input-box-loading');
            var input_box_area =  widget.find('.thread-section-bottom-input-box');
            if( !isCommentInputBoxRetrieved(widget) ) {
                loading_gif.removeClass('thread-section-bottom-hide');
                $.ajax({
                    url: $("#base-url").val() + '/thread/retrieve-comment-input',
                    type: 'post',
                    data: {thread_id: $(this).data('thread_id')},
                    success: function(data) {
                        loading_gif.addClass('thread-section-bottom-hide');
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
        
        $(document).on('click', '.thread-section-bottom-change-vote', function(event) {
            var id = $(this).data('id');
            var widget = $("#" + id);
            widget.find('.thread-section-bottom-vote-area').removeClass('thread-section-bottom-hide');
            widget.find('.thread-section-bottom-button-container').addClass('thread-section-bottom-hide');
        });
 
    });
    
});