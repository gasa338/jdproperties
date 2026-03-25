
<!-- Hero Sekcija -->
 <?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('blog_1');
$posts = get_post_by_type('choose', 'post', 3, $data['posts']);
$bg_color = $data['bg_color'];
?>
<style>
    .blog-1-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo esc_attr($bg_color); ?> !important;
    }
</style>
<!-- 3. Blog/Content sekcija -->
<section id="<?php echo esc_attr($anchor); ?>" class="py-8 sm:py-12 lg:py-18 blog-1-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" >
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <?php if (!empty($data['top_title'])) : ?>
            <p class="maxwell-top-title"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>
            
            <?php if (!empty($data['title'])) : ?>
            <h2 class="h2-responsive mt-2 mb-4"><?php echo $data['title']; ?></h2>
            <?php endif; ?>
            
            <?php if (!empty($data['description'])) : ?>
            <div class="max-w-2xl mx-auto content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($posts as $post) : ?>
            <article class="bg-white rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition">
                <?php if (!empty($post['primary_category'])) : ?>
                <div class="h-48 bg-cover bg-center relative">
                    <a href="<?php echo $post['primary_category']['link']; ?>" class="absolute top-4 left-4 bg-white/20 backdrop-blur-sm text-white px-3 py-1 rounded-full text-sm font-semibold"><?php echo $post['primary_category']['name']; ?></a>
                    <img src="<?php echo $post['image']['url']; ?>" alt="<?php echo $post['image']['alt']; ?>" class="w-full h-48 overflow-hidden object-center">
                </div>
                <?php endif; ?>
                <div class="p-6">
                    <h3 class="h3-responsive mb-3"><a href="<?php echo $post['link']; ?>" title="<?php echo $post['title']; ?>" target="_blank"><?php echo $post['title']; ?></a></h3>
                    <p class="mb-4"><?php echo $post['excerpt']; ?></p>
                    <div class="flex justify-between items-center">
                        <span class=""><?php echo $post['date']; ?></span>
                        
                        <?php if (!empty($post['link'])) : ?>
                        <a href="<?php echo $post['link']['url']; ?>" title="<?php echo $post['title']; ?>" target="_blank" class="flex items-center group">
                            <?php echo __('Read more', 'maxwell'); ?>
                            <i class="fas fa-arrow-right ml-1 group-hover:translate-x-1 transition text-xs"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        
        <?php if (!empty($data['to_link'])) : ?>
        <div class="text-center mt-12">
            <?php link_1($data['to_link']); ?>
        </div>
        <?php endif; ?>
    </div>
</section>