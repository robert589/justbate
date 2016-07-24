$(function(){
    $(document).on("change", "#search-issue-search-input", function(e){
        $("#search-issue-searched-list-loading").show();
        $("#search-issue-searched-list").hide();
        $.ajax({
            url: $("#base-url").val() + "/site/search-all-issues",
            type: 'post',
            success: function(data) {
                $("#search-issue-searched-list-loading").hide();
                $("#search-issue-searched-list").show();

            }
        });
    });

    $(document).on("click",'label.search-issue', function() {
        $(this).toggleClass('checked');
    });
});