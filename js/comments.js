function addNewComment(name, email, text, date){
	var newComment = $("#comments div:eq(0)").clone();

	newComment.find('.comment-title').text(name);
	newComment.find('.comment-email').text(email);
	newComment.find('.comment-text').text(text);
	newComment.find('.comment-date').text(date);

	return newComment;
}



function loadAllComments(){
	$.get('api.php?action=getNew', function(result){
		var resultComments = JSON.parse(result);

		var comments = [];
		for (var i = 0; i < resultComments.length; i++) {
			var newComment = addNewComment(resultComments[i].name, resultComments[i].email, resultComments[i].text, resultComments[i].date); // name, email, text, date
			comments.push(newComment);
		}

		$('#comments').children().remove();
		$('#comments').append(comments);

	});
}

// loadAllComments();

setInterval( loadAllComments, 1000 );

