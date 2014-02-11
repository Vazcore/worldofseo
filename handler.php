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
				case "add-new-post":
					if(isset($_POST['author']) && isset($_POST['text'])){
						$author = $_POST['author'];
						$text = $_POST['text'];
						$author = trim($author);	
						$text = trim($text);
						if(!empty($author) && !empty($text)){
							$post->addPost($author, $text);					
						}else{
							echo "Error!";
						}
					}else{
						echo "Error!";
					}					
					break;
				
				default:
					# code...
					break;
			}
		}
	}
?>