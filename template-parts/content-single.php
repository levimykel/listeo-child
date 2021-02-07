<?php 
if ( ! post_password_required() ) { 
    if(has_post_thumbnail()) { 
          $thumb = get_post_thumbnail_id();
          $img_url = wp_get_attachment_url( $thumb,'full');

          $image = aq_resize( $img_url, 900, 500,true,true,true); ?>
          <img src="<?php echo esc_url($image); ?>" class="post-img" alt="<?php the_title(); ?>">
        
   <?php } 
}?>
  <!-- Content -->
  <div class="post-content">
    <a href="<?php the_permalink(); ?>"><h1><?php the_title(); ?></h1></a>
      <?php listeo_posted_on(); ?>
      
      <?php the_content(); ?>
      <?php
        wp_link_pages( array(
          'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'listeo' ),
          'after'  => '</div>',
        ) );
      ?>
      <?php 
        $share_options = get_option( 'pp_post_share' );

      if(!empty($share_options)) {
        $id = $post->ID;
        $title = urlencode($post->post_title);
        $url =  urlencode( get_permalink($id) );
        $summary = urlencode(listeo_string_limit_words($post->post_excerpt,20));
        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'medium' );
        $imageurl = urlencode($thumb[0]);
        ?>
        <ul class="share-buttons margin-top-40 margin-bottom-0">
          <?php if (in_array("facebook", $share_options)) { ?><li><?php echo '<a target="_blank" class="fb-share" href="https://www.facebook.com/sharer/sharer.php?u=' . $url . '"><i class="fa fa-facebook"></i> Share</a>'; ?></li><?php } ?>
          <?php if (in_array("twitter", $share_options)) { ?><li><?php echo '<a target="_blank" class="twitter-share" href="https://twitter.com/share?url=' . $url . '&amp;text=' . esc_attr($summary ). '" title="' . esc_html__( 'Twitter', 'listeo' ) . '"><i class="fa fa-twitter"></i> Tweet</a></a>'; ?></li><?php } ?>
          <?php if (in_array("google-plus", $share_options)) { ?><li><?php echo '<a target="_blank" class="gplus-share" href="https://plus.google.com/share?url=' . $url . '&amp;title="' . esc_attr($title) . '" onclick=\'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600");return false;\'><i class="fa fa-google-plus"></i> Share</a></a>'; ?></li><?php } ?>
          <?php if (in_array("pinterest", $share_options)) { ?><li><?php echo '<a target="_blank"  class="pinterest-share" href="http://pinterest.com/pin/create/button/?url=' . $url . '&amp;description=' . esc_attr($summary) . '&media=' . esc_attr($imageurl) . '" onclick="window.open(this.href); return false;"><i class="fa fa-pinterest-p"></i> Pin</a></a>'; ?></li><?php } ?>
        </ul>
      <?php } ?>
  </div>