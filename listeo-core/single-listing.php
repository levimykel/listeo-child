<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$template_loader = new Listeo_Core_Template_Loader;

get_header(get_option('header_bar_style','standard') );

$layout = get_option('listeo_single_layout','right-sidebar');
$mobile_layout = get_option('listeo_single_mobile_layout','right-sidebar');

$custom_fields = Listeo_Core_Meta_Boxes::meta_boxes_custom();
$detailed_itinerary = get_post_meta($post->ID, '_detailed_itinerary', false);

$gallery_style = get_post_meta( $post->ID, '_gallery_style', true );

if(empty($gallery_style)) { $gallery_style = get_option('listeo_gallery_type','top'); }

$count_gallery = listeo_count_gallery_items($post->ID);

if($count_gallery < 4 ){
	$gallery_style = 'content';	
}
if( get_post_meta( $post->ID, '_gallery_style', true ) == 'top' && $count_gallery == 1 ) {
	$gallery_style = 'none';	
}

if ( have_posts() ) :
if( $gallery_style == 'top' ) :
	$template_loader->get_template_part( 'single-partials/single-listing','gallery' );  
else: ?>
<!-- Gradient-->
<div class="single-listing-page-titlebar"></div>
<?php endif; ?>

<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">
		<!-- Sidebar
		================================================== -->
		<!-- " -->
		<?php if($layout=="left-sidebar" || ($layout== 'right-sidebar' && $mobile_layout=="left-sidebar")) : ?>
			<div class="col-lg-4 col-md-4 <?php if($layout== 'right-sidebar' && $mobile_layout=="left-sidebar") echo "col-lg-push-8"; ?> margin-top-75 sticky"> 

					<?php if( get_post_meta($post->ID,'_verified',true ) == 'on') : ?>
						<!-- Verified Badge -->
						<div class="verified-badge with-tip" data-tip-content="<?php esc_html_e('Listing has been verified and belongs to the business owner or manager.','listeo_core'); ?>">
							<i class="sl sl-icon-check"></i> <?php esc_html_e('Verified Listing','listeo_core') ?>
						</div>
					<?php else:
						if(get_option('listeo_claim_page_button')){
						$claim_page = get_option('listeo_claim_page');?>
						<div class="claim-badge with-tip" data-tip-content="<?php esc_html_e('Click to claim this listing.','listeo_core'); ?>">
							<?php 
							$link =  add_query_arg ('subject', get_permalink(), get_permalink($claim_page)) ; ?>

							<a href="<?php echo $link; ?>"><i class="sl sl-icon-question"></i> <?php esc_html_e('Not verified. Claim this listing!','listeo_core') ?></a>
						</div>
						<?php }

						endif; ?>
					<?php get_sidebar('listing'); ?>
			</div>
			<!-- Sidebar / End -->
		<?php endif; ?>

		<?php while ( have_posts() ) : the_post();  ?>
			<!--  -->
		<div class="col-lg-8 col-md-8 <?php if($layout== 'right-sidebar' && $mobile_layout=="left-sidebar") { echo "col-lg-pull-4"; }  ?> padding-right-30">
			
			<!-- Titlebar -->
			<div id="titlebar" class="listing-titlebar">
				<div class="listing-titlebar-title">
					<h2><?php the_title(); ?>
					<?php
					$terms = get_the_terms( get_the_ID(), 'listing_category' );
					if ( $terms && ! is_wp_error( $terms ) ) : 
					    $categories = array();
					    foreach ( $terms as $term ) {
					        
					        $categories[] = sprintf( '<a href="%1$s">%2$s</a>',
                    			esc_url( get_term_link( $term->slug, 'listing_category' ) ),
                    			esc_html( $term->name )
                			);
					    }

					    $categories_list = join( ", ", $categories );
					    ?>
					    <span class="listing-tag">
					        <?php  echo ( $categories_list ) ?>
					    </span>
					<?php endif; ?>
					<?php $listing_type = get_post_meta( get_the_ID(), '_listing_type', true);
					switch ($listing_type) {
					 	case 'service':
					 		$type_terms = get_the_terms( get_the_ID(), 'service_category' );
					 		$taxonomy_name = 'service_category';
					 		break;
					 	case 'rental':
					 		$type_terms = get_the_terms( get_the_ID(), 'rental_category' );
					 		$taxonomy_name = 'rental_category';
					 		break;
					 	case 'event':
					 		$type_terms = get_the_terms( get_the_ID(), 'event_category' );
					 		$taxonomy_name = 'event_category';
					 		$type_terms2 = get_the_terms( get_the_ID(), 'service_category' );
					 		$taxonomy_name2 = 'service_category';
					 		break;
					 	
					 	default:
					 		# code...
					 		break;
					 } 
					 if( isset($type_terms) ) {
					 	if ( $type_terms && ! is_wp_error( $type_terms ) ) : 
					    $categories = array();
					    foreach ( $type_terms as $term ) {
								$categories[] = sprintf( '<a href="%1$s">%2$s</a>',
									esc_url( get_term_link( $term->slug, $taxonomy_name ) ),
									esc_html( $term->name )
								);
					    }

					    $categories_list = join( ", ", $categories );
					    ?>
					    <span class="listing-tag">
					        <?php  echo ( $categories_list ) ?>
					    </span>
						<?php endif;
					 }
					 ?>

					 <?php
							if( isset($type_terms2) ) {
								if ( $type_terms2 && ! is_wp_error( $type_terms2 ) ) : 
								$categories = array();
								foreach ( $type_terms2 as $term ) {
									$categories[] = sprintf( '<a href="%1$s">%2$s</a>',
										esc_url( get_term_link( $term->slug, $taxonomy_name2 ) ),
										esc_html( $term->name )
									);
								}
								$categories_list = join( ", ", $categories );
								?>
								<span class="listing-tag">
										<?php  echo ( $categories_list ) ?>
								</span>
							<?php endif;
							}
					 ?>

					</h2>
					<?php if(get_the_listing_address()): ?>
						<span>
							<a href="#listing-location" class="listing-address">
								<i class="fa fa-map-marker"></i>
								<?php the_listing_address(); ?>
							</a>
						</span>
					<?php endif; ?>
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
							<div class="rating-counter"><a href="#listing-reviews">(<?php printf( _n( '%s review', '%s reviews', $number,'listeo_core' ), number_format_i18n( $number ) );  ?>)</a></div>
						</div>
					<?php endif; 
				}?>
				</div>

			</div>
			<!-- Content
			================================================== -->
			<?php 
			if($gallery_style == 'none' ) :
				$gallery = get_post_meta( $post->ID, '_gallery', true );
				if(!empty($gallery)) : 

					foreach ( (array) $gallery as $attachment_id => $attachment_url ) {
						$image = wp_get_attachment_image_src( $attachment_id, 'listeo-gallery' );
						echo '<img src="'.esc_url($image[0]).'" class="single-gallery margin-bottom-40" style="margin-top:-30px;"></a>';
					}
					
				 endif;
			 endif; ?>

			<!-- Listing Nav -->
			<div id="listing-nav" class="listing-nav-container">
				<ul class="listing-nav">
					<li><a href="#listing-overview" class="active"><?php esc_html_e('Overview','listeo_core'); ?></a></li>
					<?php if($count_gallery > 0 && $gallery_style == 'content') : ?><li><a href="#listing-gallery"><?php esc_html_e('Gallery','listeo_core'); ?></a></li>
					<?php endif; 
					$_menu = get_post_meta( get_the_ID(), '_menu_status', 1 ); 

					if(!empty($_menu)) {
						$_bookable_show_menu =  get_post_meta(get_the_ID(), '_hide_pricing_if_bookable',true);
						if(!$_bookable_show_menu){ ?>
							<li><a href="#listing-pricing-list"><?php esc_html_e('Pricing','listeo_core'); ?></a></li>
						<?php } ?>
						
					<?php } 

					$video = get_post_meta( $post->ID, '_video', true ); 
					if(!empty($video)) :  ?>
						<li><a href="#listing-video"><?php esc_html_e('Video','listeo_core'); ?></a></li>
					<?php endif;
					$latitude = get_post_meta( $post->ID, '_geolocation_lat', true ); 
					if(!empty($latitude)) :  ?>
					<li><a href="#listing-location"><?php esc_html_e('Location','listeo_core'); ?></a></li>
					<?php 
          endif;
          ?>
          <li><a href="#itinerary"><?php esc_html_e('Itinerary','listeo_core'); ?></a></li>
          <li><a href="#sustainability"><?php esc_html_e('Sustainability','listeo_core'); ?></a></li>
          <?php
					if(!get_option('listeo_disable_reviews')){
						$reviews = get_comments(array(
						    'post_id' => $post->ID,
						    'status' => 'approve' //Change this to the type of comments to be displayed
						)); 
						if ( $reviews ) : ?>
						<li><a href="#listing-reviews"><?php esc_html_e('Reviews','listeo_core'); ?></a></li>
						<?php endif; ?>
						<?php 
						$usercomment = false;
    					if(is_user_logged_in()) {
							$usercomment = get_comments( array (
					            'user_id' => get_current_user_id(),
					            'post_id' => $post->ID,
					    	) );
					    }

					    if ( !$usercomment ) { ?>
						<li><a href="#add-review"><?php esc_html_e('Add Review','listeo_core'); ?></a></li>
						<?php } ?>
					<?php } ?>
				</ul>
			</div>

			<?php 
				// $d = DateTime::createFromFormat('d-m-Y', $expires);
				// echo $d->getTimestamp(); 
			?>

			<!-- Overview -->
			<div id="listing-overview" class="listing-section">
				<?php $template_loader->get_template_part( 'single-partials/single-listing','main-details' );  ?>
				
				<!-- Description -->
	
				<?php the_content(); ?>

				<?php 
					// echo "<pre>";
					// var_dump(empty($detailed_itinerary[0]));
					// echo "</pre>";
				?>

				<?php if(!empty($detailed_itinerary) && !empty($detailed_itinerary[0])): ?>
					<div class="margin-top-30" style="text-align: center;">
						<a href=<?php echo $detailed_itinerary[0] ?> class="button" target="_blank">Download detailed itinerary & FAQ</a>
					</div>
				<?php endif; ?>

				<?php $template_loader->get_template_part( 'single-partials/single-listing','socials' );  ?>
				<?php $template_loader->get_template_part( 'single-partials/single-listing','features' );  ?>
			</div>

			<?php
			
			if( $count_gallery > 0 && $gallery_style == 'content') : $template_loader->get_template_part( 'single-partials/single-listing','gallery-content' ); endif; ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','pricing' );  ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','opening' );  ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','video' );  ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','location' );  ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','itinerary' );  ?>
			<?php $template_loader->get_template_part( 'single-partials/single-listing','sustainability' );  ?>
			<?php if(!get_option('listeo_disable_reviews')){ 
				$template_loader->get_template_part( 'single-partials/single-listing','reviews' ); } ?>
			
		</div>
		<?php endwhile; // End of the loop. ?>
	
		<?php if($layout=="right-sidebar") : ?>
			<div class="col-lg-4 col-md-4  margin-top-75 sticky">

					<?php if( get_post_meta($post->ID,'_verified',true ) == 'on') : ?>
						<!-- Verified Badge -->
						<div class="verified-badge with-tip" data-tip-content="<?php esc_html_e('Listing has been verified and belongs to the business owner or manager.','listeo_core'); ?>">
							<i class="sl sl-icon-check"></i> <?php esc_html_e('Verified Listing','listeo_core') ?>
						</div>
					<?php else:
						if(get_option('listeo_claim_page_button')){
						$claim_page = get_option('listeo_claim_page');?>
						<div class="claim-badge with-tip" data-tip-content="<?php esc_html_e('Click to claim this listing.','listeo_core'); ?>">
							<?php 
							$link =  add_query_arg ('subject', get_permalink(), get_permalink($claim_page)) ; ?>

							<a href="<?php echo $link; ?>"><i class="sl sl-icon-question"></i> <?php esc_html_e('Not verified. Claim this listing!','listeo_core') ?></a>
						</div>
						<?php }

						endif; ?>
					<?php get_sidebar('listing'); ?>
			</div>
			<!-- Sidebar / End -->
		<?php endif; ?>
	</div>
</div>



<?php else : ?>

<?php get_template_part( 'content', 'none' ); ?>

<?php endif; ?>


<?php get_footer(); ?>