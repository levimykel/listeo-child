<?php 
if(isset($data)) :
    $style        = (isset($data->style)) ? $data->style : '' ;
    $columns        = (isset($data->grid_columns)) ? $data->grid_columns : '' ;
endif; 

$template_loader = new Listeo_Core_Template_Loader;
$listing_type = get_post_meta( $post->ID,'_listing_type',true );
$is_featured = listeo_core_is_featured($post->ID);  ?>
<!-- Listing Item -->
<?php if(isset($style) && $style == 'compact') {
    if($columns == 3) { ?>
        <div class="col-lg-4 col-md-6"> 
    <?php } else {?>
        <div class="col-lg-6 col-md-12"> 
    <?php } 
}?>

<div class="listing-item-link-wrapper">
  <a href="<?php the_permalink(); ?>" class="listing-item-container listing-geo-data compact" <?php echo listeo_get_geo_data($post); ?> >
    <div class="listing-item  <?php if($is_featured){ ?>featured-listing<?php } ?>">
      <div class="listing-small-badges-container">
              <?php if($is_featured){ ?>
                  <div class="listing-small-badge featured-badge"><i class="fa fa-star"></i> <?php esc_html_e('Featured','listeo_core'); ?></div>
              <?php } ?>
              <?php if(get_the_listing_price_range()): ?>
                  <div class="listing-small-badge pricing-badge"><i class="fa fa-<?php echo esc_attr(get_option('listeo_price_filter_icon','tag')); ?>"></i><?php echo get_the_listing_price_range(); ?></div>
              <?php endif; ?>
              <?php  
              if( $listing_type  == 'event') { 
                  $date_format = listeo_date_time_wp_format_php();
                  $_event_datetime = get_post_meta($post->ID,'_event_date', true); 
                  if($_event_datetime){
                      $_event_date = list($_event_datetime) = explode(' -', $_event_datetime);
                      if($_event_date) :
                      if(substr($date_format, 0, 1) === 'd'){
                          $_event_date[0] = str_replace('/', '-', $_event_date[0]);
                      } ?>
                      <div class="listing-small-badge"><i class="fa fa-calendar-check-o"></i><?php echo esc_html(date($date_format, strtotime($_event_date[0]))); ?></div> 
                      <?php endif;
                  }
                  
              }  ?>
              
          </div>
          <?php 
      $template_loader->get_template_part( 'content-listing-image');  ?>

      <?php
            if( $listing_type  == 'service' && get_post_meta( $post->ID,'_opening_hours_status',true )) { 
                  if( listeo_check_if_open() ){ ?>
                      <div class="listing-badge now-open"><?php esc_html_e('Now Open','listeo_core'); ?></div>
                  <?php } else { 
                      if( listeo_check_if_has_hours() ) { ?>
                          <div class="listing-badge now-closed"><?php esc_html_e('Now Closed','listeo_core'); ?></div>
                      <?php } ?>
              <?php } 
              }
            ?>
            

      <div class="listing-item-content">
        <?php 
              if(!get_option('listeo_disable_reviews')){
                  $rating = get_post_meta($post->ID, 'listeo-avg-rating', true); 
          if(isset($rating) && $rating > 0 ) : ?>
            <div class="numerical-rating" data-rating="<?php $rating_value = esc_attr(round($rating,1)); printf("%0.1f",$rating_value); ?>"></div>
          <?php endif;
              } ?>
      
        <h3><?php the_title(); ?> <?php if( get_post_meta($post->ID,'_verified',true ) == 'on') : ?><i class="verified-icon"></i><?php endif; ?></h3>
              <?php if(get_the_listing_address()) { ?><span><?php the_listing_address(); ?></span><?php } ?>

      </div>
      <?php 
          if( listeo_core_check_if_bookmarked($post->ID) ) { 
                  $nonce = wp_create_nonce("listeo_core_bookmark_this_nonce"); ?>
                  <span class="like-icon listeo_core-unbookmark-it liked"
                  data-post_id="<?php echo esc_attr($post->ID); ?>" 
                  data-nonce="<?php echo esc_attr($nonce); ?>" ></span>
              <?php } else { 
                  if(is_user_logged_in()){ 
                      $nonce = wp_create_nonce("listeo_core_remove_fav_nonce"); ?>
                      <span class="save listeo_core-bookmark-it like-icon" 
                      data-post_id="<?php echo esc_attr($post->ID); ?>" 
                      data-nonce="<?php echo esc_attr($nonce); ?>" ></span>
                  <?php } ?>
          <?php } ?>
    </div>
  </a>

  <?php
    // LEVI: Makes the bookmark button open the login modal
    if(!is_user_logged_in()){ ?>
      <a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim">
        <span class="save like-icon tooltip left"  title="<?php esc_html_e('Login To Bookmark Items','listeo_core'); ?>"  ></span>
      </a>
  <?php } ?>
</div>
<?php if(isset($style) && $style == 'compact') { ?>
    </div>
<?php } ?>


<!-- Listing Item / End -->