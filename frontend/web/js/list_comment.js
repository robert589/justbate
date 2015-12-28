
function upVote(){
	$('#vote_result').val(1);
	$(field).closest("form").submit();
}

function downVote(){
	$('#vote_result').val(-1);
	$(field).closest("form").submit();

}