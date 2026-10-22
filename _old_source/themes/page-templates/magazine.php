<?php
/**
 * Template Name: Magazine Template
 *
 * @package xMag
 * @since xMag 1.0
 */

get_header(); ?>

<?php if( get_theme_mod('show_block7') ) { get_template_part('template-parts/magazine/magazine', 'block7'); } ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php if( get_theme_mod('show_block1', 1) ) { get_template_part('template-parts/magazine/magazine', 'block1'); } ?>

		<?php if( get_theme_mod('show_block2', 1) ) { get_template_part('template-parts/magazine/magazine', 'block2'); } ?>

		<?php if( get_theme_mod('show_block3', 1) ) { get_template_part('template-parts/magazine/magazine', 'block3'); } ?>

		<?php if( get_theme_mod('show_block4') ) { get_template_part('template-parts/magazine/magazine', 'block4'); } ?>

		<?php if( get_theme_mod('show_block5') ) { get_template_part('template-parts/magazine/magazine', 'block5'); } ?>

		<?php if( get_theme_mod('show_block6') ) { get_template_part('template-parts/magazine/magazine', 'block6'); } ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
