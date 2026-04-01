<?php

/**
 * Template Name: Single Property — Prodaja
 */

if (! defined('ABSPATH')) exit;

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

    <?php if (is_single()) : ?>
        <?php if (function_exists('yoast_breadcrumb')) : ?>
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 print:hidden">
                <div class="flex items-center gap-2 text-sm font-body text-muted-foreground">
                    <?php yoast_breadcrumb('<div id="breadcrumbs">', '</div>'); ?>

                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <section class="container mx-auto pb-16">

        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <?php do_action('jd_sale_gallery'); ?>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center gap-16">
                <?php do_action('jd_sale_action_buttons'); ?>
            </div>
            <div class="grid lg:grid-cols-3 gap-10">

                <div class="lg:col-span-2 space-y-10">
                    <?php do_action('jd_sale_content'); ?>
                </div>

                <aside class="space-y-6 print:hidden">
                    <?php do_action('jd_sale_sidebar'); ?>
                </aside>

            </div>

            <?php do_action('jd_sale_after_content'); ?>

        </div>

    </section>

<?php endwhile; ?>

<?php get_footer(); ?>