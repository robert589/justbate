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
        selected_issue_array.push($(this).text());
    });
    
    $(document).on("click", '#search-issue-searched-list label', function() {
        $(this).appendTo($('.search-issue-followed-by-user'));
        $("#search-issue-form").append("<input type='hidden' value='$(this).text()' />");
        var selected_issue = current_issue_list.indexOf($(this).text());
        selected_issue_array.push($(this).text());
    });
    
    $(document).on("click", '.search-issue-followed-by-user label', function() {
        var selected_issue = selected_issue_array.indexOf($(this).text());
        selected_issue_array.splice(selected_issue, 1);
        $(this).appendTo($('#search-issue-searched-list'));
    });

});
