<?php
$elements = get_sub_field('element');

$html = '';

foreach ($elements as $element) {
	$html .= '<div class="col-12 col-md-6">';
	$html .= '<div class="element element-' . $element['source'] . '">';
	$html .= '<div class="headline">' . $element['headline'] . '</div>';
	$html .= '<div class="entries">';
	switch ($element['source']) {
		case 'press-review':
			$counting = !empty($element['count']) ? $element['count'] : 7;
			$html .= do_shortcode('[shortcode_to_view_press_review id=' . $counting . ']');
			break;
		default:
			$count = $element['count'] > 0 ? $element['count'] : -1;
			$args = [
				'post_type' => 'post',
				'posts_per_page' => $count,
				'post_status' => 'publish',
				'suppress_filters' => false,
				'orderby' => 'date',
				'order' => 'DESC',
				'paged' => 0
			];
			$posts = get_posts($args);
			$all_categories = get_categories($args);
			$all_categories_by_term_id = [];
			foreach ($all_categories as $category) {
				$all_categories_by_term_id[$category->term_id] = $category;
			}
			foreach ($posts as $news_post) {
				$categories = wp_get_post_categories($news_post->ID);
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($news_post->ID), 'large');
				$html .= '<div class="entry">';
				$html .= '<a href="'.get_permalink($news_post->ID).'">';
				$html .= '<div class="categories date">';
				$html .= '<ul>';
				foreach ($categories as $category_id) {
					if (isset($all_categories_by_term_id[$category_id])) {
						$html .= '<li>' . $all_categories_by_term_id[$category_id]->name . '</li>';
					}
				}
				$html .= '<li>' . get_the_date('d.m.Y', $news_post) . '</li>';
				$html .= '<ul>';
				$html .= '</div>';
				$html .= '<div class="title">';
				$html .= '<h3>' . $news_post->post_title . '</h3>';
				$html .= '</div>';
				if (isset($image[0])) {
					$html .= '<div class="image">';
					$html .= '<img src="' . $image[0] . '" alt="' . htmlspecialchars($news_post->post_title) . '" width="' . $image[1] . '" height="' . $image[2] . '">';
					$html .= '</div>';
				}
				if ($news_post->post_excerpt != '') {
					$html .= '<div class="excerpt">';
					$html .= '<p>' . nl2br($news_post->post_excerpt) . '<span href="' . get_permalink($news_post->ID) . '" class="read-more">Mehr lesen</span></p>';
					$html .= '</div>';
				}
				$html .= '</a>';
				$html .= '</div>';
			}
			break;
	}
	$html .= '</div>';
	$html .= '<div class="all-button-wrapper"><a href="' . $element['button']['url'] . '"' . ($element['button']['target'] != '' ? ' target="' . $element['button']['target'] . '"' : '') . '>' . $element['button']['title'] . '</a></div>';
	$html .= '</div>';
	$html .= '</div>';
}

if ($html != '') {
	$html = '<div class="module block-' . $acf_layout_counter . ' block-news-press-review"><div class="wrapper"><div class="container-fluid"><div class="row">' . $html . '</div></div></div></div>';
}

echo $html;
