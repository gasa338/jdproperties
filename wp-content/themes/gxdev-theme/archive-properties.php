<?php
get_header();

$paged = max(1, get_query_var('paged'));

$tax_query = [
	'relation' => 'AND',
];

$meta_query = [
	'relation' => 'AND',
];

$cat = $_GET['cat'];
$type = $_GET['jd_type'];
$location = $_GET['location'];
/**
 * TAXONOMIES
 */

// CAT
if (!empty($cat)) {	

	$tax_query[] = [
		'taxonomy' => 'cat',
		'field'    => 'slug',
		'terms'    => sanitize_text_field($cat),
	];
}

// TYPE
if (!empty($type)) {

	$tax_query[] = [
		'taxonomy' => 'jd-type',
		'field'    => 'slug',
		'terms'    => sanitize_text_field($type),
	];
}

// LOCATION
if (!empty($location)) {

	$tax_query[] = [
		'taxonomy' => 'location',
		'field'    => 'slug',
		'terms'    => sanitize_text_field($location),
	];
}

/**
 * META
 */

// PRICE MIN
if (!empty($_GET['price_min'])) {

	$meta_query[] = [
		'key'     => 'price',
		'value'   => intval($_GET['price_min']),
		'compare' => '>=',
		'type'    => 'NUMERIC',
	];
}

// PRICE MAX
if (!empty($_GET['price_max'])) {

	$meta_query[] = [
		'key'     => 'price',
		'value'   => intval($_GET['price_max']),
		'compare' => '<=',
		'type'    => 'NUMERIC',
	];
}

// AREA MIN
if (!empty($_GET['area_min'])) {

	$meta_query[] = [
		'key'     => 'square',
		'value'   => intval($_GET['area_min']),
		'compare' => '>=',
		'type'    => 'NUMERIC',
	];
}

// AREA MAX
if (!empty($_GET['area_max'])) {

	$meta_query[] = [
		'key'     => 'square',
		'value'   => intval($_GET['area_max']),
		'compare' => '<=',
		'type'    => 'NUMERIC',
	];
}

/**
 * NOVOGRADNJA
 */

if (!empty($_GET['novogradnja'])) {

	$tax_query[] = [
		'taxonomy' => 'property-label',
		'field'    => 'slug',
		'terms'    => 'novogradnja',
	];
}

/**
 * QUERY
 */

$query = new WP_Query([
	'post_type'      => 'properties',
	'posts_per_page' => 12,
	'paged'          => $paged,
	'tax_query'      => count($tax_query) > 1 ? $tax_query : [],
	'meta_query'     => count($meta_query) > 1 ? $meta_query : [],
]);

$title = sprintf(
    __('Search results for: <span class="text-script italic text-accent font-normal">%1$s %2$s</span>', 'your-text-domain'),
    $cat,
    $type
);

$additional_pages = get_field('addition_content', 'option');
?>

<section class="">
	<div class="relative bg-gradient-navy py-24 overflow-hidden">
		<div class="absolute top-20 right-[10%] w-48 h-48 rounded-full border border-primary-foreground/8 animate-pulse-subtle"></div>
		<div class="absolute bottom-10 left-[5%] w-24 h-24 rounded-full border border-primary-foreground/5"></div>
		<div class="absolute top-1/3 right-[25%] w-3 h-3 rounded-full bg-accent opacity-60"></div>
		<div class="absolute bottom-1/4 right-[15%] w-2 h-2 rounded-full bg-accent opacity-40"></div>
		<div class="container mx-auto px-6 relative z-10">
			<div class="max-w-3xl">
				<h1 class="h2-responsive text-primary-foreground mb-6"><?php echo $title; ?></h1>
			</div>
			<div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-primary-foreground/30">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down w-4 h-4 animate-bounce">
					<path d="M12 5v14"></path>
					<path d="m19 12-7 7-7-7"></path>
				</svg>
			</div>
		</div>
	</div>
	<?php if (!empty($additional_pages) && isset($additional_pages['top'])): ?>
		<?php foreach ($additional_pages['top'] as $page): ?>
			<?php echo gxdev_render_global_content($page->post_name); ?>
		<?php endforeach; ?>
	<?php endif; ?>
	<div class="container py-8 lg:py-12">
		<!-- RESULTS -->

		<?php if ($query->have_posts()) : ?>

			<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">

				<?php while ($query->have_posts()) : $query->the_post(); ?>
					<?php get_template_part('template-parts/content', 'property'); ?>

				<?php endwhile; ?>

			</div>

			<!-- PAGINATION -->
			<div class="mt-16">

				<?php
				echo paginate_links([
					'total'   => $query->max_num_pages,
					'current' => $paged,
				]);
				?>

			</div>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>

			<div class="text-center py-20 border border-border">

				<h2 class="h3-responsive mb-4">
					Nema pronađenih nekretnina
				</h2>

				<p>
					Pokušajte sa drugačijim parametrima pretrage.
				</p>

			</div>

		<?php endif; ?>

	</div>
	<?php
	if (!empty($additional_pages)) {
		foreach ($additional_pages['bottom'] as $page) : ?>
			<?php echo gxdev_render_global_content($page->post_name); ?>
		<?php endforeach; ?>
	<?php } ?>

</section>

<?php get_footer(); ?>