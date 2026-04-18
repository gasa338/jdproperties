<?php

/**
 * mma-future functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mma-future
 */

if (! defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}
/** helper test functions */
function dd($array): void
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

if (! function_exists('gxdev_log')) {
	function gxdev_log($entry, $mode = 'a', $file = 'gxdev_log')
	{
		// Get WordPress uploads directory.
		$upload_dir = wp_upload_dir();

		$upload_dir = $upload_dir['basedir'];
		$upload_dir = dirname(__FILE__);
		// If the entry is array, json_encode.
		if (is_array($entry)) {
			$entry = json_encode($entry);
		}
		// Write the log file.
		$file  = $upload_dir . '/' . $file . '.log';
		$file  = fopen($file, $mode);
		$bytes = fwrite($file, current_time('mysql') . "::" . $entry . "\n");
		fclose($file);
		return $bytes;
	}
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mma_future_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on mma-future, use a find and replace
		* to change 'mma-future' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('mma-future', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'primary' => esc_html__('Primary', 'mma-future'),
			'footer-menu-1' => esc_html__('Footer Menu 1', 'mma-future'),
			'footer-menu-2' => esc_html__('Footer Menu 2', 'mma-future'),
			'footer-menu-3' => esc_html__('Footer Menu 3', 'mma-future'),
			'footer-menu-4' => esc_html__('Footer Menu 4', 'mma-future'),
			'footer-menu-5' => esc_html__('Footer Menu 5', 'mma-future'),
		)
	);

	/*
	* Switch default core markup for search form, comment form, and comments
	* to output valid HTML5.
	*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'mma_future_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'mma_future_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mma_future_content_width()
{
	$GLOBALS['content_width'] = apply_filters('mma_future_content_width', 640);
}
add_action('after_setup_theme', 'mma_future_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mma_future_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'mma-future'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'mma-future'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'mma_future_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function mma_future_scripts()
{
	global $template;
	$basename = basename($template);
	/** ==============================            custom styles and scripts            ============================== */
	/**  */
	wp_enqueue_style('main', get_template_directory_uri() . '/assets/dist/css/output.css');

	wp_enqueue_script('main', get_template_directory_uri() . '/assets/dist/js/main.js', array(), _S_VERSION, true);

	/** ==============================            default styles and scripts            ============================== */

	wp_enqueue_style('mma-future-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('mma-future-style', 'rtl', 'replace');

	wp_enqueue_script('mma-future-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	if (is_singular('post')) {
		wp_enqueue_script('blog-main', get_template_directory_uri() . '/assets/dist/js/blog-main.js', array(), _S_VERSION, true);
		wp_enqueue_style('blog', get_template_directory_uri() . '/assets/dist/css/blog.css', array(), _S_VERSION, 'all');
	}
	
	if (is_singular('properties')) {
		wp_enqueue_script('properties', get_template_directory_uri() . '/assets/dist/js/properties-single.js', array(), _S_VERSION, true);
		wp_enqueue_style('form', get_template_directory_uri() . '/assets/dist/css/form.css', array(), _S_VERSION, 'all');
	}

	if ($basename === 'properties.php') {
		wp_enqueue_script(
			'properties-filters',
			get_template_directory_uri() . '/assets/dist/js/properties-filters.js',
			['jquery'],
			filemtime(get_template_directory() . '/assets/dist/js/properties-filters.js'),
			true
		);

		wp_localize_script('properties-filters', 'propertiesAjax', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('properties_filter_nonce'),
			'test' => 'test'
		]);
	}

	if ($basename === 'taxonomy-location.php' || $basename === 'taxonomy-cat.php' || $basename === 'taxonomy-other.php' || $basename === 'taxonomy-jd-type.php') {

		$term = get_queried_object();
		wp_enqueue_script(
			'properties-filters-taxonomy',
			get_template_directory_uri() . '/assets/dist/js/properties-filters-taxonomy.js',
			['jquery'],
			filemtime(get_template_directory() . '/assets/dist/js/properties-filters-taxonomy.js'),
			true
		);

		wp_localize_script('properties-filters-taxonomy', 'propertiesAjax', [
			'ajaxurl' => admin_url('admin-ajax.php'),
			'nonce'   => wp_create_nonce('properties_filter_taxonomy_nonce'),
			'term_slug' => $term->slug,
			'taxonomy' => $term->taxonomy,
		]);
	}
	
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
	wp_dequeue_style('wc-blocks-style'); // Ako koristite WooCommerce

	// wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.6.0.min.js', array(), '3.6.0', true);
}
add_action('wp_enqueue_scripts', 'mma_future_scripts', 20);


/**
 * Enqueue admin scripts
 */
function mma_future_admin_scripts($hook)
{
	if ('post.php' === $hook) {
		wp_enqueue_style('mma-main', get_template_directory_uri() . '/assets/dist/css/output.css');
		wp_enqueue_script('mma-main', get_template_directory_uri() . '/assets/dist/js/main.js', array(), _S_VERSION, true);
		
		wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/dist/js/swiper-bundle.min.js', array(), _S_VERSION, true);
		wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/dist/css/swiper-bundle.min.css');
	}

}
add_action('admin_enqueue_scripts', 'mma_future_admin_scripts');

/**
 * Include helper functions
 */
require_once get_template_directory() . '/inc/helper-function.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Register blocks
 */
require get_template_directory() . '/inc/register-blocks.php';

/**
 * Register components
 */
require get_template_directory() . '/inc/components.php';


/**
 * This file includes the functions for setting default social media share image.
 */
require get_template_directory() . '/inc/default-share-image.php';


/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}


// Uključite custom ACF field type
require_once get_template_directory() . '/acf-image-select/acf-image-select.php';
require_once get_template_directory() . '/acf-advanced-title/acf-advanced-title.php';
require_once get_template_directory() . '/acf-wysiwyg/acf-wysiwyg.php';


/**
 * Include include load more for post
 */
require_once get_template_directory() . '/blocks/posts-list/posts-list-fn.php';

/**
 * Include table of content
 */
require get_template_directory() . '/inc/table_of_content.php';
require get_template_directory() . '/inc/gutenberg_native.php';

require_once get_template_directory() . '/inc/jd-property-hooks.php';
require_once get_template_directory() . '/inc/jd-property-sale-hooks.php';
require_once get_template_directory() . '/inc/functions-properties-ajax.php';
require_once get_template_directory() . '/inc/functions-properties-ajax-taxonomy.php';



/**
 * CPT: Properties + taxonomies (cat, type, location, other)
 * Slug CPT-a: properties  (VAŽNO: isti kao u staroj temi/WP All Import-u)
 */
add_action('init', function () {

	/* ---------- CPT: properties ---------- */
	if ( ! post_type_exists('properties') ) {
		$labels = array(
			'name'               => 'Properties',
			'singular_name'      => 'Property',
			'menu_name'          => 'Properties',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Property',
			'edit_item'          => 'Edit Property',
			'new_item'           => 'New Property',
			'view_item'          => 'View Property',
			'all_items'          => 'All Properties',
			'search_items'       => 'Search Properties',
			'not_found'          => 'No properties found',
			'not_found_in_trash' => 'No properties found in Trash',
		);

		register_post_type('properties', array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'show_in_rest'       => true,   // Gutenberg/REST
			'has_archive'        => true,
			'rewrite'            => array('slug' => 'nekretnine'), // npr. /nekretnine/
			'menu_icon'          => 'dashicons-building',
			'supports'           => array('title','editor','thumbnail','excerpt','custom-fields'),
			'exclude_from_search'=> false,
			'map_meta_cap'       => true,
		));
	}

	/* ---------- TAX: cat (hijerarhijska — kao kategorije) ---------- */
	// koristila se u staroj temi; ako želiš drugi slug, promeni 'cat'
	register_taxonomy('cat', array('properties'), array(
		'labels' => array(
			'name'          => 'Categories',
			'singular_name' => 'Category',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		// 'rewrite'           => array('slug' => 'prop-category'),
	));

	/* ---------- TAX: location (hijerarhijska — npr. Grad/Opština) ---------- */
	register_taxonomy('location', array('properties'), array(
		'labels' => array(
			'name'          => 'Locations',
			'singular_name' => 'Location',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array('slug' => 'location'),
	));

	/* ---------- TAX: other (nehijerarhijska — tagovi/feature-i) ---------- */
	register_taxonomy('other', array('properties'), array(
		'labels' => array(
			'name'          => 'Features',
			'singular_name' => 'Feature',
		),
		'hierarchical'      => false, // tagovi
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array('slug' => 'feature'),
	));
});



function jdproperty_map_shortcode() {
    $lat = get_field('geo_sirina');
    $lng = get_field('geo_duzina');

    // Ako nema koordinate, ne prikazuj ništa
    if ( empty($lat) || empty($lng) ) {
        return '';
    }

    // HTML embed mape
    $map = '<div class="property-map" style="margin-top:20px;">
        <iframe 
            width="100%" 
            height="450" 
            style="border:0" 
            loading="lazy" 
            allowfullscreen 
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q=' . esc_attr($lat) . ',' . esc_attr($lng) . '&hl=sr&z=15&output=embed">
        </iframe>
    </div>';

    return $map;
}
add_shortcode('property_map', 'jdproperty_map_shortcode');


add_action('save_post_properties', function($post_id, $post, $update) {

  if (wp_is_post_revision($post_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
    return;
  }

  $raw = get_post_meta($post_id, 'property_price', true);

  // iz "455.160 €" napravi 455160
  $num = preg_replace('/[^\d]/', '', (string)$raw);

  $num = $num !== '' ? (int)$num : 0;

  update_post_meta($post_id, 'property_price_num', $num);

  _update_price_bounds_in_options($num);

}, 10, 3);


function _update_price_bounds_in_options($current_price) {
  // Ako je cena 0 (nema cene), ignoriši
  if ($current_price <= 0) {
    return;
  }
  
  // Dohvati trenutne vrednosti iz option tabele
  $current_min = get_option('property_price_min', null);
  $current_max = get_option('property_price_max', null);
  
  // INICIJALIZACIJA: ako nema vrednosti, postavi trenutnu cenu
  if ($current_min === null) {
    update_option('property_price_min', $current_price);
  }
  
  if ($current_max === null) {
    update_option('property_price_max', $current_price);
  }
  
  // Provera za MINIMUM
  if ($current_price < (int)$current_min) {
    update_option('property_price_min', $current_price);
  }
  
  // Provera za MAKSIMUM
  if ($current_price > (int)$current_max) {
    update_option('property_price_max', $current_price);
  }
}


/** dinamic populate field */
add_filter('acf/load_field/name=property_location', function($field) {

    // uzmi samo termine iz "location" taksonomije
    $terms = get_terms([
        'taxonomy'   => 'location',
        'hide_empty' => true, // samo one koje imaju properties
    ]);

    // reset choices
    $field['choices'] = [];

    if (!is_wp_error($terms)) {
        foreach ($terms as $term) {
            $field['choices'][$term->term_id] = $term->name;
        }
    }

    return $field;
});