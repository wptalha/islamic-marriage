<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );
/**
 * The template for displaying archive pages
 */
$us_layout = US_Layout::instance();
// Needed for canvas class
$us_layout->titlebar = ( us_get_option( 'titlebar_content', 'all' ) == 'hide' ) ? 'none' : 'default' ;
get_header();

// Creating .l-titlebar
us_load_template( 'templates/titlebar', array(
	'title' => get_the_archive_title(),
) );

$template_vars = array(
	'layout_type' => us_get_option( 'archive_layout', 'large' ),
	'metas' => (array) us_get_option( 'archive_meta', array() ),
	'content_type' => us_get_option( 'archive_content_type', 'excerpt' ),
	'show_read_more' => in_array( 'read_more', us_get_option( 'archive_meta', array() ) ),
	'pagination' => us_get_option( 'archive_pagination', 'regular' ),
);

?>
<!-- MAIN -->
<div class="l-main">
	<div class="l-main-h i-cf">

		<div class="l-content g-html">
			<section class="l-section">
				<div class="l-section-h i-cf">

					<?php do_action( 'us_before_archive' ) ?>

					<?php us_load_template( 'templates/blog/listing', $template_vars ) ?>

					<?php do_action( 'us_after_archive' ) ?>

				</div>
			</section>
		</div>

<?php if ( $us_layout->sidebar_pos == 'left' OR $us_layout->sidebar_pos == 'right' ): ?>
		<aside class="l-sidebar at_<?php echo $us_layout->sidebar_pos ?>">
			<?php dynamic_sidebar( 'default_sidebar' ) ?>
		</aside>
<?php endif; ?>

	</div>
</div>


<?php
get_footer();
