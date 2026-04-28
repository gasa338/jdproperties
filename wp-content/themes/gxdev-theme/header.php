<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<?php $is_logged_in = is_user_logged_in(); ?>
<body <?php body_class('font-body scroll-smooth' . ($is_logged_in ? 'mt-8' : '')); ?>>
	<?php wp_body_open(); ?>
	<!-- <div id="page" class="site"> -->
	<a class="skip-link screen-reader-text hidden" href="#primary"><?php esc_html_e('Skip to content', 'mma-future'); ?></a>


	<header class="w-full hairline-b font-body">
		<div class="bg-background hairline-b">
			<div class="container mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-2.5 text-xs font-body text-muted-foreground">
				<div class="flex items-center gap-5">
					<a href="tel:+381111234567" class="flex items-center gap-1.5 hover:text-accent transition-colors">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone w-3 h-3 text-accent">
							<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
						</svg>
						<span class="hidden sm:inline tracking-wide">+381 11 123 4567</span>
					</a>
					<a href="mailto:info@jdproperties.rs" class="flex items-center gap-1.5 hover:text-accent transition-colors">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-3 h-3 text-accent">
							<rect width="20" height="16" x="2" y="4" rx="2"></rect>
							<path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
						</svg>
						<span class="hidden sm:inline tracking-wide">info@jdproperties.rs</span>
					</a>
				</div>
				<span class="eyebrow hidden sm:inline">Privatno posredovanje · od 2010</span>
			</div>
		</div>

		<!-- Main Navigation -->
		<nav class="bg-background/95 backdrop-blur-md hairline-b sticky top-0 z-50">
			<div class="container-luxury mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
				<!-- Logo -->
				<div class="flex-shrink-0 custom-logo-link h-10 sm:h-12">
					<?php the_custom_logo(); ?>
				</div>

				<!-- Desktop Navigation Links -->
				<div class="hidden lg:flex items-center gap-8">
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
									<button class="flex items-center text-sm font-body font-medium tracking-wide transition-colors hover:text-accent text-foreground">
										<span><?php echo $item->title; ?></span>
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 ml-1">
											<path d="m6 9 6 6 6-6"></path>
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
													<?php if (!empty($menu_items['text'])) : ?>
														<p class="mt-0.5 text-sm text-gray-600"><?php echo $menu_items['text']; ?></p>
													<?php endif; ?>
												</div>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php else: ?>
								<a href="<?php echo $item->url; ?>" class="text-sm font-body font-medium tracking-wide transition-colors hover:text-accent <?php echo is_front_page() && $item->title == 'Početna' ? 'text-accent' : 'text-foreground'; ?>">
									<?php echo $item->title; ?>
								</a>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

				<!-- Call to Action Button -->
				<?php $header = get_field('header', 'option');
				if (!empty($header) && !empty($header['link'])) : ?>
					<div class="hidden lg:block">
						<a href="<?php echo $header['link']['url']; ?>" title="<?php echo esc_attr($header['link']['title']); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground glow-primary hover:scale-105 rounded-lg px-10 py-2 group no-underline">
							<?php echo esc_html($header['link']['title']); ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 transition-transform group-hover:translate-x-1">
								<path d="M5 12h14"></path>
								<path d="m12 5 7 7-7 7"></path>
							</svg>
						</a>
					</div>
				<?php endif; ?>

				<!-- Mobile menu button -->
				<div class="block lg:hidden z-50 w-12 h-12 flex items-center justify-end">
					<button id="mobile-menu-button" class="p-2 text-foreground" aria-label="Toggle mobile menu">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu w-6 h-6">
							<line x1="4" x2="20" y1="12" y2="12"></line>
							<line x1="4" x2="20" y1="6" y2="6"></line>
							<line x1="4" x2="20" y1="18" y2="18"></line>
						</svg>
					</button>
				</div>
			</div>
		</nav>

		<!-- Mobile Menu -->
		<div id="mobile-menu" class="hidden lg:hidden fixed top-0 right-0 w-full h-screen bg-card z-40 overflow-y-auto pt-20">
			<nav class="px-4 pt-2 pb-3 space-y-2">
				<?php
				foreach ($menu_1_items as $item) :
					if ($item->menu_item_parent == 0) :
						$children = array_filter($menu_1_items, function ($child) use ($item) {
							return $child->menu_item_parent == $item->ID;
						});

						if (!empty($children)) : ?>
							<div>
								<button class="flex items-center justify-between w-full px-3 py-3 text-foreground hover:bg-gray-100 rounded-md transition-colors" onclick="toggleSubmenu(this)">
									<span class="font-medium"><?php echo $item->title; ?></span>
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 transition-transform">
										<path d="m6 9 6 6 6-6"></path>
									</svg>
								</button>
								<div class="submenu hidden pl-4 mt-1 space-y-1">
									<?php foreach ($children as $child) : ?>
										<a href="<?php echo $child->url; ?>" class="flex items-center px-3 py-2 text-muted-foreground hover:text-accent hover:bg-gray-50 rounded-md no-underline transition-colors">
											<?php
											$menu_items = get_field('menu_items', $child->ID);
											if (!empty($menu_items['icon']) && $menu_items['icon']['subtype'] == 'svg+xml') : ?>
												<div class="flex-none mr-3">
													<?php echo maxwell_render_svg($menu_items['icon']['url'], 'w-5 h-5 text-primary'); ?>
												</div>
											<?php endif; ?>
											<div class="flex-auto">
												<div><?php echo $child->title; ?></div>
												<?php if (!empty($menu_items['text'])) : ?>
													<p class="text-xs text-muted-foreground"><?php echo $menu_items['text']; ?></p>
												<?php endif; ?>
											</div>
										</a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php else: ?>
							<a href="<?php echo $item->url; ?>" class="flex items-center px-3 py-3 text-foreground hover:bg-gray-100 rounded-md no-underline transition-colors font-medium">
								<?php echo $item->title; ?>
							</a>
						<?php endif; ?>
					<?php endif; ?>
				<?php endforeach; ?>

				<!-- Mobile CTA Button -->
				<?php if (!empty($header) && !empty($header['link'])) : ?>
					<div class="pt-4 mt-4 border-t border-gray-200">
						<a href="<?php echo $header['link']['url']; ?>" class="flex items-center justify-center gap-2 bg-primary text-primary-foreground rounded-lg px-6 py-3 no-underline transition-all hover:scale-105 font-medium">
							<?php echo esc_html($header['link']['title']); ?>
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
								<path d="M5 12h14"></path>
								<path d="m12 5 7 7-7 7"></path>
							</svg>
						</a>
					</div>
				<?php endif; ?>
			</nav>
		</div>
	</header>

	<script>
		// Mobile menu toggle
		document.getElementById('mobile-menu-button').addEventListener('click', function() {
			var menu = document.getElementById('mobile-menu');
			menu.classList.toggle('hidden');
			document.body.classList.toggle('overflow-hidden');
		});

		// Mobile submenu toggle
		function toggleSubmenu(button) {
			var submenu = button.nextElementSibling;
			var icon = button.querySelector('svg');

			submenu.classList.toggle('hidden');
			icon.classList.toggle('rotate-180');
		}

		// Close mobile menu when clicking on a link (optional)
		document.querySelectorAll('#mobile-menu a').forEach(function(link) {
			link.addEventListener('click', function() {
				document.getElementById('mobile-menu').classList.add('hidden');
				document.body.classList.remove('overflow-hidden');
			});
		});
	</script>