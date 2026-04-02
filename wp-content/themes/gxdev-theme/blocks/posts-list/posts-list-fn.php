<?php
/**
 * AJAX Load More Posts
 */
function load_more_posts() {
    // Dohvatanje parametara
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 6;
    
    // Pravljenje query argumenata
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $posts_per_page,
        'paged'          => $page,
    );
    
    if (!empty($category)) {
        $args['category_name'] = $category;
    }
    
    $query = new WP_Query($args);
    $response = array(
        'success' => false,
        'html' => '',
        'page' => $page,
        'max_pages' => $query->max_num_pages
    );
    
    if ($query->have_posts()) {
        ob_start();
        
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/blog-card');
        }
        
        wp_reset_postdata();
        
        $response['success'] = true;
        $response['html'] = ob_get_clean();
    }
    
    wp_send_json($response);
}
add_action('wp_ajax_load_more_posts', 'load_more_posts');
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts');