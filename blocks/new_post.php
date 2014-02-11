<script type="text/javascript" src="js/add_new_post.js"></script>

<form class="form-edit" method="post">
	<h3>Добавление нового поста</h3>	
	<div id="error-console" align="center"></div>
	<div class="post-part-title">
		<p>Ваше имя:</p>
	</div>
	<div class="post-part-input">
		<input id="author" type="text" name="author">
	</div>

	<div class="clr"></div>

	<div class="post-part-title">
		<p>Заголовок поста:</p>
	</div>
	<div class="post-part-input">
		<input type="text" name="title">
	</div>

	<div class="clr"></div>

	<div class="post-part-title">
		<p>Текст поста:</p>
	</div>
	<div class="post-part-input">
		<textarea name="text"></textarea>
	</div>

	<div class="clr"></div>

	<div class="post-part-title">
		<br>
	</div>
	<div class="post-part-input">
		<button class="nav_button_edit" name="add-new-post">Создать</button>
	</div>

	<div class="clr"></div>
</form>