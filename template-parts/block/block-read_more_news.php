<?php
$heading = get_sub_field('heading');
$choose_news = get_sub_field('choose_news');
$link = get_sub_field('link');

?>
<div class="read-more-news">
    <div class="read-more-news-in">
        <?php
        if (!empty($heading)) { ?>
            <div class="title">
                <h3><?= $heading; ?></h3>
            </div>
        <?php }
        ?>
        <?php
        if (!empty($choose_news)) {
        ?>
            <div class="row-box">
                <?php
                foreach ($choose_news as $post_id) {
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
                                <span class="date"><?= date(__('d.m.Y', 'gross-partner-intranet'), $timestamp); ?></span>
                            </div>
                            <div class="title">
                                <h3><?= get_the_title($post_id); ?></h3>
                            </div>
                            <div class="excerpt">
                                <p><span><?= nl2br(get_the_excerpt($post_id)); ?></span> <a href="<?= get_permalink($post_id); ?>" class="read-more">Mehr lesen</a></p>
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