<?php

/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package mma-future
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php get_header(); ?>

	<section class="py-8 sm:py-12 lg:py-18">
		<div class="px-4 mx-auto max-w-7xl">
			<div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-1">
				<div class="text-center">

					<!-- Top title -->
					<p class="maxwell-top-title mb-2">
						<?php echo function_exists('pll__') ? pll__('Error 404') : __('Error 404', 'maxwell-team'); ?>
					</p>

					<!-- Main title -->
					<h1 class="my-4 h1-responsive">
						<?php echo function_exists('pll__') ? pll__('Page not found') : __('Page not found', 'maxwell-team'); ?>
					</h1>

					<!-- Content -->
					<div class="my-4 max-w-xl mx-auto">
						<p>
							<?php echo function_exists('pll__')
								? pll__('The page you are looking for does not exist or has been removed. We offer private and special passenger transfers across Slovenia and neighboring countries, including airport and city shuttle services. We are not a tour operator or travel agency.')
								: __('The page you are looking for does not exist or has been removed. We offer private and special passenger transfers across Slovenia and neighboring countries, including airport and city shuttle services. We are not a tour operator or travel agency.', 'maxwell-team'); ?>
						</p>
					</div>

					<!-- Button -->
					<a href="<?php echo home_url(); ?>"
						class="inline-flex items-center rounded-xl border-2 border-button text-white bg-button px-4 py-2 hover:bg-transparent hover:text-button transition-all duration-300 flex items-center justify-center"
						role="button">
						<?php echo function_exists('pll__') ? pll__('Back to homepage') : __('Back to homepage', 'maxwell-team'); ?>
					</a>

				</div>
			</div>
		</div>
	</section>

	<?php get_footer(); ?>

</main><!-- #main -->

<?php
get_footer();
