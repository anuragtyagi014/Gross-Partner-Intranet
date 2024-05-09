<?php
	$attach_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
	$image = get_sub_field('image');
	$text = get_sub_field('text');
	$button = get_sub_field('button');
	$video = get_field('featured-video');
	$image_url = $attach_image[0];
	if($image['ID'] > 0){
		$image_url = $image['sizes']['large'];
	}
	$timestamp = strtotime(get_the_date());
	$wp_post_categories = get_categories();
	foreach ($wp_post_categories as $cat) {
		$categories_by_id[$cat->term_id] = $cat->name;
	}
	$categories = wp_get_post_categories(get_the_ID());
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
<div class="single-post-conetnt block-news-details">
	<div class="row-box">
		<div class="left-content-box">
			<?php
			if(isset($video['ID']) && $video['ID'] > 0){
				echo '<div class="img-box">';
				echo '<div class="video'.($image_url != '' ? ' has-poster' : '').'">';
				/*
				if($image_url != '') {
					echo '<img src="' . $image_url . '" alt="'.htmlspecialchars(get_the_title()).'">';
				}
				*/
				echo '<video src="'.$video['url'].'"'.($image_url != '' ? ' poster="'.$image_url.'"' : '').' loop muted playsinline autoplay></video>';
				echo '</div>';
				echo '</div>';
			}elseif($image_url != ''){
			?>
			<div class="img-box">
				<img src="<?php echo $image_url; ?>" alt="<?= htmlspecialchars(get_the_title()); ?>">
			</div>
			<?php
			}
			?>
		</div>
		<div class="right-content-box">
			<div class="inner">
				<div class="categories-list date-row">
					<?php
					if (!empty($categories_html)) {
						echo $categories_html;
					}
					?>
					<span class="date"><?= date(__('d.m.Y', 'gross-partner-intranet'), $timestamp); ?></span>
				</div>
				<div class="title">
					<h3><?php echo get_the_title(); ?></h3>
				</div>
				<?php
				if($image_url != ''){
				?>
				<div class="img-box">
					<img src="<?php echo $image_url; ?>" alt="<?= htmlspecialchars(get_the_title()); ?>">
				</div>
				<?php
				}
				?>
				<div class="excerpt">
					<?php echo $text; ?>
				</div>
				<?php
				if(isset($button['url']) && $button['url'] != ''){
				?>
				<div class="btn-box">
					<a href="<?php $button['url']; ?>"<?php echo ($button['target'] != '' ? ' target="'.$button['target'].'"' : '')?>><?php echo $button['title']; ?></a>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>