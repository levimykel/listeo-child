<?php 

if (!function_exists('listeo_core_is_instant_booking')) {
	function listeo_core_is_instant_booking($id){
		$featured = get_post_meta($id,'_instant_booking',true);
		if(!empty($featured)) {
			return true;
		} else {
			return false;
		}
	}
}

$template_loader = new Listeo_Core_Template_Loader; 
$is_featured = listeo_core_is_featured($post->ID);
$is_instant = listeo_core_is_instant_booking($post->ID);
$listing_type = get_post_meta( $post->ID,'_listing_type',true ); 

?>
<!-- Listing Item -->

	<div class="col-lg-12 col-md-12">
		<div class="listing-item-container listing-geo-data  list-layout <?php echo esc_attr('listing-type-'.$listing_type) ?>" <?php echo listeo_get_geo_data($post); ?> >
			<a href="<?php the_permalink(); ?>" class="listing-item <?php if($is_featured){ ?>featured-listing<?php } ?>">
				 <div class="listing-small-badges-container">
						<?php if($is_featured){ ?>
							<div class="listing-small-badge featured-badge"><i class="fa fa-star"></i> <?php esc_html_e('Featured','listeo_core'); ?></div><br>
						<?php } ?>
					</div>
				<!-- Image -->
				<div class="listing-item-image">
					<?php $template_loader->get_template_part( 'content-listing-image');  ?>
					<?php $terms = get_the_terms( get_the_ID(), 'listing_category' );
						if ( $terms && ! is_wp_error( $terms ) ) : 
							$categories = array();
							foreach ( $terms as $term ) {
								$categories[] = $term->name;
							}

							$categories_list = join( ", ", $categories );
							?>
							<span class="tag">
								<?php  esc_html_e( $categories_list ) ?>
							</span>
						<?php endif; ?>
				</div>

				<!-- Content -->
				<div class="listing-item-content">
					<?php if( $listing_type  == 'service' && get_post_meta( $post->ID,'_opening_hours_status',true )) { 
						if( listeo_check_if_open() ){ ?>
							<div class="listing-badge now-open"><?php esc_html_e('Now Open','listeo_core'); ?></div>
						<?php } else { 
							if( listeo_check_if_has_hours() ) { ?>
								<div class="listing-badge now-closed"><?php esc_html_e('Now Closed','listeo_core'); ?></div>
							<?php } ?>
						<?php } 
					}?>
					<div class="listing-item-inner">
						<h3>
							<?php the_title(); ?>
							<?php if( get_post_meta($post->ID,'_verified',true ) == 'on') : ?><i class="verified-icon"></i><?php endif; ?>
						</h3>
						<?php
						$tagline = get_post_meta($post->ID, '_tagline', true);
						?>
						<h4><?php echo $tagline; ?></h4>
						<span><?php the_listing_location_link($post->ID, false); ?></span>
						
						<?php 
						if(!get_option('listeo_disable_reviews')){
							$rating = get_post_meta($post->ID, 'listeo-avg-rating', true); 
							if(isset($rating) && $rating > 0 ) : 
								$rating_type = get_option('listeo_rating_type','star');
								if($rating_type == 'numerical') { ?>
									<div class="numerical-rating" data-rating="<?php $rating_value = esc_attr(round($rating,1)); printf("%0.1f",$rating_value); ?>">
								<?php } else { ?>
									<div class="star-rating" data-rating="<?php echo $rating; ?>">
								<?php } ?>
									<?php $number = listeo_get_reviews_number($post->ID);  ?>
									<div class="rating-counter">(<?php printf( _n( '%s review', '%s reviews', $number,'listeo_core' ), number_format_i18n( $number ) );  ?>)</div>
								</div>
						<?php endif; 
						}?>
						
						<?php if($listing_type  == 'event' || get_the_listing_price_range() ) : ?>
						<div class="listing-list-small-badges-container">
						<?php  endif; ?>
							<?php if(get_the_listing_price_range()): ?>
								<div class="listing-small-badge pricing-badge"><i class="fa fa-<?php echo esc_attr(get_option('listeo_price_filter_icon','tag')); ?>"></i><?php echo get_the_listing_price_range(); ?></div>
								<?php endif; ?>
								<?php if($is_instant){ ?>
										<div class="listing-small-badge instant-badge"><i class="fa fa-bolt"></i> <?php esc_html_e('Instant Booking','listeo_core'); ?></div>
								<?php } ?>
								<?php  
								if( $listing_type  == 'event') { 
										$date_format = listeo_date_time_wp_format_php();
										$_event_datetime = get_post_meta($post->ID,'_trip_start_date', true);

										if($_event_datetime) {
											$_event_date = list($_event_datetime) = explode(' ', $_event_datetime);
											
											if($_event_date) : 
									//Dates in the m/d/y or d-m-y formats are disambiguated by looking at the separator between the various components: if the separator is a slash (/), then the American m/d/y is assumed; whereas if the separator is a dash (-) or a dot (.), then the European d-m-y format is assumed.    
												if(substr($date_format, 0, 1) === 'd'){
									$_event_date[0] = str_replace('/', '-', $_event_date[0]);
												}
												?>
											<div class="listing-small-badge"><i class="fa fa-calendar-check-o"></i><?php echo esc_html(date($date_format, strtotime($_event_date[0]))); ?></div> <br>
										<?php endif; 
									}
								}  ?>
							<?php if($listing_type  == 'event' || get_the_listing_price_range() ) : ?>
								</div>
							<?php  endif; ?>
					</div>

					<?php 
						if( listeo_core_check_if_bookmarked($post->ID) ) { 
							$nonce = wp_create_nonce("listeo_core_bookmark_this_nonce");
					?>
						<span class="like-icon listeo_core-unbookmark-it liked"
							data-post_id="<?php echo esc_attr($post->ID); ?>" 
							data-nonce="<?php echo esc_attr($nonce); ?>" ></span>
					<?php } else { 
						if(is_user_logged_in()){ 
							$nonce = wp_create_nonce("listeo_core_remove_fav_nonce"); ?>
							<span class="save listeo_core-bookmark-it like-icon" 
							data-post_id="<?php echo esc_attr($post->ID); ?>" 
							data-nonce="<?php echo esc_attr($nonce); ?>" ></span>
						<?php } else { ?>
							<span class="save like-icon tooltip left"  title="<?php esc_html_e('Login To Bookmark Items','listeo_core'); ?>"   ></span>
						<?php } ?>
					<?php } ?>
				</div>
			</a>
		</div>
	</div>

<!-- Listing Item / End -->