// Status okna: 0 - zakryto, 1 - otkryto
var statusWindow = 0;
// Okno, kotoroe zakroet ves' ekran
var cover = $("#cover-window");
// Okno, kuda budem zagruzhat' content
var contentWindow = $(".creation_window");

var contentLoad = $(".load-content");

// Function uznaet kakoi content nuzhno gruzit'
function typeLoading() {
	var loadButton = $(".nav_button");
	var type = loadButton.attr("name"); 
	return type;
}

// Zagruzka contenta
function loadContent(type) {
	var pageType = type;	

	$.ajax({
		type: "POST",
		url: "handler.php",
		data: { type:pageType }
	}).done(function(html) {		
		$(".load-content").html(html);
	});

}

// Poyavlenia okna
function loadWindow() {
	if(statusWindow == 0){
		var cover = $("#cover-window");
		var contentWindow = $(".creation_window");
		var type = "None";

		cover.css({"opacity" : "0.7"});
		cover.fadeIn("slow");
		type = typeLoading();
		loadContent(type);
		contentWindow.fadeIn("slow");
		statusWindow = 1;		
	}
}

// Zakrytie
function closeWindow() {
	if(statusWindow == 1){
		var cover = $("#cover-window");
		var contentWindow = $(".creation_window");
		cover.css({"opacity" : "1"});
		cover.fadeOut("slow");
		contentWindow.fadeOut("slow");
		contentLoad.html("");
		statusWindow = 0;
	}
}

function editorOpertions(id) {
	$("#cancel-edit-post-button").click(function() {
		$("#hidden-edit-post-form").fadeOut("slow");
	});

	$("#edit-post-button").click(function() {
		var tittle = $("#hidden-edit-post-form").find("input[name='tittle']").val();
		var text = $("#hidden-edit-post-form").find("textarea").val();

		$.ajax({
			type: "POST",
			url: "handler.php",
			data: { type : 'edit-post', id : id, tittle : tittle, text : text }
		}).done(function(msg) {
			$("#hidden-edit-post-form").fadeOut("slow");
			closePost();
			loadPosts();
			alert(msg);
		});
	});
}

function post_operations() {
	$("#post-edit").click(function() {
		var id = $("#post-id-edit").val();
		$.ajax({
			type: "POST",
			url: "handler.php",
			data: { type : 'load-post-for-edit', id : id }
		}).done(function(msg) {
			$("#hidden-edit-post-form").html(msg);
			$("#hidden-edit-post-form").fadeIn("slow");			
			// Block операций над открывшейся формой редактирования
			editorOpertions(id);

		});
				
	});
}

function comments_operations() {
	$("#add-comm-button").click(function() {
		$("#hidden-send-comm-form").fadeIn("slow");		
	});
	$("#cancel-send-comm-button").click(function() {
		$("#hidden-send-comm-form").fadeOut("slow");
	});

	$("#send-comm-button").click(function() {
		var author = $("#hidden-send-comm-form").find("input[name='author']").val();
		var email = $("#hidden-send-comm-form").find("input[name='email']").val();
		var post_id = $("#post-id-edit").val();
		var text = $("#hidden-send-comm-form").find("textarea").val();

		$.ajax({
			type: "POST",
			url: "handler.php",
			data: { type : 'send-comment', id : post_id, author : author, email : email, text : text }
		}).done(function(msg) {
			alert(msg);
			closePost();
		});
	});
}

function openPost() {
	var post_id = $(this).parent().find("input").val();
	var cover = $("#cover-window");
	var postWindow = $("#post-window");
	if(statusWindow == 0){
		cover.css({"opacity" : "0.7"});
		cover.fadeIn("slow");
		$.ajax({
			type: "POST",
			url: "handler.php",
			data: { type : 'open-post', id : post_id }
		}).done(function(msg) {
			postWindow.find(".load-content").html(msg);
			postWindow.fadeIn("slow");			
			statusWindow = 1;
			post_operations();
			comments_operations();

		});		
	}
}

function closePost() {	
	var cover = $("#cover-window");
	var postWindow = $("#post-window");
	if(statusWindow == 1){
		cover.css({"opacity" : "1"});
		cover.fadeOut("slow");
		postWindow.fadeOut("slow");
		statusWindow = 0;	
	}
}

function loadPosts(){	
	$.ajax({
		type: "POST",
		url: "handler.php",
		scriptCharset: "utf-8",
		data: { type : 'loadAllPost' }
	}).done(function(msg) {
		$("#posts-section").html(msg);
		$("#posts-status").html($("#post-status-base").html());
		// После загрузки постов мы можем кликать и просматривать пост полностью
		$(".post-button").click(openPost);
		$(".close-post img").click(closePost);
	});
}

function check_posts() {
	var count_before = $("#posts-status").html();

	$.ajax({
		type: "POST",
		url: "handler.php",
		data: { type : 'check-new-posts', count : count_before }
	}).done(function(msg) {
		if(msg == "We need reload it"){
			loadPosts();
		}
	});
}


$(document).ready(function() {

	loadPosts();

	setInterval(check_posts, 5000);

	$(".nav_button").click(function() {		
		loadWindow();
	});


	$(".close-window img").click(function() {
		closeWindow();		
	});


});