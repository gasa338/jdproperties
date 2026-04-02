<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

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
		'rewrite'           => array('slug' => 'prop-category'),
	));

	/* ---------- TAX: type (hijerarhijska — tip nekretnine) ---------- */
	register_taxonomy('type', array('properties'), array(
		'labels' => array(
			'name'          => 'Types',
			'singular_name' => 'Type',
		),
		'hierarchical'      => true,
		'public'            => true,
		'show_ui'           => true,
		'show_admin_column' => true,
		'show_in_rest'      => true,
		'rewrite'           => array('slug' => 'prop-type'),
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

// Za nove 'properties' postove automatski postavi Elementor Full Width template
add_action('wp_insert_post', function ($post_id, $post, $update) {
    if ( wp_is_post_revision($post_id) || $update ) return;             // samo za novo kreirane
    if ( $post->post_type !== 'properties' ) return;

    // ako nije već postavljeno, namesti Elementor Full Width
    $current = get_post_meta($post_id, '_wp_page_template', true);
    if ( ! $current ) {
        update_post_meta($post_id, '_wp_page_template', 'elementor_header_footer'); // Elementor Full Width
        // Alternativa: 'elementor_canvas' za potpuno prazan template
    }
}, 10, 3);
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
// Elementor custom query za filter nekretnina
add_action( 'elementor/query/nekretnine_filter', function( $query ) {

    if ( is_admin() ) {
        return;
    }

    $meta_query = array( 'relation' => 'AND' );
    $tax_query  = array( 'relation' => 'AND' );

    // 1) TRANSAKCIJA - taxonomy: cat (Prodaja, Izdavanje)
    if ( ! empty( $_GET['transakcija'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'cat', // ovo je tvoja taxonomy za prodaja/izdavanje
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['transakcija'] ),
        );
    }

    // 2) VRSTA OBJEKTA - taxonomy: type (Stan, Kuća, Poslovni prostor)
    if ( ! empty( $_GET['vrsta'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['vrsta'] ),
        );
    }

    // 3) LOKACIJA - taxonomy: location (Vračar, Novi Beograd…)
    if ( ! empty( $_GET['lokacija'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'location',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['lokacija'] ),
        );
    }

    // 4) CENA - ACF: property_price
    if ( ! empty( $_GET['min_price'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_price',
            'value'   => floatval( $_GET['min_price'] ),
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }
    if ( ! empty( $_GET['max_price'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_price',
            'value'   => floatval( $_GET['max_price'] ),
            'compare' => '<=',
            'type'    => 'NUMERIC',
        );
    }

    // 5) KVADRATURA - ACF: property_squarespace
    if ( ! empty( $_GET['min_sq'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_squarespace',
            'value'   => floatval( $_GET['min_sq'] ),
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }
    if ( ! empty( $_GET['max_sq'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_squarespace',
            'value'   => floatval( $_GET['max_sq'] ),
            'compare' => '<=',
            'type'    => 'NUMERIC',
        );
    }

    // 6) Ključna reč u naslovu/tekstu
    if ( ! empty( $_GET['keyword'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['keyword'] ) );
    }

    // Primeni tax/meta query ako ima uslova
    if ( count( $tax_query ) > 1 ) {
        $query->set( 'tax_query', $tax_query );
    }
    if ( count( $meta_query ) > 1 ) {
        $query->set( 'meta_query', $meta_query );
    }

    // Osiguraj CPT
    $query->set( 'post_type', 'properties' );
    $query->set( 'post_status', 'publish' );
} );
// Shortcode za formu pretrage nekretnina
function jd_property_filter_form_shortcode() {

    // Trenutne vrednosti iz GET-a (da ostanu odabrane posle submit-a)
    $cur_Tip = isset($_GET['Tip']) ? sanitize_text_field($_GET['Tip']) : '';
    $cur_vrsta       = isset($_GET['vrsta']) ? sanitize_text_field($_GET['vrsta']) : '';
    $cur_lokacija    = isset($_GET['lokacija']) ? sanitize_text_field($_GET['lokacija']) : '';
    $cur_min_price   = isset($_GET['min_price']) ? sanitize_text_field($_GET['min_price']) : '';
    $cur_max_price   = isset($_GET['max_price']) ? sanitize_text_field($_GET['max_price']) : '';
    $cur_min_sq      = isset($_GET['min_sq']) ? sanitize_text_field($_GET['min_sq']) : '';
    $cur_max_sq      = isset($_GET['max_sq']) ? sanitize_text_field($_GET['max_sq']) : '';
    $cur_keyword     = isset($_GET['keyword']) ? sanitize_text_field($_GET['keyword']) : '';

    // Termini za transakciju (taxonomy: cat)
    $transakcije = get_terms(array(
        'taxonomy'   => 'cat',
        'hide_empty' => false,
    ));

    // Termini za vrstu (taxonomy: type)
    $vrste = get_terms(array(
        'taxonomy'   => 'type',
        'hide_empty' => false,
    ));

    // Termini za lokaciju (taxonomy: location)
    $lokacije = get_terms(array(
        'taxonomy'   => 'location',
        'hide_empty' => false,
    ));

    // URL stranice na koju šalješ filter (PROMENI ako nije /nekretnine)
    $action_url = home_url('/nekretnine/');

    ob_start();
    ?>
    <form method="get" action="<?php echo esc_url( $action_url ); ?>" class="property-filters">

      <div class="filters-row basic-filters">

        <!-- Tip -->
        <div class="filter-item">
          <label>Tip</label>
          <select name="Tip">
            <option value="">Sve</option>
            <?php if ( ! empty( $transakcije ) && ! is_wp_error( $transakcije ) ) : ?>
                <?php foreach ( $transakcije as $term ) : ?>
                    <?php
                    $selected = ( $cur_Tip === $term->slug ) ? ' selected' : '';
                    ?>
                    <option value="<?php echo esc_attr( $term->slug ); ?>"<?php echo $selected; ?>>
                        <?php echo esc_html( $term->name ); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- VRSTA OBJEKTA -->
        <div class="filter-item">
          <label>Vrsta objekta</label>
          <select name="vrsta">
            <option value="">Sve</option>
            <?php if ( ! empty( $vrste ) && ! is_wp_error( $vrste ) ) : ?>
                <?php foreach ( $vrste as $term ) : ?>
                    <?php
                    $selected = ( $cur_vrsta === $term->slug ) ? ' selected' : '';
                    ?>
                    <option value="<?php echo esc_attr( $term->slug ); ?>"<?php echo $selected; ?>>
                        <?php echo esc_html( $term->name ); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- LOKACIJA -->
        <div class="filter-item">
          <label>Lokacija</label>
          <select name="lokacija">
            <option value="">Sve lokacije</option>
            <?php if ( ! empty( $lokacije ) && ! is_wp_error( $lokacije ) ) : ?>
                <?php foreach ( $lokacije as $term ) : ?>
                    <?php
                    $selected = ( $cur_lokacija === $term->slug ) ? ' selected' : '';
                    ?>
                    <option value="<?php echo esc_attr( $term->slug ); ?>"<?php echo $selected; ?>>
                        <?php echo esc_html( $term->name ); ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
          </select>
        </div>

        <!-- SUBMIT -->
        <div class="filter-item filter-submit">
          <button type="submit" class="btn-search">TRAŽI</button>
        </div>

        <!-- Dugme za naprednu pretragu -->
        <button type="button" id="toggle-advanced" class="advanced-toggle">
          ⚙ <span class="label">Napredna pretraga</span>
        </button>
      </div>

      <!-- NAPREDNI FILTERI -->
      <div class="filters-row advanced-filters" id="advanced-filters">
        <div class="filter-item">
          <label>Cena od</label>
          <input type="number" name="min_price" placeholder="Min" value="<?php echo esc_attr( $cur_min_price ); ?>">
        </div>
        <div class="filter-item">
          <label>Cena do</label>
          <input type="number" name="max_price" placeholder="Max" value="<?php echo esc_attr( $cur_max_price ); ?>">
        </div>
        <div class="filter-item">
          <label>Kvadratura od</label>
          <input type="number" name="min_sq" placeholder="Min" value="<?php echo esc_attr( $cur_min_sq ); ?>">
        </div>
        <div class="filter-item">
          <label>Kvadratura do</label>
          <input type="number" name="max_sq" placeholder="Max" value="<?php echo esc_attr( $cur_max_sq ); ?>">
        </div>
        <div class="filter-item">
          <label>Ključna reč</label>
          <input type="text" name="keyword" placeholder="Bilo koja ključna reč…" value="<?php echo esc_attr( $cur_keyword ); ?>">
        </div>
      </div>

    </form>
    <?php
    return ob_get_clean();
}
add_shortcode( 'property_filter', 'jd_property_filter_form_shortcode' );
// ==================================================
// Filter za glavnu arhivu /nekretnine/ (pretraga preko GET parametara)
// ==================================================
add_action( 'pre_get_posts', 'jdproperties_archive_filter' );

function jdproperties_archive_filter( $query ) {

    // 1) Ne diramo admin i neglavne upite
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // 2) Primeni samo na arhivu custom post type-a "properties"
    if ( ! is_post_type_archive( 'properties' ) ) {
        return;
    }

    // 3) Početni tax/meta query
    $tax_query  = array( 'relation' => 'AND' );
    $meta_query = array( 'relation' => 'AND' );

    // ---- Tip (Prodaja / Izdavanje) - taxonomy: cat ----
    if ( ! empty( $_GET['Tip'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'cat',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['Tip'] ),
        );
    }

    // ---- VRSTA OBJEKTA (stan, kuća, poslovni) - taxonomy: type ----
    if ( ! empty( $_GET['vrsta'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'type',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['vrsta'] ),
        );
    }

    // ---- LOKACIJA (Vračar, Kumodraž...) - taxonomy: location ----
    if ( ! empty( $_GET['lokacija'] ) ) {
        $tax_query[] = array(
            'taxonomy' => 'location',
            'field'    => 'slug',
            'terms'    => sanitize_text_field( $_GET['lokacija'] ),
        );
    }

    // ---- CENA min/max - ACF: property_price ----
    if ( ! empty( $_GET['min_price'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_price',
            'value'   => floatval( $_GET['min_price'] ),
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    if ( ! empty( $_GET['max_price'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_price',
            'value'   => floatval( $_GET['max_price'] ),
            'compare' => '<=',
            'type'    => 'NUMERIC',
        );
    }

    // ---- KVADRATURA min/max - ACF: property_squarespace ----
    if ( ! empty( $_GET['min_sq'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_squarespace',
            'value'   => floatval( $_GET['min_sq'] ),
            'compare' => '>=',
            'type'    => 'NUMERIC',
        );
    }

    if ( ! empty( $_GET['max_sq'] ) ) {
        $meta_query[] = array(
            'key'     => 'property_squarespace',
            'value'   => floatval( $_GET['max_sq'] ),
            'compare' => '<=',
            'type'    => 'NUMERIC',
        );
    }

    // ---- Ključna reč u naslovu/sadržaju ----
    if ( ! empty( $_GET['keyword'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['keyword'] ) );
    }

    // Primeni taksonomije samo ako ima bar jedan uslov
    if ( count( $tax_query ) > 1 ) {
        $query->set( 'tax_query', $tax_query );
    }

    // Primeni meta query samo ako ima bar jedan uslov
    if ( count( $meta_query ) > 1 ) {
        $query->set( 'meta_query', $meta_query );
    }

    // Za svaki slučaj, osiguraj CPT
    $query->set( 'post_type', 'properties' );
    $query->set( 'post_status', 'publish' );
}
add_action('wp_enqueue_scripts', function () {
  if (is_singular('properties')) {
    wp_enqueue_style('jd-single-properties', get_stylesheet_directory_uri().'/assets/single-properties.css', [], '1.0.0');
    wp_enqueue_script('jd-single-properties', get_stylesheet_directory_uri().'/assets/single-properties.js', [], '1.0.0', true);
  }
});
/**
 * JD Properties - grid shortcode + assets
 */

add_action('wp_enqueue_scripts', function () {
  // CSS za kartice (grid prikaz)
  wp_enqueue_style(
    'jd-properties-cards',
    get_stylesheet_directory_uri() . '/assets/jd-properties-cards.css',
    [],
    '1.0.0'
  );
});

/**
 * Shortcode:
 * [jd_properties_grid type="stan" cat="izdavanje" posts_per_page="12"]
 * [jd_properties_grid type="kuca" cat="prodaja"]
 * [jd_properties_grid type="poslovni-prostor"]
 */
add_shortcode('jd_properties_grid', function ($atts) {
 $atts = shortcode_atts([
  'type' => '',
  'cat'  => '',
  'posts_per_page' => 12,
  'orderby' => 'date',
  'order' => 'DESC',
  'title_contains' => '', // filtriranje po naslovu
], $atts, 'jd_properties_grid');
// SORT iz URL-a
$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';

if ($sort === 'price_desc') {
  $atts['orderby'] = 'meta_value_num';
  $atts['order']   = 'DESC';
} elseif ($sort === 'price_asc') {
  $atts['orderby'] = 'meta_value_num';
  $atts['order']   = 'ASC';
} elseif ($sort === 'date_asc') {
  $atts['orderby'] = 'date';
  $atts['order']   = 'ASC';
} elseif ($sort === 'date_desc') {
  $atts['orderby'] = 'date';
  $atts['order']   = 'DESC';
}

  $tax_query = [];

  if (!empty($atts['type'])) {
    $tax_query[] = [
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => sanitize_title($atts['type']),
    ];
  }

  if (!empty($atts['cat'])) {
    $tax_query[] = [
      'taxonomy' => 'cat',
      'field'    => 'slug',
      'terms'    => sanitize_title($atts['cat']),
    ];
  }

  if (count($tax_query) > 1) {
    $tax_query['relation'] = 'AND';
  }
	$title_contains = trim((string)$atts['title_contains']);
$title_filter = null;

if ($title_contains !== '') {
  $title_filter = function($where) use ($title_contains) {
    global $wpdb;
    $like = '%' . $wpdb->esc_like($title_contains) . '%';
    $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", $like);
    return $where;
  };

  add_filter('posts_where', $title_filter);
}

  $query_args = [
  'post_type'      => 'properties',
  'post_status'    => 'publish',
  'posts_per_page' => (int)$atts['posts_per_page'],
  'orderby'        => sanitize_key($atts['orderby']),
  'order'          => ($atts['order'] === 'ASC') ? 'ASC' : 'DESC',
  'tax_query'      => $tax_query ?: null,
];

// ako je sortiranje po ceni
if ($atts['orderby'] === 'meta_value_num') {
  $query_args['meta_key'] = 'property_price_num';
}

$q = new WP_Query($query_args);

if ($title_filter) {
  remove_filter('posts_where', $title_filter);
}

  ob_start();

  if ($q->have_posts()) :
    ?>
    <div class="jd-cards-grid">
      <?php while ($q->have_posts()) : $q->the_post();
        $post_id = get_the_ID();

        // Featured image fallback
        $img = get_the_post_thumbnail_url($post_id, 'large');

        // Ako imaš galeriju meta "gallery" (kao na single), uzmi prvu sliku kao cover
        $gallery = get_post_meta($post_id, 'gallery', true);
        if (is_string($gallery)) {
          $gallery = maybe_unserialize($gallery);
        }
        if (is_array($gallery) && !empty($gallery)) {
          $first = $gallery[0];
          if (is_numeric($first)) {
            $maybe = wp_get_attachment_image_url((int)$first, 'large');
            if ($maybe) $img = $maybe;
          } elseif (is_string($first) && filter_var($first, FILTER_VALIDATE_URL)) {
            $img = $first;
          }
        }

        // Meta (ti ključevi)
        $rooms = get_post_meta($post_id, 'property_structure', true);     // sobe
        $area  = get_post_meta($post_id, 'property_squarespace', true);   // kvadratura
        $floor = get_post_meta($post_id, 'property_floor', true);         // sprat
        $price_raw = get_post_meta($post_id, 'property_price', true);

        // format cene
        $price = '';
        if ($price_raw !== '') {
          $num = preg_replace('/[^\d]/', '', (string)$price_raw);
          $price = $num ? number_format((float)$num, 0, ',', '.') . ' €' : $price_raw;
        }

        // Location term (ako koristiš taxonomy location)
        $loc = '';
        $terms = get_the_terms($post_id, 'location');
        if (!is_wp_error($terms) && !empty($terms)) {
          $loc = $terms[0]->name;
        }

        $icons_base = get_stylesheet_directory_uri() . '/assets/icons/';
        $rooms_icon = $icons_base . 'rooms.svg';
        $area_icon  = $icons_base . 'area.svg';
        $floor_icon = $icons_base . 'floor.svg';
        ?>
        <a class="jd-card" href="<?php the_permalink(); ?>">
          <div class="jd-card-media" style="background-image:url('<?php echo esc_url($img); ?>');">
            <div class="jd-card-overlay"></div>
          </div>

          <div class="jd-card-body">
            <div class="jd-card-metrics">
              <div class="jd-metric">
                <img src="<?php echo esc_url($rooms_icon); ?>" alt="">
                <span><?php echo esc_html($rooms !== '' ? $rooms : '-'); ?></span>
              </div>
              <div class="jd-metric">
                <img src="<?php echo esc_url($area_icon); ?>" alt="">
                <span><?php echo esc_html($area !== '' ? $area . ' m²' : '-'); ?></span>
              </div>
              <div class="jd-metric">
                <img src="<?php echo esc_url($floor_icon); ?>" alt="">
                <span><?php echo esc_html($floor !== '' ? $floor : '-'); ?></span>
              </div>
            </div>

            <h3 class="jd-card-title"><?php the_title(); ?></h3>

            <?php if ($loc): ?>
              <div class="jd-card-loc"><?php echo esc_html($loc); ?></div>
            <?php endif; ?>

            <?php if ($price): ?>
              <div class="jd-card-price"><?php echo esc_html($price); ?></div>
            <?php endif; ?>
          </div>
        </a>
      <?php endwhile; ?>
    </div>
    <?php
  else :
    echo '<p>Nema rezultata.</p>';
  endif;

  wp_reset_postdata();
  return ob_get_clean();
});

add_shortcode('jd_sort_properties', function () {

  $current = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';
  $action  = esc_url(remove_query_arg(['paged']));

  ob_start();
  ?>
  <form class="jd-sortform" method="get" action="<?php echo $action; ?>" style="margin:20px 0;">
    <?php
    foreach ($_GET as $k => $v) {
      if ($k === 'sort' || $k === 'paged') continue;
      if (is_array($v)) continue;
      echo '<input type="hidden" name="'.esc_attr($k).'" value="'.esc_attr($v).'">';
    }
    ?>
    <label for="jd-sort" style="margin-right:8px;">Sortiraj:</label>
    <select id="jd-sort" name="sort" onchange="this.form.submit()">
      <option value="" <?php selected($current, ''); ?>>Podrazumevano</option>
      <option value="price_desc" <?php selected($current, 'price_desc'); ?>>Cena: najskuplje → najjeftinije</option>
      <option value="price_asc"  <?php selected($current, 'price_asc');  ?>>Cena: najjeftinije → najskuplje</option>
      <option value="date_desc"  <?php selected($current, 'date_desc');  ?>>Datum: najnovije → najstarije</option>
      <option value="date_asc"   <?php selected($current, 'date_asc');   ?>>Datum: najstarije → najnovije</option>
    </select>
  </form>
  <?php

  return ob_get_clean();
});
/**
 * ------------------------------------------------------------
 * JD SEARCH BAR (Izdavanje/Prodaja + Napredna pretraga)
 * + GET filteri za [jd_properties_grid]
 * ------------------------------------------------------------
 */

/** Helper: vrati listu termova kao slug=>name */
function jd_get_terms_options($tax) {
  if (!taxonomy_exists($tax)) return [];
  $terms = get_terms(['taxonomy' => $tax, 'hide_empty' => false]);
  if (is_wp_error($terms) || empty($terms)) return [];
  $out = [];
  foreach ($terms as $t) $out[$t->slug] = $t->name;
  return $out;
}

/** Helper: numeric meta (iz "1.100 €" -> 1100) */
function jd_to_number($raw) {
  $n = preg_replace('/[^\d]/', '', (string)$raw);
  return $n !== '' ? (int)$n : 0;
}

/**
 * Shortcode: [jd_searchbar results_url="/nekretnine/" city_tax="city" furnished_tax="furnished"]
 *
 * - results_url: gde vodi "Pretraži" (npr. /nekretnine/ ili strana gde imaš grid)
 * - koristi taxonomije:
 *   type (Vrsta), location (Lokacija), city (Grad - promenljivo), cat (Izdavanje/Prodaja), structure (Struktura - opciono),
 *   furnished (Nameštenost - promenljivo)
 *
 * Napomena: ako nemaš city/furnished/structure taxonomy, samo promeni atribute ili ostavi prazno.
 */
add_shortcode('jd_searchbar', function($atts) {

  $atts = shortcode_atts([
    'results_url'   => '/nekretnine/',
    'furnished_tax' => 'furnished',
    'structure_tax' => 'structure',
  ], $atts, 'jd_searchbar');

  $action = home_url($atts['results_url']);

  // vrednosti iz URL-a
  $cat   = isset($_GET['cat']) ? sanitize_title($_GET['cat']) : 'izdavanje';
  if (!in_array($cat, ['izdavanje','prodaja'], true)) $cat = 'izdavanje';

  $type      = isset($_GET['type']) ? sanitize_title($_GET['type']) : '';
  $location  = isset($_GET['location']) ? sanitize_title($_GET['location']) : '';
  $furnished = isset($_GET['furnished']) ? sanitize_title($_GET['furnished']) : '';
  $structure = isset($_GET['structure']) ? sanitize_title($_GET['structure']) : '';

  $price_min = isset($_GET['price_min']) ? jd_to_number($_GET['price_min']) : '';
  $price_max = isset($_GET['price_max']) ? jd_to_number($_GET['price_max']) : '';
  $area_min  = isset($_GET['area_min']) ? jd_to_number($_GET['area_min']) : '';
  $area_max  = isset($_GET['area_max']) ? jd_to_number($_GET['area_max']) : '';
  $pid       = isset($_GET['pid']) ? jd_to_number($_GET['pid']) : '';

  // options
  $type_opts = jd_get_terms_options('type');

  // samo aktivne lokacije
  $loc_terms = get_terms([
    'taxonomy'   => 'location',
    'hide_empty' => true,
  ]);

  $loc_opts = [];
  if (!is_wp_error($loc_terms) && !empty($loc_terms)) {
    foreach ($loc_terms as $t) {
      $loc_opts[$t->slug] = $t->name;
    }
  }

  $furn_opts   = $atts['furnished_tax'] && taxonomy_exists($atts['furnished_tax']) ? jd_get_terms_options($atts['furnished_tax']) : [];
  $struct_opts = $atts['structure_tax'] && taxonomy_exists($atts['structure_tax']) ? jd_get_terms_options($atts['structure_tax']) : [];

  ob_start();
  ?>
  <div class="jd-searchbox" data-jd-search>
    <div class="jd-searchbox-tabs" role="tablist" aria-label="Izdavanje / Prodaja">
      <button type="button" class="jd-tab <?php echo $cat==='izdavanje'?'is-active':''; ?>" data-cat="izdavanje">IZDAVANJE</button>
      <button type="button" class="jd-tab <?php echo $cat==='prodaja'?'is-active':''; ?>" data-cat="prodaja">PRODAJA</button>
    </div>

    <form class="jd-searchbox-form" method="get" action="<?php echo esc_url($action); ?>">
      <input type="hidden" name="cat" value="<?php echo esc_attr($cat); ?>">

      <div class="jd-searchbox-row">
        <div class="jd-field">
          <label>VRSTA</label>
          <select name="type">
            <option value="">Izaberite</option>
            <?php foreach($type_opts as $slug => $name): ?>
              <option value="<?php echo esc_attr($slug); ?>" <?php selected($type, $slug); ?>>
                <?php echo esc_html($name); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="jd-field">
          <label>GRAD</label>
          <input type="text" value="Beograd" readonly>
        </div>

        <div class="jd-field">
          <label>LOKACIJA</label>
          <select name="location">
            <option value="">Izaberite</option>
            <?php foreach($loc_opts as $slug => $name): ?>
              <option value="<?php echo esc_attr($slug); ?>" <?php selected($location, $slug); ?>>
                <?php echo esc_html($name); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="jd-field">
          <label>NAMEŠTENOST</label>
          <select name="furnished" <?php echo empty($furn_opts) ? 'disabled' : ''; ?>>
            <option value=""><?php echo empty($furn_opts) ? 'Izaberite' : 'Izaberite'; ?></option>
            <?php foreach($furn_opts as $slug => $name): ?>
              <option value="<?php echo esc_attr($slug); ?>" <?php selected($furnished, $slug); ?>>
                <?php echo esc_html($name); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <button class="jd-adv-btn" type="button" data-jd-adv-toggle>
          Napredna pretraga <span class="jd-adv-ico" aria-hidden="true"></span>
        </button>

        <button class="jd-btn jd-btn-primary" type="submit">Pretraži</button>
      </div>

      <div class="jd-searchbox-adv" data-jd-adv>
        <div class="jd-searchbox-row jd-searchbox-row-adv">
          <div class="jd-field">
            <label>STRUKTURA</label>
            <select name="structure" <?php echo empty($struct_opts) ? 'disabled' : ''; ?>>
              <option value="">Izaberite</option>
              <?php foreach($struct_opts as $slug => $name): ?>
                <option value="<?php echo esc_attr($slug); ?>" <?php selected($structure, $slug); ?>>
                  <?php echo esc_html($name); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="jd-field jd-field-range">
            <label>CENA</label>
            <div class="jd-range">
              <input type="text" name="price_min" placeholder="Od..." value="<?php echo esc_attr($price_min); ?>">
              <span class="jd-range-sep">—</span>
              <input type="text" name="price_max" placeholder="...do" value="<?php echo esc_attr($price_max); ?>">
            </div>
          </div>

          <div class="jd-field jd-field-range">
            <label>KVADRATURA</label>
            <div class="jd-range">
              <input type="text" name="area_min" placeholder="Od..." value="<?php echo esc_attr($area_min); ?>">
              <span class="jd-range-sep">—</span>
              <input type="text" name="area_max" placeholder="...do" value="<?php echo esc_attr($area_max); ?>">
            </div>
          </div>

          <div class="jd-field">
            <label>KATALOŠKI BROJ</label>
            <input type="text" name="pid" placeholder="Unesite ID" value="<?php echo esc_attr($pid); ?>">
          </div>
        </div>
      </div>
    </form>
  </div>
  <?php
  return ob_get_clean();
});

/**
 * ------------------------------------------------------------
 * CSS/JS učitavanje za search bar (fajlovi u astra-child/assets/)
 * ------------------------------------------------------------
 */
add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('jd-searchbox', get_stylesheet_directory_uri() . '/assets/jd-searchbox.css', [], '1.0.0');
  wp_enqueue_script('jd-searchbox', get_stylesheet_directory_uri() . '/assets/jd-searchbox.js', [], '1.0.0', true);
});

/**
 * ------------------------------------------------------------
 * Nadogradnja: [jd_properties_grid] da filtrira po GET parametrima
 * (cat, type, location, city, furnished, structure, price, area, pid)
 * ------------------------------------------------------------
 */
add_shortcode('jd_properties_grid', function ($atts) {
  $atts = shortcode_atts([
  'type' => '',
  'cat'  => '',
  'posts_per_page' => 12,
  'city_tax'      => 'city',
  'furnished_tax' => 'furnished',
  'structure_tax' => 'structure',
  'title_contains' => '',
], $atts, 'jd_properties_grid');

  // FILTERI IZ URL-a (ako postoje)
  $g_cat   = isset($_GET['cat']) ? sanitize_title($_GET['cat']) : '';
  $g_type  = isset($_GET['type']) ? sanitize_title($_GET['type']) : '';
  $g_loc   = isset($_GET['location']) ? sanitize_title($_GET['location']) : '';
  $g_furn  = isset($_GET['furnished']) ? sanitize_title($_GET['furnished']) : '';
  $g_str   = isset($_GET['structure']) ? sanitize_title($_GET['structure']) : '';

  $price_min = isset($_GET['price_min']) ? jd_to_number($_GET['price_min']) : 0;
  $price_max = isset($_GET['price_max']) ? jd_to_number($_GET['price_max']) : 0;
  $area_min  = isset($_GET['area_min'])  ? jd_to_number($_GET['area_min'])  : 0;
  $area_max  = isset($_GET['area_max'])  ? jd_to_number($_GET['area_max'])  : 0;

  $pid = isset($_GET['pid']) ? jd_to_number($_GET['pid']) : 0;

  // Ako korisnik dođe sa searchbar-a, GET ima prioritet nad atts
  $type = $g_type !== '' ? $g_type : sanitize_title($atts['type']);
  $cat  = $g_cat  !== '' ? $g_cat  : sanitize_title($atts['cat']);

  $tax_query = [];

  if ($type !== '') {
    $tax_query[] = [
      'taxonomy' => 'type',
      'field'    => 'slug',
      'terms'    => $type,
    ];
  }

  if ($cat !== '') {
    $tax_query[] = [
      'taxonomy' => 'cat',
      'field'    => 'slug',
      'terms'    => $cat,
    ];
  }

  if ($g_loc !== '') {
    $tax_query[] = [
      'taxonomy' => 'location',
      'field'    => 'slug',
      'terms'    => $g_loc,
    ];
  }

  if ($g_furn !== '' && taxonomy_exists($atts['furnished_tax'])) {
    $tax_query[] = [
      'taxonomy' => $atts['furnished_tax'],
      'field'    => 'slug',
      'terms'    => $g_furn,
    ];
  }

  if ($g_str !== '' && taxonomy_exists($atts['structure_tax'])) {
    $tax_query[] = [
      'taxonomy' => $atts['structure_tax'],
      'field'    => 'slug',
      'terms'    => $g_str,
    ];
  }

  if (count($tax_query) > 1) $tax_query['relation'] = 'AND';

  // META QUERY: cena i kvadratura
  // CENU je NAJBOLJE držati u property_price_num (numerički).
  $meta_query = [];

  if ($price_min || $price_max) {
    $min = $price_min ? $price_min : 0;
    $max = $price_max ? $price_max : 999999999;
    $meta_query[] = [
      'key'     => 'property_price_num',
      'value'   => [$min, $max],
      'type'    => 'NUMERIC',
      'compare' => 'BETWEEN',
    ];
  }

  if ($area_min || $area_max) {
    $min = $area_min ? $area_min : 0;
    $max = $area_max ? $area_max : 999999999;
    $meta_query[] = [
      'key'     => 'property_squarespace',
      'value'   => [$min, $max],
      'type'    => 'NUMERIC',
      'compare' => 'BETWEEN',
    ];
  }

 // Sortiranje iz URL-a: ?sort=price_desc|price_asc|date_desc|date_asc
$sort = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';

$orderby  = 'date';
$order    = 'DESC';
$meta_key = '';

if ($sort === 'price_desc') {
  $meta_key = 'property_price_num';
  $orderby  = 'meta_value_num';
  $order    = 'DESC';
} elseif ($sort === 'price_asc') {
  $meta_key = 'property_price_num';
  $orderby  = 'meta_value_num';
  $order    = 'ASC';
} elseif ($sort === 'date_asc') {
  $orderby = 'date';
  $order   = 'ASC';
} else { // date_desc ili prazno
  $orderby = 'date';
  $order   = 'DESC';
}

  $query_args = [
    'post_type'      => 'properties',
    'post_status'    => 'publish',
    'posts_per_page' => (int)$atts['posts_per_page'],
    'orderby'        => $orderby,
    'order'          => $order,
    'tax_query'      => $tax_query ?: null,
    'meta_query'     => $meta_query ?: null,
  ];

  if ($meta_key) $query_args['meta_key'] = $meta_key;

  // Ako je unet kataloški broj (ID posta)
  if ($pid > 0) {
    $query_args['p'] = $pid;
  }
$title_contains = trim((string)$atts['title_contains']);
$title_filter = null;

if ($title_contains !== '') {
  $title_filter = function($where) use ($title_contains) {
    global $wpdb;
    $like = '%' . $wpdb->esc_like($title_contains) . '%';
    $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", $like);
    return $where;
  };

  add_filter('posts_where', $title_filter);
}
  $q = new WP_Query($query_args);
if ($title_filter) {
  remove_filter('posts_where', $title_filter);
}
  ob_start();

  if ($q->have_posts()) :
    ?>
    <div class="jd-cards-grid">
      <?php while ($q->have_posts()) : $q->the_post();
        $post_id = get_the_ID();

        // cover slika: featured ili prva iz galerije
        $img = get_the_post_thumbnail_url($post_id, 'large');

        $gallery = get_post_meta($post_id, 'gallery', true);
        if (is_string($gallery)) $gallery = maybe_unserialize($gallery);

        if (is_array($gallery) && !empty($gallery)) {
          $first = $gallery[0];
          if (is_numeric($first)) {
            $maybe = wp_get_attachment_image_url((int)$first, 'large');
            if ($maybe) $img = $maybe;
          } elseif (is_string($first) && filter_var($first, FILTER_VALIDATE_URL)) {
            $img = $first;
          }
        }

        // meta
        $rooms = get_post_meta($post_id, 'property_structure', true);
        $area  = get_post_meta($post_id, 'property_squarespace', true);
        $floor = get_post_meta($post_id, 'property_floor', true);

        $price_raw = get_post_meta($post_id, 'property_price', true);
        $price = '';
        if ($price_raw !== '') {
          $num = preg_replace('/[^\d]/', '', (string)$price_raw);
          $price = $num ? number_format((float)$num, 0, ',', '.') . ' €' : $price_raw;
        }

        $loc = '';
        $terms = get_the_terms($post_id, 'location');
        if (!is_wp_error($terms) && !empty($terms)) $loc = $terms[0]->name;

        $icons_base = get_stylesheet_directory_uri() . '/assets/icons/';
        $rooms_icon = $icons_base . 'rooms.svg';
        $area_icon  = $icons_base . 'area.svg';
        $floor_icon = $icons_base . 'floor.svg';
        ?>
        <a class="jd-card" href="<?php the_permalink(); ?>">
          <div class="jd-card-media" style="background-image:url('<?php echo esc_url($img); ?>');">
            <div class="jd-card-overlay"></div>
          </div>

          <div class="jd-card-body">
            <div class="jd-card-metrics">
              <div class="jd-metric">
                <img src="<?php echo esc_url($rooms_icon); ?>" alt="">
                <span><?php echo esc_html($rooms !== '' ? $rooms : '-'); ?></span>
              </div>
              <div class="jd-metric">
                <img src="<?php echo esc_url($area_icon); ?>" alt="">
                <span><?php echo esc_html($area !== '' ? $area . ' m²' : '-'); ?></span>
              </div>
              <div class="jd-metric">
                <img src="<?php echo esc_url($floor_icon); ?>" alt="">
                <span><?php echo esc_html($floor !== '' ? $floor : '-'); ?></span>
              </div>
            </div>

            <h3 class="jd-card-title"><?php the_title(); ?></h3>

            <?php if ($loc): ?>
              <div class="jd-card-loc"><?php echo esc_html($loc); ?></div>
            <?php endif; ?>

            <?php if ($price): ?>
              <div class="jd-card-price"><?php echo esc_html($price); ?></div>
            <?php endif; ?>
          </div>
        </a>
      <?php endwhile; ?>
    </div>
    <?php
  else :
    echo '<p>Nema rezultata.</p>';
  endif;

  wp_reset_postdata();
  return ob_get_clean();
}, 20);

/**
 * Auto-popuni property_price_num iz property_price (da napredna pretraga po ceni radi numerički)
 */
add_action('save_post_properties', function($post_id, $post, $update) {
  if (wp_is_post_revision($post_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) return;

  $raw = get_post_meta($post_id, 'property_price', true);
  $num = jd_to_number($raw);
  update_post_meta($post_id, 'property_price_num', $num);
}, 10, 3);
/**
 * Shortcode: [jd_sort_tabs]
 * 4 klik filtera za sortiranje
 */
add_shortcode('jd_sort_tabs', function () {
  $current = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : '';

  $base_url = remove_query_arg(['sort', 'paged']);

  $tabs = [
    'date_desc'  => 'Najnovije',
    'price_desc' => 'Najskuplje',
    'price_asc'  => 'Najjeftinije',
    'date_asc'   => 'Najstarije',
  ];

  ob_start();
  echo '<div class="jd-sort-tabs">';

  foreach ($tabs as $value => $label) {
    $url = add_query_arg('sort', $value, $base_url);
    $active = ($current === $value) ? ' is-active' : '';
    echo '<a class="jd-sort-tab' . $active . '" href="' . esc_url($url) . '">' . esc_html($label) . '</a>';
  }

  echo '</div>';

  return ob_get_clean();
});
/**
 * Automatski pravi numeričku cenu za sortiranje
 */
add_action('save_post_properties', function($post_id, $post, $update) {

  if (wp_is_post_revision($post_id) || (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
    return;
  }

  $raw = get_post_meta($post_id, 'property_price', true);

  // iz "455.160 €" napravi 455160
  $num = preg_replace('/[^\d]/', '', (string)$raw);

  $num = $num !== '' ? (int)$num : 0;

  update_post_meta($post_id, 'property_price_num', $num);

}, 10, 3);