<div class="notification closeable notice"><p><strong><?php esc_html_e('Notice!','listeo_core');?></strong> <?php esc_html_e("This is preview of listing you've submitted, please confirm or edit your submission using buttons at the end of that page.",'listeo_core'); ?></p><a class="close" href="#"></a></div>

	<div class="listing_preview_container">
		
	<?php 
		$template_loader = new Listeo_Core_Template_Loader; 
		$post = get_post();
		$post_id = $post->ID;
		?>
		<?php 
		
		
		$gallery_style = 'content';

		if( $gallery_style == 'top' ) :
			$template_loader->get_template_part( 'single-partials/single-listing','gallery' );  
		endif; ?>
		<div id="titlebar" class="listing-titlebar">
			<div class="listing-titlebar-title">
				<h2><?php the_title(); ?>
				<?php $terms = get_the_terms( $post_id, 'listing_category' );

				if ( $terms && ! is_wp_error( $terms ) ) : 
				    $categories = array();
				    foreach ( $terms as $term ) {
				        $categories[] = $term->name;
				    }

				    $categories_list = join( ", ", $categories );
				    ?>
				    <span class="listing-tag">
				        <?php  esc_html_e( $categories_list ) ?>
				    </span>
				<?php endif; ?>
				</h2>
				<?php if(get_the_listing_address()): ?>
					<span>
						<a href="#listing-location" class="listing-address">
							<i class="fa fa-map-marker"></i>
							<?php the_listing_address(); ?>
						</a>
					</span>
				<?php endif; ?>
				<?php $rating = get_post_meta($post->ID, 'listeo-avg-rating', true); 
				if(isset($rating) && $rating > 0 ) : 
						$rating_type = get_option('listeo_rating_type','star');
							if($rating_type == 'numerical') { ?>
								<div class="numerical-rating" data-rating="<?php $rating_value = esc_attr(round($rating,1)); printf("%0.1f",$rating_value); ?>">
							<?php } else { ?>
								<div class="star-rating" data-rating="<?php echo $rating; ?>">
							<?php } ?>
						<?php $number = get_comments_number($post->ID);  ?>
						<div class="rating-counter">(<?php printf( _n( '%s review', '%s reviews', $number, 'listeo_core' ), number_format_i18n( $number ) );  ?>)</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<div id="listing-nav" class="listing-nav-container">
			<ul class="listing-nav">
				<li><a href="#listing-overview" class="active"><?php esc_html_e('Overview','listeo_core'); ?></a></li>
				<?php if($gallery_style == 'content') : ?><li><a href="#listing-gallery"><?php esc_html_e('Gallery','listeo_core'); ?></a></li>
				<?php endif; 
				$_menu = get_post_meta( get_the_ID(), '_menu', 1 ); 
				if(!empty($_menu)) { ?>
					<li><a href="#listing-pricing-list"><?php esc_html_e('Pricing','listeo_core'); ?></a></li>
				<?php } 

				$latitude = get_post_meta( $post->ID, '_geolocation_lat', true ); 
				if(!empty($latitude)) :  ?>
				<li><a href="#listing-location"><?php esc_html_e('Location','listeo_core'); ?></a></li>
				<?php 
				endif;
				?>
				<li><a href="#sustainability"><?php esc_html_e('Sustainability','listeo_core'); ?></a></li>
			</ul>
		</div>
		<!-- Overview -->
		<div id="listing-overview" class="listing-section">
			<?php $template_loader->get_template_part( 'single-partials/single-listing','main-details' );  ?>
			
			<!-- Description -->

			<?php the_content(); ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','socials' );  ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','features' );  ?>
		</div>
		<style>
		#listing-gallery { width: calc(100vw -  460px) }
		@media (max-width: 992px) { #listing-gallery { width: calc(100vw -  160px) } }
		</style>
		<!-- <div class="row">
			<div class="col-md-12"> -->
				<?php if( $gallery_style == 'content') :$template_loader->get_template_part( 'single-partials/single-listing','gallery-content' ); endif; ?>
			<!-- </div>
			
		</div> -->
		
		<?php $template_loader->get_template_part( 'single-partials/single-listing','pricing' );  ?>
		<?php $template_loader->get_template_part( 'single-partials/single-listing','opening' );  ?>
		<?php $template_loader->get_template_part( 'single-partials/single-listing','video' );  ?>
		<?php $template_loader->get_template_part( 'single-partials/single-listing','location' );  ?>
		<?php $template_loader->get_template_part( 'single-partials/single-listing','sustainability' );  ?>
		
	</div>
	<form method="post" id="listing_preview" >
	<div class="row margin-bottom-30">
		<div class="col-md-12">
			
			<button type="submit" value="edit_listing" name="edit_listing"  class="button border margin-top-20"><i class="fa fa-edit"></i> <?php esc_attr_e( 'Edit listing', 'listeo_core' ); ?></button>
			<!-- <input type="submit" name="continue"> -->
			<button type="submit" value="<?php echo apply_filters( 'submit_listing_step_preview_submit_text', __( 'Submit Listing', 'listeo_core' ) ); ?>" name="continue"  class="button margin-top-20"><i class="fa fa-check"></i> 
				<?php 
		if(isset($_GET["action"]) && $_GET["action"] == 'edit' ) { esc_html_e('Save Changes','listeo_core'); } else { echo apply_filters( 'submit_listing_step_preview_submit_text', __( 'Submit Listing', 'listeo_core' ) ); } ?>
	</button>

			<input type="hidden" 	name="listing_id" value="<?php echo esc_attr( $data->listing_id ); ?>" />
			<input type="hidden" 	name="step" value="<?php echo esc_attr( $data->step ); ?>" />
			<input type="hidden" 	name="listeo_core_form" value="<?php echo $data->form; ?>" />
		</div>
	</div>
</form>
