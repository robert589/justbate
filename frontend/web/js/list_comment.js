function upVote(){
	$('#vote').val(1);
	$("#submitvote-form").submit();
}

function downVote(){
	$('#vote').val(0);
	$("#submitvote-form").submit();

}