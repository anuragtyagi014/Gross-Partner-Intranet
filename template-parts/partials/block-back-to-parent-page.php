<?php
$option_field = '';
$url = get_home_url();
$title = __('ZURÜCK ZUR HOME-SEITE', 'gross-partner-intranet');
$post_type = get_post_type();

if (!isset($acf_layout_counter) && isset($args['acf-layout-counter'])) {
	$acf_layout_counter = $args['acf-layout-counter'];
}

/*
switch($post_type){
	case 'projekt':
		$link = get_field('google-search-url','options');
	break;
	default:
	break;
}
*/
if (is_single()) {
	$url = site_url('/news/');
	$title = __('ZURÜCK ZUR NEWS-ÜBERSICHT', 'gross-partner-intranet');
}


$html = '';


$html .= '<div class="link">';
if ($url != '') {
	$html .= '<a href="' . $url . '">' . $title . '</a>';
}
$html .= '</div>';

if ($html != '') {
	$html = '<div class="module block-' . $acf_layout_counter . ' block-back-to-parent-page"><div class="wrapper"><div class="container-fluid"><div class="row"><div class="col col-12">' . $html . '</div></div></div></div></div>';
}

echo $html;
