<?php
/**
 * =============================================================================
 * PROPERTIES FILTER — Dodati u functions.php teme
 * =============================================================================
 */

/* -------------------------------------------------------------------------- */
/* 1. Enqueue skripte i stilove                                                */
/* -------------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', function () {

    // Samo na stranici sa Properties templateom
    if ( ! is_page_template('properties.php') ) return;

    // Inline CSS za range slider i loading (dodaj u tema CSS ako preferiraš)
    wp_add_inline_style('your-theme-style', '
        /* === Price Range Slider === */
        .price-range-wrap { position: relative; height: 20px; }
        .range-track {
            position: absolute; top: 50%; left: 0; right: 0;
            height: 4px; background: var(--secondary, #e5e7eb);
            border-radius: 9999px; transform: translateY(-50%);
            pointer-events: none;
        }
        .range-fill {
            position: absolute; height: 100%;
            background: var(--accent, #b8860b); border-radius: 9999px;
        }
        .range-input {
            position: absolute; width: 100%; pointer-events: none;
            appearance: none; -webkit-appearance: none;
            background: transparent; height: 4px; outline: none;
            top: 50%; transform: translateY(-50%);
        }
        .range-input::-webkit-slider-thumb {
            pointer-events: all; appearance: none; -webkit-appearance: none;
            width: 18px; height: 18px; border-radius: 50%;
            background: var(--background, #fff);
            border: 2px solid var(--accent, #b8860b);
            cursor: pointer; position: relative; z-index: 2;
        }
        .range-input::-moz-range-thumb {
            pointer-events: all; width: 18px; height: 18px; border-radius: 50%;
            background: var(--background, #fff);
            border: 2px solid var(--accent, #b8860b);
            cursor: pointer;
        }
        /* === Loading spinner === */
        .properties-loading-spinner {
            width: 36px; height: 36px;
            border: 3px solid var(--border, #e5e7eb);
            border-top-color: var(--accent, #b8860b);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        /* === Oblačić dugmad aktivno stanje === */
        .room-btn.active, .floor-btn.active, .bld-floor-btn.active {
            border-color: var(--accent); color: var(--accent);
            background: color-mix(in srgb, var(--accent) 10%, transparent);
        }
        /* === Filter toggle rotacija === */
        .filter-toggle svg.rotate-180 { transform: rotate(180deg); transition: transform 0.2s; }
    ');
});


/* -------------------------------------------------------------------------- */
/* 2. AJAX handler — filter_properties                                         */
/* -------------------------------------------------------------------------- */
add_action('wp_ajax_filter_properties',        'properties_ajax_handler');
add_action('wp_ajax_nopriv_filter_properties', 'properties_ajax_handler');

function properties_ajax_handler() {

    // Nonce verifikacija
    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ?? '' ) ), 'properties_filter_nonce' ) ) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    /* -- Sanitizacija ulaznih podataka -- */
    $search       = sanitize_text_field( $_POST['search']        ?? '' );
    $prop_category = sanitize_text_field( $_POST['prop_category'] ?? '' );
    $prop_types   = array_map('sanitize_text_field', (array) ( $_POST['prop_types']  ?? [] ) );
    $locations    = array_map('sanitize_text_field', (array) ( $_POST['locations']   ?? [] ) );
    $price_min        = intval( $_POST['price_min']        ?? 0 );
    $price_max        = intval( $_POST['price_max']        ?? 500000 );
    $price_filtered   = ! empty( $_POST['price_filtered'] ) && $_POST['price_filtered'] === '1';
    $area_min     = sanitize_text_field( $_POST['area_min']  ?? '' );
    $area_max     = sanitize_text_field( $_POST['area_max']  ?? '' );
    $rooms        = array_map('sanitize_text_field', (array) ( $_POST['rooms']       ?? [] ) );
    $floors       = array_map('sanitize_text_field', (array) ( $_POST['floors']      ?? [] ) );
    $bld_floors   = array_map('sanitize_text_field', (array) ( $_POST['bld_floors']  ?? [] ) );
    $orderby      = sanitize_text_field( $_POST['orderby']   ?? 'date' );
    $order        = in_array( strtoupper($_POST['order'] ?? 'DESC'), ['ASC', 'DESC'] ) ? strtoupper($_POST['order']) : 'DESC';
    $meta_key     = sanitize_key( $_POST['meta_key']  ?? '' );
    $paged        = max(1, intval( $_POST['paged']     ?? 1 ) );
    $per_page     = intval( $_POST['per_page']  ?? 9 );

    /* -- Dozvoljeni orderby vrednosti -- */
    $allowed_orderby = ['date', 'meta_value_num', 'title', 'rand'];
    if ( ! in_array($orderby, $allowed_orderby) ) {
        $orderby = 'date';
    }

    /* -- Izgradnja WP_Query args -- */
    $args = [
        'post_type'      => 'properties',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'orderby'        => $orderby,
        'order'          => $order,
    ];

    // Meta key za sortiranje po ceni/površini
    if ( $orderby === 'meta_value_num' && $meta_key ) {
        $args['meta_key'] = $meta_key;
    }

    // Search
    if ( $search ) {
        $args['s'] = $search;
    }

    /* -- Taksonomije -- */
    $tax_query = [];

    if ( $prop_category ) {
        $tax_query[] = [
            'taxonomy' => 'prop-category',
            'field'    => 'slug',
            'terms'    => $prop_category,
        ];
    }

    if ( ! empty($prop_types) ) {
        $tax_query[] = [
            'taxonomy' => 'prop-type',
            'field'    => 'slug',
            'terms'    => $prop_types,
            'operator' => 'IN',
        ];
    }

    if ( ! empty($locations) ) {
        $tax_query[] = [
            'taxonomy' => 'location',
            'field'    => 'slug',
            'terms'    => $locations,
            'operator' => 'IN',
        ];
    }

    if ( ! empty($tax_query) ) {
        if ( count($tax_query) > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        $args['tax_query'] = $tax_query;
    }

    /* -- Meta Query -- */
    $meta_query = ['relation' => 'AND'];

    // Cena — samo ako je korisnik pomerio slider
    if ( $price_filtered ) {
        $meta_query[] = [
            'relation' => 'OR',
            [
                'key'     => '_property_price',
                'value'   => [$price_min, $price_max],
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            ],
            [
                'key'     => '_property_price',
                'compare' => 'NOT EXISTS',
            ],
        ];
    }

    // Površina
    if ( $area_min !== '' || $area_max !== '' ) {
        if ( $area_min !== '' && $area_max !== '' ) {
            $meta_query[] = [
                'key'     => 'property_squarespace',
                'value'   => [floatval($area_min), floatval($area_max)],
                'type'    => 'NUMERIC',
                'compare' => 'BETWEEN',
            ];
        } elseif ( $area_min !== '' ) {
            $meta_query[] = [
                'key'     => 'property_squarespace',
                'value'   => floatval($area_min),
                'type'    => 'NUMERIC',
                'compare' => '>=',
            ];
        } else {
            $meta_query[] = [
                'key'     => 'property_squarespace',
                'value'   => floatval($area_max),
                'type'    => 'NUMERIC',
                'compare' => '<=',
            ];
        }
    }

    // Broj soba (property_structure) — "5+" znači >= 5
    if ( ! empty($rooms) ) {
        $rooms_query = ['relation' => 'OR'];
        foreach ( $rooms as $r ) {
            if ( $r === '5+' ) {
                $rooms_query[] = [
                    'key'     => 'property_structure',
                    'value'   => 5,
                    'type'    => 'NUMERIC',
                    'compare' => '>=',
                ];
            } else {
                $rooms_query[] = [
                    'key'     => 'property_structure',
                    'value'   => intval($r),
                    'type'    => 'NUMERIC',
                    'compare' => '=',
                ];
            }
        }
        $meta_query[] = $rooms_query;
    }

    // Sprat (property_floor) — "PR" = 0, "6+" = >= 6
    if ( ! empty($floors) ) {
        $floors_query = ['relation' => 'OR'];
        foreach ( $floors as $f ) {
            if ( $f === 'PR' ) {
                $floors_query[] = [
                    'key'     => 'property_floor',
                    'value'   => 0,
                    'type'    => 'NUMERIC',
                    'compare' => '=',
                ];
            } elseif ( $f === '6+' ) {
                $floors_query[] = [
                    'key'     => 'property_floor',
                    'value'   => 6,
                    'type'    => 'NUMERIC',
                    'compare' => '>=',
                ];
            } else {
                $floors_query[] = [
                    'key'     => 'property_floor',
                    'value'   => intval($f),
                    'type'    => 'NUMERIC',
                    'compare' => '=',
                ];
            }
        }
        $meta_query[] = $floors_query;
    }

    // Broj spratova zgrade (property_floors_in_building) — "8+" = >= 8, "P" = prizemlje = 0
    if ( ! empty($bld_floors) ) {
        $bld_query = ['relation' => 'OR'];
        foreach ( $bld_floors as $bf ) {
            if ( $bf === 'P' ) {
                $bld_query[] = [
                    'key'     => 'property_floors_in_building',
                    'value'   => 0,
                    'type'    => 'NUMERIC',
                    'compare' => '=',
                ];
            } elseif ( $bf === '8+' ) {
                $bld_query[] = [
                    'key'     => 'property_floors_in_building',
                    'value'   => 8,
                    'type'    => 'NUMERIC',
                    'compare' => '>=',
                ];
            } else {
                $bld_query[] = [
                    'key'     => 'property_floors_in_building',
                    'value'   => intval($bf),
                    'type'    => 'NUMERIC',
                    'compare' => '=',
                ];
            }
        }
        $meta_query[] = $bld_query;
    }

    // Dodaj meta_query samo ako postoji bar jedan uslov (osim 'relation')
    $real_meta = array_filter($meta_query, fn($v) => is_array($v));
    if ( ! empty($real_meta) ) {
        $args['meta_query'] = $meta_query;
    }

    /* -- Izvršavanje upita -- */
    $query = new WP_Query($args);

    /* -- Renderovanje HTML -- */
    ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part('template-parts/content', 'property');
        }
        wp_reset_postdata();
    } else {
        echo '<p class="col-span-full text-center text-muted-foreground py-12">Nema nekretnina koje odgovaraju zadatim filterima.</p>';
    }
    $html = ob_get_clean();

    wp_send_json_success([
        'html'        => $html,
        'total'       => $query->found_posts,
        'total_pages' => $query->max_num_pages,
        'paged'       => $paged,
    ]);
}