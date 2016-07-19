//new string library
function checkNewNotification() {
    $.ajax({
        url: $("#base-url").val() + "/notification/count-new-notification",
        type: 'post',
        success: function(data) {
            if(data != '' && data !== '0') {
                document.title = "(" + data + ") " + document.title;
                $("#notification-count").html("(" + data + ")");
            }

        }
    });
}
String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

var Application  = function(template){

    this.template = template;
    this.userSubscriptions = [];
    this.userLastChildCommentMessage = [];
    this.setTimeZoneToCookie();
};

Application.prototype.setTimeZoneToCookie = function(){
    if (navigator.cookieEnabled) {
        document.cookie = "tzo=" + (- new Date().getTimezoneOffset());
    }
};

Application.prototype.getSocketConnection = function(comment_id){
    for(var i = 0; i < this.userSubscriptions.length; i++){
        if(this.userSubscriptions[i].getCommentId() === comment_id ){
            return this.userSubscriptions[i];
        }
    }
    return null;
};

Application.prototype.checkExist = function(comment_id){
    if(this.getSocketConnection(comment_id) !== null){
        return true;
    }
};

Application.prototype.subscribeChildCommentConn = function(comment_id){

    if(!this.checkExist(comment_id)){
        var newConn = new ChildCommentWebSocket(comment_id, this.template);
        this.userSubscriptions.push(newConn);
    }
};

Application.prototype.unsubscribe = function(){
    //TODO
};

/**
 *
 * @param comment_id
 * @param self
 * @constructor
 */
 var ChildCommentWebSocket = function(comment_id, template){
    this.comment_id = comment_id;
    var child_comment_template = template;
    this.conn = new WebSocket('ws://52.6.157.157:8080?' + comment_id);
    this.conn.onopen = function(msg) {
        console.log('Connection successfully opened (readyState ' + this.readyState+')');
    };
    this.conn.onclose = function(msg) {
        if(this.readyState == 2) {
            console.log(
                'Closing... The connection is going throught'
                + 'the closing handshake (readyState ' + this.readyState + ')'
                );
        }
        else if(this.readyState == 3) {
            console.log(
                'Connection closed... The connection has been closed'
                + 'or could not be opened (readyState ' + this.readyState + ')'
                );
            console.log(msg);
        }
        else {
            console.log('Connection closed... (unhandled readyState ' + this.readyState + ')');
        }
    };
    this.conn.onmessage = function(e){
        applyTemplate(JSON.parse(e.data));

    };
    this.conn.onerror = function(event) {
        console.log("error");
    };
};


ChildCommentWebSocket.prototype.applyTemplate = function(){

};

ChildCommentWebSocket.prototype.subscribe = function(){
    this.conn.send(JSON.stringify({command: "subscribe", channel: this.comment_id}));
};

ChildCommentWebSocket.prototype.sendMessage = function(comment_id, user_id){
    console.log("Sending data");
    this.conn.send(JSON.stringify({command: "message",
     comment_id: comment_id,
     user_id: user_id}));
};

ChildCommentWebSocket.prototype.getCommentId = function(){
    return this.comment_id;
};


$(document).ready(function() {
    // register dropdown
    $("a#register-dropdown").click(function() {
        $("div#email-register").slideToggle(0);
        $("a#register-dropdown").css("display", "none");
    });

    $("div#cancel-register-button").click(function() {
        $("div#email-register").slideToggle(0);
        $("a#register-dropdown").css("display", "block");
    });    

    // forgot password 
    $("div#forgot-password").click(function() {
        $("div#forgot-password-wrapper").slideToggle(0);
        $("div#forgot-password").css("display", "none");
    });

    $("div#cancel-button").click(function() {
        $("div#forgot-password-wrapper").slideToggle(0);
        $("div#forgot-password").css("display", "block");
    });
});

// search-issue 
$('label.search-issue').on('click', function() {
    $(this).toggleClass('checked');
    $(this).toggleClass('unchecked');
});

$(document).ready(function(){
    var $this = $(this);
    var child_comment_template = $this.find("#child-comment-template").html();
    var app = new Application(child_comment_template);


    //facebook
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    $('#loading-bar').height($(document).height());
    
    $(document).on("click", ".comment-vote-button", function(element) {
        var is_up = parseInt($(this).val());
        var comment_id = $(this).data('arg');
        var comment_vote_section = $("#comment-vote-section-" + comment_id);
        var comment_vote_old_value = parseInt(comment_vote_section.find(".comment-vote-old-value").val());
        if(comment_vote_old_value === is_up) {
            return false;
        } 
        var comment_vote_up_section = comment_vote_section.find('.comment-vote-up-section');
        var comment_vote_down_section = comment_vote_section.find('.comment-vote-down-section');
        var comment_vote_total_like = parseInt(comment_vote_up_section.find('.comment-vote-total').text());
        var comment_vote_total_dislike = parseInt(comment_vote_down_section.find('.comment-vote-total').text());
        
        if(is_up === 1) {
            comment_vote_up_section.find('.comment-vote-button').prop('disabled', true);                        
            comment_vote_down_section.find('.comment-vote-button').prop('disabled', false);
            comment_vote_up_section.find('.comment-vote-total').text(comment_vote_total_like + 1);
            if(comment_vote_old_value !== null && !isNaN(comment_vote_old_value)) {
                comment_vote_down_section.find('.comment-vote-total').text(comment_vote_total_dislike - 1);
            }
        } else {
            comment_vote_down_section.find('.comment-vote-button').prop('disabled', true);                        
            comment_vote_up_section.find('.comment-vote-button').prop('disabled', false);
            
            comment_vote_down_section.find('.comment-vote-total').text(comment_vote_total_dislike + 1);
            if(comment_vote_old_value !== null && !isNaN(comment_vote_old_value) ) {
                comment_vote_up_section.find('.comment-vote-total').text(comment_vote_total_like - 1);
            }
        }
        
        
        $.ajax({
            url: $("#base-url").val() + '/comment/comment-vote',
            type: 'post',
            data: {comment_id: comment_id, vote: is_up},
            success: function(data) {
                if(data) {
                    
                } else {
                    
                }
            }
        });
        comment_vote_section.find(".comment-vote-old-value").val(is_up); 
        
        
        
    });
    
    $(document).on("click",".thread-vote-radio-button",function(element) {
        var thread_id = $(this).data('arg');
        var thread_vote_section = $("#thread-vote-" + thread_id);
        
        //update new choice
        var new_choice_value = $(this).data('label');
        var old_choice_value = thread_vote_section.find("#thread-vote-old-value-" + thread_id).val();
        if(old_choice_value === new_choice_value) {
            return false;
        }
        var new_choice_value_section =thread_vote_section.find('.simple-button-group-label-' + new_choice_value);
        var new_choice_text = new_choice_value_section.text();                
        var new_choice_total_comments = new_choice_text.substring(new_choice_text.lastIndexOf("(")+1,
          new_choice_text.lastIndexOf(")"));
        
        var new_new_choice_text = new_choice_value + " (" + (parseInt(new_choice_total_comments) + 1) + ")";
        new_choice_value_section.text(new_new_choice_text);
        new_choice_value_section.parent().addClass(" active disabled");
        
        // update old choice text
        if(old_choice_value !== null) {
            var old_choice_label_section = thread_vote_section.find('.simple-button-group-label-' + old_choice_value);
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
            data: {thread_id: thread_id, vote: new_choice_value},
            success: function(data) {
                if(data) {
                   if($("#comment_input_box_section_" + thread_id).length === 0) {
                    $("#retrieve-input-box-button-" + thread_id).prop('disabled', false);
                    $("#retrieve-input-box-button-" + thread_id).click();
                }
            } else {
                
            }
        }
    });
        thread_vote_section.find("#thread-vote-old-value-" + thread_id).val(new_choice_value);
        
    });

    $(document).on('submit', '.form_user_thread_vote', function(event){
        var data_pjax = $(this).data('pjax');

        $.pjax.submit(event, data_pjax ,
           {'push' : false,
           'replace' : false,
           'timeout' : false,
           'skipOuterContainers':true,
           'scrollTo':false});
    });

    checkNewNotification();

    $(document).on("click", "table[id^='user-table-comment'] tbody tr td button", function() {
        var table_unique_id = $(this).attr("data-service");
        $("input#dropdown-comment-input-"+table_unique_id).trigger('click');
    });
    $("span.auth-icon").remove();
    $("a.auth-link").removeAttr("data-popup-width");
    $("a.auth-link").removeAttr("data-popup-height");
    $("a.auth-link").append($('<div class="input-group"><span style="width: 37.78px;" class="input-group-addon"><i class="fa fa-facebook"></i></span><input type="text" class="form-control" value="Continue with Facebook" readonly="true" /></div>'));
    $("div#facebook-signup input[type='text']").val("Join Us With Facebook");

    var total_width = $('div#first-part').width();
    var sum_of_children = $("div#comment-tab ul#comment-tab").children().length;
    if ($(window).innerWidth() < 767) {
        $("div.section div#comment-tab div#comment-tab-container ul.nav-tabs li").css("width", (total_width/sum_of_children) + "px");
    }

    // on site/home
    $(document).on('click',"div#verify-email-dropdown",function() {
        $("div#verify-email-form").slideToggle("fast");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-down");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-up");
    });

    $(document).on('click', '#home-add-issue-button', function(){
        $("#home-add-issue-button-div").hide();
        $("#home-add-issue-form-div").show();
    });

    $("#home-issue-edit-popover").click(function(){
     $("#home-search-issue-modal").modal("show")
     .find('#home-search-issue-modal')
     .load($(this).attr("value"));
 });

    $(document).on('click', '#resend-unverified-email-button',function(){
        $("#resendchangeemailform-command").val("resend");
        $("#change-verify-email-form").submit();
    });

    $(document).on('click', '#change-unverified-email-button', function(){
        if($(this).text() == 'Change'){
            $("#resendchangeemailform-user_email").prop('readonly', false);
            $(this).text('Confirm');
        }
        else if($(this).text() == 'Confirm') {
            $("#resendchangeemailform-command").val("change");
            $("#change-verify-email-form").submit();
            $(this).text('Change');
            $("#resendchangeemailform-user_email").prop('readonly', true);
        }
    });

    $(document).on('pjax:send', '#change-verify-email-pjax', function(){
        $('#resend-unverified-email-button').prop('disabled', true);
        $('#change-unverified-email-button').prop('disabled', true);

        if($("#command-change-verify-email").val() == 'change'){
            $("#change-verify-email-status").html("Changing your email...")
        }
    });


    $("img#avatar").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("button#upload-image").css("opacity","1");
    });

    $("button#upload-image").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("button#upload-image").css("opacity","1");
    });

    $("button#upload-image").mouseout(function() {
        $("img#avatar").css("opacity","1");
        $("button#upload-image").css("opacity","0");
    });

    /**
     *
     */
     $("img#avatar").mouseout(function() {
        $("img#avatar").css("opacity","1");
        $("button#upload-image").css("opacity","0");
    });

    /**
     *
     */
     $("#upload-image").click(function(){
        $("#uploadProfilePicModal").modal("show")
        .find('#uploadProfilePicModal')
        .load($(this).attr("value"));
    });

    //menu bar
    $("#loginMenu").click(function(){
        $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
    });

    $("div#create-thread-dropdown").click(function(event) {
        $("div#create-thread-main-form").slideToggle("fast");
        event.stopPropagation();
    });

    $(document).on('click', '#comment_hide_list_thread_btn', function(){
        if($(this).text() == 'Comment'){
            // $("#list_thread_comment_part").show();
            $("#list_thread_comment_part").css("display", "block");
            $('#comment_hide_list_thread_btn').text('Hide');
        } else {
            // $("#list_thread_comment_part").hide();
            $("#list_thread_comment_part").css("display", "none");
            $('#comment_hide_list_thread_btn').text('Comment');
        }
    });


    // thread
    $(document).on('click', '.retrieve-comment-link', function(event){
        var thread_id = $(this).data('service');
        if($("#home_comment_section_" + thread_id).length == 1){
            event.preventDefault();
            if($("#home_comment_section_" + thread_id).is(":visible")){
                $("#home_comment_section_" + thread_id).hide();
            }
            else{
                $("#home_comment_section_" + thread_id).show();
            }
        }
        else{
            $.pjax.click(event,
                {container: "#comment_section_" + thread_id,
                push:false,
                scrollTo:false,
                timeout:6000,
                skipOuterContainers:true}
                );
        }
    });


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

    $(document).on('pjax:send', '.child_comment_pjax', function(event){
        console.log("sending");
        event.preventDefault();
        var comment_id = $(this).data('service');

        $('#child_comment_loading_gif_' + comment_id).css("display", "inline");

        return false;

    });


    $(document).on('pjax:complete', '.child_comment_pjax', function(event){
        event.preventDefault();
        var comment_id = $(this).data('service');
        $('#child_comment_loading_gif_' + comment_id).css("display","none");

        return false;


    });
    
    $(document).on('click', '.child-comment-input-box-submit-button', function(event){
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
    
    $(document).on('pjax:send', '.comment-section-edit-pjax', function(event){
        event.preventDefault();
        event.stopPropagation();
    });
     

    $(document).on('submit', '.comment-section-edit-form', function(event){
        event.preventDefault();
        $.pjax.submit(event,
            $(this).data('pjax'),
            {'push' : false,
            'replace' : false,
            'timeout' : false,
            'skipOuterContainers':true});

        return false;
    });


    $(document).on('click', '.give-comment', function(event){
        var thread_id = $(this).data('service');
        if($("#redactor_box_" + thread_id ).length == 1){
            event.preventDefault();
            if($("#comment_input_box_section_" + thread_id ).is(":visible")){
                $("#comment_input_box_section_" + thread_id).css("display","none");
            }
            else{
                $("#comment_input_box_section_" + thread_id).css("display","inline");
            }
        }
    });

    $(document).on('pjax:complete', '.pjax_user_vote', function(){
        var thread_id = $(this).data('service');

        $("#retrieve-input-box-button-" + thread_id).prop('disabled', false).click();
    });

    $(document).on('pjax:send','.comment_input_pjax', function(event){
        event.preventDefault();
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).css("display","inline");

    }).on('pjax:complete', '.comment_input_pjax', function(event){
        event.preventDefault();
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).css("display","none");

    });

    $(document).on('submit', '.retrieve_comment_input_box_form', function(event) {
        event.preventDefault();
        var services = '' + $(this).data('pjax');
        $.pjax.submit(event,  services, {push:false});
        return false;
    });

    $(document).on('click', '.notification-item', function(event) {
        var notification_id = $(this).data('arg');
        $.ajax({
            url: $("#base-url").val() + "/notification/update-read-notification",
            type: 'post',
            data : {id: notification_id},
            success: function(data) {
            }
        });


    });

    $(document).on('pjax:send','.comment_section_pjax', function(event){
        event.preventDefault();
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).css("display","inline");
        return false;
    }).on('pjax:complete', '.comment_section_pjax', function(event){
        event.preventDefault();
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).css("display","none");
        return false;
    }).on('pjax:timeout', '.comment_section_pjax', function(event){
        event.preventDefault();
    });

    $("#edit-thread").click(function(){
        $("#shown_title_description_part").css("display","none");
        $("#edit_title_description_part").css("display","inline");
    });

    $("#delete-thread").on("click", function() {
        krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
            if (result) {
                $("#delete_thread_form").submit();
                return false;
            }
        });
    });


    $(document).on('click', '.edit_comment',function(e){
        e.preventDefault();
        //initialize redactor

        var comment_id = $(this).data('service');
        $("#comment-section-edit-redactor-" + comment_id).redactor({
            plugins: ['video', 'fullscreen'],
            buttons: ['undo', 'redo', 'format', 'bold', 'italic', 'image', 'lists'],
            imageUpload: '/frontend/web/photos'

        });
        $("#comment_shown_part_" + comment_id).hide();
        $("#comment_edit_part_" + comment_id).show();
    });

    $(document).on('click', '.delete-comment',function(e){
        e.preventDefault();
        var comment_id = $(this).data('service');
        krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
            if (result) {
                $("#delete_comment_form_" + comment_id).submit();
                return false;
            }
        });
    });

    //cancel edit comment is at
    $(document).on('click','.cancel_edit_comment',function(e){
        e.preventDefault();
        var comment_id = $(this).data('service');
        $("#comment_shown_part_" +  comment_id).show();
        $("#comment_edit_part_" + comment_id).hide();
    });

    $(document).on('click', '#display_hide_comment_input_box', function(){
        if(!$("#comment_section").is(':visible')){
            $("#comment_section").show();
        }
        else{
            $("#comment_section").hide();
        }
    });

    $(document).on('click', '.home_show_hide', function(){
        var thread_id  = $(this).data('service');
        var $this_button = $("#home_show_hide_" + thread_id);
        if($this_button.text() == 'Hide'){
            $("#home_comment_section_" + thread_id).hide();
            $this_button.text('Comment (' + $("#hi_total_comments_" + thread_id).val() + ")");
        }
        else{
            $this_button.text('Hide');
            $("#home_comment_section_" + thread_id).show();
        }
    });


    $(".hide_comment").click(function(){
        var comment_id = $(this).data('service');
        if($("#hide_button_" + comment_id).text() == "Hide"){
            $("#comment_part_" + comment_id).hide();
            $("#hide_button_" + comment_id).text("Show");
        }
        else{
            $("div._list_thread_form_"+comment_id+" form.comment-form div.col-xs-12").slideToggle();
            $("#comment_part_" + comment_id).show();
            $("#hide_button_" +comment_id).text("Hide");
        }
    });

    $(document).on('submit', '.comment-form', function(event){
        event.preventDefault();
        var data_pjax = $(this).data('pjax');
        $.pjax.submit(event,
            data_pjax ,
            {'push' : false,
            'replace' : false,
            'timeout' : false,
            'skipOuterContainers':true,
            'scrollTo':false});
        return false;
    });

    $("#cancel_edit_thread_button").click(function(){
        $("#shown_title_description_part").show();
        $("#edit_title_description_part").hide();
    });

    function beginProfilePicModal(){
        $("#uploadProfilePicModal").modal("show")
        .find('#uploadProfilePicModal')
        .load($(this).attr("value"));
    }

    $("li#notif-expansion").click(function() {
        //the reason of length 0 instead of 1 because this code is executed first then the notifcation is opened
        if($('#notif-expansion').parent().find('.open').length == 0){
            $("#notification-form").submit();
        }
    });

    function beginLoginModal(){
        $("#loginModal").modal("show")
        .find('#loginModal')
        .load($(this).attr("value"));
    }

    $("#login_link").click(function(){
        beginLoginModal();
        return false;
    });

    $("#login-modal-button").click(function(){
        beginLoginModal();
        return false;
    });

    $("button.comment_post").click(function() {
        $("div#w6-container").slideToggle("fast");
    });

    $(document).on("pjax:complete", "#notifbar", function(e) {
     document.title = document.title.slice(document.title.indexOf(')') + 1);
 });
    $.pjax.defaults.scrollTo = false;
    $.pjax.defaults.skipOuterContainers = true;
});
