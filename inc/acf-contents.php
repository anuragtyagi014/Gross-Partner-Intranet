<?php

function email_scrambler($content)
{
	preg_match_all("/(mailto:)?([a-z0-9_-]+(\.[a-z0-9_-]+)*@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4}|museum))/im", $content, $matches);
	if (isset($matches[0][0]) and $matches[0][0] != '') {
		for ($m = 0; $m < count($matches[0]); $m++) {
			$encrypted_email_address = "";
			for ($i = 0; $i < strlen($matches[0][$m]); $i++) {
				$encrypted_email_address .= "&#" . ord(substr($matches[0][$m], $i, 1)) . ";";
			}
			$content = str_replace($matches[0][$m], $encrypted_email_address, $content);
		}
	}
	return $content;
}

function get_final_content($content)
{
	return email_scrambler($content);
}

function get_website_contents($type = '')
{
	if (is_home()) {
		if (have_rows('modules', get_option('page_for_posts'))) {
			while (have_rows('modules', get_option('page_for_posts'))) {
				the_row();
				$tpl = get_template_directory() . '/template-parts/block/block-' . get_row_layout() . '.php';
				if (file_exists($tpl)) {
					if (!isset($acf_layout_counter)) {
						$acf_layout_counter = 0;
					}
					$acf_layout_counter++;
					include($tpl);
				} else {
					echo $tpl . ': file not found';
				}
			}
		}
	} else {
		if (have_rows('modules')) {
			while (have_rows('modules')) {
				the_row();
				$tpl = get_template_directory() . '/template-parts/block/block-' . get_row_layout() . '.php';
				if (file_exists($tpl)) {
					if (!isset($acf_layout_counter)) {
						$acf_layout_counter = 0;
					}
					$acf_layout_counter++;
					if (get_row_layout() == "read_more_news" && get_post_type() == "post") {
					} else {
						include($tpl);
					}
					if (!is_front_page() && $acf_layout_counter == 1 && $type != 'single-post') {
						get_template_part('template-parts/partials/block-back-to-parent-page', null, ['acf-layout-counter' => $acf_layout_counter]);
						$acf_layout_counter++;
					}
				} else {
					echo $tpl . ': file not found';
				}
			}
		} else {
			if (!is_front_page()) {
				get_template_part('template-parts/partials/block-back-to-parent-page');
			}
		}
	}
}
