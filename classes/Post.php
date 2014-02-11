<?php
	/**
	* Class Posts. S nim svyazany vse operatsii nad postami
	*/
	require_once "classes/Content.php";
	require_once "classes/Bd.php";
	
	class Post extends Content
	{
		private $title;

		public function showPosts() {}

		public function newPost() {
			include_once "blocks/new_post.php";
		}

		public function editPost() {}				

		public function addPost($author, $text, $tittle) {
			$bd = new Bd();
			$base = $bd->get_link();
			$this->setAuthor($author);
			$this->setText($text);
			$this->tittle = $tittle;
			$date = date("d-m-Y");
			$this->setDate($date);
			
			$base->query("INSERT INTO o_posts (tittle,post_text,author,post_date) VALUES ('$this->tittle', '$this->text', '$this->author', '$this->date_publishing') ");
		}				
	}
?>