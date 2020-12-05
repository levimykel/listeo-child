<!-- Sustainability -->
<?php 
$custom_fields = Listeo_Core_Meta_Boxes::meta_boxes_custom();

$book_now = $custom_fields['fields']['_book_now'];
$cancellation_policy = $custom_fields['fields']['_cancellation_policy'];
$covid_precautions = $custom_fields['fields']['_covid_precautions'];
$faqs = $custom_fields['fields']['_faqs'];
$other_trip_info = $custom_fields['fields']['_other_trip_info'];

$tab_fields = [
  $book_now,
  $cancellation_policy,
  $covid_precautions,
  $faqs,
  $other_trip_info,
];

$tabs = '';
$panels = '';
$needs_active_tab = true;

if (!empty($tab_fields)) :
  foreach ($tab_fields as $index => $field) {
    $field_value = get_post_meta($post->ID, $field['id'], false);

    if (isset($field['name']) && !empty($field_value[0])) {
      $tabs .= '<li class="vc_tta-tab';
      
      if ($needs_active_tab) {
        $tabs .= ' vc_active';
      }
      
      $tabs .= '" data-vc-tab="" data-tab-id="' . $field['id'] . '"><a href="#" data-vc-tabs="" 
        data-vc-container=".vc_tta"><span class="vc_tta-title-text">' . $field['name'] . '</span></a></li>';

      $panels .= '
        <div class="vc_tta-panel';
      
      if ($needs_active_tab) {
        $panels .= ' vc_active';
        $needs_active_tab = false;
      }
        
      $panels .= '" data-panel-id="' . $field['id'] . '" data-vc-content=".vc_tta-panel-body">
        <div class="vc_tta-panel-heading">
          <h4 class="vc_tta-panel-title" data-tab-id="' . $field['id'] . '">
            <a href="#1484910239035-36e56128-7751"  style="padding-left: 0;" data-vc-accordion="" data-vc-container=".vc_tta-container">
              <u><span class="vc_tta-title-text">' . $field['name'] . '</span></u>
            </a>
          </h4>
        </div>
        <div class="vc_tta-panel-body">
          <div class="wpb_text_column wpb_content_element ">
            <div class="wpb_wrapper">';

      $panels .= wpautop($field_value[0]);

      $panels .= '
              </div>
            </div>
          </div>
        </div>';
    }
  }
endif;
?>

<!-- Extra details tabs -->
<div id="other-info" class="listing-section">
	<h3 class="listing-desc-headline margin-top-70 margin-bottom-30"><?php esc_html_e('ℹ️ Other Info','listeo_core') ?></h3>
  <div id="extra-details-tabs" class="vc_tta-container margin-top-30" data-vc-action="collapse">
    <div
      class="vc_general vc_tta vc_tta-tabs vc_tta-color-white vc_tta-style-tabs-style-1 vc_tta-shape-square vc_tta-o-shape-group vc_tta-o-no-fill vc_tta-tabs-position-top vc_tta-controls-align-left">
      <div class="vc_tta-tabs-container">
        <ul class="vc_tta-tabs-list">
          <?php echo $tabs; ?>
        </ul>
      </div>
      <div class="vc_tta-panels-container">
        <div class="vc_tta-panels">
          <?php echo $panels; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery( document ).ready(function() {
    jQuery("#extra-details-tabs .vc_tta-tab, #extra-details-tabs .vc_tta-panel-title").click(function(event){
      event.preventDefault();
      jQuery("#extra-details-tabs .vc_tta-tab").removeClass("vc_active");
      jQuery(this).addClass("vc_active");

      const newPanelId = jQuery(this).attr('data-tab-id');
      jQuery("#extra-details-tabs .vc_tta-panel.vc_active").removeClass("vc_active");
      jQuery("#extra-details-tabs .vc_tta-panel[data-panel-id='" + newPanelId + "']").addClass("vc_active");
    });
  });
</script>

<?php 
  // echo "<pre>";
  // var_dump($tab_fields);
  // echo "</pre>";
?>
