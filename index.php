<?php
	require_once "classes/Page.php";
	$page = new Page("main");
	$page->get_header();
 ?>
 			<div id="posts-status"></div>
			<section id="posts-section"></section>
<?php
	$page->get_footer();
?>