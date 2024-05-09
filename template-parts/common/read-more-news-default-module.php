<?php
$post_id = get_the_ID();
$heading = "Weitere News lesen";
$choose_news = wp_get_recent_posts(array(
	'suppress_filters' => false,
    'numberposts' => 2, // Number of recent posts thumbnails to display
    'post_status' => 'publish',
	'exclude' => $post_id, // do not show current post
));
$news_overview_page = get_field('news-overview-page','option');
$link = ["url" => (isset($news_overview_page['url']) ? $news_overview_page['url'] : ''), "title" => "ZURÜCK ZUR NEWS-ÜBERSICHT"];

?>
<div class="read-more-news">
    <div class="read-more-news-in">
        <?php
        if (!empty($heading)) { ?>
            <div class="title">
                <h3><?php echo $heading; ?></h3>
            </div>
        <?php }
        ?>
        <?php
        if (!empty($choose_news)) {
        ?>
            <div class="row-box">
                <?php
                foreach ($choose_news as $post_item) {
                    $post_id = $post_item['ID'];
                    $timestamp = strtotime(get_the_date($post_id));
                    $wp_post_categories = get_categories();
                    $categories_by_id = [];
                    foreach ($wp_post_categories as $cat) {
                        $categories_by_id[$cat->term_id] = $cat->name;
                    }
                    $categories = wp_get_post_categories($post_id);
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
                ?>
                    <div class="post-box">
                        <div class="inner">
                            <div class="categories-list date-row">
                                <?php if (!empty($categories_html)) {
                                    echo $categories_html;
                                }
                                ?>
                                <span class="date"><?php date(__('d.m.Y', 'gross-partner-intranet'), $timestamp); ?></span>
                            </div>
                            <div class="title">
                                <h3><?php echo get_the_title($post_id); ?></h3>
                            </div>
                            <div class="excerpt">
                                <p><span><?php echo nl2br(get_the_excerpt($post_id)); ?></span> <a href="<?php echo get_permalink($post_id); ?>" class="read-more">Mehr lesen</a></p>
                            </div>
                        </div>
                    </div>
                <?php }
                ?>
            </div>
        <?php } ?>
    </div>
    <?php
    if (!empty($link['url']) && !empty(!empty($link['title']))) { ?>
        <div class="btn-box">
            <a href="<?= $link['url']; ?>"><span><?= $link['title']; ?></span></a>
        </div>
    <?php }
    ?>

</div>