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
			
			while($res_row = $res->fetch_array(MYSQLI_ASSOC)){				
				$text_preview = implode(array_slice(explode('<br>',wordwrap($res_row['post_text'],490,'<br>',false)),0,1))." ...";
				echo '
				<article class="post-cover">
					<input name="post_id" type="hidden" value="'.$res_row['id'].'">
					<div class="post-title"><a href="javascript:;">'.$res_row['tittle'].'</a></div>
					<div class="post-date">'.$res_row['author'].', '.$res_row['post_date'].'</div>
					<div class="post-image"><img src="image/post/no_image.jpg" width="100%%"></div>
					<div class="post-preview-text">
						<p>'.$text_preview.'</p>
					</div>
					<div class="clr"></div>
					<div class="post-button"><a href="javascript:;" class="b-read-next">Читать дальше</a></div>					
					<div class="clr"></div>
				</article>
				';
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

			echo '
				<h2 align="center">'.$row['tittle'].'</h2>
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
				<div class="post-info">'.$row['author'].'</div>
				<div class="post-info">'.$row['post_date'].'</div>
				<input type="hidden" id="post-id-edit" value="'.$row['id'].'">
				<div class="clr"></div>
				<div id="open-post-text"><img src="image/post/no_image.jpg" width="50%%"><p>'.$row['post_text'].'</p></div>
				<div class="clr"></div>
				<h2 align="center">Комментарии: <a id="add-comm-button" href="javascript:;">+</a></h2>				
				';
			// Vyzov zagruzki vseh commentov
			$comment->loadComments($id);
		}

		public function load_post_forEdit() {
			$id = $_POST['id'];
			$base = $this->bd->get_link();
			$res = $base->query("SELECT * FROM o_posts WHERE id = '$id' ");
			$row = $res->fetch_array();

			echo '
					<form>
						<label><h3>Окно редактирования</h3></label>
						<input type="text" name="tittle" value="'.$row['tittle'].'">
						<br>
						<textarea>'.$row['post_text'].'</textarea>
						<a href="javascript:;" id="edit-post-button">Редактировать</a>
						<a href="javascript:;" id="cancel-edit-post-button">Отмена</a>
					</form>
				';
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