<?php
$post_id = $args['post_id'] ?? get_the_ID();
$link    = get_permalink();
$title   = get_the_title();

// Primer ACF polja (prilagodi po sebi)
$price   = get_field('property_price', $post_id);

// Povlači prvu kategoriju iz 'prop-category' taxona ili praznu niz ako nema kategorija
$prop_categories = gxdev_get_custom_tax($post_id, 'cat');
$category = !empty($prop_categories) ? $prop_categories[0] : '';

$prop_type = gxdev_get_custom_tax($post_id, 'jd-type');
$property_type = !empty($prop_type) ? $prop_type[0] : '';

/*----*/
$opstinski_region = get_field('opstinski_region', $post_id);
$opstina = get_field('opstina', $post_id);
// Formiranje grada sa uslovima
$city_parts = [];
if (!empty($opstinski_region)) {
	$city_parts[] = $opstinski_region;
}
if (!empty($opstina)) {
	$city_parts[] = $opstina;
}
$city = !empty($city_parts) ? implode(', ', $city_parts) : '';

$size    = get_field('property_squarespace', $post_id);
$rooms   = get_field('property_structure', $post_id);
$floor   = get_field('property_floor', $post_id);
// Thumbnail fallback
$thumb = get_the_post_thumbnail_url($post_id, 'medium_large');
?>

<div class="group bg-card group card-border">

	<!-- IMAGE (LINK) -->
	<a href="<?php echo esc_url($link); ?>" class="block relative aspect-[4/3] bg-muted rounded-t-lg overflow-hidden">

		<?php if ($thumb): ?>
			<img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover rounded-t-lg overflow-hidden">
		<?php else: ?>
			<div class="absolute inset-0 flex items-center justify-center">
				<!-- fallback ikonica -->
			</div>
		<?php endif; ?>

		<div class="image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

		<!-- Badge -->
		<?php if (!empty($category)): ?>
			<div class="absolute top-3 left-3 flex gap-2">
				<div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-accent text-white">
					<?php echo esc_html($category['name']); ?>
				</div>
			</div>
		<?php endif; ?>
	</a>

	<!-- SPECS -->
	<div class="flex items-center justify-center gap-6 py-3 bg-background border-b border-border">
		<?php if (!empty($size)): ?>
			<div class="flex items-center gap-1.5 text-accent">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-maximize w-4 h-4 text-accent">
					<path d="M8 3H5a2 2 0 0 0-2 2v3"></path>
					<path d="M21 8V5a2 2 0 0 0-2-2h-3"></path>
					<path d="M3 16v3a2 2 0 0 0 2 2h3"></path>
					<path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>
				</svg>
				<span class=""><?php echo $size; ?> m²</span>
			</div>
		<?php endif; ?>
		<?php if (!empty($rooms)): ?>
			<div class="flex items-center gap-1.5 text-accent">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bed-double w-4 h-4 text-accent">
					<path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"></path>
					<path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"></path>
					<path d="M12 4v6"></path>
					<path d="M2 18h20"></path>
				</svg>
				<?php if ($rooms == 1): ?>
					<span class=""><?php echo $rooms; ?> <?php echo __('soba', 'gxdev'); ?></span>
				<?php else: ?>
					<span class=""><?php echo $rooms; ?> <?php echo __('sobe', 'gxdev'); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($floor)): ?>
			<div class="flex items-center gap-1.5 text-accent">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers w-4 h-4 text-accent">
					<path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"></path>
					<path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"></path>
					<path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"></path>
				</svg>
				<span class=""><?php echo $floor; ?> <?php echo __('sprat', 'gxdev'); ?></span>
			</div>
		<?php endif; ?>
	</div>

	<!-- CONTENT -->
	<div class="p-5 space-y-3">

		<a href="<?php echo esc_url($property_type['link']); ?>" class="text-xs font-medium text-accent uppercase tracking-wider">
			<?php echo esc_html($property_type['name']); ?>
		</a>

		<!-- TITLE (LINK) -->
		<h3 class="text-xl">
			<a href="<?php echo esc_url($link); ?>" class="font-heading font-[400] hover:text-accent transition-colors">
				<?php echo esc_html($title); ?>
			</a>
		</h3>

		<!-- LOCATION -->
		<div class="text-sm text-muted-foreground">
			<?php echo esc_html($city); ?>
		</div>

		<!-- PRICE + CTA -->
		<div class="pt-3 border-t border-border flex items-center justify-between">

			<span class="font-heading text-xl font-[400]">
				<?php echo esc_html($price); ?> €
			</span>

			<a href="<?php echo esc_url($link); ?>"
				class="text-sm font-semibold text-accent hover:underline">
				Pogledaj detaljno →
			</a>

		</div>
	</div>

</div>