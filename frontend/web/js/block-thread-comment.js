$(function(){  
    $(document).on('click',".block-thread-comment", function(event) {
        var id = $(this).data('id');
        $("#" + id).find('.block-thread-comment').addClass('block-thread-comment-hide');
        $("#" + id).find('.real-thread-comment').removeClass('block-thread-comment-hide');
    });
});
