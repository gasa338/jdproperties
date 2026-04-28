<?php
if (function_exists('acf_register_block_type')) {
	/**
	 * ==============================
	 * Blog 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'blog-1',
		'title' => 'Blog 1',
		'description' => 'Blog 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/blog-1/blog-1.php',
	));

	/**
	 * ==============================
	 * Contact Form 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'contact-form-1',
		'title' => 'Contact Form 1',
		'description' => 'Contact Form 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/contact-form-1/contact-form-1.php',
		'enqueue_assets'    => function () {
			// Enqueue block styles
			wp_enqueue_style(
				'contact-form-block-style',
				get_template_directory_uri() . '/blocks/contact-form-1/blocks.css',
				array(),
				'1.0.0'
			);
		},

	));

	

	/**
	 * ==============================
	 * Contact Form 2 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'contact-form-2',
		'title' => 'Contact Form 2',
		'description' => 'Contact Form 2',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/contact-form-2/contact-form-2.php',
		'enqueue_assets'    => function () {
			// Enqueue block styles
			wp_enqueue_style(
				'contact-form-block-style',
				get_template_directory_uri() . '/blocks/contact-form-2/blocks-2.css',
				array(),
				'1.0.0'
			);
			
		},
	));
		

	/**
	 * ==============================
	 * CTA light Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'cta-light',
		'title' => 'CTA light',
		'description' => 'CTA light',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/cta-light/cta-light.php',
	));

	/**
	 * ==============================
	 * CTA 2 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'cta-2',
		'title' => 'CTA 2',
		'description' => 'CTA 2',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/cta-2/cta-2.php',
	));

	/**
	 * ==============================
	 * CTA 3 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'cta-3',
		'title' => 'CTA 3',
		'description' => 'CTA 3',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/cta-3/cta-3.php',
	));

	/**
	 * ==============================
	 * FAQ 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'faq-1',
		'title' => 'FAQ 1',
		'description' => 'FAQ 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/faq-1/faq-1.php',
	));

	/**
	 * ==============================
	 * Features 2 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'features-1',
		'title' => 'Features 1',
		'description' => 'Features 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/features-1/features-1.php',
		'enqueue_assets' => function () {
			if (!wp_script_is('features-1', 'enqueued')) {
				wp_enqueue_script(
					'features-1',
					get_template_directory_uri() . '/blocks/features-1/features-1.js',
					array(),
					_S_VERSION,
					array(
						'strategy'  => 'defer', // Koristi defer za bolje performance
						'in_footer' => true
					)
				);
			}
		}
	));

	/**
	 * ==============================
	 * Features 2 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'features-2',
		'title' => 'Features 2',
		'description' => 'Features 2',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/features-2/features-2.php',
	));

	/**
	 * ==============================
	 * Features 3 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'features-3',
		'title' => 'Features 3',
		'description' => 'Features 3',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/features-3/features-3.php',
	));

	/**
	 * ==============================
	 * Features 4 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'features-4',
		'title' => 'Features 4',
		'description' => 'Features 4',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/features-4/features-4.php',
	));

	/**
	 * ==============================
	 * Feature Number Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'feature-number',
		'title' => 'Feature Number',
		'description' => 'Feature Number',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/feature-number/feature-number.php',
	));

	/**
	 * ==============================
	 * Features Challenge Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'features-challenge',
		'title' => 'Features Challenge',
		'description' => 'Features Challenge',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/feature-challenge/feature-challenge.php',
	));

	/**
	 * ==============================
	 * Feature Box Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'feature-box',
		'title' => 'Feature Box',
		'description' => 'Feature Box',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/feature-box/feature-box.php',
	));

	/**
	 * ==============================
	 * Feature Solution Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'feature-solution',
		'title' => 'Feature Solution',
		'description' => 'Feature Solution',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/feature-solution/feature-solution.php',
	));

	/**
	 * ==============================
	 * Feature Slider Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'feature-slider',
		'title' => 'Feature Slider',
		'description' => 'Feature Slider',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/feature-slider/feature-slider.php',
		'enqueue_assets' => function () {
			if (!wp_script_is('swiper', 'enqueued')) {
				wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/dist/js/swiper-bundle.min.js', array(), _S_VERSION, true);
			}

			if (!wp_style_is('swiper', 'enqueued')) {
				wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/dist/css/swiper-bundle.min.css');
			}
		}
	));

	/**
	 * ==============================
	 * Hero 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-1',
		'title' => 'Hero 1',
		'description' => 'Hero 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-1/hero-1.php',
	));

	/**
	 * ==============================
	 * Hero Slider Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-slider',
		'title' => 'Hero Slider',
		'description' => 'Hero Slider',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-slider/hero-slider.php',
	));


	/**
	 * ==============================
	 * Hero Text Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-text',
		'title' => 'Hero Text',
		'description' => 'Hero Text',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-text/hero-text.php',
	));

	/**
	 * ==============================
	 * Hero 2 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-2',
		'title' => 'Hero 2',
		'description' => 'Hero 2',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-2/hero-2.php',
	));

	/**
	 * ==============================
	 * Hero 3 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-3',
		'title' => 'Hero 3',
		'description' => 'Hero 3',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-3/hero-3.php',
	));

	/**
	 * ==============================
	 * Hero 4 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-4',
		'title' => 'Hero 4',
		'description' => 'Hero 4',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-4/hero-4.php',
	));

	/**
	 * ==============================
	 * Hero Service Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-service',
		'title' => 'Hero Service',
		'description' => 'Hero Service',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-service/hero-service.php',
	));

	/**
	 * ==============================
	 * Hero Industry Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-industry',
		'title' => 'Hero Industry',
		'description' => 'Hero Industry',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-industry/hero-industry.php',
	));

	/**
	 * ==============================
	 * Hero Case Study Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-case-study',
		'title' => 'Hero Case Study',
		'description' => 'Hero Case Study',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-case-study/hero-case-study.php',
	));

	/**
	 * ==============================
	 * Popular 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'popular-1',
		'title' => 'Popular 1',
		'description' => 'Popular 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/popular-1/popular-1.php',
	));

	/**
	 * ==============================
	 * Popular 3 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'popular-3',
		'title' => 'Popular 3',
		'description' => 'Popular 3',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/popular-3/popular-3.php',
		'enqueue_assets' => function () {
			if (!wp_script_is('swiper', 'enqueued')) {
				wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/dist/js/swiper-bundle.min.js', array(), _S_VERSION, true);
			}

			if (!wp_style_is('swiper', 'enqueued')) {
				wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/dist/css/swiper-bundle.min.css');
			}
		}
	));

	/**
	 * ==============================
	 * Service 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'service-1',
		'title' => 'Service 1',
		'description' => 'Service 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/service-1/service-1.php',
	));

	/**
	 * ==============================
	 * Service 2 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'service-2',
		'title' => 'Service 2',
		'description' => 'Service 2',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/service-2/service-2.php',
	));

	/**
	 * ==============================
	 * Service 3 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'service-3',
		'title' => 'Service 3',
		'description' => 'Service 3',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/service-3/service-3.php',
	));

	/**
	 * ==============================
	 * Service 4 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'service-4',
		'title' => 'Service 4',
		'description' => 'Service 4',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/service-4/service-4.php',
	));

	/**
	 * ==============================
	 * Service 5 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'service-5',
		'title' => 'Service 5',
		'description' => 'Service 5',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/service-5/service-5.php',
	));


	/**
	 * ==============================
	 * Trusted 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'trusted-1',
		'title' => 'Trusted 1',
		'description' => 'Trusted 1',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/trusted-1/trusted-1.php',
	));


	/**
	 * ==============================
	 * Bg Image
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'bg-image',
		'title' => 'Bg Image',
		'description' => 'Bg Image',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/bg-image/bg-image.php',
	));


	/**
	 * ==============================
	 * Pricing table
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'pricing-table',
		'title' => 'Pricing Table',
		'description' => 'Pricing Table',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/pricing-table/pricing-table.php',
	));


	/**
	 * ==============================
	 * Pricing card
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'pricing-card',
		'title' => 'Pricing Card',
		'description' => 'Pricing Card',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/pricing-card/pricing-card.php',
	));


	/**
	 * ==============================
	 * clone components
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'clone-components',
		'title' => 'Clone Components',
		'description' => 'Clone Components for internal use',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/pricing-table/pricing-table.php',
	));


	/**
	 * ==============================
	 * Info Box
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'info-box',
		'title' => 'Info Box',
		'description' => 'Info Box',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/info-box/info-box.php',
	));


	/**
	 * ==============================
	 * Contact Us
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'contact-us',
		'title' => 'Contact Us',
		'description' => 'Contact Us',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/contact-us/contact-us.php',
	));


	/**
	 * ==============================
	 * Trip Details
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'trip-details',
		'title' => 'Trip Details',
		'description' => 'Trip Details',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/trip-details/trip-details.php',
	));

	/**
	 * ==============================
	 * Marque
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'marque',
		'title' => 'Marque',
		'description' => 'Marque',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/marque/marque.php',
	));

	/**
	 * ==============================
	 * About Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'about-block',
		'title' => 'About Block',
		'description' => 'About Block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/about-block/about-block.php',
	));

	/**
	 * ==============================
	 * Horizontal Tab Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'horizontal-tab',
		'title' => 'Horizontal Tab',
		'description' => 'Horizontal tab block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/horizontal-tab/horizontal-tab.php',
	));

	/**
	 * ==============================
	 * Client Logo Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'client-logo',
		'title' => 'Client Logo',
		'description' => 'Client Logo block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/client-logo/client-logo.php',
	));

	/**
	 * ==============================
	 * Case Study Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'case-study',
		'title' => 'Case Study',
		'description' => 'Case Study block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/case-study/case-study.php',
	));

	/**
	 * ==============================
	 * Case Studies List Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'case-studies-list',
		'title' => 'Case Studies List',
		'description' => 'Case Studies List block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/case-studies-list/case-studies-list.php',
	));

	/**
	 * ==============================
	 * Process 1 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'process-1',
		'title' => 'Process 1',
		'description' => 'Process 1 block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/process-1/process-1.php',
	));

	/**
	 * ==============================
	 * Text Column Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'text-column',
		'title' => 'Text Column',
		'description' => 'Text Column block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/text-column/text-column.php',
	));

	/**
	 * ==============================
	 * Text Component Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'text-component',
		'title' => 'Text Component',
		'description' => 'Text Component block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/text-component/text-component.php',
	));

	/**
	 * ==============================
	 * Text with boxes Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'text-with-boxes',
		'title' => 'Text with boxes',
		'description' => 'Text with boxes block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/text-with-boxes/text-with-boxes.php',
	));

	/**
	 * ==============================
	 * Comparison Table Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'comparison-table',
		'title' => 'Comparison Table',
		'description' => 'Comparison Table block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/comparison-table/comparison-table.php',
	));

	/**
	 * ==============================
	 * Text with CTA Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'text-with-cta',
		'title' => 'Text with CTA',
		'description' => 'Text with CTA block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/text-with-cta/text-with-cta.php',
	));

	/**
	 * ==============================
	 * Testimonial Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'testimonial',
		'title' => 'Testimonial',
		'description' => 'Testimonial block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/testimonial/testimonial.php',
		'enqueue_assets' => function () {
			if (!wp_script_is('swiper', 'enqueued')) {
				wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/dist/js/swiper-bundle.min.js', array(), _S_VERSION, true);
			}

			if (!wp_style_is('swiper', 'enqueued')) {
				wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/dist/css/swiper-bundle.min.css');
			}
		}
	));

	/**
	 * ==============================
	 * Feature Posts Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'feature-posts',
		'title' => 'Feature Posts',
		'description' => 'Feature Posts block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/feature-posts/feature-posts.php',
	));

	/**
	 * ==============================
	 * Home Search Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'home-search',
		'title' => 'Home Search',
		'description' => 'Home Search block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/home-search/home-search.php',
	));

	/**
	 * ==============================
	 * Posts list Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'posts-list',
		'title' => 'Posts list',
		'description' => 'Posts list block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/posts-list/posts-list.php',
		'enqueue_assets' => function () {
			

			wp_enqueue_script(
            'blog-js', 
            get_template_directory_uri() . '/blocks/posts-list/blog.js', 
            array('jquery'), 
            '1.0.0', 
            true
        );
        
        // Prosledi PHP varijable JavaScriptu
        wp_localize_script('blog-js', 'blogConfig', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'postsPerPage' => 6,
            'currentCategory' => isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '',
            'maxPages' => 1 // Ovo će biti ažurirano u template-u
        ));
		}
	));


	

	/**
	 * ==============================
	 * Feature Category Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'feature-category',
		'title' => 'Feature Category',
		'description' => 'Feature Category block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/feature-category/feature-category.php',
	));

	/**
	 * ==============================
	 * About Text Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'about-text',
		'title' => 'About Text',
		'description' => 'About Text block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/about-text/about-text.php',
	));

	/**
	 * ==============================
	 * Newsletter Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'newsletter',
		'title' => 'Newsletter',
		'description' => 'About Text block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/newsletter/newsletter.php',
	));

	/**
	 * ==============================
	 * test Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'test',
		'title' => 'Test',
		'description' => 'Test block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/test/test.php',
	));

	/**
	 * ==============================
	 * Recommended property Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'recommended-property',
		'title' => 'Recommended property',
		'description' => 'Recommended property block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/recommended-property/recommended-property.php',
	));
	/**
	 * ==============================
	 * FAQ 2 Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'faq-2',
		'title' => 'FAQ 2',
		'description' => 'FAQ 2 block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/faq-2/faq-2.php',
	));

	/**
	 * ==============================
	 * link-list Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'link-list',
		'title' => 'Link list',
		'description' => 'Link list block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/link-list/link-list.php',
	));

	/**
	 * ==============================
	 * properties-list Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'properties-list',
		'title' => 'Properties list',
		'description' => 'Properties list block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/properties-list/properties-list.php',
	));

	/**
	 * ==============================
	 * hero-image Block
	 * ==============================
	 */
	acf_register_block_type(array(
		'name' => 'hero-image',
		'title' => 'Hero image',
		'description' => 'Hero image block',
		'category' => 'maxwell-blocks',
		'mode' => 'preview',
		'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48">
			<circle cx="12" cy="12" r="10" fill="none" stroke="#ff0000" stroke-width="2"/>
			<text x="12" y="16" text-anchor="middle" font-size="12" font-family="Arial, sans-serif" fill="#ff0000" font-weight="bold"> M </text>
		</svg>',
		'supports' => array(
			'align' => true,
			'mode' => true,
			'jsx' => true,
			'anchor' => true,
		),
		'render_template' => 'blocks/hero-image/hero-image.php',
	));
}
