<!-- Itinerary -->
<?php
  $itinerary = get_post_meta($post->ID, '_itinerary', false);
?>

<!-- Itinerary -->
<div id="itinerary" class="listing-section">
	<h3 class="listing-desc-headline margin-top-60 margin-bottom-30"><?php esc_html_e('Itinerary','listeo_core'); ?></h3>
  <?php echo wpautop($itinerary[0]); ?>

  <?php 
    // echo "<pre>";
    // var_dump($itinerary);
    // echo "</pre>";
  ?>
</div>
