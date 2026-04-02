<?php
// Dohvatanje podataka o postu
$post_id = get_the_ID();
$categories = get_the_category();
$category_names = wp_list_pluck($categories, 'name');
$category_slugs = wp_list_pluck($categories, 'slug');

// Podaci o autoru
$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
$author_avatar = get_avatar_url($author_id, array('size' => 100));

// Vreme čitanja
$content = get_the_content();
$word_count = str_word_count(strip_tags($content));
$reading_time = max(1, ceil($word_count / 200));

// Featured image
$thumbnail_url = get_the_post_thumbnail_url($post_id, 'large');
if (!$thumbnail_url) {
    $thumbnail_url = 'https://images.unsplash.com/photo-1677442136019-21780ecad995?w=800'; // Fallback slika
}
?>

<article class="group post-item" data-categories="<?php echo implode(',', $category_slugs); ?>">
    <a class="block h-full no-underline" href="<?php the_permalink(); ?>">
        <div class="bg-card border border-accent/30 rounded-2xl overflow-hidden hover:border-accent/60 transition-all h-full flex flex-col">
            <div class="aspect-video overflow-hidden">
                <img src="<?php echo esc_url($thumbnail_url); ?>"
                    alt="<?php the_title_attribute(); ?>"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    loading="lazy">
            </div>
            <div class="p-6 flex flex-col flex-grow">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-accent text-white">
                        <?php echo !empty($category_names) ? esc_html($category_names[0]) : 'Uncategorized'; ?>
                    </span>
                    <span class="text-muted-foreground flex items-center gap-1">
                        <div class="bg-accent p-1 rounded-full">
                            <svg class="w-3 h-3 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3 h-3">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                        </div>
                        <?php echo maxwell_estimated_reading_time($post_id); ?> min read 
                    </span>
                </div>
                <h3 class="text-lg font-bold text-foreground mb-2 group-hover:text-accent transition-colors">
                    <?php the_title(); ?>
                </h3>
                <p class="text-muted-foreground mb-4 flex-grow">
                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                </p>
                <div class="flex items-center gap-3 pt-4 border-t border-accent/30">
                    <img src="<?php echo esc_url($author_avatar); ?>"
                        alt="<?php echo esc_attr($author_name); ?>"
                        class="w-8 h-8 rounded-full object-cover">
                    <div>
                        <p class="font-medium text-foreground"><?php echo esc_html($author_name); ?></p>
                        <p class="text-muted-foreground"><?php echo get_the_date('M j, Y'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </a>
</article>