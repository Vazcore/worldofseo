// Status okna: 0 - zakryto, 1 - otkryto
var statusWindow = 0;

function loadWindow() {
	if(statusWindow == 0){
		var cover = $("#cover-window");
		var contentWindow = $(".creation_window");
		cover.css({"opacity" : "0.7"});
		cover.fadeIn("slow");
		contentWindow.fadeIn("slow");
		statusWindow = 1;
	}
}


$(document).ready(function() {
	$(".nav_button").click(function() {		
		loadWindow();
	});
});