<?php

$post_number = get_sub_field('count');
$load_more_text = get_sub_field('load-more-text');

$default_cat_id = 0;

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array(
	'suppress_filters' => false,
	'post_status' => array('publish'),
	'posts_per_page' => $post_number,
	'nopaging' => false,
	'order' => 'DESC',
	'orderby' => 'date',
	'paged' => $paged,
	'post_type' => ['post']
);

$page_object = get_queried_object();
$cat_id = $default_cat_id;
if (isset($page_object->cat_name)) {
	$cat_id = get_cat_ID($page_object->cat_name);
}

if ($cat_id > 0) {
	$args['category'] = $cat_id;
}

$news = get_posts($args);

$wp_post_categories = get_categories();
$categories_by_id = [];
foreach ($wp_post_categories as $cat) {
	$categories_by_id[$cat->term_id] = $cat->name;
}

$title = get_sub_field('title');
$page_id = get_queried_object_id();

$html = '';

foreach ($news as $p) {
	$excerpt = $p->post_excerpt;
	$timestamp = strtotime($p->post_date);
	$title = $p->post_title;
	$post_type = get_post_type($p->ID);
	$image = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'medium_large');
	$video = get_field('featured-video', $p->ID);
	$categories = wp_get_post_categories($p->ID);
	$categories_html = '';
	foreach ($categories as $category_id) {
		if ($categories_html != '') {
			$categories_html .= ' | ';
		}
		$categories_html .= $categories_by_id[$category_id];
	}
	if ($categories_html != '') {
		$categories_html = ' <span class="categories">' . $categories_html . '</span>';
	}
	$html .= '<div class="news-entry grid-item ">';
	$html .= '<a href="'.get_permalink($p->ID).'">';
	$html .= '<div class="inner">';
	$html .= '<div class="categories-list date-row">';
	if ($categories_html != '') {
		$html .= $categories_html;
	}
	$html .= '<span class="date">' . date(__('d.m.Y', 'gross-partner-intranet'), $timestamp) . '</span>';
	$html .= '</div>';

	if ($title != '') {
		$html .= '<div class="title">';
		$html .= '<h3>' . $title . '</h3>';
		$html .= '</div>';
	}
	if(isset($video['ID']) && $video['ID'] > 0){
		$html .= '<div class="image video'.(isset($image[0]) ? ' has-poster' : '').'">';
		if(isset($image[0])) {
			$html .= '<img src="' . $image[0] . '" alt="' . htmlspecialchars($p->post_title) . '" width="' . $image[1] . '" height="' . $image[2] . '">';
		}
		$html .= '<video src="'.$video['url'].'" loop muted playsinline></video>'; // '.(isset($image[0]) && isset($image[0]) != '' ? ' poster="'.$image[0].'"' : '').'
		$html .= '</div>';
	}elseif(isset($image[0])) {
		$html .= '<div class="image">';
		$html .= '<img src="' . $image[0] . '" alt="' . htmlspecialchars($p->post_title) . '" width="' . $image[1] . '" height="' . $image[2] . '">';
		$html .= '</div>';
	}
	if ($excerpt != '') {
		$html .= '<div class="excerpt">';
		$html .= '<p>' . nl2br($excerpt) . '<span class="read-more">Mehr lesen</span></p>';
		$html .= '</div>';
	}
	$html .= '</div>';
	$html .= '</a>';
	$html .= '</div>';
}
$loader = '<a href="javascript:void(0);" id="load-more-posts" perpage=' . $post_number . '>' . $load_more_text . '</a>';
if ($html != '') {
	$html = '<div class="module block-' . $acf_layout_counter . ' block-news-overview"><div class="wrapper"><div class="container-fluid"><div class="row"><div class="col col-12"><div class="news-list grid-masonry news-list-result">' . $html . '<div class="grid-sizer"></div></div><div class="load-more">' . $loader . '</div></div></div></div></div></div>';
}

echo $html;
