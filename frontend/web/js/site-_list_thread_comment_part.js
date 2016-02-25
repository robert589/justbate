$(document).on('click', '#comment_hide_list_thread_btn', function(){
    if($('#comment_hide_list_thread_btn').text() == 'Comment'){
        $("#list_thread_comment_part").show();
        $('#comment_hide_list_thread_btn').text('Hide');

    }
    else{
        $("#list_thread_comment_part").hide();
        $('#comment_hide_list_thread_btn').text('Comment');


    }
});