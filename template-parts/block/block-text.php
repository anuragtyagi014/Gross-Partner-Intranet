<?php
$text = get_sub_field('text');

$html = '';

if ($text != '') {
	$html .= '<div class="text">' . $text . '</div>';
}

if ($html != '') {
	$html = '<div class="module block-' . $acf_layout_counter . ' block-text"><div class="wrapper"><div class="container-fluid"><div class="row"><div class="col col-12 page-title">' . $html . '</div></div></div></div></div>';
}

echo $html;
