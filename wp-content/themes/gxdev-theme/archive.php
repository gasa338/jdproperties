<?php

/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mma-future
 */

get_header();
?>

<!-- Sekcija sa postovima -->
<section class="py-20 bg-background">
	<div class="container mx-auto px-6">
		<!-- Loading indicator -->
		<div id="loading-indicator" class="text-center py-12 hidden">
			<div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary border-t-transparent"></div>
			<p class="text-muted-foreground mt-2">Loading posts...</p>
		</div>

		<!-- Posts grid -->
		<div id="posts-container">

			<?php if (have_posts()) : ?>

				<header class="page-header">
					<?php
					the_archive_title('<h1 class="h1-responsive mb-8">', '</h1>');
					the_archive_description('<div class="archive-description mb-8">', '</div>');
					?>
				</header><!-- .page-header -->
				<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
				/* Start the Loop */
				while (have_posts()) :
					the_post();

					/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
					get_template_part('template-parts/content', 'blog_card');

				endwhile;
				?></div><?php 

				the_posts_navigation();

			else :

				get_template_part('template-parts/content', 'none');

			endif;
			?>
		</div>
	</div>
</section>
