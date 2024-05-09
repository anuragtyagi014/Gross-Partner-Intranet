<div class="single-post-conetnt block-related-news">
	<?php
	/*
	$read_more = [];
	$tpl_readmore = get_template_directory() . '/template-parts/block/block-read_more_news.php';
	if (have_rows('modules')) {
		while (have_rows('modules')) {
			the_row();
			if (get_row_layout() == "read_more_news") {
				$read_more[] = "yes";
				include($tpl_readmore);
			}
		}
	}
	*/
	$tpl_ = get_template_directory() . '/template-parts/common/read-more-news-default-module.php';
	include($tpl_);
	?>
</div>