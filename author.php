<?php
/**
 * The template for displaying author archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package listeo
 */

get_header();
$template_loader = new Listeo_Core_Template_Loader; 

$user = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
$user_info = get_userdata( $user->ID );
$email = $user_info->user_email;
?>
<!-- Titlebar
================================================== -->
<div id="titlebar" class="gradient">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
				
				<div class="user-profile-titlebar">
					<div class="user-profile-avatar"><?php echo get_avatar($user->ID,'full'); ?></div>
					<div class="user-profile-name">
						<h1><?php 
						$first_name = $user_info->first_name;
						$last_name = $user_info->last_name;
						if($first_name || $last_name) {
							 echo esc_html($user_info->first_name); ?> <?php echo esc_html($user_info->last_name); 
							} else {
								echo esc_html($user_info->user_login);
						}
						?>
							
						</h1>
						<?php 

						$total_visitor_reviews_args = array(
							'post_author' 	=> $user->ID,
							'parent'      	=> 0,
							'status' 	  	=> 'approve',
							'post_type'   	=> 'listing',
							'orderby' 		=> 'post_date' ,
            				'order' 		=> 'DESC',
						);
						add_filter( 'comments_clauses', 'listeo_top_comments_only' );
						$total_visitor_reviews = get_comments( $total_visitor_reviews_args ); 
						remove_filter( 'comments_clauses', 'listeo_top_comments_only' ); 
						$review_total = 0;
						$review_count = 0;
						foreach($total_visitor_reviews as $review) {
							if( get_comment_meta( $review->comment_ID, 'listeo-rating', true ) ) {
							 $review_total = $review_total + (int) get_comment_meta( $review->comment_ID, 'listeo-rating', true );
							 $review_count++;
							}
						}
						if($review_total > 0): 
							$rating = $review_total/$review_count; ?>
						<div class="star-rating" data-rating="<?php echo esc_attr($rating);?>">
							<div class="rating-counter"><a href="#listing-reviews">(<?php echo esc_attr($review_count);?> <?php esc_html_e('reviews','listeo'); ?>)</a></div>
						</div>
						<?php endif; ?>
					</div>
				</div>
				
            </div>

            
        </div>
    </div>
   
</div>


<!-- Content
================================================== -->
<div class="container">
	<div class="row sticky-wrapper">


		<!-- Sidebar
		================================================== -->
		<div class="col-lg-4 col-md-4 margin-top-0">
			<?php if($user_info->user_verified ) : ?>
				<!-- Verified Badge -->
				<div class="verified-badge with-tip" data-tip-content="<?php esc_attr_e( 'Account has been verified and belongs to the person or organization represented.', 'listeo' ); ?>">
					<i class="sl sl-icon-user-following"></i> <?php esc_html_e('Verified Account','listeo'); ?>
				</div>
			<?php endif; ?>
			<!-- Contact -->
			<div class="boxed-widget margin-top-30 margin-bottom-50">
				<h3><?php esc_html_e('Contact','listeo'); ?></h3>

				<?php 
					$visibility_setting = get_option('listeo_user_contact_details_visibility'); // hide_all, show_all, show_logged, show_booked,  
					if($visibility_setting == 'hide_all') {
						$show_details = false;
					} elseif ($visibility_setting == 'show_all') {
						$show_details = true;
					} else {
						if(is_user_logged_in() ){
							if($visibility_setting == 'show_logged'){
								$show_details = true;
							} else {
								$show_details = false;
							}
						} else {
							$show_details = false;
						}
					}	
					if($show_details){ ?>
						<ul class="listing-details-sidebar">
							<?php if(isset($user_info->phone) && !empty($user_info->phone)) : ?>
								<li><i class="sl sl-icon-phone"></i> <?php echo esc_html($user_info->phone); ?></li>
							<?php endif; ?>
							<?php $email = $user_info->user_email; if($email):  ?>
							<li><i class="fa fa-envelope-o"></i><a href="mailto:<?php echo esc_attr($email);?>"><?php echo esc_html($email);?></a></li>
							<?php endif; ?>
						</ul>
					<?php } else { ?>
						<p><?php printf( esc_html__( 'Please %s sign %s in to see contact details.', 'listeo' ), '<a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim">', '</a>' ) ?></p>
						
					<?php } ?>
				<?php if($show_details){ ?>
				<ul class="listing-details-sidebar social-profiles">
					<?php if(isset($user_info->twitter) && !empty($user_info->twitter)) : ?><li><a href="<?php echo esc_url($user_info->twitter) ?>" class="twitter-profile"><i class="fa fa-twitter"></i> Twitter</a></li><?php endif; ?>
					<?php if(isset($user_info->facebook) && !empty($user_info->facebook)) : ?><li><a href="<?php echo esc_url($user_info->facebook) ?>" class="facebook-profile"><i class="fa fa-facebook-square"></i> Facebook</a></li><?php endif; ?>
					<?php if(isset($user_info->instagram) && !empty($user_info->instagram)) : ?><li><a href="<?php echo esc_url($user_info->instagram) ?>" class="instagram-profile"><i class="fa fa-instagram"></i> Instagram</a></li><?php endif; ?>
					<?php if(isset($user_info->linkedin) && !empty($user_info->linkedin)) : ?><li><a href="<?php echo esc_url($user_info->linkedin) ?>" class="linkedin-profile"><i class="fa fa-linkedin"></i> LinkedIN</a></li><?php endif; ?>
					<?php if(isset($user_info->youtube) && !empty($user_info->youtube)) : ?><li><a href="<?php echo esc_url($user_info->youtube) ?>" class="youtube-profile"><i class="fa fa-youtube"></i> YouTube</a></li><?php endif; ?>
					
				</ul>
				<?php } ?>

				<!-- Reply to review popup -->
				<div id="small-dialog" class="zoom-anim-dialog mfp-hide">
					<div class="small-dialog-header">
						<h3><?php esc_html_e('Send Message', 'listeo'); ?></h3>
					</div>
					<div class="message-reply margin-top-0">
						<form action="" id="send-message-from-widget" >
							<textarea 
							required
							data-recipient="<?php echo esc_attr($user->ID); ?>"  
							data-referral="author_archive"  
							cols="40" id="contact-message" name="message" rows="3" placeholder="<?php esc_attr_e('Your message to ','listeo'); echo esc_attr($user_info->first_name); ?>"></textarea>
							<button class="button">
							<i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i><?php esc_html_e('Send Message', 'listeo'); ?></button>	
							<div class="notification closeable success margin-top-20"></div>
						</form>
						
					</div>
				</div>

				<a href="#small-dialog" class="send-message-to-owner button popup-with-zoom-anim"><i class="sl sl-icon-envelope-open"></i> <?php esc_html_e('Send Message', 'listeo'); ?></a>
			</div>

			<?php 
			$authorDesc = get_the_author_meta('description');
		    if($authorDesc) : ?>
		    <div class="boxed-widget margin-top-30 margin-bottom-50">
				<h3><?php esc_html_e('About','listeo'); ?></h3>
				<?php  echo $authorDesc; ?>
			</div>
			<?php endif; ?>
			
		</div>
		<!-- Sidebar / End -->


		<!-- Content
		================================================== -->
		<div class="col-lg-8 col-md-8 padding-left-30">
			<h3 class="margin-top-0 margin-bottom-40"><?php echo esc_html(($first_name) ? $first_name : $user_info->user_login); ?><?php esc_html_e("'s Listings","listeo"); ?></h3>
				

				<div class="row">

				
				<?php
				if ( have_posts() ) : 

					/* Start the Loop */
					while ( have_posts() ) : the_post();

						$template_loader->get_template_part( 'content-listing' ); 

					endwhile; ?>

					<div class="col-lg-12 col-md-12 pagination-container">
						<nav class="pagination">
						<?php
							if(function_exists('wp_pagenavi')) { 
								wp_pagenavi(array(
									'next_text' => '<i class="fa fa-chevron-right"></i>',
									'prev_text' => '<i class="fa fa-chevron-left"></i>',
									'use_pagenavi_css' => false,
									));
							} else {
								the_posts_navigation();	
							}?>
						</nav>
					</div>

				<?php else : ?>
					<div class="col-lg-12 col-md-12">
						<?php get_template_part( 'template-parts/author-content-none' ); ?>
					</div>
				<?php endif; ?>
					
					

				
			</div>
			<!-- Listings Container / End -->

			<?php 
			$limit = 5;
			$visitor_reviews_page = (isset($_GET['author-reviews-page'])) ? $_GET['author-reviews-page'] : 1;
			
			$visitor_reviews_offset = ($visitor_reviews_page * $limit) - $limit;
			
			if(!empty($total_visitor_reviews)) :
				$visitor_reviews_args = array(
					'post_author' 	=> $user->ID,
					'parent'      	=> 0,
					'status' 		=> 'approve',
					'post_type' 	=> 'listing',
					'number' 		=> $limit,
					'offset' 		=> $visitor_reviews_offset,
				);
				$visitor_reviews_pages = ceil(count($total_visitor_reviews)/$limit);
				
				$visitor_reviews = get_comments( $visitor_reviews_args );  ?>
				<!-- Reviews -->
				<div id="listing-reviews" class="listing-section margin-bottom-60">
					<h3 class="margin-top-60 margin-bottom-20"><?php esc_html_e('Reviews','listeo'); ?></h3>

					<div class="clearfix"></div>

						<!-- Reviews -->
						<section class="comments listing-reviews">

							<ul>
							<?php 
							foreach($visitor_reviews as $review) :
								?>
								<li>
									<div class="avatar"><?php echo get_avatar( $review, 70 ); ?></div>
									<div class="comment-content"><div class="arrow-comment"></div>
										<div class="comment-by"><?php echo esc_html($review->comment_author); ?>
										<div class="comment-by-listing"><?php esc_html_e('on','listeo'); ?> 
											<a href="<?php echo esc_url(get_permalink($review->comment_post_ID)); ?>"><?php echo get_the_title(
											$review->comment_post_ID) ?></a></div> 
											<span class="date"><?php echo date_i18n(  get_option( 'date_format' ),  strtotime($review->comment_date), false ); ?></span>
											<div class="star-rating" data-rating="<?php echo get_comment_meta( $review->comment_ID, 'listeo-rating', true ); ?>"></div>
										</div>
										<?php echo wpautop( $review->comment_content ); ?>
										
										<?php 
							            $photos = get_comment_meta( $review->comment_ID, 'listeo-attachment-id', false );
							            if($photos) : ?>
							            <div class="review-images mfp-gallery-container">
							            	<?php foreach ($photos as $key => $attachment_id) {
							            		$image = wp_get_attachment_image_src( $attachment_id, 'listeo-gallery' );
							            		$image_thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
							            	 ?>
											<a href="<?php echo esc_attr($image[0]); ?>" class="mfp-gallery"><img src="<?php echo esc_attr($image_thumb[0]); ?>"></a>
											<?php } ?>
										</div>
										<?php endif; ?>
									</div>		
								</li>
								
							<?php endforeach; ?>
						</ul>
					</section>
					<?php if($visitor_reviews_pages>1) { ?>
					<div class="clearfix"></div>
					<div class="pagination-container margin-top-30 margin-bottom-0">
						<nav class="pagination">
							<?php 
								echo paginate_links( array(
									'base'         	=> @add_query_arg('author-reviews-page','%#%'),
									'format'       	=> '?author-reviews-page=%#%',
									'current' 		=> $visitor_reviews_page,
									'total' 		=> $visitor_reviews_pages,
									'type' 			=> 'list',
									'prev_next'    	=> true,
							        'prev_text'    	=> '<i class="sl sl-icon-arrow-left"></i>',
							        'next_text'    	=> '<i class="sl sl-icon-arrow-right"></i>',
							         'add_args'     => false,
				   					 'add_fragment' => ''
								    
								) );?>
						</nav>
					</div>
					<?php } ?>
				</div>
			<?php endif; ?>

		</div>

	</div>
</div>

<?php get_footer(); ?>