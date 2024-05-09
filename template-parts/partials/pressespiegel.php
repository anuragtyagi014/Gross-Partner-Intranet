<div class="press-review-sec">
	<!-- 
	<div class="module block-3 block-text">
	   <div class="wrapper">
	      <div class="container-fluid">
	         <div class="row">
	            <div class="col col-12 page-title">
	               <div class="text">
	                  <h2>Relevante Presseartikel über unsere Branche und unsere Unternehmensfamilie</h2>
	               </div>
	            </div>
	         </div>
	      </div>
	   </div>
	</div> -->
	<?php
	function getMonthsCollection(){
		$currentYear = date('Y');
		$currentMonth = date('n');

		$months = array(
			'01' => 'Januar', '02' => 'Februar', '03' => 'March', '04' => 'April', '05' => 'Mai', '06' => 'Juni',
			'07' => 'Juli', '08' => 'August', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Dezember'
		);

		$yearlyMonthArray = array();

		for ($year = $currentYear; $year >= 2020; $year--) {
			$monthlyArray = array();

			if ($year == $currentYear) {
				$endMonth = $currentMonth;
			} else {
				$endMonth = 12;
			}

			for ($i = $endMonth; $i >= 1; $i--) {
				$monthNumber = str_pad($i, 2, '0', STR_PAD_LEFT);
				$monthlyArray[$months[$monthNumber]] = $monthNumber;
			}

			$yearlyMonthArray[$year] = $monthlyArray;
		}
		return $yearlyMonthArray;
	}
	?>
	<div class="preview-sec">
		<div class="row">
			<div class="col col-md-9 col-lg-8 col-xl-9 left-box">
				<div class="title">
					<h3>Presseartikel <span class="month-name"><?php echo date("F"); ?></span></h3>
					<span class="mobile-archiv"><img src="/wp-content/themes/gross-partner-intranet/assets/img/plus-icon.svg"> ARCHIV</span>
				</div>
				<div class="preview-list">
					<?php
					$slug = slugGenerator(date("Y"), date("m") . "-" . date("Y"));
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
					?>
				</div>
			</div>
			<div class="col col-md-3 col-lg-4 col-xl-3 right-box">
				<div class="title">
					<h3>ARCHIV</h3>
				</div>
				<div class="archiv-list" id="accordion">
					<?php
					$i = 0;
					foreach (getMonthsCollection() as $year => $months) {
						$i++; ?>
						<div class="archiv-item <?= $i == 1 ? 'active' : ''; ?>">
							<div class="heading <?= $i == 1 ? 'active' : ''; ?>">
								<span class="arrow-down"></span><?= $year; ?>
							</div>
							<div class="content">
								<ul>
									<?php
									$j = 0;
									foreach ($months as $k => $v) {
										$j++; ?>
										<li class="<?= ($i == 1 && $j == 1) ? 'active' : ''; ?> press-reviews" style="cursor: pointer;" year="<?= $year; ?>" month="<?= $v . '-' . $year; ?>"><?= $k; ?></li>
									<?php }
									?>
								</ul>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- archive list -popup -->
<div class="mobile-header-popup archiv-list-popup" id="archiv-popup">
	<div class="mobile-header-popup-in">
		<div class="title">
			<div class="logo-box">
				<a href="<?php echo home_url(); ?>">
					<img src="/wp-content/themes/gross-partner-intranet/assets/img/gp-logo.svg" width="63.886" height="64.407" alt="Gross &amp; Partner Logo">
				</a>
			</div>
			<div class="close-box">
				<span>ABBRECHEN <img src="/wp-content/themes/gross-partner-intranet/assets/img/close-icon.svg"></span>
			</div>
		</div>
		<div class="middle-content">
			<h4>Archiv Presseartikel</h4>
			<div class="archiv-list" id="accordion">
				<?php
				$i = 0;
				foreach (getMonthsCollection() as $year => $months) {
					$i++; ?>
					<div class="archiv-item <?= $i == 1 ? 'active' : ''; ?>">
						<div class="heading <?= $i == 1 ? 'active' : ''; ?>">
							<span class="arrow-down"></span><?= $year; ?>
						</div>
						<div class="content">
							<ul>
								<?php
								$j = 0;
								foreach ($months as $k => $v) {
									$j++; ?>
									<li class="<?= ($i == 1 && $j == 1) ? 'active' : ''; ?> press-reviews" style="cursor: pointer;" year="<?= $year; ?>" month="<?= $v . '-' . $year; ?>"><?= $k; ?></li>
								<?php }
								?>
							</ul>
						</div>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		<div class="bottom-btnbox">
			<a href="#" class="close-box">Zeitraum anzeigen</a>
		</div>
	</div>
</div>
<!--end archiev list-popup -->