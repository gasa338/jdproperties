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
	<a href="<?php echo esc_url($link); ?>" class="block relative aspect-[4/3] bg-muted rounded-t-2xl overflow-hidden">

		<?php if ($thumb): ?>
			<img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover rounded-t-2xl overflow-hidden">
		<?php else: ?>
			<div class="absolute inset-0 flex items-center justify-center">
				<!-- fallback ikonica -->
			</div>
		<?php endif; ?>

		<div class="image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

		<!-- Badge -->
		<?php if (!empty($category)): ?>
			<div class="absolute top-3 left-3 flex gap-2">
				<div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-accent text-accent-foreground">
					<?php echo esc_html($category['name']); ?>
				</div>
			</div>
		<?php endif; ?>
	</a>

	<!-- SPECS -->
	<div class="flex items-center justify-center gap-6 py-3 bg-secondary border-b border-border text-sm font-semibold">
		<?php if (!empty($size)): ?>
			<div class="flex items-center gap-1.5">
				<span class="font-semibold"><?php echo $size; ?> m²</span>
			</div>
		<?php endif; ?>
		<?php if (!empty($rooms)): ?>
			<div class="flex items-center gap-1.5 border-r border-border">
				<?php if ($rooms == 1): ?>
					<span class="font-semibold"><?php echo $rooms; ?> <?php echo __('soba', 'gxdev'); ?></span>
				<?php else: ?>
					<span class="font-semibold"><?php echo $rooms; ?> <?php echo __('sobe', 'gxdev'); ?></span>
				<?php endif; ?>
			</div>
		<?php endif; ?>
		<?php if (!empty($floor)): ?>
			<div class="flex items-center gap-1.5">
				<span class="font-semibold"><?php echo $floor; ?> <?php echo __('sprat', 'gxdev'); ?></span>
			</div>
		<?php endif; ?>
	</div>

	<!-- CONTENT -->
	<div class="p-5 space-y-3">

		<a href="<?php echo esc_url($property_type['link']); ?>" class="text-xs font-medium text-accent uppercase tracking-wider">
			<?php echo esc_html($property_type['name']); ?>
		</a>

		<!-- TITLE (LINK) -->
		<h3 class="font-heading text-lg font-semibold leading-tight line-clamp-2">
			<a href="<?php echo esc_url($link); ?>" class="hover:text-accent transition-colors">
				<?php echo esc_html($title); ?>
			</a>
		</h3>

		<!-- LOCATION -->
		<div class="text-sm text-muted-foreground">
			<?php echo esc_html($city); ?>
		</div>

		<!-- PRICE + CTA -->
		<div class="pt-3 border-t border-border flex items-center justify-between">

			<span class="font-heading text-xl font-bold">
				<?php echo esc_html($price); ?> €
			</span>

			<a href="<?php echo esc_url($link); ?>"
				class="text-sm font-semibold text-accent hover:underline">
				Pogledaj detaljno →
			</a>

		</div>
	</div>

</div>