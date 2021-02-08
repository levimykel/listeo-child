<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package listeo
 */

get_header(); ?>

<?php
$args = array(
  'post_type' => 'post',
  'posts_per_page' => '4'
 );
 // the query
 $query = new WP_Query( $args );


?>

<?php $titlebar_status = get_option('listeo_blog_titlebar_status','show');

if( $titlebar_status == 'show' ) : ?>
<!-- Titlebar
================================================== -->
<div id="titlebar" class="<?php echo esc_attr(get_option('listeo_blog_titlebar_style','gradient')); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
				<?php if ( is_home() ) { ?>
					<h1><?php echo get_option('listeo_blog_title','Blog'); ?></h1>
				<?php } else { ?>
					<h2><?php echo get_option('listeo_blog_title','Blog'); ?></h2>
				<?php } ?>
				<span><?php echo get_option('listeo_blog_subtitle','Latest News'); ?></span>

        <?php
          // Levi Troubleshooting blog issue
          // echo "<pre>";
          // var_dump($variable_trip_start_date_string);
          // echo "</pre>";
        ?>
	
				<!-- Breadcrumbs -->
				<?php if(function_exists('bcn_display')) { ?>
					<nav id="breadcrumbs">
						<ul>
							<?php bcn_display_list(); ?>
						</ul>
					</nav>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php 
endif; 
$sidebar_side = get_option('pp_blog_layout'); 

?>
<!-- Content
================================================== -->
<div class="container <?php echo esc_attr($sidebar_side); if( $titlebar_status == 'hide' ) { echo ' margin-top-50'; } ?>">

	<!-- Blog Posts -->
	<div class="blog-page">
		<div class="row">
			<div class="col-lg-9 col-md-8 <?php  echo esc_attr(($sidebar_side == 'left-sidebar') ? 'padding-left-30' : 'padding-right-30' ); ?> col-blog">
			
			<?php
			if ( have_posts() ) :

				/* Start the Loop */
				while ( have_posts() ) : the_post();
          get_template_part( 'blog-parts/content', get_post_format() );
				
				endwhile;

				?>
				<!-- Pagination -->
				<div class="clearfix"></div>
				<div class="row">
					<div class="col-md-12">
						<!-- Pagination -->
						<div class="pagination-container margin-bottom-40">
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
				</div>
			</div>
			<!-- Pagination / End -->
				<?php

			else :
				get_template_part( 'template-parts/content', 'none' );
			endif; ?>

		
			</div>

			<!-- Widgets -->
			<div class="col-lg-3 col-md-4 col-sidebar">
				<div class="sidebar right">
					<?php get_sidebar(); ?>
				</div>
			</div>
			<!-- Sidebar / End -->
		</div>
	<!-- Sidebar / End -->

	</div>

</div>

<?php get_footer(); ?>