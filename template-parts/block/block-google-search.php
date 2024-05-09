<?php
$google_link = get_field('google-search-url','options');
$google_url = '';

$html = '';

$html .= '<div class="form search-form">';
$html .= '<form action="'.(isset($google_link['url']) && $google_link['url'] != '' ? $google_link['url'] : '').'" method="GET" target="_blank">';
$html .= '<fieldset>';
$html .= '<div class="field">';
$html .= '<input type="text" name="q" value="" placeholder="'.(isset($google_link['title']) && $google_link['title'] != '' ? $google_link['title'] : '').'">';
$html .= '</div>';
$html .= '</fieldset>';
$html .= '</form>';
$html .= '</div>';

if($html != ''){
	$html = '<div class="module block-'.(isset($args['layout']) ? $args['layout'] : $acf_layout_counter).' block-google-search"><div class="wrapper"><div class="row"><div class="col col-12">'.$html.'</div></div></div></div>';
}

echo $html;
