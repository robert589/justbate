$(document).ready(function() {
    $(document).on('click', '.infinite-scroll-load-btn', function(e){
        var id = $(this).data('arg');
        var url = $(this).data('url');
        var next_page = parseInt($("#" + id + "-current-page").val()) +1;
        var per_page = parseInt($("#" + id + "-per-page").val());
        var total_count = parseInt($("#" + id + "-total-count").val());

        url += "&page=" + next_page + "&per-page=" + per_page;
        $.ajax({
            url:  url,
            type: 'get',
            success: function(data) {
                var current_page = next_page;
                $("#" + id + "-item-list").append(data);
                $("#" + id + "-current-page").val(current_page);
                if((current_page * per_page) >= total_count) {
                    $("#" + id + "-load-btn-container").hide();
                }
            }
        });
    });
});