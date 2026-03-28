<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_category');
$color_mode = $data['background'] ?? 'dark';
?><?php echo _spacing_full('feature-category', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="feature-category-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class);
                                                                                                            echo ' ' . _background($data['background']); ?>">

    <div class="container mx-auto">
        <div class="mb-12 text-center">
            <?php if (!empty($data['top_title'])) : ?>
                <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
            <?php endif; ?>

            <?php echo _heading($data['title'], "mb-6" . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
            <?php if (!empty($data['text'])) : ?>
                <div class="text-lg mb-8 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'; ?>">
                    <?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>
        </div>
        <?php if (!empty($data['categories'])) : ?>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <?php foreach ($data['categories'] as $category): ?>
                <div>
                    <a class="group relative block rounded-lg overflow-hidden aspect-[3/4] card-hover" href="<?php echo $category['link']['url']; ?>" title="<?php echo $category['title']; ?>" target="<?php echo $category['link']['target'] ? $category['link']['target'] : '_self'; ?>">
                        <img src="<?php echo $category['image']['url']; ?>" alt="<?php echo $category['image']['alt']; ?>" loading="lazy" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-102">
                        <div class="absolute inset-0 bg-gradient-to-t from-accent/90 via-accent/60 to-transparent "></div>
                        <div class="absolute bottom-0 left-0 right-0 p-6">
                            <h3 class="text-2xl text-primary-foreground font-semibold mb-1"><?php echo $category['title']; ?></h3>

                            <div class="flex items-center gap-2 transition-all text-primary-foreground">
                                <span><?php echo $category['link']['title']; ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>