<?php
/**
 * The template for displaying the author pages.
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
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

<div class="wrapper" id="author-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<header class="page-header author-header">

				<?php
				if ( isset( $_GET['author_name'] ) ) {
					$curauth = get_user_by( 'slug', $author_name );
				} else {
					$curauth = get_userdata( intval( $author ) );
				}
				?>

				<h1><?php echo esc_html__( 'About:', 'starter' ) . ' ' . esc_html( $curauth->nickname ); ?></h1>

				<?php if ( ! empty( $curauth->ID ) ) : ?>
					<?php echo get_avatar( $curauth->ID ); ?>
				<?php endif; ?>

				<?php if ( ! empty( $curauth->user_url ) || ! empty( $curauth->user_description ) ) : ?>
					<dl>
						<?php if ( ! empty( $curauth->user_url ) ) : ?>
							<dt><?php esc_html_e( 'Website', 'starter' ); ?></dt>
							<dd>
								<a href="<?php echo esc_url( $curauth->user_url ); ?>"><?php echo esc_html( $curauth->user_url ); ?></a>
							</dd>
						<?php endif; ?>

						<?php if ( ! empty( $curauth->user_description ) ) : ?>
							<dt><?php esc_html_e( 'Profile', 'starter' ); ?></dt>
							<dd><?php esc_html_e( $curauth->user_description ); ?></dd>
						<?php endif; ?>
					</dl>
				<?php endif; ?>

				<h2><?php echo esc_html( 'Posts by', 'starter' ) . ' ' . esc_html( $curauth->nickname ); ?>:</h2>

			</header><!-- .page-header -->

			<ul>

				<!-- The Loop -->
				<?php if ( have_posts() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<li>
							<?php
							printf(
								'<a rel="bookmark" href="%1$s" title="%2$s %3$s">%3$s</a>',
								esc_url( apply_filters( 'the_permalink', get_permalink( $post ), $post ) ),
								esc_attr( __( 'Permanent Link:', 'starter' ) ),
								the_title( '', '', false )
							);
							?>
							<?php starter_posted_on(); ?>
							<?php esc_html_e( 'in', 'starter' ); ?>
							<?php the_category( '&' ); ?>
						</li>
					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

				<!-- End Loop -->

			</ul>

			<!-- The pagination component -->
			<?php starter_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div> <!-- .row -->

	</div>

</div><!-- #author-wrapper --> <?php

starter_identify_block( true );

get_footer(); ?>
