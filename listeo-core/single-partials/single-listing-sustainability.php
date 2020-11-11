<!-- Sustainability -->
<?php 
$type = get_post_meta($post->ID, '_listing_type',true);
$custom_fields = Listeo_Core_Meta_Boxes::meta_boxes_custom();
$highlights = get_post_meta($post->ID, '_highlights', false);

$general_sustainability_practices = $custom_fields['fields']['_general_sustainability_practices'];
$economic_sustainability_practices = $custom_fields['fields']['_economic_sustainability_practices'];
$social_sustainability_practices = $custom_fields['fields']['_social_sustainability_practices'];
$environmental_nature_sustainability_practices = $custom_fields['fields']['_environmental_nature_sustainability_practices'];
$environmental_climate_change_sustainability_practices = $custom_fields['fields']['_environmental_climate_change_sustainability_practices'];
$environmental_waste_sustainability_practices = $custom_fields['fields']['_environmental_waste_sustainability_practices'];
$environmental_accommodation_sustainability_practices = $custom_fields['fields']['_environmental_accommodation_sustainability_practices'];

$sustainability_fields = [
  $general_sustainability_practices,
  $economic_sustainability_practices,
  $social_sustainability_practices,
  $environmental_nature_sustainability_practices,
  $environmental_climate_change_sustainability_practices,
  $environmental_waste_sustainability_practices,
  $environmental_accommodation_sustainability_practices
];

$output = '';

if (!empty($sustainability_fields)) :
  foreach ($sustainability_fields as $field) {
    $field_value = get_post_meta($post->ID, $field['id'], false);

    if (isset($field['name']) && !empty($field_value)) {
      $output .= '<h4>' . $field['name'] . '</h4>';

      $output .= '<ul class="margin-bottom-30">';
      foreach ($field_value as $value) {
        if (isset($field['options'][$value])) {
          $output .= '<li>' . $field['options'][$value] . '</li>';
        }
      }
      $output .= '</ul>';
    }
  }
endif;
?>

<!-- Sustainability -->
<div id="sustainability" class="listing-section">
	<h3 class="listing-desc-headline margin-top-60 margin-bottom-30"><?php esc_html_e('Sustainability','listeo_core'); ?></h3>
  <div style="margin: 30px 0">
    <?php echo wpautop($highlights[0]); ?>
  </div>

  <?php echo $output; ?>

  <?php 
    // echo "<pre>";
    // var_dump($highlights);
    // echo "</pre>";
  ?>
</div>
