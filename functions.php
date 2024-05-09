<?php

$includes = [
	'inc/acf-contents.php',
	// 'inc/acf-fields.php', // see "acf-json" folder
	'inc/menu-walker.class.inc.php'
];

foreach ($includes as $file) {
	include_once($file);
}

function website_textdomain()
{
	return 'gross-partner-intranet';
}

function website_setup()
{
	load_theme_textdomain(website_textdomain(), get_template_directory() . '/languages');
	add_theme_support('automatic-feed-links');
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	add_theme_support('responsive-embeds');
}

function get_website_menu($type = 'Left')
{
	return wp_nav_menu(
		[
			'theme_location' => $type,
			'container' => '',
			'echo' => false,
			'item_spacing' => 'discard',
			'walker' => new Website_Menu_Walker,
			'link_after' => '',
			'fallback_cb' => function () {
				return '';
			}
		]
	);
}

function website_menus()
{
	$locations = array(
		'Main'  => __('Main', website_textdomain()),
		'Footer' => __('Footer', website_textdomain())
	);
	register_nav_menus($locations);
}

function website_styles_and_scripts()
{
	$styles = [
		'website' => ['file' => '/assets/css/styles.css'],
		'website-js' => ['file' => '/assets/css/styles-js.css']
	];
	$scripts = [
		'jquery' => ['file' => '/assets/js/jquery-3.4.1.min.js', 'dependencies' => []],
		'jquery-ui' => ['file' => '/assets/js/jquery-ui.min.js', 'dependencies' => ['jquery']],
		'tweenmax' => ['file' => '/assets/js/scrollmagic/TweenMax.min.js', 'dependencies' => ['jquery']],
		'scrollmagic' => ['file' => '/assets/js/scrollmagic/ScrollMagic.min.js', 'dependencies' => ['jquery']],
		'scrollmagic-jquery' => ['file' => '/assets/js/scrollmagic/plugins/jquery.ScrollMagic.min.js', 'dependencies' => ['jquery', 'scrollmagic']],
		'scrollmagic-gsap' => ['file' => '/assets/js/scrollmagic/plugins/animation.gsap.min.js', 'dependencies' => ['jquery', 'scrollmagic']],
		'scrollmagic-velocity' => ['file' => '/assets/js/scrollmagic/plugins/animation.velocity.min.js', 'dependencies' => ['jquery', 'scrollmagic']],
		'scrollmagic-indicators' => ['file' => '/assets/js/scrollmagic/plugins/debug.addIndicators.min.js', 'dependencies' => ['jquery', 'scrollmagic']],
		'owl-carousel' => ['file' => '/assets/js/owl.carousel.min.js', 'dependencies' => ['jquery']],
		'owl-carousel-linked' => ['file' => '/assets/js/owl.carousel.linked.js', 'dependencies' => ['jquery', 'owl-carousel']],
		'object-fit-images' => ['file' => '/assets/js/ofi.min.js', 'dependencies' => ['jquery']],
		'object-fit-videos' => ['file' => '/assets/js/object-fit-videos.min.js', 'dependencies' => ['jquery']],
		'imagesloaded' => ['file' => '/assets/js/imagesloaded.pkgd.min.js', 'dependencies' => ['jquery']],
		'masonry' => ['file' => '/assets/js/masonry.pkgd.min', 'dependencies' => ['jquery']],
		// 'kinetic' => ['file' => '/assets/js/jquery.kinetic.js', 'dependencies' => ['jquery']],
		// 'touch-swipe' => ['file' => '/assets/js/jquery.touchSwipe.min.js', 'dependencies' => ['jquery']],
		// 'select2' => ['file' => '/assets/js/select2.min.js', 'dependencies' => ['jquery']],
		'website' => ['file' => '/assets/js/main.js', 'dependencies' => ['jquery', 'owl-carousel']],
	];
	if (!is_admin()) {
		foreach ($styles as $key => $style) {
			wp_enqueue_style($key, get_template_directory_uri() . $style['file']);
		}
		wp_deregister_script('jquery');
		foreach ($scripts as $key => $script) {
			wp_enqueue_script($key, get_template_directory_uri() . $script['file'], $script['dependencies'], wp_get_theme()->get('Version'), true);
		}
	}
}

function get_image_by_id($attachment_id, $size = 'full')
{
	$image = wp_get_attachment_image_src($attachment_id, $size);
	$image['src'] = $image[0];
	$image['alt'] = htmlspecialchars(get_post_meta($attachment_id, '_wp_attachment_image_alt', true));
	return $image;
}

function normalize_characters($content)
{
	$content = str_replace("a\xCC\x88", "ä", $content);
	$content = str_replace("o\xCC\x88", "ö", $content);
	$content = str_replace("u\xCC\x88", "ü", $content);
	$content = str_replace("A\xCC\x88", "Ä", $content);
	$content = str_replace("O\xCC\x88", "Ö", $content);
	$content = str_replace("U\xCC\x88", "Ü", $content);
	return $content;
}

function website_mce_buttons($buttons)
{
	array_unshift($buttons, 'styleselect');
	$buttons[] = 'sup';
	$buttons[] = 'sub';
	return $buttons;
}

function website_custom_mce_styles($init_array)
{

	$style_formats = array(
		array(
			'title' => 'kein Umbruch',
			'inline' => 'span',
			'classes' => 'no-line-break',
			'wrapper' => true
		),
		array(
			'title' => '"Mehr-Text"-Absatz',
			'inline' => 'span',
			'classes' => 'more-text',
			'wrapper' => true
		),
		array(
			'title' => 'Optisch: H1',
			'selector' => 'h2,h3,h4,h5,h6,p',
			'classes' => 'h1'
		),
		array(
			'title' => 'Optisch: H2',
			'selector' => 'h1,h3,h4,h5,h6,p',
			'classes' => 'h2'
		),
		array(
			'title' => 'Optisch: H3',
			'selector' => 'h1,h2,h4,h5,h6,p',
			'classes' => 'h3'
		),
		array(
			'title' => 'Optisch: H4',
			'selector' => 'h1,h2,h3,h5,h6,p',
			'classes' => 'h4'
		),
	);
	$init_array['style_formats'] = json_encode($style_formats);

	return $init_array;
}

// allow svg upload
function kb_svg($svg_mime)
{
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}

function kb_ignore_upload_ext($checked, $file, $filename, $mimes)
{
	if (!$checked['type']) {
		$wp_filetype = wp_check_filetype($filename, $mimes);
		$ext = $wp_filetype['ext'];
		$type = $wp_filetype['type'];
		$proper_filename = $filename;

		if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg') {
			$ext = $type = false;
		}

		$checked = compact('ext', 'type', 'proper_filename');
	}

	return $checked;
}

function remove_editor()
{
	remove_post_type_support('page', 'editor');
}

function get_button_html($button, $type = '1')
{
	$html = '';
	switch ($type) {
		case '2':
			if (isset($button['url']) && $button['url'] != '') {
				$html .= '<a href="' . (isset($button['url']) ? $button['url'] : '') . '"' . (isset($button['target']) && $button['target'] != '' ? ' target="' . $button['target'] . '"' : '') . '><span class="title">' . (isset($button['title']) ? $button['title'] : '') . '</span></a>';
			}
			break;
		default:
			if (isset($button['url']) && $button['url'] != '') {
				$html .= '<a href="' . (isset($button['url']) ? $button['url'] : '') . '"' . (isset($button['target']) && $button['target'] != '' ? ' target="' . $button['target'] . '"' : '') . ' class="btn btn-type-' . $type . '"><span class="title">' . (isset($button['title']) ? $button['title'] : '') . '</span><span class="arrow"><svg xmlns="http://www.w3.org/2000/svg" width="21.615" height="18.144" viewBox="0 0 21.615 18.144"><path d="M-76.485-34.074H-94.95v1.692h18.465L-83.6-25.294l1.2,1.138,9.072-9.072L-82.407-42.3l-1.167,1.138Z" transform="translate(94.95 42.3)" fill="#ff3855"/></svg></span></a>';
			}
			break;
	}

	return $html;
}

function fidcap_options_page_init()
{
	// Check function exists.
	if (function_exists('acf_add_options_page')) {
		// Register options page.
		$option_page = acf_add_options_page(array(
			'page_title'    => __('G&P Intranet Options', website_textdomain()),
			'menu_title'    => __('G&P Intranet Options', website_textdomain()),
			'menu_slug'     => 'theme-general-settings',
			'capability'    => 'edit_posts',
			'redirect'      => false
		));
	}
}

function fidcap_add_editor_styles()
{
	add_editor_style('custom-editor-style.css');
}

function gup_intranet_wp_nav_menu_objects($items, $args)
{
	// loop
	foreach ($items as &$item) {
		// vars
		$icon = get_field('icon', $item);
		// append icon
		if (isset($icon['ID']) && $icon['ID'] > 0) {
			if (in_array($icon['subtype'], ['svg+xml'])) {
				$item->title = '<span class="icon">' . file_get_contents($icon['url']) . '</span>' . $item->title;
			} else {
				$item->title = '<span class="icon"><img src="' . $icon['sizes']['medium'] . '" alt="' . htmlspecialchars($item->title) . '" width="' . $icon['sizes']['medium-width'] . '" height="' . $icon['sizes']['medium-height'] . '"></span>' . $item->title;
			}
		}
	}
	return $items;
}

add_filter('wp_nav_menu_objects', 'gup_intranet_wp_nav_menu_objects', 10, 2);

add_action('init', 'fidcap_add_editor_styles');

add_action('acf/init', 'fidcap_options_page_init');

add_action('admin_init', 'remove_editor');

add_filter('wp_check_filetype_and_ext', 'kb_ignore_upload_ext', 10, 4);
add_filter('upload_mimes', 'kb_svg');

// tiny mce
add_filter('mce_buttons_2', 'website_mce_buttons');
add_filter('tiny_mce_before_init', 'website_custom_mce_styles');

add_action('init', 'website_menus');
add_action('after_setup_theme', 'website_setup');
add_action('wp_enqueue_scripts', 'website_styles_and_scripts');

do_shortcode('[cf7-db-display-ip]');

add_filter('big_image_size_threshold', '__return_false');

add_filter('show_admin_bar', '__return_false');

if (isset($_GET['test'])) {
	wp_scss_compile();
	wpscss_handle_errors();
}


// Write load more scripe
/**
 * Summary of load_more_news
 * @return void
 */
function load_more_posts()
{
	if (!empty($_POST['page'])) {

		$default_cat_id = 0;
		$paged = ($_POST['page']) ? $_POST['page'] : 2;
		$perpage = !empty($_POST['perpage']) ? (int)$_POST['perpage'] : 6;
		$total_printed_posts = $perpage / 3;

		$args = array(
			'suppress_filters' => false,
			'post_status' => array('publish'),
			'posts_per_page' => $perpage,
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
			$total_printed_posts++;
			if ($total_printed_posts % 3 == 1) {
				$styled_element = "position: absolute; left: 0%; top: 1px;";
			} elseif ($total_printed_posts % 3 == 2) {
				$styled_element = "position: absolute; left: 33.3328%; top: 1px;";
			} else {
				$styled_element = "position: absolute; left: 66.6656%; top: 1px;";
			}

			$styled_element = "";

			$excerpt = $p->post_excerpt;
			$timestamp = strtotime($p->post_date);
			$title = $p->post_title;
			$post_type = get_post_type($p->ID);
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'medium_large');
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
			$html .= '<div class="news-entry grid-item" style="' . $styled_element . '">';
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
			if (isset($image[0])) {
				$html .= '<div class="image">';
				$html .= '<img src="' . $image[0] . '" alt="' . htmlspecialchars($p->post_title) . '" width="' . $image[1] . '" height="' . $image[2] . '">';
				$html .= '</div>';
			}
			if ($excerpt != '') {
				$html .= '<div class="excerpt">';
				$html .= '<p>' . nl2br($excerpt) . '<a href="' . get_permalink($p->ID) . '">Mehr lesen</a></p>';
				$html .= '</div>';
			}
			$html .= '</div>';
			$html .= '</div><div class="grid-sizer"></div>';
		}
	}
	echo $html;
	wp_die();
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');



function filterFiles($slug){
	global $wpdb;
	$tableName = $wpdb->prefix.'nextcloud_press_reviews';
	$query = 'SELECT * FROM '.$tableName.' WHERE slug = \''.$slug.'\' ORDER BY slug DESC LIMIT 1';
	$results = $wpdb->get_results($query, ARRAY_A);
	$get_update = false;
	if(count($results) > 0){
		$current_time = time();
		foreach($results as $result){
			$timestamp = strtotime($result['update_date']);
			if($current_time - $timestamp > 14400){ // update if the data is older than 4h
				$get_update = true;
			}
		}
	}else{
		$get_update = true; // force update on first call
	}

	if($get_update){
		$nextcloudUrl = NEXTCLOUD_PATH . $slug;
		// Nextcloud username and password
		$username = 'Pressespiegel';
		$password = 'kBjUJaA#cpy9';

		// Initialize cURL session
		$ch = curl_init($nextcloudUrl);

		// Set cURL options
		curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PROPFIND'); // WebDAV method for listing files and folders
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Depth: 2', 'Content-Type: text/xml; charset="utf-8"')); //infinity
		curl_setopt($ch, CURLOPT_POSTFIELDS, '<?xml version="1.0" encoding="utf-8" ?>
	<d:propfind xmlns:d="DAV:">
	    <d:allprop/>
	</d:propfind>');

		// Execute the cURL session
		$output = curl_exec($ch);
		curl_close($ch);
		if ($output === false) {
			$items = [];
		} else {
			// Parse the XML response to extract file and folder names
			$xml = simplexml_load_string($output);
			$items = $xml->xpath('//d:href');
		}
		if(count($results) > 0){
			$query = 'UPDATE '.$tableName;
			$query .= ' SET items = \''.json_encode($items).'\'';
			$query .= ', update_date = \''.date('Y-m-d H:i:s').'\'';
			$query .= ' WHERE slug = \''.$slug.'\'';
		}else{
			$query = 'INSERT INTO '.$tableName;
			$query .= ' SET items = \''.json_encode($items).'\'';
			$query .= ', update_date = \''.date('Y-m-d H:i:s').'\'';
			$query .= ', slug = \''.$slug.'\'';
		}
		$wpdb->query($query);
	}else{
		$items = json_decode($results[0]['items'],true);
	}

	$temp_items = $items;
	$items = [];
	foreach($temp_items as $item){
		$items[] = $item[0];
	}

	return $items;
}

function slugGenerator($year, $month)
{
	return "$year%20Presse%20Allgemeines/$month/";
}




function load_more_press_reviews()
{
	$slug = slugGenerator($_POST['year'], $_POST['month']);
	$items = filterFiles($slug);
	if(count($items) > 0){
		foreach ($items as $item) {
			if (stripos($item, ".pdf") !== false) {
		?>
				<li>
					<span class="pr-name"><?php echo urldecode(basename((string) $item)); ?></span>
					<span class="pr-links">
						<a href="<?= site_url('/pressespiegel'); ?>?file=<?= NEXTCLOUD_PATH . $slug . basename((string) $item); ?>" target="_blank">ANSEHEN</a>
						<a href="<?= site_url('/pressespiegel'); ?>?file=<?= NEXTCLOUD_PATH . $slug . basename((string) $item); ?>&v1=<?= basename((string) $item); ?>" target="_blank">HERUNTERLADEN</a>
					</span>
				</li>
		<?php

			}
		}
	}else{
		echo '<div class="text no-press-reviews"><p>Für diesen Monat wurden noch keine Pressespiegel erstellt.</p></div>';
	}
	wp_die();
}
add_action('wp_ajax_load_more_press_reviews', 'load_more_press_reviews');
add_action('wp_ajax_nopriv_load_more_press_reviews', 'load_more_press_reviews');



add_action('parse_request', 'handle_get_request');

function handle_get_request($wp)
{
	// Check if this is a GET request.
	if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['file'])) {
		// Get and process GET parameters.
		$baseURL = sanitize_url($_GET['file']);
		// echo "<br>";

		// echo $baseURL = "https://cloud.gross-partner.de/remote.php/dav/files/4E589062-AF4C-43E1-8EAF-1967AD08B06F/2023%20Presse%20Allgemeines/02-2023/20220223_FAZ_M%c3%b6bel%20werden%20teurer.pdf";
		// exit;
		$credentials = 'Pressespiegel:kBjUJaA#cpy9';

		$ch = curl_init($baseURL);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_USERPWD, $credentials);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Set to true to capture the file content.
		$response = curl_exec($ch);
		header('Content-Type: application/pdf');
		if (!empty($_GET['v1'])) {
			$fileName = $_GET['v1'];
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
		}
		echo $response;
		curl_close($ch);
		exit;
	}
}


add_shortcode('shortcode_to_view_press_review', 'shortcode_to_view_press_review_fn');
function shortcode_to_view_press_review_fn($id)
{
	ob_start();
	$count = !empty($id['id']) ? $id['id'] : 7;
	?>
	<div class="preview-list">
		<?php
		$year = date("Y");
		$month = date("m");
		$items = [];
		$counter = 0; // try last 4 months
		while(count($items) < $count && $counter < 4){
			$slug = slugGenerator($year, $month . "-" . $year);
			$items = array_merge($items, filterFiles($slug));
			if(count($items) >= $count){
				break;
			}
			if($month == 1){
				$month = 12;
				$year = $year-1;
			}else{
				$month = $month - 1;
			}
			$counter++;
		}
		$items = array_reverse($items);
		$items = array_slice($items, 0, ((int)$count + 1));
		foreach ($items as $item) {
			if (stripos($item, ".pdf") !== false) { ?>
				<li>
					<span class="pr-name"><?= basename((string) $item); ?></span>
					<span class="pr-links">
						<a href="<?= site_url('/pressespiegel'); ?>?file=<?= NEXTCLOUD_PATH . $slug . basename((string) $item); ?>" target="_blank">ANSEHEN</a>
						<a href="<?= site_url('/pressespiegel'); ?>?file=<?= NEXTCLOUD_PATH . $slug . basename((string) $item); ?>&v1=<?= basename((string) $item); ?>" target="_blank">HERUNTERLADEN</a>
					</span>
				</li>
		<?php

			}
		}
		?>
	</div>

<?php
	return ob_get_clean();
}
/*
function adjustColorLightenDarken($color_code,$percentage_adjuster = 0) {
    $percentage_adjuster = round($percentage_adjuster/100,2);
    if(is_array($color_code)) {
        $r = $color_code["r"] - (round($color_code["r"])*$percentage_adjuster);
        $g = $color_code["g"] - (round($color_code["g"])*$percentage_adjuster);
        $b = $color_code["b"] - (round($color_code["b"])*$percentage_adjuster);
 
        return array("r"=> round(max(0,min(255,$r))),
            "g"=> round(max(0,min(255,$g))),
            "b"=> round(max(0,min(255,$b))));
    }
    else if(preg_match("/#/",$color_code)) {
        $hex = str_replace("#","",$color_code);
        $r = (strlen($hex) == 3)? hexdec(substr($hex,0,1).substr($hex,0,1)):hexdec(substr($hex,0,2));
        $g = (strlen($hex) == 3)? hexdec(substr($hex,1,1).substr($hex,1,1)):hexdec(substr($hex,2,2));
        $b = (strlen($hex) == 3)? hexdec(substr($hex,2,1).substr($hex,2,1)):hexdec(substr($hex,4,2));
        $r = round($r - ($r*$percentage_adjuster));
        $g = round($g - ($g*$percentage_adjuster));
        $b = round($b - ($b*$percentage_adjuster));
 
        return "#".str_pad(dechex( max(0,min(255,$r)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$g)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$b)) ),2,"0",STR_PAD_LEFT);
 
    }
}
*/

