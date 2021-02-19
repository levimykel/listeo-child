<div class="checkboxes one-in-row <?php if(isset($data->class)) { echo esc_attr($data->class); }?>" id="<?php echo esc_attr($data->name); ?>">

<?php if(isset($data->placeholder)){ ?>
  <span class="range-slider-headline"><?php echo esc_attr($data->placeholder); ?></span>
<?php } ?>

<?php if(isset($data->dynamic) && $data->dynamic=='yes'){ ?>
	<div class="notification warning"><p><?php esc_html_e('Please choose category to display filters','listeo_core') ?></p> </div>
<?php } else {

	if(isset($_GET[$data->name])) {
		$selected = array($_GET[$data->name]);
	} else {
		$selected = array();
	} 
	
	if(isset($data->taxonomy) && !empty($data->taxonomy)) {
		$data->options = listeo_core_get_options_array('taxonomy',$data->taxonomy);
		if(is_tax($data->taxonomy)){
			$selected[get_query_var($data->taxonomy)] = 'on';
		}	
		foreach ($data->options as $key => $value) { ?>
			<input <?php if ( array_key_exists ($value['slug'], $selected) ) { echo 'checked="checked"'; } ?> id="<?php echo esc_html($value['slug']) ?>-<?php echo esc_attr($data->name); ?>" value="<?php echo esc_html($value['slug']) ?>" type="checkbox" name="<?php echo $data->name.'['.esc_html($value['slug']).']'; ?>">
			<label for="<?php echo esc_html($value['slug']) ?>-<?php echo esc_attr($data->name); ?>"><?php echo esc_html($value['name']) ?></label>
		
	<?php } 
	}

	if(isset($data->options_source) && empty($data->taxonomy) ) {
		if(isset($data->options_cb) && !empty($data->options_cb) ){
			switch ($data->options_cb) {
				case 'listeo_core_get_offer_types':
					$data->options = listeo_core_get_offer_types_flat(false);
					break;

				case 'listeo_core_get_listing_types':
					$data->options = listeo_core_get_listing_types();
					break;

				case 'listeo_core_get_rental_period':
					$data->options = listeo_core_get_rental_period();
					break;
			
				default:
					# code...
					break;
			}	
		}
		if($data->options_source == 'custom') {
			//$data->options = array_flip($data->options);
		}
		
		foreach ($data->options as $key => $value) { ?>

			<input <?php if ( array_key_exists ($key, $selected) ) { echo 'checked="checked"'; } ?> id="<?php echo esc_html($key) ?>-<?php echo esc_attr($data->name); ?>" type="checkbox" name="<?php echo $data->name.'['.esc_html($key).']'; ?>">
			<label for="<?php echo esc_html($key) ?>-<?php echo esc_attr($data->name); ?>"><?php echo esc_html($value) ?></label>
		
	<?php } 
	}
}
?>

</div>
