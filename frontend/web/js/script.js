var Application  = function(){
    this.userSubscriptions = [];
    this.userLastChildCommentMessage = [];
    this.setTimeZoneToCookie();
};

Application.prototype.setTimeZoneToCookie = function(){
    if (navigator.cookieEnabled) {
        console.log('heelo');
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
    console.log(this.userSubscriptions);

    if(!this.checkExist(comment_id)){
        console.log("New connection");
        var newConn = new ChildCommentWebSocket(comment_id);
        this.userSubscriptions.push(newConn);
    }
};

Application.prototype.unsubscribe = function(){
    //TODO
};

//Websocket connection class
/**
 *
 * @param comment_id
 * @constructor
 */
var ChildCommentWebSocket = function(comment_id){
    this.comment_id = comment_id;
    this.conn = new WebSocket('ws://127.0.0.1:8080/server/start');

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
        }
        else {
            console.log('Connection closed... (unhandled readyState ' + this.readyState + ')');
        }
    };

    this.conn.onmessage = function(e){
        console.log(e.data);
    };

    this.conn.onerror = function(event) {
        console.log("error");
    };
};

/**
 *
 */
ChildCommentWebSocket.prototype.subscribe = function(){
    this.conn.send(JSON.stringify({command: "subscribe", channel: this.comment_id}));
};

/**
 *
 * @param message
 */
ChildCommentWebSocket.prototype.sendMessage = function(message, user_id){
    console.log("Sending data");
    this.conn.send(JSON.stringify({command: "message", message: message}));
};

/**
 *s
 * @returns {*}
 */
ChildCommentWebSocket.prototype.getCommentId = function(){
    return this.comment_id;
};


$(document).ready(function(){

    var app = new Application();

    //facebook
    (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    //layout main
    $('#loading-bar').height($(document).height());

    // user vote submit when value changed
    $(document).on('change',".user-vote",function() {
        var service = $(this).data('service');
        $("form#form_user_vote_"+service).submit();
    });

    $(document).on('submit', '.form_user_thread_vote', function(event){
        var data_pjax = $(this).data('pjax');

        $.pjax.submit(event, data_pjax ,{'push' : false, 'replace' : false, 'timeout' : false, skipOuterContainers:true, scrollTo:false});

    });

    // replacing fb icon with font-awesome
    $("span.auth-icon").remove();
    $("a.auth-link").removeAttr("data-popup-width");
    $("a.auth-link").removeAttr("data-popup-height");
    $("a.auth-link").append($('<div class="input-group"><span class="input-group-addon"><i class="fa fa-facebook"></i></span><input type="text" class="form-control" value="Facebook" readonly="true" /></div>'));
    $("div#facebook-signup input[type='text']").val("Join Us With Facebook");

    // define width on thread/index.php
    var total_width = $('div#first-part').width();
    var sum_of_children = $("div#comment-tab ul#comment-tab").children().length;
    if ($(window).innerWidth() < 767) {
        $("div.section div#comment-tab div#comment-tab-container ul.nav-tabs li").css("width", (total_width/sum_of_children) + "px");
    //        alert($("div.section div#comment-tab div#comment-tab-container ul.nav-tabs li").css("width"));
    }

    // on site/home
    $(document).on('click',"div#verify-email-dropdown",function() {
        $("div#verify-email-form").slideToggle("fast");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-down");
        $("span#icon-dropdown").toggleClass("glyphicon-chevron-up");
    });

    /**
     *
     */
    $(document).on('click', '#home-add-issue-button', function(){
        $("#home-add-issue-button-div").hide();
        $("#home-add-issue-form-div").show();
    });

    /**
     *
     */
    $(document).on('click', '#resend-unverified-email-button',function(){
        $("#resendchangeemailform-command").val("resend");
        $("#change-verify-email-form").submit();
    });


    /**
     *
     *
     */
    $(document).on('click', '#change-unverified-email-button', function(){
        if($(this).text() == 'Change'){
            $("#resendchangeemailform-user_email").prop('readonly', false);
            $(this).text('Confirm');
        }
        else if($(this).text() == 'Confirm') {
            $("#resendchangeemailform-command").val("change");
            //    $("#resendchangeemailform-email").val("rlimanto001@gmail.com");
            $("#change-verify-email-form").submit();
            $(this).text('Change');
            $("#resendchangeemailform-user_email").prop('readonly', true);
        }
    });

    $(document).on('pjax:send', '#change-verify-email-pjax', function(){
        console.log('change verify email pjax');
        $('#resend-unverified-email-button').prop('disabled', true);
        $('#change-unverified-email-button').prop('disabled', true);

        if($("#command-change-verify-email").val() == 'change'){
            $("#change-verify-email-status").html("Changing your email...")
        }
    });


    //on profile/index
    /**
     *
     */
    $("img#avatar").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("button#upload-image").css("opacity","1");
    });

    /**
     *
     */
    $("button#upload-image").mouseenter(function() {
        $("img#avatar").css("opacity",".5");
        $("button#upload-image").css("opacity","1");
    });

    /**
     *
     */
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

    $("div#create-thread-dropdown").click(function() {
        $("div#create-thread-main-form").slideToggle("fast");
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
            $.pjax.click(event,{container: "#comment_section_" + thread_id,push:false, scrollTo:false, timeout:6000, skipOuterContainers:true });
        }
    });


    $(document).on('click', '.retrieve-child-comment-link', function(event){
        var comment_id = $(this).data('service');
        if($("#comment_part_" + comment_id).length == 1){

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
            console.log('retrieve child comment link');

            $.pjax.click(event,{container: "#child_comment_" + comment_id, push:false, scrollTo : false, timeout:false, skipOuterContainers:true});
        }
    });

    $(document).on('pjax:send', '.child_comment_pjax', function(event){
        event.preventDefault();

        var comment_id = $(this).data('service');

        $('#child_comment_loading_gif_' + comment_id).css("display", "inline");

        return false;

    });


    $(document).on('pjax:complete', '.child_comment_pjax', function(event){
        event.preventDefault();

        var comment_id = $(this).data('service');

        $('#child_comment_loading_gif_' + comment_id).css("display","none");

        app.subscribeChildCommentConn(comment_id);

        return false;

    });



    $(document).on('pjax:complete', '.child_comment_input_box_pjax', function(){
     //   event.preventDefault();
        console.log('Complete child comment input box');

        var comment_id = $(this).data('service');

        $('#child_comment_loading_gif_' + comment_id).css("display","none");

        var socketConn = app.getSocketConnection(comment_id);

        var message = $("#last_message_current_user_" + comment_id).val();

        if(message !== null){
            socketConn.sendMessage(message, $("#current_user_login_id_" + comment_id));
        }
        return false;
    });

    $(document).on('pjax:send', '.child_comment_input_box_pjax', function(){
       // event.preventDefault();
        console.log('Sent child comment input box');
        //return false;
    });

    $(document).on('pjax:timeout', '.child_comment_input_box_pjax', function(){
       console.log('timeout');
       event.preventDefault();
       return false;
    });

    $(document).on('pjax:error', '.child_comment_input_box_pjax', function(){
        console.log('error');
        event.preventDefault();
    })

    .on('submit', '.submit_child_comment_form', function(event){
        event.preventDefault();

        var comment_id = $(this).data('service');

        $.pjax.submit(event, $(this).data('pjax') ,{'push' : false, 'replace' : false, 'timeout' : false, skipOuterContainers:true});
    })

    .on('submit', '.submit-vote-form', function(event){
        event.preventDefault();

        $.pjax.submit(event, $(this).data('pjax'), {'push' : false, 'replace' : false, 'timeout' : false, skipOuterContainers:true})
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


        $("#retrieve-input-box-button-" + thread_id).prop('disabled', false);
    });

    $(document).on('pjax:send','.comment_input_pjax', function(event){
        event.preventDefault();
        console.log('comment input pjax sent');
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).css("display","inline");

    }).on('pjax:complete', '.comment_input_pjax', function(event){
        event.preventDefault();
        console.log('comment input pjax completed');
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).css("display","none");

    });

    /**
     * File:
     */
    $(document).on('submit', '.retrieve_comment_input_box_form', function(event) {
        event.preventDefault();

        console.log('retrieve comment input box form submitted');

        var services = '' + $(this).data('pjax');


        $.pjax.submit(event,  services, {push:false});

        return false;

    });

    $(document).on('pjax:send','.comment_section_pjax', function(event){
        event.preventDefault();

        console.log('comment_section_pjax sent');

        var thread_id = $(this).data('service');

        $('#list_thread_loading_gif_' + thread_id).css("display","inline");

        return false;

    }).on('pjax:complete', '.comment_section_pjax', function(event){
        event.preventDefault();

        console.log('comment_section_pjax completed')

        var thread_id = $(this).data('service');

        $('#list_thread_loading_gif_' + thread_id).css("display","none");

        return false;

    }).on('pjax:timeout', '.comment_section_pjax', function(event){
        event.preventDefault();
        console.log('timeout');
    });

    //edit thread part
    $("#edit_thread").click(function(){
        $("#shown_title_description_part").css("display","none");
        $("#edit_title_description_part").css("display","inline");
    });

    $("#delete_thread").on("click", function() {
        krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
            if (result) {
                $("#delete_thread_form").submit();
                return false;
            }
        });
    });

    //comment_votes part
    $(document).on("click",".submit-comment-vote-button", function(){
        var vote = $(this).val();

        var comment_id = $(this).closest("form").find('.hi-comment-vote-comment-id').val();
        // console.log(vote);

        $("#hi-comment-vote-" + comment_id).val(vote);
        //console.log( $("#hi-comment-vote-" + comment_id).val());
    });


    //edit comment is at
    $(document).on('click', '.edit_comment',function(e){
        e.preventDefault();
        var comment_id = $(this).data('service');
        $("#comment_shown_part_" + comment_id).hide();
        $("#comment_edit_part_" + comment_id).show();
    });

    //edit comment is at
    $(document).on('click', '.delete_comment',function(e){
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
        console.log(thread_id + $this_button.text());
        if($this_button.text() == 'Hide'){
            console.log('' + $this_button.length);
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
            $("div._list_thread_form_"+comment_id+" form#comment-form div.col-xs-12").slideToggle();
            $("#comment_part_" + comment_id).show();
            $("#hide_button_" +comment_id).text("Hide");
        }
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

    $.pjax.defaults.scrollTo = false;
    $.pjax.defaults.skipOuterContainers = true;
});