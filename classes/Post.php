<?php
	/**
	* Class Posts. S nim svyazany vse operatsii nad postami
	*/
	require_once "classes/Content.php";
	require_once "classes/Bd.php";
	require_once "classes/Comment.php";
	
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

		public function open_post() {
			$comment = new Comment();
			$id = $_POST['id'];
			$base = $this->bd->get_link();

			$res = $base->query("SELECT * FROM o_posts WHERE id = '$id' ");
			$row = $res->fetch_array();

			printf('
				<h2 align="center">%s</h2>
				<div id="post-edit">Редактировать</div>
				<div id="hidden-edit-post-form">					
					<form>
						<label><h3>Окно редактирования</h3></label>
						<input type="text" name="tittle">
						<br>
						<textarea></textarea>
						<button>Редактировать</button>
					</form>
				</div>
				<div class="clr"></div>
				<div class="clr"></div>
				<div class="post-info">%s</div>
				<div class="post-info">%s</div>
				<input type="hidden" id="post-id-edit" value="%s">
				<div class="clr"></div>
				<div id="open-post-text"><img src="image/post/no_image.jpg" width="50%%"><p>%s</p></div>
				<div class="clr"></div>
				<h2 align="center">Комментарии: <a id="add-comm-button" href="javascript:;">+</a></h2>				
				', $row['tittle'], $row['author'], $row['post_date'], $row['id'], $row['post_text']);
			// Vyzov zagruzki vseh commentov
			$comment->loadComments($id);
		}

		public function load_post_forEdit() {
			$id = $_POST['id'];
			$base = $this->bd->get_link();
			$res = $base->query("SELECT * FROM o_posts WHERE id = '$id' ");
			$row = $res->fetch_array();

			printf('
					<form>
						<label><h3>Окно редактирования</h3></label>
						<input type="text" name="tittle" value="%s">
						<br>
						<textarea>%s</textarea>
						<a href="javascript:;" id="edit-post-button">Редактировать</a>
						<a href="javascript:;" id="cancel-edit-post-button">Отмена</a>
					</form>
				', $row['tittle'], $row['post_text']);
		}

		public function editPost() {
			$tittle = $_POST['tittle'];
			$text = $_POST['text'];
			$id = $_POST['id'];

			$base = $this->bd->get_link();
			$res = $base->query("UPDATE o_posts SET tittle='$tittle', post_text='$text' WHERE id = '$id' ");
			if($res){
				echo "Пост отредактирован успешно!";
			}			
		}				

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