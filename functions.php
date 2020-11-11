<?php 
add_action( 'wp_enqueue_scripts', 'listeo_enqueue_styles' );
function listeo_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css',array('bootstrap','listeo-icons','listeo-woocommerce') );
    wp_enqueue_style('vc-tta-styles', get_stylesheet_directory_uri() .'/vc-tta-styles.css', array('parent-style'));

}

 
function remove_parent_theme_features() {
   	
}
add_action( 'after_setup_theme', 'remove_parent_theme_features', 10 );



?>