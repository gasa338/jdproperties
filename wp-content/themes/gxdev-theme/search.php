<?php

/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package mma-future
 */

get_header();
?>

<main id="primary" class="site-main py-20 bg-background">
	<div class="container mx-auto px-6">
		<?php if (have_posts()) : ?>

			<header class="page-header">
				<h1 class="page-title h1-responsive mb-12">
					<?php
					/* translators: %s: search query. */
					printf(esc_html__('Search Results for: %s', 'mma-future'), '<span class="text-accent">' . get_search_query() . '</span>');
					?>
				</h1>
			</header><!-- .page-header -->

			<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
				<?php
				/* Start the Loop */
				while (have_posts()) :
					the_post();

					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-search.php and that will be used instead.
					 */
					get_template_part('template-parts/blog-card');

				endwhile;
				?></div>
			<div class="mt-12 no-underline">
				<?php
				the_posts_navigation(array(
					'screen_reader_text' => ' ',
					'prev_text' => '< Previous',
					'next_text' => 'Next >',
				));
				?>
			</div>
		<?php else : ?>

		<?php get_template_part('template-parts/content', 'none');

		endif;
		?>
	</div>
</main><!-- #main -->

<?php
get_footer();
