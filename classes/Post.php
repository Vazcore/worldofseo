<?php
	/**
	* Class Posts. S nim svyazany vse operatsii nad postami
	*/
	require_once "classes/Content.php";
	class Post extends Content
	{
		private $title;

		public function showPosts() {}

		public function newPost() {
			include_once "blocks/new_post.php";
		}

		public function editPost() {}				

		public function addPost($author, $text) {
			
		}				
	}
?>