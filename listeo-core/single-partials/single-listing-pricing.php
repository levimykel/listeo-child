<?php
$custom_fields = Listeo_Core_Meta_Boxes::meta_boxes_custom();
$inclusions_exclusions = get_post_meta($post->ID, '_inclusions_exclusions', false);
	
$_menu = get_post_meta(get_the_ID(), '_menu_status',true);
if(!$_menu){
	return;
}
$_bookable_show_menu =  get_post_meta(get_the_ID(), '_hide_pricing_if_bookable',true);
if(!empty($_bookable_show_menu)){
	return;
}
$_menu = get_post_meta( get_the_ID(), '_menu', 1 );
// if(!$_menu){
// 	return;
// }
$counter = 0;
foreach ($_menu as $menu) { 
	$counter++;
	if(isset($menu['menu_elements']) && !empty($menu['menu_elements'])) :
		foreach ($menu['menu_elements'] as $item) {
			$counter++;
		}
	endif;
}

if(isset($_menu[0]['menu_elements'][0]['name']) && !empty($_menu[0]['menu_elements'][0]['name'])) { ?>

<!-- Food Menu -->
<div id="listing-pricing-list" class="listing-section">
	<h3 class="listing-desc-headline margin-top-70 margin-bottom-30"><?php esc_html_e('🏷️ Pricing','listeo_core') ?></h3>

	<?php if($counter>5): ?><div class="show-more"><?php endif; ?>
		<div class="pricing-list-container">
			
			<?php foreach ($_menu as $menu) { 
					$has_menu_title = false;
					if(isset($menu['menu_title']) && !empty($menu['menu_title'])) :
						echo '<h4>'.esc_html($menu['menu_title']).'</h4>'; 
						$has_menu_title = true;
					endif;
					if(isset($menu['menu_elements']) && !empty($menu['menu_elements'])) :
					?>
					<ul class="<?php if(!$has_menu_title) { ?>pricing-menu-no-title<?php } ?>">
						<?php foreach ($menu['menu_elements'] as $item) { ?>
							<li>
								<?php if(isset($item['name']) && !empty($item['name'])) { ?><h5><?php echo esc_html($item['name']) ?></h5><?php } ?>
								<?php if(isset($item['description']) && !empty($item['description'])) { ?><p><?php echo ($item['description']) ?></p><?php } ?>
								<?php  if(isset($item['price']) && !empty($item['price'])) { ?><span>
									<?php 
									$currency_abbr = get_option( 'listeo_currency' );
									$currency_postion = get_option( 'listeo_currency_postion' );
									$currency_symbol = Listeo_Core_Listing::get_currency_symbol($currency_abbr); 
									?>
									<?php 
										if(empty($item['price']) || $item['price'] == 0) {
											esc_html_e('Free','listeo_core');
										} else {
										 	if($currency_postion == 'before') { echo $currency_symbol.' '; } 
											echo esc_html($item['price']); 
											if($currency_postion == 'after') { echo ' '.$currency_symbol; } 
										}
										?>
									</span><?php } 
									else if(!isset($item['price']) || $item['price'] == '0'){ ?>
										<span><?php esc_html_e('Free','listeo_core'); ?></span>
									<?php }  ?>
							</li>
						<?php } ?>
					</ul>
					
				<?php endif;
				}
			?>
			<!-- Food List -->
			
		</div>
	<?php if($counter>5): ?></div>
	<a href="#" class="show-more-button" data-more-title="<?php esc_html_e('Show More','listeo_core') ?>" data-less-title="<?php esc_html_e('Show Less','listeo_core') ?>"><i class="fa fa-angle-down"></i></a><?php endif; ?>

  <?php if(!empty($inclusions_exclusions) && !empty($inclusions_exclusions[0])): ?>
    <div class="margin-top-30" style="text-align: center;">
      <a href=<?php echo $inclusions_exclusions[0] ?> class="button" target="_blank">Download full list of price inclusions & exclusions</a>
    </div>
  <?php endif; ?>

  <?php 
    // echo "<pre>";
    // var_dump($inclusions_exclusions);
    // echo "</pre>";
  ?>
</div>
<?php } ?>