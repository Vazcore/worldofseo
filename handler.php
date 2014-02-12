<?php
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == "xmlhttprequest"){
		require_once "classes/Post.php";		
		$post = new Post("ni");

		if(isset($_POST['type'])){
			$type = $_POST['type'];
			switch ($type) {
				case "new-post":
					$post->newPost();					
					break;
				case "add-new-post":
					if((isset($_POST['author']) && isset($_POST['text'])) && isset($_POST['title'])){
						$author = $_POST['author'];
						$text = $_POST['text'];
						$title = $_POST['title'];
						$author = trim($author);	
						$text = trim($text);
						$title = trim($title);
						if((!empty($author) && !empty($text)) && !empty($title)){							
							$post->addPost($author, $text, $title);					
						}else{
							echo "Error!";
						}
					}else{
						echo "Error!";
					}					
					break;

				case "loadAllPost":
					$post->showPosts();
					break;

				case 'check-new-posts':
					$post->checkNewsPosts();
					break;

				case 'open-post':
					$post->open_post();
					break;
				case 'load-post-for-edit':
					$post->load_post_forEdit();
					break;
				default:
					# code...
					break;
			}
		}
	}
?>