<?php
/**
 * Template Name: Home Page with Search Form
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Listeo
 */

get_header(); 

if(get_option('listeo_home_background_type')=='video'){
	$video = get_option('listeo_search_video_mp4'); 	
} else {
	$video = false;
}


$form_type = get_option('listeo_home_form_type','wide');


$background =  get_post_meta($post->ID, 'listeo_parallax_image', TRUE);
if(empty($background)) {
	$background =  get_option( 'listeo_search_bg');
}

if($form_type == 'wide') : ?>

<!-- Banner
================================================== -->
<div class="main-search-container <?php if(get_option('listeo_home_full_screen') == 'enable') { echo 'full-height'; } ?> <?php if($video) { echo ' dark-overlay'; } ?>" data-background-image="<?php echo get_option( 'listeo_search_bg'); ?>">
	<div class="main-search-inner">

		<div class="container">
			<div class="row">
				<div class="col-md-12">
					
					<h2><?php echo get_option('listeo_home_title','Find Nearby Attractions'); ?> <span class="typed-words"></span></h2>
					<h4><?php echo get_option('listeo_home_subtitle', 'Explore top-rated attractions, activities and more!'); ?></h4>
					
					<?php // echo do_shortcode('[listeo_search_form action='.get_post_type_archive_link( 'listing' ).' source="home" custom_class="main-search-form"]') ?>
					

					
				</div>
			</div>

			<?php
			if(get_option('listeo_home_featured_categories_status')=='enable') :
				$terms = get_theme_mod('listeo_home_featured_categories');
				
				if(!empty($terms)) : ?>
				<div class="row">
					<div class="col-md-12">
						<h5 class="highlighted-categories-headline"><?php esc_html_e('Browse featured categories:','listeo') ?></h5>
						
							  
						<div class="highlighted-categories">
							
							<?php

							foreach ($terms as $key => $value) {
								$term = get_term($value,'listing_category');
								if( $term && ! is_wp_error( $term ) ) {
									$icon = get_term_meta($value,'icon',true); ?>
									<!-- Box -->
									<a href="<?php echo get_term_link($term->slug, 'listing_category'); ?>" class="highlighted-category">
								    	<?php if($icon && $icon != 'empty')  : ?><i class="<?php echo esc_attr($icon); ?>"></i><?php endif; ?>
										<h4><?php echo esc_html($term->name) ?></h4>
									</a>	

							<?php }
							} ?>
					
						</div>
						
					</div>
				</div>
			<?php endif;
			endif; ?>

			
		</div>
	<?php if($video) { ?>
	<!-- Video -->
	<div class="video-container">
		<video poster="<?php echo get_option('listeo_search_video_poster'); ?>" loop autoplay muted>
			<source src="<?php echo get_option('listeo_search_video_mp4'); ?>" type="video/mp4">
			
		</video>
	</div>
	<?php } ?>
	</div>
</div>
<?php else : ?>

<div class="main-search-container <?php if(get_option('listeo_home_full_screen') == 'enable') { echo 'full-height'; } ?> alt-search-box centered <?php if($video) { echo ' dark-overlay'; } ?>" data-background-image="<?php echo esc_attr($background); ?>">
	<div class="main-search-inner">

		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<div class="main-search-input">

						<div class="main-search-input-headline">
							<h2><?php echo get_option('listeo_home_title','Find Nearby Attractions'); ?> <?php if(( is_page_template('template-home-search.php') || is_page_template('template-home-search-video.php') || is_page_template('template-home-search-splash.php')) && get_option('listeo_home_typed_status','enable') == 'enable') {  ?><span class="typed-words"></span><?php } ?></h2>
							<h4><?php echo get_option('listeo_home_subtitle', 'Explore top-rated attractions, activities and more!'); ?></h4>
					
						</div>
						
						<?php echo do_shortcode('[listeo_search_form action='.get_post_type_archive_link( 'listing' ).' source="homebox" custom_class="main-search-form"]') ?>

						
					</div>
				</div>
			</div>
			
		</div>
	<?php if($video) { ?>
	<!-- Video -->
	<div class="video-container">
		<video poster="<?php echo get_option('listeo_search_video_poster'); ?>" loop autoplay muted>
			<source src="<?php echo get_option('listeo_search_video_mp4'); ?>" type="video/mp4">
			
		</video>
	</div>
	<?php } ?>
	</div>
</div>

<?php endif; ?>


<?php while ( have_posts() ) : the_post(); ?>
	
	<!-- 960 Container -->
	<div class="container page-container home-page-container">
	    <article <?php post_class(); ?>>
	        <?php the_content(); ?>
	    </article>
	</div>

<?php endwhile; // end of the loop.

get_footer(); ?>