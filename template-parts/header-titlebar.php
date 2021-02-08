<!-- Titlebar
================================================== -->
<?php 

$titlebar_style = get_post_meta($post->ID, 'listeo_page_top_regular_style', TRUE);
if(empty($titlebar_style)){
    $titlebar_style = 'gradient';
}
?>
<div id="titlebar" class="<?php echo esc_attr($titlebar_style); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h1><?php the_title(); ?></h1>
                <?php do_action('listeo_page_subtitle') ?>
                <?php if(function_exists('bcn_display')) { ?>
                    <nav id="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">
                        <ul>
                            <?php bcn_display_list(); ?>
                        </ul>
                    </nav>
                <?php } ?>

            </div>
        </div>
    </div>
</div>