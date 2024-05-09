<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @subpackage gross-partner-intranet
 * @since 1.0.0
 */

get_header();

echo '<div class="col col-12 col-lg-8 col-xl-8 col-contents">';
get_template_part('template-parts/partials/news-title');
get_template_part('template-parts/partials/block-back-to-parent-page');
get_website_contents('single-post');
get_template_part('template-parts/partials/related-news');
echo '</div>';


get_footer();
