<?php
	/**
	* Class dlya comentov
	*/
	require_once "classes/Content.php";
	require_once "classes/Bd.php";

	class Comment extends Content
	{
		private $email;

		public function loadComments($post_id) {			
			$res = $this->base->query("SELECT * FROM o_comments WHERE post_id = '$post_id' ");
			
			echo '
				<div id="hidden-send-comm-form">					
					<form>
						<label><h3>Отправка комментария:</h3></label>
						<input type="text" name="author" placeholder="Ваше имя ...">
						<input type="text" name="email" placeholder="Email ...">
						<br>
						<textarea></textarea>
						<a href="javascript:;" id="send-comm-button">Отправить</a>
						<a href="javascript:;" id="cancel-send-comm-button">Отмена</a>
					</form>
				</div>
				';
			if($res->num_rows != 0){
				while($row = $res->fetch_array(MYSQLI_ASSOC)) {
					echo '
					<div id="comments-block">
						<div class="comment-unit">
							<p class="comment-author">'.$row['author'].' написал '.$row['com_date'].':</p>
							<p class="comment-text">'.$row['com_text'].'</p>
						</div>
					</div>	
					';
				}				
			}else{
				echo "<h3 align='center'>Комментарии отсутствуют</h3>";
			}
		}

		public function send_comment() {
			$this->author = $_POST['author'];
			$this->email = $_POST['email'];
			$this->date_publishing = date("d-m-Y");
			$this->text = $_POST['text'];
			$post_id = $_POST['id'];

			$res = $this->base->query("INSERT INTO o_comments (post_id, author, com_date, email, com_text) VALUES ('$post_id', '$this->author', '$this->date_publishing', '$this->email', '$this->text') ");
			if($res){
				echo "Комментарий успешно добавлен!";
			}
		}
	}
?>