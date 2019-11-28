<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package starter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'starter_container_type' );

starter_identify_block();
?>

<div class="wrapper" id="error-404-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<section class="error-404 not-found">

					<header class="page-header">

						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'starter' ); ?></h1>

					</header><!-- .page-header -->

					<div class="page-content">

						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'starter' ); ?></p>

						<?php get_search_form(); ?>

						<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

						<?php if ( starter_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>

							<div class="widget widget_categories">

								<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'starter' ); ?></h2>

								<ul>
									<?php
									wp_list_categories(
										array(
											'orderby'    => 'count',
											'order'      => 'DESC',
											'show_count' => 1,
											'title_li'   => '',
											'number'     => 10,
										)
									);
									?>
								</ul>

							</div><!-- .widget -->

						<?php endif; ?>

						<?php

						/* translators: %1$s: smiley */
						$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'starter' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

						the_widget( 'WP_Widget_Tag_Cloud' );
						?>

					</div><!-- .page-content -->

				</section><!-- .error-404 -->

			</div><!-- #primary -->

		</div><!-- .row -->

	</div>

</div><!-- #error-404-wrapper --> <?php

starter_identify_block( true );

get_footer(); ?>
