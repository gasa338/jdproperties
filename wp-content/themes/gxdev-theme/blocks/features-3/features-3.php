<?php

use SimplePie\Item;

$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_3');
$background_color = $data['background_color'] ?? '#fff';
?> 
<style>
    .features-3-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo esc_attr($background_color); ?> !important;
    }

    .bg-pattern {
        background-image: radial-gradient(circle at 20% 50%, hsl(40 60% 50% / .03) 0%, transparent 50%), radial-gradient(circle at 80% 20%, hsl(222 47% 20% / .03) 0%, transparent 50%), radial-gradient(circle at 40% 80%, hsl(40 60% 50% / .02) 0%, transparent 50%);
    }
</style>
<section id="<?php echo esc_attr($anchor); ?>" class="py-8 sm:py-12 lg:py-18 features-3-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> bg-pattern">
    <div class="container items-center justify-center mx-auto px-3">
        <div class="text-center mb-16 max-w-2xl mx-auto">
            <?php if ($data['top_title']) : ?>
                <p class="maxwell-top-title"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>
            <?php if (!empty($data['title'])) : ?>
                <h2 class="h2-responsive mb-4"><?php echo $data['title']; ?></h2>
            <?php endif; ?>
            <?php if (!empty($data['description'])) : ?>
                <div class="content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($data['items'] as $item) : ?>
                <?php if (!empty($item['link']['url'])) : ?>
                    <a class="group rounded-lg overflow-hidden shadow-md transition-all duration-300 hover:-translate-y-0.5 bg-white" href="<?php echo $item['link']['url'] ?>">
                    <?php else : ?>
                        <div class="group rounded-lg overflow-hidden shadow-md transition-all duration-300 hover:-translate-y-0.5 bg-white">
                        <?php endif; ?>
                        <div class="relative h-56 overflow-hidden">
                            <?php if ($item['image']) : ?>
                                <img src="<?php echo $item['image']['url']; ?>" alt="<?php echo $item['image']['alt']; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
                            <?php if ($item['icon']) : ?>
                                <div class="absolute bottom-4 left-4">
                                    <?php echo maxwell_render_icon($item['icon'], 'w-12 h-12 rounded-lg bg-secondary flex items-center justify-center'); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="p-6 content-list-link">
                            <?php if (!empty($item['title'])) : ?>
                                <h3 class="text-xl font-bold mb-2 group-hover:text-secondary"><?php echo $item['title']; ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($item['description'])) : ?>
                                <p class="mb-4 text-primary"><?php echo $item['description']; ?></p>
                            <?php endif; ?>
                            <?php if (!empty($item['places'])) : ?>
                                <ul class="space-y-2 text-primary">
                                    <?php foreach ($item['places'] as $place) : ?>
                                        <li class="flex items-center gap-2">
                                            <?php echo $place['place']; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($item['link']['url'])) : ?>
                    </a>
                <?php else : ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>