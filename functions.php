<?php 
add_action( 'wp_enqueue_scripts', 'listeo_enqueue_styles' );
function listeo_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css',array('bootstrap','listeo-icons','listeo-woocommerce') );
    wp_enqueue_style('vc-tta-styles', get_stylesheet_directory_uri() .'/vc-tta-styles.css', array('parent-style'));

}

 
function remove_parent_theme_features() {
   	
}
add_action( 'after_setup_theme', 'remove_parent_theme_features', 10 );

add_filter('loop_shop_columns', 'loop_columns', 999);
if (!function_exists('loop_columns')) {
    function loop_columns() {
        return 3; // 3 products per row
    }
}

add_action('woocommerce_before_shop_loop', 'show_category_title', 10, 2);
function show_category_title() {
	$cat_title = single_tag_title("", false);
	echo '<h1>' . $cat_title . '</h1>';
}

?>