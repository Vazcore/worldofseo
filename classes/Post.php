<?php
	/**
	* Class Posts. S nim svyazany vse operatsii nad postami
	*/
	require_once "classes/Content.php";
	require_once "classes/Bd.php";
	
	class Post extends Content
	{
		private $title;		

		public function showPosts() {
			$base = $this->bd->get_link();
			$count = $base->query("SELECT * FROM o_posts")->num_rows;
			$res = $base->query("SELECT * FROM o_posts ORDER BY id DESC LIMIT 10");			

			header('Content-type: text/html; charset=utf-8');


			foreach ($res as $val) {
				// Conv
				$tittle = $val['tittle'];
				$author = $val['author'];
				$date = $val['post_date'];				
				$text = $val['post_text'];
				$text = implode(array_slice(explode('<br>',wordwrap($text,500,'<br>',false)),0,1));
				//
				printf('
					<article class="post-cover">
					<input name="post_id" type="hidden" value="%s">
					<div class="post-title"><a href="javascript:;">%s</a></div>
					<div class="post-date">%s, %s</div>
					<div class="post-image"><img src="image/post/no_image.jpg" width="100%%"></div>
					<div class="post-preview-text">
						<p>%s</p>
					</div>
					<div class="clr"></div>
					<div class="post-button"><a href="javascript:;" class="b-read-next">Читать дальше</a></div>					
					<div class="clr"></div>
					</article>
					', $val['id'], $tittle, $date, $author, $text);				
			}
			echo "<div id='post-status-base'>".$count."</div>";

		}

		public function checkNewsPosts() {
			$countBefore = $_POST['count'];
			$base = $this->bd->get_link();
			$count = $base->query("SELECT * FROM o_posts")->num_rows;
			if($countBefore != $count){
				echo "We need reload it";
			}
		}

		public function newPost() {
			include_once "blocks/new_post.php";
		}

		public function editPost() {}				

		public function addPost($author, $text, $tittle) {			
			$base = $this->bd->get_link();
			$this->setAuthor($author);
			$this->setText($text);
			$this->tittle = $tittle;
			$date = date("d-m-Y");
			$this->setDate($date);
			
			$sending_to_base = $base->query("INSERT INTO o_posts (tittle,post_text,author,post_date) VALUES ('$this->tittle', '$this->text', '$this->author', '$this->date_publishing') ");
			if($sending_to_base){
				echo "Пост успешно отправлен!";
			}
		}				
	}
?>