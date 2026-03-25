<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('features_1');
?>

<style>
    .features-1-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffffff" ?>;
    }

    /* Dodajte u vaš CSS fajl */
    .tour-item {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .tour-item[style*="display: none"] {
        opacity: 0;
        transform: translateY(20px);
    }

    .tour-load-more {
        transition: all 0.3s ease;
    }

    .tour-load-more:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>
<section id="destinations" class="py-8 sm:py-12 lg:py-18 features-1-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto flex flex-col items-center justify-center">
        <div class="text-center mb-12 ">
            <?php if ($data['top_title']) : ?>
                <p class="maxwell-top-title mb-2"><?php echo esc_html($data['top_title']); ?></p>
            <?php endif; ?>

            <?php if ($data['title']) : ?>
                <h2 class="h2-responsive mb-4"><?php echo esc_html($data['title']); ?></h2>
            <?php endif; ?>

            <?php if ($data['description']) : ?>
                <div class="content-list-link mb-4"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>
        <?php if ($data['items']) : ?>
            <div class="tour-packages-container">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 px-4 tour-items-grid">
                    <?php
                    $total_items = count($data['items']);
                    $items_to_show = min(6, $total_items);

                    for ($i = 0; $i < $total_items; $i++) :
                        $item = $data['items'][$i];
                        $is_hidden = $i >= $items_to_show ? 'style="display: none;"' : '';
                    ?>
                        <div class="tour-item bg-white rounded-2xl overflow-hidden hover:-translate-y-1 transition-transform"
                            data-index="<?php echo $i; ?>"
                            <?php echo $is_hidden; ?>>
                            <div class="p-6">
                                <?php if ($item['duration']) : ?>
                                    <div class="flex items-center gap-1 mb-2 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                                            <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512 256 256 0 1 1 0-512zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"></path>
                                        </svg>
                                        <span><?php echo $item['duration']; ?></span>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($item['title'])): ?>
                                    <h3 class="text-primary text-xl font-semibold mb-2"><?php echo $item['title']; ?></h3>
                                <?php endif; ?>

                                <?php if (!empty($item['description'])): ?>
                                    <p><?php echo $item['description']; ?></p>
                                <?php endif; ?>

                                <?php if (!empty($item['places'])): ?>
                                    <ul class="space-y-2 mb-6 mt-2">
                                        <?php foreach ($item['places'] as $place): ?>
                                            <li class="flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-4 h-4 text-secondary">
                                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                                    <circle cx="12" cy="10" r="3"></circle>
                                                </svg>
                                                <?php echo $place['name']; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>

                                <div class="flex items-center justify-between pt-4 border-t border-border/50">
                                    <?php if ($item['price']) : ?>
                                        <span class="text-primary text-2xl font-bold"><?php echo esc_html($item['price']); ?></span>
                                    <?php endif; ?>

                                    <?php if ($item['link']) : ?>
                                        <?php link_5($item['link']); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>

                <?php if ($total_items > 6) : ?>
                    <div class="text-center mt-12 load-more-container">
                        <button type="button"
                            class="tour-load-more bg-primary text-white px-8 py-3 rounded-xl font-semibold hover:bg-primary/90 transition-colors"
                            data-items-per-load="6"
                            data-total-items="<?php echo $total_items; ?>"
                            data-text-load-more="<?php echo esc_attr__('Read more', 'maxwell-team'); ?>"
                            data-text-loading="<?php echo esc_attr__('Loading...', 'maxwell-team'); ?>"
                            data-text-remaining="<?php echo esc_attr__('remaining', 'maxwell-team'); ?>">
                            Read more
                        </button>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>