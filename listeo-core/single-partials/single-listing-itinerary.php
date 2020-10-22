<!-- Itinerary -->
<?php
  $itinerary = get_post_meta($post->ID, '_itinerary', false);

  $custom_fields = Listeo_Core_Meta_Boxes::meta_boxes_custom();
  $detailed_itinerary = get_post_meta($post->ID, '_detailed_itinerary', false);
?>

<!-- Itinerary -->
<div id="itinerary" class="listing-section">
	<h3 class="listing-desc-headline margin-top-60 margin-bottom-30"><?php esc_html_e('Itinerary','listeo_core'); ?></h3>
  <?php echo wpautop($itinerary[0]); ?>

  <?php if(!empty($detailed_itinerary) && !empty($detailed_itinerary[0])): ?>
    <div class="margin-top-30" style="text-align: center;">
      <a href=<?php echo $detailed_itinerary[0] ?> class="button" target="_blank">Download detailed itinerary & FAQ</a>
    </div>
  <?php endif; ?>

  <?php 
    // echo "<pre>";
    // var_dump($itinerary);
    // echo "</pre>";
  ?>
</div>
