<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_posts');



// Konfiguracija
$posts_per_page = 6;

// Dohvatanje trenutne kategorije iz URL-a
$current_category = isset($_GET['category']) && !empty($_GET['category']) 
    ? sanitize_text_field($_GET['category']) 
    : '';

// Inicijalni query za prvu stranu
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => 1,
);

if ($current_category) {
    $args['category_name'] = $current_category;
}

$blog_posts = new WP_Query($args);

// Dohvatanje svih kategorija
$all_categories = get_categories(array(
    'hide_empty' => true,
    'orderby'    => 'name',
    'order'      => 'ASC'
));

// Broj ukupnih stranica
$max_pages = $blog_posts->max_num_pages;
?>

<!-- Filter sekcija -->
<section class="py-12 bg-section-light border-y border-border">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row gap-6 items-center justify-between">
            <!-- Search polje -->
<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <div class="relative w-full md:w-96">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-muted-foreground">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
        </svg>
        <input type="text" 
               name="s" 
               id="search-input" 
               class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm pl-12" 
               placeholder="Search articles..." 
               value="<?php echo get_search_query(); ?>">
        
        <!-- Opciono: sakriveno polje da ograniči pretragu samo na postove -->
        <input type="hidden" name="post_type" value="post" />
    </div>
</form>
            
            <!-- Filter dugmad -->
            <div class="flex flex-wrap gap-2" id="category-filters">
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" 
                   class="category-filter inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-9 rounded-md px-3 <?php echo !$current_category ? 'bg-accent text-white' : 'bg-light text-accent'; ?> no-underline"
                   data-category="">
                    All
                </a>
                
                <?php foreach ($all_categories as $category) : ?>
                    <?php
                    $category_url = add_query_arg('category', $category->slug, get_permalink(get_option('page_for_posts')));
                    $is_active = ($current_category == $category->slug);
                    ?>
                    <a href="<?php echo esc_url($category_url); ?>" 
                       class="category-filter inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-9 rounded-md px-3 <?php echo !$current_category ? 'bg-accent text-white' : 'bg-light text-accent'; ?> no-underline"
                       data-category="<?php echo esc_attr($category->slug); ?>">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Sekcija sa postovima -->
<section class="py-20 bg-background">
    <div class="container mx-auto px-6">
        <!-- Loading indicator -->
        <div id="loading-indicator" class="text-center py-12 hidden">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary border-t-transparent"></div>
            <p class="text-muted-foreground mt-2">Loading posts...</p>
        </div>

        <!-- Posts grid -->
        <div id="posts-container" class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($blog_posts->have_posts()) : ?>
                <?php while ($blog_posts->have_posts()) : $blog_posts->the_post(); ?>
                    <?php include locate_template('template-parts/blog-card.php'); ?>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="col-span-full text-center py-12">
                    <p class="text-muted-foreground">No posts found.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Load More dugme -->
        <?php if ($max_pages > 1) : ?>
            <div class="text-center mt-12">
                <button id="load-more" 
                        class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-border bg-transparent text-foreground hover:bg-secondary hover:border-primary/50 h-10 rounded-md px-8"
                        data-page="1"
                        data-max-pages="<?php echo $max_pages; ?>"
                        data-category="<?php echo $current_category; ?>">
                    Load More Articles
                </button>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
// Globalne varijable za JavaScript
var blogConfig = {
    ajaxUrl: '<?php echo admin_url('admin-ajax.php'); ?>',
    postsPerPage: <?php echo $posts_per_page; ?>,
    currentCategory: '<?php echo $current_category; ?>',
    maxPages: <?php echo $max_pages; ?>
};
</script>