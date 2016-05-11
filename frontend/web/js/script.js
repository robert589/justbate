$(document).ready(function(){

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

    $(document).on('change',"select.user-vote",function() {
        var service = $(this).data('service');
        $("form#form_user_vote_"+service+"").submit();
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
        alert($("div.section div#comment-tab div#comment-tab-container ul.nav-tabs li").css("width"));
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
        $('#resend-unverified-email-button').prop('disabled', true);
        $('#change-unverified-email-button').prop('disabled', true);

        if($("#command-change-verify-email").val() == 'change'){
            $("#change-verify-email-status").html("Changing your email...")
        }
    });



    //on profile/index
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
    $("img#avatar").mouseout(function() {
        $("img#avatar").css("opacity","1");
        $("button#upload-image").css("opacity","0");
    });
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
            $.pjax.defaults.scrollTo = false;
            $.pjax.click(event,{container: "#comment_section_" + thread_id, push:false});
        }
    });

    $(document).on('click', '.retrieve-child-comment-btn', function(){
        var comment_id = $(this).data('service');
        if($("#comment_part_" + comment_id).length == 1){
            console.log(comment_id);
            if($("#comment_part_" + comment_id).is(":visible")){
                $("#comment_part_" + comment_id).hide();
            }
            else{
                $("#comment_part" + comment_id).show();
            }
        }
        else{
            console.log("!" + comment_id);

            $("#retrieve-child-comment-form-"  + comment_id).submit();
        }
    });

    $(document).on('click', '.give_comment', function(event){
        var thread_id = $(this).data('service');
        if($("#redactor_box_" + thread_id ).length == 1){
            event.preventDefault();
            if($("#comment_input_box_section_" + thread_id ).is(":visible")){
                $("#comment_input_box_section_" + thread_id).hide();
            }
            else{
                $("#comment_input_box_section_" + thread_id).show();
            }
        }
        else{

        }

    });

    $(document).on('pjax:send','.comment_input_pjax', function(){

        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).show();
    }).on('pjax:complete', '.comment_input_pjax', function(){
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).hide();

    });

    $(document).on('pjax:send','.comment_section_pjax', function(){

        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).show();
    }).on('pjax:complete', '.comment_section_pjax', function(){
        var thread_id = $(this).data('service');
        $('#list_thread_loading_gif_' + thread_id).hide();

    }).on('pjax:timeout', '.comment_section_pjax', function(event){
        event.preventDefault();

    });

    //edit thread part
    $("#edit_thread").click(function(){
        $("#shown_title_description_part").hide();
        $("#edit_title_description_part").show();
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
        if($(this).data('guest') == 0){
            beginLoginModal();
            return false;
            $("#ask_to_login").show();
        }
        else{
            if($(this).html() == "Comment"){
                $("#comment_section").show();
                $("#display_hide_comment_input_box").html("<span class=\"glyphicon glyphicon-menu-up\"></span>");
            }
            else{
                $("#comment_section").hide();
                $("#display_hide_comment_input_box").html("Comment");
            }
        }

    });

    $(document).on('keydown',  ".child_comment_text_area", function(event){
        var comment_id = $(this).data('service');
        console.log("entered");

        if(event.keyCode == 13){
            $("#child_comment_form_" + comment_id).submit();
            return false;
        }
    })
    .on('focus', '.child_comment_text_area',function() {

        if (this.value == "Add comment here...") {
            this.value = "";
        }
    })
    .on('blur', '.child_comment_text_area',function(){

        if(this.value==""){
            this.value = "Add comment here...";
        }
    }).on('pjax:send', '.child_comment_text_area', function(){

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


    $("button.comment_post").click(function() {
        $("div#w6-container").slideToggle("fast");
    });

    /** pjax handling */
    $(document).on('submit', 'form[data-pjax]', function(event) {
        var services = '' + $(this).data('pjax');
        $.pjax.defaults.scrollTo = false;


        if(services.indexOf("comment_input") > -1){
            $.pjax.submit(event,  services, {push:false});

        }
    });


});
