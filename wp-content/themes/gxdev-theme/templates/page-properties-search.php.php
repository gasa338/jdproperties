<?php
/**
 * Template Name: Pretraga nekretnina
 */

get_header();

$cat_slug = get_query_var('cat_slug');
$type_slug = get_query_var('type_slug');
$location_slug = get_query_var('location_slug');
$paged = get_query_var('paged') ?: 1;

$tax_query = array('relation' => 'AND');

if ($cat_slug) {
    $tax_query[] = array(
        'taxonomy' => 'cat',
        'field' => 'slug',
        'terms' => $cat_slug
    );
}

if ($type_slug) {
    $tax_query[] = array(
        'taxonomy' => 'type',
        'field' => 'slug',
        'terms' => $type_slug
    );
}

if ($location_slug) {
    $tax_query[] = array(
        'taxonomy' => 'location',
        'field' => 'slug',
        'terms' => $location_slug
    );
}

$args = array(
    'post_type' => 'properties',
    'tax_query' => $tax_query,
    'posts_per_page' => 12,
    'paged' => $paged
);

$query = new WP_Query($args);

// SEO: Postavite naslov stranice
if ($cat_slug || $type_slug || $location_slug) {
    $title_parts = array();
    $cat_term = get_term_by('slug', $cat_slug, 'cat');
    $type_term = get_term_by('slug', $type_slug, 'type');
    $location_term = get_term_by('slug', $location_slug, 'location');
    
    if ($cat_term) $title_parts[] = $cat_term->name;
    if ($type_term) $title_parts[] = $type_term->name;
    if ($location_term) $title_parts[] = $location_term->name;
    
    add_filter('pre_get_document_title', function() use ($title_parts) {
        return implode(' ', $title_parts) . ' | ' . get_bloginfo('name');
    });
}
?>

<div class="properties-search-results">
    <h1>
        <?php
        if ($cat_term) echo $cat_term->name . ' ';
        if ($type_term) echo $type_term->name . ' ';
        if ($location_term) echo 'na ' . $location_term->name;
        ?>
    </h1>
    
    <?php if ($query->have_posts()) : ?>
        <div class="properties-grid">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <article class="property-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <?php the_excerpt(); ?>
                </article>
            <?php endwhile; ?>
        </div>
        
        <?php 
        // Paginacija
        echo paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'format' => 'page/%#%/',
            'base' => home_url("/{$cat_slug}/{$type_slug}/{$location_slug}/page/%#%/")
        ));
        ?>
        
    <?php else : ?>
        <p>Nema nekretnina za ovu kombinaciju.</p>
    <?php endif; ?>
    
    <?php wp_reset_postdata(); ?>
</div>

<?php get_footer(); ?>