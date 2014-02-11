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



$(document).ready(function() {
	$(".nav_button").click(function() {		
		loadWindow();
	});


	$(".close-window img").click(function() {
		closeWindow();		
	});

});