<!-- Sustainability -->
<?php 
$type = get_post_meta($post->ID, '_listing_type',true);
$custom_fields = Listeo_Core_Meta_Boxes::meta_boxes_custom();
$highlights = get_post_meta($post->ID, '_highlights', false);

// $general_sustainability_practices = $custom_fields['fields']['_general_sustainability_practices'];
// $environmental_nature_sustainability_practices = $custom_fields['fields']['_environmental_nature_sustainability_practices'];
// $environmental_climate_change_sustainability_practices = $custom_fields['fields']['_environmental_climate_change_sustainability_practices'];
// $environmental_waste_sustainability_practices = $custom_fields['fields']['_environmental_waste_sustainability_practices'];
// $environmental_accommodation_sustainability_practices = $custom_fields['fields']['_environmental_accommodation_sustainability_practices'];
// $economic_sustainability_practices = $custom_fields['fields']['_economic_sustainability_practices'];
// $social_sustainability_practices = $custom_fields['fields']['_social_sustainability_practices'];

// $sustainability_fields = [
//   $general_sustainability_practices,
//   $environmental_nature_sustainability_practices,
//   $environmental_climate_change_sustainability_practices,
//   $environmental_waste_sustainability_practices,
//   $environmental_accommodation_sustainability_practices,
//   $economic_sustainability_practices,
//   $social_sustainability_practices
// ];

$general_sustainability_practices = $custom_fields['fields']['_general_sustainability_practices'];
$environmental_sustainability_practices = $custom_fields['fields']['_environmental_'];
$economic_sustainability_practices = $custom_fields['fields']['_economic_sustainability_practices'];
$social_sustainability_practices = $custom_fields['fields']['_social_sustainability_practices'];

$sustainability_fields = [
  $general_sustainability_practices,
  $environmental_sustainability_practices,
  $economic_sustainability_practices,
  $social_sustainability_practices
];

$tabs = '';
$panels = '';

if (!empty($sustainability_fields)) :
  foreach ($sustainability_fields as $field) {
    $field_value = get_post_meta($post->ID, $field['id'], false);

    if (isset($field['name']) && !empty($field_value)) {
      $tabs .= '<li class="vc_tta-tab" data-vc-tab="" data-tab-id="' . $field['id'] . '"><a href="#" data-vc-tabs="" 
        data-vc-container=".vc_tta"><span class="vc_tta-title-text">' . $field['name'] . '</span></a></li>';

      $panels .= '
        <div id="' . $field['id'] . '" class="vc_tta-panel" data-panel-id="' . $field['id'] . '" data-vc-content=".vc_tta-panel-body">
          <div class="vc_tta-panel-heading">
            <h4 class="vc_tta-panel-title" data-tab-id="' . $field['id'] . '">
              <a href="#' . $field['id'] . '"  style="padding-left: 0;" data-vc-accordion="" data-vc-container=".vc_tta-container">
                <u><span class="vc_tta-title-text">' . $field['name'] . '</span></u>
              </a>
            </h4>
          </div>
          <div class="vc_tta-panel-body">
            <div class="wpb_text_column wpb_content_element ">
              <div class="wpb_wrapper">
                <ul class="margin-bottom-30 margin-left-30">';

      foreach ($field_value as $value) {
        if (isset($field['options'][$value])) {
          $panels .= '<li>' . $field['options'][$value] . '</li>';
        }
      }

      $panels .= '
                </ul>
              </div>
            </div>
          </div>
        </div>';
    }

    // if (isset($field['name']) && !empty($field_value)) {
    //   $output .= '<h4>' . $field['name'] . '</h4>';

    //   $output .= '<ul class="margin-bottom-30">';
    //   foreach ($field_value as $value) {
    //     if (isset($field['options'][$value])) {
    //       $output .= '<li>' . $field['options'][$value] . '</li>';
    //     }
    //   }
    //   $output .= '</ul>';
    // }
  }
endif;
?>

<!-- Sustainability -->
<div id="sustainability" class="listing-section">
	<h3 class="listing-desc-headline margin-top-60 margin-bottom-30"><?php esc_html_e('🌱 Sustainability','listeo_core'); ?></h3>

  <div id="sustainability-tabs" class="vc_tta-container" data-vc-action="collapse">
    <div
      class="vc_general vc_tta vc_tta-tabs vc_tta-color-white vc_tta-style-tabs-style-1 vc_tta-shape-square vc_tta-o-shape-group vc_tta-o-no-fill vc_tta-tabs-position-top vc_tta-controls-align-left">
      <div class="vc_tta-tabs-container">
        <ul class="vc_tta-tabs-list">
          <li class="vc_tta-tab vc_active" data-vc-tab="" data-tab-id="highlights"><a href="#" data-vc-tabs=""
              data-vc-container=".vc_tta"><span class="vc_tta-title-text">Highlights</span></a></li>

          <?php echo $tabs; ?>

        </ul>
      </div>
      <div class="vc_tta-panels-container">
        <div class="vc_tta-panels">
          <div class="vc_tta-panel vc_active" data-panel-id="highlights" id="1484910219237-b016c90e-893f" data-vc-content=".vc_tta-panel-body">
            <div class="vc_tta-panel-heading">
              <h4 class="vc_tta-panel-title" data-tab-id="highlights">
                <a href="#1484910239035-36e56128-7751" style="padding-left: 0;" data-vc-accordion="" data-vc-container=".vc_tta-container">
                  <u><span class="vc_tta-title-text">Highlights</span></u>
                </a>
              </h4>
            </div>
            <div class="vc_tta-panel-body">
              <?php echo wpautop($highlights[0]); ?>
            </div>
          </div>

          <?php echo $panels; ?>

        </div>
      </div>
    </div>
  </div>
  <script>
    jQuery( document ).ready(function() {
      jQuery("#sustainability-tabs .vc_tta-tab, #sustainability-tabs .vc_tta-panel-title").click(function(event){
        if (jQuery(window).width() > 767) {
          event.preventDefault();
        }
        jQuery("#sustainability-tabs .vc_tta-tab").removeClass("vc_active");
        jQuery(this).addClass("vc_active");

        const newPanelId = jQuery(this).attr('data-tab-id');
        jQuery("#sustainability-tabs .vc_tta-panel.vc_active").removeClass("vc_active");
        jQuery("#sustainability-tabs .vc_tta-panel[data-panel-id='" + newPanelId + "']").addClass("vc_active").delay( 1000 );
      });
    });
  </script>

  <?php //echo $output; ?>

  <?php 
    // echo "<pre>";
    // var_dump($highlights);
    // echo "</pre>";
  ?>
</div>
