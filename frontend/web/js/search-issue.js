$(function(){
    $(document).on("keyup", "#search-issue-search-input", function(e){
        $("#search-issue-searched-list-loading").show();
        $("#search-issue-searched-list").hide();
        $.ajax({
            url: $("#base-url").val() + "/site/search-issue?except-own=true",
            type: 'post',
            success: function(data) {
                // set the initial
                var issue_list = [];
                for (key in data) {
                    var index = key;
                    for (key in data[index]) {
                        issue_list.push(data[index][key]['id']);
                    }
                }

                // using this variable instead of issue_list
                var current_issue_list = issue_list;

                // flush search-issue-searched-list
                $('#search-issue-searched-list').text('');
                var user_input = $('#search-issue-search-input').val();

                $(document).on("click", 'label.default', function() {
                    $(this).removeClass('default');
                    $(this).appendTo($('.search-issue-followed-by-user'));
                })

                $(document).on("click", '#search-issue-searched-list label', function() {
                    $(this).appendTo($('.search-issue-followed-by-user'));
                    var selected_issue = current_issue_list.indexOf($(this).text());
                    current_issue_list.splice(selected_issue, 1);
                    console.log(current_issue_list);
                });

                $(document).on("click", '.search-issue-followed-by-user label', function() {
                    current_issue_list.push($(this).text());
                    $(this).appendTo($('#search-issue-searched-list'));
                    console.log(current_issue_list);
                });

                // compare user_selected_issue with current_issue_list
                var user_selected_issue = [];
                $('.search-issue-followed-by-user').children().each(function() {
                    user_selected_issue.push($(this).text());
                });

                // display availables issue(s) to the webpage
                for (var i = 0; i < current_issue_list.length; i++) {
                    if (current_issue_list[i].indexOf(user_input) != -1) {
                        $('#search-issue-searched-list').append('<label class="search-issue default">' + current_issue_list[i] + '</label>');
                    }
                }

                $("#search-issue-searched-list-loading").hide();
                $("#search-issue-searched-list").show();
            }
        });
    });
});
