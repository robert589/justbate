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




$(document).ready(function(){
    
    /** LOGIN PAGE **/
    $(document).on("click", ".login-register-with-email", function(event) {
        var service = $(this).data('service');
        $("#email-register"  +service).css("display", "block");
        $("#login-register-choice"  +service).css("display", "none");
    });
    
    $(document).on("submit",'.login-login-form', function(e) {
        var service = $(this).data('service'); 
        $("#login-login-loading" + service).css("display", "block");
    });
    
    $(document).on("pjax:complete",'.login-login-pjax', function(e) {
        var service = $(this).data('service'); 
        $("#login-login-loading" + service).css("display", "none");
    });
    
    $(document).on("submit",'.login-email-register-form', function(e) {
        var service = $(this).data('service'); 
        $("#login-email-register-loading" + service).css("display", "block");
    });
    
    $(document).on("pjax:complete",'.login-email-register-pjax', function(e) {
        var service = $(this).data('service'); 
        $("#login-email-register-loading" + service).css("display", "none");
    });
    
    $(document).on("click", ".login-email-register-cancel-btn", function(e) {
        var service = $(this).data('service');
        $("#email-register"  +service).css("display", "none");
        $("#login-register-choice"  +service).css("display", "block");
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

    
    $("#home-sidenav-followed-issue-edit").click(function(event){
        event.preventDefault();
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
        beginLoginModal();
    });
    
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
    $("#create-button").click(function(event) {
        if(checkGuest()) {
            return false;
        }
        $("#create-thread-form").submit();
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
                if(data !== false) {
                    
                } else {
                    
                }
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

    $(document).on('mousedown', ".edit-thread", function(event){
        var thread_id = $(this).data('service');
        $("#thread-section-view-" + thread_id).css("display","none");
        $("#thread-section-edit-" +  thread_id).css("display","block");
    });

    $(document).on("mousedown",".delete-thread" , function(event) {
        var thread_id = $(this).data('service');
        krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
            if (result) {   
                $.ajax({
                    url: $("#base-url").val() + "/thread/delete-thread",
                    type: 'post',
                    data: {'thread_id': thread_id},
                    success: function(data) {
                        if(data === '1') {
                            window.location.href  = $("#base-url").val() + "/";

                        } else {
                            
                        }
                    }
                });
                return false;
            }
        });
    });
    
    $(document).on('click', '.update-comment-btn', function(e) {
        
    });

    $(document).on('mousedown', '.edit_comment',function(e){

        var comment_id = $(this).data('service');
        var $text_area = $("#comment-section-edit-redactor-" + comment_id);
        if($text_area.parent().find('.redactor-editor').length === 0) {
            $("#comment-section-edit-redactor-" + comment_id).redactor({
                plugins: ['video', 'fullscreen'],
                buttons: ['undo', 'redo', 'format', 'bold', 'italic', 'image', 'lists'],
                imageUpload: '/frontend/web/photos'
            });   
        }
        $("#comment_shown_part_" + comment_id).hide();
        $("#comment_edit_part_" + comment_id).show();
    });

    $(document).on('mousedown', '.delete_comment',function(e){
        var comment_id = $(this).data('service');
        krajeeDialog.confirm("Are you sure you want to proceed?", function (result) {
            if (result) {
                $.ajax({
                    url: $("#base-url").val() + "/comment/delete-comment",
                    type: 'post',
                    data: {'comment_id': comment_id},
                    success: function(data) {
                        if(data === '1') {
                            window.location.href  = $("#base-url").val() + "/";

                        } else {
                            
                        }
                    }
                });
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

    $(".thread-section-cancel-button").click(function(){
        var thread_id = $(this).data('id');
        $("#thread-section-view-" + thread_id).css('display', 'block');
        $("#thread-section-edit-" + thread_id).css('display', 'none');
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

