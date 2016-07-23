$(function(){
	$(document).on("change", "#search-issue-search-input", function(e){
            $.ajax({
	        url: $("#base-url").val() + "/site/search-all-issues",
	        type: 'post',
	        success: function(data) {
	        	console.log(data);
	        }
            });
	});
        
        $(document).on("click",'label.search-issue', function() {
            $(this).toggleClass('checked');
        });
});