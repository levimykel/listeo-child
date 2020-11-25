<!-- Category Bubbles -->
<?php 

function createCategoriesList($terms, $taxonomy_name) {
	$categories = array();
	foreach ( $terms as $term ) {
		$categories[] = sprintf( '<span class="listing-tag"><a href="%1$s">%2$s</a></span>',
			esc_url( get_term_link( $term->slug, $taxonomy_name ) ),
			esc_html( $term->name )
		);
	}

	return join( "", $categories );
}

?>


<?php
$terms = get_the_terms( get_the_ID(), 'listing_category' );
if ( $terms && ! is_wp_error( $terms ) ) : 
	$categories_list = createCategoriesList($terms, 'listing_category');
?>

<div class="col-md-7">
	<div class="category-bubbles">
		<span class="bubble-name">Category: </span>
		<?php  echo ( $categories_list ) ?>
	</div>

	<?php endif; ?>

	<?php
	$listing_type = get_post_meta( get_the_ID(), '_listing_type', true);
	switch ($listing_type) {
		case 'service':
			$type_terms = get_the_terms( get_the_ID(), 'service_category' );
			$taxonomy_name = 'service_category';
			break;
		case 'rental':
			$type_terms = get_the_terms( get_the_ID(), 'rental_category' );
			$taxonomy_name = 'rental_category';
			break;
		case 'event':
			$type_terms = get_the_terms( get_the_ID(), 'event_category' );
			$taxonomy_name = 'event_category';
			$type_terms2 = get_the_terms( get_the_ID(), 'service_category' );
			$taxonomy_name2 = 'service_category';
			break;
		
		default:
			# code...
			break;
	}

	if( isset($type_terms) ) {
		if ( $type_terms && ! is_wp_error( $type_terms ) ) : 
			$categories_list = createCategoriesList($type_terms, $taxonomy_name);
	?>

	<div class="category-bubbles">
		<span class="bubble-name">Theme: </span>
		<?php  echo ( $categories_list ) ?>
	</div>

	<?php
		endif;
	}
	?>

	<?php
	if( isset($type_terms2) ) {
		if ( $type_terms2 && ! is_wp_error( $type_terms2 ) ) : 
			$categories_list = createCategoriesList($type_terms2, $taxonomy_name2);
	?>

	<div class="category-bubbles">
		<span class="bubble-name">Activity: </span>
		<?php  echo ( $categories_list ) ?>
	</div>
</div>

<?php
	endif;
}
?>
