function typeLoadingEdit() {
	var loadButton = $(".nav_button_edit");
	var type = loadButton.attr("name"); 
	return type;
}

function editContent() {
	var forma = $(".form-edit");
	var type = "None";
	var title = "None";
	var author = "None";
	var text = "None";
	var email = "None";
	var date_publishing = "None";

	type = typeLoadingEdit();

	if(type == "add-new-post"){
		author = forma.find("input[name='author']").val();
		text = forma.find("textarea").val();
		title = forma.find("input[name='title']").val();

		$.ajax({
			type: "POST",
			url: "handler.php",
			data: { type:type, author:author, text:text, title:title }
		}).done(function(msg) {
			if(msg == "Error!"){
				$("#error-console").html("<font color='red'>Незаполнены поля!</font>");
			}else{
				alert(msg);
				closeWindow();	
			}
		});
	}
}


$(".form-edit").submit(function(e) {
		editContent();
		
		e.preventDefault();
		return false;
	});
