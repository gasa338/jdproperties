<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package mma-future
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mma_future_body_classes($classes)
{
	// Adds a class of hfeed to non-singular pages.
	if (! is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (! is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter('body_class', 'mma_future_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mma_future_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'mma_future_pingback_header');



function maxwell_block_category($block_categories)
{

	$block_categories = array_merge(
		array(
			array(
				'slug' => 'maxwell-blocks',
				'title' => 'Blocks by Maxwell'
			)
		),
		$block_categories
	);

	return $block_categories;
}
add_filter('block_categories_all', 'maxwell_block_category');


/**
 * Funkcija koja vraća primarnu kategoriju odredenog posta.
 * Ako postoji, primarna kategorija je ona koja je postavljena u Yoast SEO pluginu.
 * U suprotnom, prva kategorija posta se uzima kao primarna kategorija.
 *
 * @param int|null $post_id ID posta. Ako nije proslijeđen, uzima se trenutni post.
 * @return mixed Objekt primarne kategorije ili false ako nema primarne kategorije.
 */
function get_primary_category($post_id = null)
{
	// Ako nije proslijeđen ID, uzmi trenutni post
	if (empty($post_id)) {
		$post_id = get_the_ID();
	}

	// Provjeri da li Yoast postoji i ima li primarnu kategoriju
	if (class_exists('WPSEO_Primary_Term')) {
		/** @var WPSEO_Primary_Term $primary_term */
		$primary_term = new WPSEO_Primary_Term('category', $post_id);
		$primary_category_id = $primary_term->get_primary_term();

		if ($primary_category_id) {
			$primary_category = get_term($primary_category_id, 'category');
			if (!is_wp_error($primary_category)) {
				return [
					'link' => get_term_link($primary_category),
					'name' => $primary_category->name
				];
			}
		}
	}

	// Fallback: vrati prvu kategoriju ako nema primarne
	$categories = wp_get_post_categories($post_id, array('number' => 1));
	if (!empty($categories)) {
		$category = get_term($categories[0], 'category');
		if ($category) {
			return [
				'link' => get_term_link($category),
				'name' => $category->name
			];
		}
	}

	return false;
}

/**
 * Funkcija koja vraća primarnu kategoriju odredenog posta.
 * Ako postoji, primarna kategorija je ona koja je postavljena u Yoast SEO pluginu.
 * U suprotnom, prva kategorija posta se uzima kao primarna kategorija.
 *
 * @param int|null $post_id ID posta. Ako nije proslijeđen, uzima se trenutni post.
 * @return mixed Objekt primarne kategorije ili false ako nema primarne kategorije.
 */
function _case_study_primary_category($post_id = null)
{
	$taxonomy = 'category-case-study';

	// 1. POKUŠAJ DA DOBIJEŠ PRIMARNU KATEGORIJU PREKO RANK MATH-A
	$primary_cat_id = get_post_meta($post_id, 'rank_math_primary_category-case-study', true);

	if (! empty($primary_cat_id)) {
		$primary_cat = get_term($primary_cat_id, $taxonomy);

		if ($primary_cat && ! is_wp_error($primary_cat)) {

			return [
				'link' => get_term_link($primary_cat),
				'name' => $primary_cat->name
			];
		}
	}

	// 2. FALLBACK: VRATI PRVU KATEGORIJU (prvu po redu)
	$categories = wp_get_post_terms($post_id, $taxonomy);

	if (! empty($categories) && ! is_wp_error($categories)) {
		$first_cat = $categories[0];
		return [
			'link' => get_term_link($first_cat),
			'name' => $first_cat->name
		];
	}

	return '';
}

/**
 * Funkcija koja vraća array s ID-evima poslednjih postova,
 * određenog tipa i broja po želji.
 *
 * @param int $count Broj postova koji se vraća. Zadani je 3.
 * @param string $post_type Tip postova koji se vraća. Zadani je 'post'.
 * @return array Array sa ID-evima poslednjih postova. Ako nema postova, vraća prazan array.
 */
function get_post_by_type($type = 'last', $post_type = 'post', $posts_per_page = 3, $posts_ids = array())
{
	if ($type == 'last') {
		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $posts_per_page,
			'orderby' => 'date',
			'order' => 'DESC',
		);
	} elseif ($type == 'choose') {
		$args = array(
			'post_type' => $post_type,
			'post_status' => 'publish',
			'posts_per_page' => $posts_per_page,
			'orderby' => 'date',
			'order' => 'ASC',
			'post__in' => $posts_ids,
		);
	}

	$query = new WP_Query($args);

	$output = array();

	if ($query->have_posts()) {
		$key = 1;
		while ($query->have_posts()) {
			$query->the_post();
			$output[$key]['id'] = get_the_ID();
			$output[$key]['primary_category'] = get_primary_category(get_the_ID());
			$output[$key]['title'] = get_the_title();
			$output[$key]['excerpt'] = get_the_excerpt();
			$output[$key]['image'] = get_image(get_post_thumbnail_id());
			$output[$key]['link'] = array(
				'url' => get_the_permalink(),
				'title' => 'Read more',
				'target' => false
			);
			$output[$key]['date'] = get_the_date();
			$key++;
		}
	}

	return $output;
}


/**
 * Hide unnecessary options in the Schema Meta JSON-LD settings page.
 *
 * This function adds inline CSS to hide certain elements on the Schema Meta JSON-LD settings page.
 * These elements are not needed for our purposes and only clutter the page.
 */
function disable_schema_meta_json_ld_options()
{
	echo '<style>
        #schema_meta_json_ld .inside .widefat,
        #schema_meta_json_ld .inside .fixed,
        #schema_meta_json_ld .inside .wp-list-table,
        #schema_meta_json_ld .inside h4 { 
            display: none !important;
        }

		#schema_meta_json_ld .inside #MetaSchemaMarkupNote,
		#schema_meta_json_ld .inside strong,
		#schema_meta_json_ld .inside #schemapostlinks button:not(:last-child) {
			display: none !important;
		}
    </style>';
}
add_action('admin_head', 'disable_schema_meta_json_ld_options');
