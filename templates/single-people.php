<?php
/**
 * Template for displaying single People
 */

get_header();
the_post();
$prefix     	= 'people_';
$classes      	= get_post_meta( $post->ID, $prefix . 'classes', true );
$title      	= get_post_meta( $post->ID, $prefix . 'title', true );
$works      	= get_post_meta( $post->ID, $prefix . 'works', true );
?>

	<header class="page-header">
		<?php \CGU\Helpers\breadcrumbs(); ?>
		<div class="u-container">
			<?php
			$subtitle = ( $title ) ? nl2br( esc_html( $title ) ) : '' ;
			\CGU\Helpers\page_header_content( $post->ID, array( 'subtitle' => $subtitle ) ); ?>
		</div>
	</header>

	<section class="page-section has-sidebar u-container">

		<div class="page-sidebar">
			<?php include( 'sidebar-people.php'); ?>
		</div>

		<div class="page-content">
			<div class="u-format-text">
                <?php the_content(); ?>
            </div>

			<?php if ( $classes || $works ) : ?>

				<nav class="tab-nav u-push">
					<?php
					$menu_items = array();
					if ( $works ) {
						$menu_items[] = array('text' => 'Selected Works', 'url' => '#', 'class' => 'tab-nav__item is-current', 'atts' => array( 'data-show' => 'works' ) );
					}
					if ( $classes ) {
						$menu_items[] = array('text' => 'Classes', 'url' => '#', 'class' => 'tab-nav__item', 'atts' => array( 'data-show' => 'classes' ) );
					}
					if ( ! empty( $menu_items ) ) {
						echo \CGU\Helpers\build_menu( $menu_items, array( "class" => "tab-nav__menu-items", "data-nav" => "works-classes-nav" ) );
					}
					?>
				</nav>

				<div class="view-manager u-push u-format-text" data-use-nav="works-classes-nav">
					<?php if ( $works ): ?>
						<article data-view="works">
							<?php echo apply_filters( 'the_content', $works ); ?>
						</article>
					<?php endif; ?>
					<?php if ( $classes ): ?>
						<article data-view="classes">
							<?php echo apply_filters( 'the_content', $classes ); ?>
						</article>
					<?php endif; ?>
				</div>

			<?php endif; ?>

		</div>

	</section>

<?php get_footer();
