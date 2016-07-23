$(function(){
    $(document).on("change", "#search-issue-search-input", function(e){
        $("#search-issue-searched-list-loading").show();
        $("#search-issue-searched-list").hide();
        $.ajax({
            url: $("#base-url").val() + "/site/search-issue",
            type: 'post',
            success: function(data) {
                // flush search-issue-searched-list
                $('#search-issue-searched-list').text('');

                var issue_list = [];
                var total_issue = 0;
                var user_input = $('#search-issue-search-input').val();

                // count how many issue(s)
                // insert it to an array
                for (key in data) {
                    var index = key;
                    total_issue = data[key].length;
                    for (key in data[index]) {
                        issue_list.push(data[index][key]['id']);
                    }
                }

                for (var i = 0; i < total_issue; i++) {
                    if (issue_list[i].toLowerCase().indexOf(user_input) != -1) {
                        $('#search-issue-searched-list').append('<label class="search-issue default">' + issue_list[i] + '</label>');
                    }
                }

                // flush array
                issue_list = []; 

                $("#search-issue-searched-list-loading").hide();
                $("#search-issue-searched-list").show();
            }
        });
    });
});

$(document).on("click", 'label.default', function() {
    $(this).removeClass('default');
    $(this).appendTo($('.search-issue-followed-by-user'));
})

$(document).on("click", '#search-issue-searched-list label', function() {
    $(this).appendTo($('.search-issue-followed-by-user'));
});

$(document).on("click", '.search-issue-followed-by-user label', function() {
    $(this).appendTo($('#search-issue-searched-list'));
});