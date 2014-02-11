<?php
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest"){
		require_once "classes/Post.php";		
		$post = new Post();

		if(isset($_POST['type'])){
			$type = $_POST['type'];
			switch ($type) {
				case "new-post":
					$post->newPost();					
					break;
				
				default:
					# code...
					break;
			}
		}
	}
?>