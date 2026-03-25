<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class('font-body scroll-smooth bg-background'); ?>>
	<?php wp_body_open(); ?>
	<!-- <div id="page" class="site"> -->
	<a class="skip-link screen-reader-text hidden" href="#primary"><?php esc_html_e('Skip to content', 'mma-future'); ?></a>

	<header class="shadow-lg font-body sticky top-0 bg-card z-90">
		<div class="mx-auto px-4 sm:px-6 lg:px-8">
			<nav class="flex justify-between items-center h-16">
				<!-- Logo -->
				<div class="flex-shrink-0 custom-logo-link">
					<?php the_custom_logo(); ?>
				</div>

				<!-- Center Navigation Links -->
				<div class="hidden md:flex items-center space-x-6">

					<?php
					// Get the primary menu
					$menu_locations = get_nav_menu_locations();
					$menu_1_id = $menu_locations['primary'];
					$menu_1 = wp_get_nav_menu_object($menu_1_id);
					$menu_1_items = wp_get_nav_menu_items($menu_1_id);

					foreach ($menu_1_items as $item) :
						if ($item->menu_item_parent == 0) :
							$children = array_filter($menu_1_items, function ($child) use ($item) {
								return $child->menu_item_parent == $item->ID;
							});

							if (!empty($children)) :
					?>
								<div class="relative group">
									<button class="flex items-center">
										<span><?php echo $item->title; ?></span>
										<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-4 h-4 ml-1">
											<g id="directional" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<g id="arrow-down" fill="#000000">
													<polygon id="Shape" points="6 7 12 13 18 7 20 9 12 17 4 9">

													</polygon>
												</g>
											</g>
										</svg>
									</button>
									<div class="absolute left-0 mt-2 w-screen max-w-md overflow-hidden rounded-3xl bg-white shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
										<?php foreach ($children as $child) : ?>
											<a href="<?php echo $child->url; ?>" class="no-underline group relative flex items-center gap-x-6 rounded-lg p-3 hover:bg-gray-200">
												<?php
												$menu_items = get_field('menu_items', $child->ID);
												if (!empty($menu_items['icon']) && $menu_items['icon']['subtype'] == 'svg+xml') : ?>
													<div class="flex flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
														<?php echo maxwell_render_svg($menu_items['icon']['url'], 'w-6 h-6 text-primary'); ?>
													</div>
												<?php endif; ?>
												<div class="flex-auto">
													<span><?php echo $child->title; ?></span>
													<?php
													if (!empty($menu_items['text'])) : ?>
														<p class="mt-0.5 text-sm text-gray-600"><?php echo $menu_items['text']; ?></p>
													<?php endif; ?>
												</div>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php else: ?>
								<!-- Home Link -->
								<a href="<?php echo $item->url; ?>" class="no-underline flex items-center transition">
									<i class="fas fa-home mr-2"></i>
									<span><?php echo $item->title; ?></span>
								</a>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<!-- Call to Action Button -->
				<div class="hidden md:block">
					<a href="#" class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground glow-primary hover:scale-105 rounded-xl px-10 py-2 group no-underline">
						<?php echo esc_html('Get Started'); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 transition-transform group-hover:translate-x-1">
							<path d="M5 12h14"></path>
							<path d="m12 5 7 7-7 7"></path>
						</svg>
					</a>
				</div>

				<!-- Mobile menu button -->
				<div class="block md:hidden z-50 w-12 h-12">
					<button id="mobile-menu-button">
						<svg class="w-6 h-6 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
							<path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z" />
						</svg>
					</button>
				</div>
			</nav>
		</div>

		<!-- Mobile Menu -->
		<div id="mobile-menu" class="hidden md:hidden z-50 absolute top-16 right-0 w-full bg-white">
			<nav class="px-2 pt-2 pb-3 space-y-1">
				<?php
				foreach ($menu_1_items as $item) :
					if ($item->menu_item_parent == 0) :
						$children = array_filter($menu_1_items, function ($child) use ($item) {
							return $child->menu_item_parent == $item->ID;
						});

						if (!empty($children)) : ?>
							<div>
								<button class="flex items-center w-full px-3 py-2 text-gray-700 hover:bg-blue-50 rounded-md" onclick="toggleSubmenu('services-mobile')">
									<span><?php echo $item->title; ?></span>
									<svg viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="w-4 h-4 ml-1">
										<g id="directional" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<g id="arrow-down" fill="#000000">
												<polygon id="Shape" points="6 7 12 13 18 7 20 9 12 17 4 9">

												</polygon>
											</g>
										</g>
									</svg>
								</button>
								<div id="services-mobile" class="hidden pl-8 space-y-1">
									<?php foreach ($children as $child) : ?>
										<a href="<?php echo $child->url; ?>" class="flex items-center px-3 py-2 text-gray-600 hover:bg-blue-50 rounded-md no-underline">
											<?php
											$menu_items = get_field('menu_items', $child->ID);
											if (!empty($menu_items['icon']) && $menu_items['icon']['subtype'] == 'svg+xml') : ?>
												<div class="flex flex-none items-center justify-center rounded-lg bg-gray-50 group-hover:bg-white">
													<?php echo maxwell_render_svg($menu_items['icon']['url'], 'w-6 h-6 text-primary'); ?>
												</div>
											<?php endif; ?>
											<div class="flex-auto">
												<span><?php echo $child->title; ?></span>
												<?php
												if (!empty($menu_items['text'])) : ?>
													<p class="mt-0.5 text-sm text-gray-600"><?php echo $menu_items['text']; ?></p>
												<?php endif; ?>
											</div>
										</a>
									<?php endforeach; ?>
								</div>
							</div>

						<?php else: ?>
							<a href="<?php echo $item->url; ?>" class="flex items-center px-3 py-2 text-gray-700 hover:bg-blue-50 rounded-md no-underline">
								<i class="fas fa-home mr-2"></i>
								<span><?php echo $item->title; ?></span>
							</a>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
		</div>
	</header>