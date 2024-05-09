<?php
$shortcode = get_sub_field('shortcode');

$html = '';

if($shortcode != ''){
	$html .= '<div class="shortcode">'.do_shortcode($shortcode).'</div>';
}

if($html != ''){
	$html = '<div class="module block-'.$acf_layout_counter.' block-calender"><div class="wrapper"><div class="container-fluid"><div class="row"><div class="col-12 col-md-10 offset-md-1">'.$html.'</div></div></div></div></div>';
}

echo $html;
