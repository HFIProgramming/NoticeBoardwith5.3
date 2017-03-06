function doVote(){
	var selected = [];
	$("#vote-form input:checked").each(function() {
	    var complete_id = $(this).attr('id');
	    selected.push(complete_id.substring(10,complete_id.length));
	});
	selected = JSON.stringify(selected);
	$("#vote-selected").val(selected);
	$("#vote-form").submit();
}