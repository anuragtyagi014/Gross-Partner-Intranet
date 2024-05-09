<?php
/**
 * Header file for gross-partner-intranet
 *
 * @subpackage gross-partner-intranet
 * @since 1.0.0
 */
/*
$languages = icl_get_languages('skip_missing=0&orderby=code&order=desc&link_empty_to=');
$language_switcher_html = '';
foreach($languages as $language){
	if($language['active'] == '1'){
		continue;
	}
	// if($language['language_code'] != 'de'){
		$language_switcher_html .= '<li class="lang"><a href="'.$language['url'].'"'.($language['active'] == '1' ? ' class="active inactive"' : '').'>'.$language['language_code'].'</a></li>';
	//}
}
if($language_switcher_html != ''){
	$language_switcher_html = '<ul>'.$language_switcher_html.'</ul>';
}
*/
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
	<link rel="manifest" href="/favicons/manifest.json">
	<link rel="mask-icon" href="/favicons/safari-pinned-tab.svg" color="#38131f">
	<meta name="msapplication-TileColor" content="#38131f">
	<meta name="theme-color" content="#ffffff">
	<?php wp_head(); ?>
	<script type="text/javascript">
		<?php
			$translations = [
				'read_more' => __('read more', website_textdomain()),
				'read_less' => __('read less', website_textdomain()),
				'months' => [
					'01' => __('Januar', website_textdomain()),
					'02' => __('Februar', website_textdomain()),
					'03' => __('März', website_textdomain()),
					'04' => __('April', website_textdomain()),
					'05' => __('Mai', website_textdomain()),
					'06' => __('Juni', website_textdomain()),
					'07' => __('Juli', website_textdomain()),
					'08' => __('August', website_textdomain()),
					'09' => __('September', website_textdomain()),
					'10' => __('Oktober', website_textdomain()),
					'11' => __('November', website_textdomain()),
					'12' => __('Dezember', website_textdomain()),
				]
			];
		?>
		var translations = <?php echo json_encode($translations); ?>;
	</script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="mobile-header" id="myHeader">
	<div class="mobile-header-in">
		<div class="logo">
			<a href="<?php echo home_url(); ?>">
				<img src="/wp-content/themes/gross-partner-intranet/assets/img/gp-logo.svg" width="63.886" height="64.407" alt="Gross &amp; Partner Logo">
			</a>
		</div>
		<div class="mobile-menu-btn">
			<span id="menubtn">
				<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25">
				  <g id="Bruger_Menü" data-name="Bruger Menü" transform="translate(0 3.5)">
				    <line id="Line_3" data-name="Line 3" x1="25" fill="none" stroke="#353a37" stroke-width="7"/>
				    <line id="Line_4" data-name="Line 4" x1="25" transform="translate(0 9)" fill="none" stroke="#353a37" stroke-width="7"/>
				    <line id="Line_5" data-name="Line 5" x1="25" transform="translate(0 18)" fill="none" stroke="#353a37" stroke-width="7"/>
				  </g>
				</svg>
			</span>
		</div>
	</div>
</div>

<div class="outer-wrapper">
	<div class="container-fluid outer-container">
		<div class="row">
			<div class="col col-12 col-xl-1 col-header">
				<header class="header">
					<div class="wrapper">
						<div class="inner-wrapper">
							<div class="logo">
								<a href="<?php echo home_url(); ?>">
									<img src="/wp-content/themes/gross-partner-intranet/assets/img/gp-logo.svg" width="63.886" height="64.407" alt="Gross &amp; Partner Logo">
								</a>
							</div>

							<div class="navigation">
								<nav class="left-navigation">
									<?php
										echo get_website_menu('Main');
									?>
								</nav>
							</div>
						</div>
					</div>
				</header>
			</div>