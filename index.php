<?php
	require_once "classes/Page.php";
	$page = new Page("main");
	$page->get_header();
 ?>
 			
			<section id="posts-section">
				<article class="post-cover">
					<div class="post-title"><a href="#">Tittle of the post</a></div>
					<div class="post-date">10 февраля 2014, Alexey Gabrusev</div>
					<div class="post-image"><img src="image/post/no_image.jpg" width="100%"></div>
					<div class="post-preview-text">
						<p>To create your first image blog post, click here and select 'Add & Edit Posts' > All Posts > This is the title of your first image post. Great looking images make your blog posts more visually compelling for your audience, and encourage readers to keep coming back.
</p>
					</div>
					<div class="clr"></div>
					<div class="post-button"><a href="#" class="b-read-next">Читать дальше</a></div>
					<div class="clr"></div>
				</article>
			</section>
<?php
	$page->get_footer();
?>