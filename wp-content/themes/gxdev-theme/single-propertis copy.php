<?php
/**
 * Template Name: Single Property
 * Prikazuje jednu nekretninu
 */

if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<div class="container-fluid mx-auto px-4 sm:px-6 lg:px-8 py-4 print:hidden">
    <div class="flex items-center gap-2 text-sm font-body text-muted-foreground">
        <a class="hover:text-accent transition-colors" href="/">Početna</a>
        <span>/</span>
        <a class="hover:text-accent transition-colors" href="/nekretnine">Nekretnine</a>
        <span>/</span>
        <span class="text-foreground truncate max-w-[200px]"><?php the_title(); ?></span>
    </div>
</div>

<section class="container-fluid mx-auto pb-16">

    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <?php do_action( 'jd_property_gallery' ); ?>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        <?php do_action( 'jd_property_action_buttons' ); ?>

        <div class="grid lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2 space-y-10">
                <?php do_action( 'jd_property_content' ); ?>
            </div>

            <aside class="space-y-6 print:hidden">
                <?php do_action( 'jd_property_sidebar' ); ?>
            </aside>

        </div>

        <?php do_action( 'jd_property_after_content' ); ?>

    </div>

</section>

<?php endwhile; ?>

<?php get_footer(); ?>
