<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'starter_container_type' );

starter_identify_block();
?>
</main><!-- .site-main end -->

<footer class="wrapper site-footer" id="colophon">

	<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

					<div class="footer-bottom">

						<?php starter_site_info(); ?>

					</div><!-- .site-info -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</footer><!-- footer end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

<?php starter_identify_block( true ); ?>

</body>

</html>
