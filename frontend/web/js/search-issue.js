$(function(){
    $(document).on("input", "#search-issue-search-input", function(e){
        $("#search-issue-searched-list-loading").show();
        $("#search-issue-searched-list").hide();
        $.ajax({
            url: $("#base-url").val() + "/site/search-issue?except-own=true",
            type: 'post',
            success: function(data) {                
                // set the initial issue(s) list
                var current_issue_list = init();
                var temp_issue_list = init();
                console.log('Initial :: ' + current_issue_list);

                // adding selected issue(s) to array
                var selected_issue_array = [];
                $('.search-issue-followed-by-user').children().each(function() {
                    selected_issue_array.push($(this).text());
                });
                console.log('Selected Issue Array :: ' + selected_issue_array);

                // removing the selected issue(s) from list
                // prevent use select sama issue
                if (current_issue_list.length != 0) {
                    for (var i = 0; i < current_issue_list.length; i++) {
                        for (var j = 0; j < selected_issue_array.length; j++) {
                            if (current_issue_list[i].toLowerCase() == selected_issue_array[j].toLowerCase()) {
                                var selected_issue = current_issue_list.indexOf(selected_issue_array[j]);
                                current_issue_list.splice(selected_issue, 1);
                            }
                        }
                    }
                }

                console.log('Current Issue List : ' + current_issue_list);

                // flush search-issue-searched-list
                $('#search-issue-searched-list').text('');
                var user_input = $('#search-issue-search-input').val();

                $(document).on("click", 'label.default', function() {
                    $(this).removeClass('default');
                    $(this).appendTo($('.search-issue-followed-by-user'));
                })

                var user_selected_issue = [];
                $(document).on("click", '#search-issue-searched-list label', function() {
                    $(this).appendTo($('.search-issue-followed-by-user'));
                    var selected_issue = current_issue_list.indexOf($(this).text());
                    current_issue_list.splice(selected_issue, 1);
                    user_selected_issue.push($(this).text());
                });

                $(document).on("click", '.search-issue-followed-by-user label', function() {
                    current_issue_list.push($(this).text());
                    var selected_issue = user_selected_issue.indexOf($(this).text());
                    user_selected_issue.splice(selected_issue, 1);
                    $(this).appendTo($('#search-issue-searched-list'));
                });

                // compare user_selected_issue with current_issue_list
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

                function init() {
                    var issue_list = [];
                    for (key in data) {
                        var index = key;
                        for (key in data[index]) {
                            issue_list.push(data[index][key]['id']);
                        }
                    }
                    return issue_list;
                }
            }
        });
    });
});
