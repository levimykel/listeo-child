<?php 
$buttons = false;

if(isset($data)) :
$buttons        = (isset($data->buttons)) ? $data->buttons : false ;
endif; 
if(!$buttons || $buttons=='none') { return false; } 
$segments = explode('|',$buttons);

?>

<?php if ( in_array('layout', $segments) ) : ?>
<div class="col-md-3 col-xs-6">
<!-- Layout Switcher -->
<div class="layout-switcher">
	<a href="#" data-layout="grid" class="grid"><i class="fa fa-th"></i></a>
	<a href="#" data-layout="list" class="list"><i class="fa fa-align-justify"></i></a>
</div>
</div>
<?php endif; ?>


<!-- Sorting / Layout Switcher -->
<?php if ( in_array('layout', $segments) ) : ?>
<div class="col-md-9">
<?php else : ?>
<div class="col-md-12">
<?php endif; ?>
<div class="fullwidth-filters <?php if(get_option('listeo_ajax_browsing') == 'on') { ?> ajax-search <?php } ?>">
	
	<?php if ( in_array('filters', $segments) ) : ?>
	<!-- Panel Dropdown -->
	<div class="panel-dropdown wide float-right" id="tax-listing_feature-panel">
		<a href="#"><?php esc_html_e('More Filters','listeo_core'); ?></a>
		<div class="panel-dropdown-content checkboxes">
			<?php $dynamic_features = get_option('listeo_dynamic_features'); ?>
			<div class="row">
				
				<?php
				if($dynamic_features == 'on') { ?>
					<div class="notification warning"><p><?php esc_html_e('Please choose category to display filters','listeo_core') ?></p> </div>
					
				<?php } else {
					?>
				<div class="panel-checkboxes-container">
				<?php
				$elements = listeo_core_get_options_array('taxonomy','listing_feature');

				$groups = array_chunk($elements, 4, true);
				foreach ($groups as $group) { ?>
					
					
					<?php 
						if(isset($_GET['tax-listing_feature'])) {
							if(is_array($_GET['tax-listing_feature'])){
								$selected = $_GET['tax-listing_feature'];
							} else {
								$selected = array(sanitize_text_field($_GET['tax-listing_feature']));	
							}
						} else {
							$selected = array();
						} 
						foreach ($group as $key => $value) { ?>
							<div class="panel-checkbox-wrap">
								<input  <?php if ( array_key_exists ($value['slug'], $selected) ) { echo 'checked="checked"'; } ?>  form="listeo_core-search-form" id="<?php echo esc_html($value['slug']) ?>" value="<?php echo esc_html($value['slug']) ?>" type="checkbox" name="tax-listing_feature<?php echo '['.esc_html($value['slug']).']'; ?>">
								<label for="<?php echo esc_html($value['slug']) ?>"><?php echo esc_html($value['name']) ?></label>
							</div>
					
					<?php } ?>
					

				<?php } ?>
				</div>
				<?php } ?>
				
			</div>
			
			<!-- Buttons -->
			<div class="panel-buttons">
				<span class="panel-cancel"><?php esc_html_e('Cancel','listeo_core'); ?></span>
				<button class="panel-apply"><?php esc_html_e('Apply','listeo_core'); ?></button>
			</div>

		</div>
	</div>
	<!-- Panel Dropdown / End -->
	<?php endif; ?>

	<?php if ( in_array('radius', $segments) ) : ?>
	<!-- Panel Dropdown-->
	<div class="panel-dropdown float-right">
		<a href="#"><?php esc_html_e('Distance Radius','listeo_core'); ?></a>
		<div class="panel-dropdown-content radius-dropdown">
			<?php $default_radius = isset( $_GET['search_radius'] ) ? $_GET['search_radius']  : '50'; ?>
			<input form="listeo_core-search-form" name="search_radius" class="distance-radius" type="range" min="1" max="100" step="1" value="<?php echo esc_attr($default_radius); ?>" data-title="<?php esc_html_e('Radius around selected destination','listeo_core') ?>">
			<div class="panel-buttons">
				<span class="panel-disable" data-disable="<?php echo esc_attr_e( 'Disable', 'listeo_core' ); ?>" data-enable="<?php echo esc_attr_e( 'Enable', 'listeo_core' ); ?>"><?php esc_html_e('Disable'); ?></span>
				<button class="panel-apply"><?php esc_html_e('Apply','listeo_core'); ?></button>
			</div>
		</div>
	</div>
	<!-- Panel Dropdown / End -->
	<?php endif; ?>

	<?php if ( in_array('order', $segments) ) : ?>
	<!-- Sort by -->
	<div class="sort-by">
		<div class="sort-by-select">
			<?php $default = isset( $_GET['listeo_core_order'] ) ? (string) $_GET['listeo_core_order']  :  get_option( 'listeo_sort_by','date' );  ?>
			<select form="listeo_core-search-form" name="listeo_core_order" data-placeholder="<?php esc_attr_e('Default order', 'listeo_core'); ?>" class="chosen-select-no-single orderby" >
				<option <?php selected($default,'date-desc'); ?> value="date-desc"><?php esc_html_e( 'Newest Listings' , 'listeo_core' ); ?></option>
				<option <?php selected($default,'date-asc'); ?> value="date-asc"><?php esc_html_e( 'Oldest Listings' , 'listeo_core' ); ?></option>
			</select>
		</div>
	</div>
	<!-- Sort by / End -->
	<?php endif; ?>

</div>
</div>