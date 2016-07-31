$(function(){  
    var selected_issue_array = [];

    $('.search-issue-followed-by-user').children().each(function() {
        selected_issue_array.push($(this).text());
    });
    putSelectedIssueInsideHiddenInput();
    sendSearchIssueAjaxRequest();
    checkActivateSearchIssueModal();
    
    $(document).on("input", "#search-issue-search-input", function(e){
        $("#search-issue-searched-list-loading").show();
        $("#search-issue-searched-list").hide();
        sendSearchIssueAjaxRequest($(this).val());
    });
    
    
    function sendSearchIssueAjaxRequest(query) {
        $.ajax({
            url: $("#base-url").val() + "/site/search-issue?except-own=true",
            type: 'get',
            data: {'query': query, 'limit' : 16 },
            success: function(data) {
                var current_issue_list = initSearchIssue(data);
                
                //remove item that has been chosen
                if (current_issue_list.length !== 0) {
                    for (var i = 0; i < current_issue_list.length; i++) {
                        for (var j = 0; j < selected_issue_array.length; j++) {
                            if (current_issue_list[i].toLowerCase() === selected_issue_array[j].toLowerCase()) {
                                var selected_issue_index = current_issue_list.indexOf(selected_issue_array[j]);
                                current_issue_list.splice(selected_issue_index, 1);
                            }
                        }
                    }
                }

                // flush search-issue-searched-list
                $('#search-issue-searched-list').text('');
                var user_input = $('#search-issue-search-input').val();

                // display availables issue(s) to the webpage
                for (var i = 0; i < current_issue_list.length; i++) {
                    $('#search-issue-searched-list').append('<label class="search-issue default">' + current_issue_list[i] + '</label>');
                }

                $("#search-issue-searched-list-loading").hide();
                $("#search-issue-searched-list").show();
            }
        });
    }
    
    function initSearchIssue(data) {
        var issue_list = [];
        for (key in data) {
            var index = key;
            for (key in data[index]) {
                issue_list.push(data[index][key]['id']);
            }
        }
        return issue_list;
    }

    $(document).on("click", 'label.default', function() {
        $(this).removeClass('default');
        $(this).appendTo($('.search-issue-followed-by-user'));
    });

    $(document).on("click", '#search-issue-searched-list label', function() {
        selected_issue_array.push($(this).text());
        $(this).appendTo($('.search-issue-followed-by-user'));
        putSelectedIssueInsideHiddenInput();
    });
        
    $(document).on("click", '#search-issue-save-btn', function(e) {
        var form = $("#search-issue-form");
        $.ajax({
            url     : form.attr('action'),
            type    : 'post',
            dataType: 'json',
            data    : {'selected_issue': JSON.stringify(selected_issue_array)},
            success : function( data ) {
                if(data) {
                    location.reload();
                }                    
            }
        });
    });

    $(document).on("click", '.search-issue-followed-by-user label', function() {
        var selected_issue = selected_issue_array.indexOf($(this).text());
        $(this).appendTo($('#search-issue-searched-list'));
        selected_issue_array.splice(selected_issue, 1);
        putSelectedIssueInsideHiddenInput();
    });
    
    function putSelectedIssueInsideHiddenInput() {
        $('#edituserissueform-issue_list').val(JSON.stringify(selected_issue_array));
        updateLabelAndButton();
        
    }
    
    function updateLabelAndButton() {
        var totalSelectedIssue = selected_issue_array.length;
        if(totalSelectedIssue >= 5) {
            $("#search-issue-save-btn").prop('disabled', false);
            $("#search-issue-error-label").text("");

        } else {
            $("#search-issue-error-label").text("Follow " + (5 - totalSelectedIssue) + " more");
            $("#search-issue-save-btn").prop('disabled', true);
        }
    }
    
    function checkActivateSearchIssueModal() {
        var totalSelectedIssue = selected_issue_array.length;
        if(totalSelectedIssue < 5) {
            $("#home-search-issue-modal").modal("show")
            .find('#home-search-issue-modal')
            .load($(this).attr("value"));
        }
    }
    
    
});
