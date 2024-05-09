<?php
$copyright = '';
$language_switcher_html = '';
$companies_html = '';
$social_media_html = '';
$footer_menu_html = '';
/*
if(function_exists('icl_get_languages')){
	$languages = icl_get_languages('skip_missing=0&orderby=code&order=desc&link_empty_to=');

	foreach($languages as $language){
		if($language['active'] == '1'){
			continue;
		}
		$language_switcher_html .= '<li class="lang"><a href="'.$language['url'].'"'.($language['active'] == '1' ? ' class="active inactive"' : '').'>'.$language['native_name'].'</a></li>';
	}
}
*/


$companies = get_field('company', 'option');
$social_media = get_field('social-media-icons', 'option');
$footer_menu_html = get_website_menu('Footer');

foreach ($companies as $company) {
	$companies_html .= '<li>';
	$companies_html .= '<a href="' . $company['link']['url'] . '"' . ($company['link']['target'] != '' ? ' target="' . $company['link']['target'] . '"' : '') . ($company['link']['title'] != '' ? ' title="' . $company['link']['title'] . '"' : '') . '><img src="' . $company['logo']['sizes']['medium'] . '" alt="' . $company['logo']['alt'] . '" width="' . $company['logo']['sizes']['medium-width'] . '" height="' . $company['logo']['sizes']['medium-height'] . '"></a>';
	$companies_html .= '</li>';
}

foreach ($social_media as $social_medium) {
	$social_media_html .= '<li>';
	$social_media_html .= '<a href="' . $social_medium['link']['url'] . '"' . ($social_medium['link']['target'] != '' ? ' target="' . $social_medium['link']['target'] . '"' : '') . ($social_medium['link']['title'] != '' ? ' title="' . $social_medium['link']['title'] . '"' : '') . '>' . $social_medium['icon'] . '</a>';
	$social_media_html .= '</li>';
}

/*
if($language_switcher_html != ''){
	$language_switcher_html = '<div class="lang-nav"><ul>'.$language_switcher_html.'</ul></div>';
}
*/
if ($companies_html != '') {
	$companies_html = '<div class="company-nav"><ul>' . $companies_html . '</ul></div>';
}
if ($social_media_html != '') {
	$social_media_html = '<div class="social-media-nav"><p>' . __('Follow us', website_textdomain()) . '</p><ul>' . $social_media_html . '</ul></div>';
}
if ($footer_menu_html != '') {
	$footer_menu_html = '<div class="nav">' . $footer_menu_html . '</div>';
}
?>
<div class="col col-12 col-lg-4 col-xl-3 col-aside page-right-bar">
	<aside>
		<div class="wrapper">
			<div class="inner-wrapper">
				<?php
				get_template_part('template-parts/block/block-google-search', null, ['layout' => 'aside']);
				?>
				<div class="calendar-wrapper">
					<div class="calendar">
						<div class="sidebar-title">
							<h3><?= get_the_title(13); ?></h3>
						</div>
						<div class="sidebar-calander">
							<?php
							echo do_shortcode('[MEC id="13"]'); ?>
						</div>
						<div class="sidebar-calander-list">
							<?php echo do_shortcode('[MEC id="21"]');
							?>
						</div>
					</div>
					<div class="page-cal-link">
						<?php
						$link = get_field('calender-page', 'option');
						if (isset($link['url']) && $link['url'] != '') {
							echo '<div class="button-wrapper"><a href="' . $link['url'] . '"' . ($link['target'] != '' ? ' target="' . $link['target'] . '"' : '') . ($link['title'] != '' ? ' title="' . $link['title'] . '"' : '') . ' class="btn">' . __('Alle Ereignisse', website_textdomain()) . '</a></div>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</aside>
</div>
</div>
</div>
<footer>
	<div class="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col col-12 col-xl-1 col-footerin"></div>
				<div class="col col-12 col-xl-11 col-footerin1">
					<div class="footer-content">
						<div class="copyright">
							<h5><?php echo nl2br($copyright); ?></h5>
						</div>
						<div class="footer-nav">
							<?php echo $companies_html; ?>
							<?php echo $social_media_html; ?>
							<?php echo $footer_menu_html; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
</div><!-- end of .outer-wrapper -->


<!-- mobile-header-popup -->
<div class="mobile-header-popup" id="mobile-headermenu">
	<div class="mobile-header-popup-in">
		<div class="title">
			<div class="logo-box">
				<a href="<?php echo home_url(); ?>">
					<img src="/wp-content/themes/gross-partner-intranet/assets/img/gp-logo.svg" width="63.886" height="64.407" alt="Gross &amp; Partner Logo">
				</a>
			</div>
			<div class="close-box">
				<span>SCHLIESSEN <img src="/wp-content/themes/gross-partner-intranet/assets/img/close-icon.svg"></span>
			</div>
		</div>
		<div class="mobile-nav">
			<nav class="navigation">
				<?php
				echo get_website_menu('Main');
				?>
			</nav>
			<div class="search-box">
				<?php get_template_part('template-parts/block/block-google-search', null, ['layout' => 'aside']); ?>
			</div>
		</div>
		<div class="bottom-nav">
			<?php echo $footer_menu_html; ?>
		</div>
	</div>
</div>
<!--end mobile-header-popup -->


<?php wp_footer(); ?>

<script>
	jQuery(document).ready(function($) {
		var page = 2;
		$("#load-more-posts").click(function() {

			var perpage = $(this).attr("perpage");
			$.ajax({
				url: "<?= admin_url("admin-ajax.php"); ?>",
				method: "POST",
				data: {
					action: "load_more_posts",
					page: page,
					perpage: perpage
				},
				success: function(res) {
					$(".grid-sizer:last()").remove();
					$(".news-list-result").append(res);
					page++;
				}
			});

		});

		// Load Press Review
		$(document).delegate(".press-reviews", "click", function() {
			var year = $(this).attr("year");
			var month = $(this).attr("month");
			$(".press-reviews").removeClass("active");
			$(this).addClass("active");
			$.ajax({
				url: "<?php echo admin_url("admin-ajax.php"); ?>",
				method: "POST",
				beforeSend: function() {
					$(".preview-list").prepend('<div class="loader-box"></div>');
				},
				data: {
					action: "load_more_press_reviews",
					year: year,
					month: month
				},
				success: function(res) {
					var month_year = month.split('-');
					$('.preview-sec .month-name').text(translations['months'][month_year[0]]);
					$(".preview-list").html(res);
					$(".preview-list div:first()").removeClass("loader-box");
				}
			});
		});
	});
</script>

</body>

</html>