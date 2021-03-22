<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package listeo
 */

get_header();

?>
<!-- Titlebar
================================================== -->
<div class="page-404">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <section id="not-found" class="center margin-bottom-100">
          <h1>404: Page not found</h1>
          <p><?php esc_html_e( 'Koala is sad that the page you were looking for doesn&rsquo;t exist.', 'listeo' ); ?></p>
          <div class="row">
            <a href="/listings" class="button"><?php esc_html_e('Back to Destinations','listeo') ?></a>
          </div>
        </section>
      </div>
    </div>
    <p class="photo-credit">Photo by <a href="https://unsplash.com/@crisaur?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Cris Saur</a> on <a href="/?utm_source=unsplash&utm_medium=referral&utm_content=creditCopyText">Unsplash</a></p>
  </div>
</div>

<?php
get_footer();