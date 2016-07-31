$(function(){
    var selected_issue_array = [];
    $(document).on("input", "#search-issue-search-input", function(e){
        $("#search-issue-searched-list-loading").show();
        $("#search-issue-searched-list").hide();
        $.ajax({
            url: $("#base-url").val() + "/site/search-issue?except-own=true",
            type: 'post',
            success: function(data) {
                $('.search-issue-followed-by-user').children().each(function() {
                    selected_issue_array.push($(this).text());
                });

                // checking selected_issue_array
                for (var i = 0; i < selected_issue_array.length; i++) {
                    console.log('Selected Issue Array');
                    console.log(selected_issue_array[i]);
                }

                var current_issue_list = init();
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

                // checking current_issue_list
                for (var i = 0; i < current_issue_list.length; i++) {
                    console.log('Current Issue List');
                    console.log(current_issue_list[i]);
                }

                // flush search-issue-searched-list
                $('#search-issue-searched-list').text('');
                var user_input = $('#search-issue-search-input').val();

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

    $(document).on("click", 'label.default', function() {
        $(this).removeClass('default');
        $(this).appendTo($('.search-issue-followed-by-user'));
    });

    $(document).on("click", '#search-issue-searched-list label', function() {
        selected_issue_array.push($(this).text());
        $(this).appendTo($('.search-issue-followed-by-user'));
        $('input.search-issue-data').val(JSON.stringify(selected_issue_array));
    });

    $(document).on("click", '.search-issue-followed-by-user label', function() {
        var selected_issue = selected_issue_array.indexOf($(this).text());
        $(this).appendTo($('#search-issue-searched-list'));
        selected_issue_array.splice(selected_issue, 1);
        $('input.search-issue-data').val(JSON.stringify(selected_issue_array));
    });
});
