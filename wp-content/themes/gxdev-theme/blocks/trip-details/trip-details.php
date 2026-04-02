<?php

use SimplePie\Item;

$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('trip_details');
$background_color = $data['background_color'] ?? '#fff';
?>
<style>
    .trip-details-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo esc_attr($background_color); ?> !important;
    }
</style>


<section id="<?php echo esc_attr($anchor); ?>" class="py-8 sm:py-12 lg:py-18 trip-details-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
            <div>
                <?php if (!empty($data['title'])) : ?>
                    <h2 class="h2-responsive mb-6"><?php echo $data['title']; ?></h2>
                <?php endif; ?>

                <?php if (!empty($data['highlights'])) : ?>
                    <ul class="space-y-4">
                        <?php foreach ($data['highlights'] as $highlight) : ?>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-6 h-6 text-secondary flex-shrink-0 mt-0.5">
                                    <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                    <path d="m9 11 3 3L22 4"></path>
                                </svg>
                                <span class="text-primary"><?php echo $highlight['highlight']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <?php if (!empty($data['adicional_text'])) : ?>
                    <div class="mt-8 p-6 rounded-xl bg-secondary/10 border border-secondary/20">
                        <?php echo apply_filters('the_content', $data['adicional_text']); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="rounded-2xl p-8 border border-border/50 shadow-md">
                <?php if (!empty($data['pricing_title'])) : ?>
                    <h2 class="h2-responsive mb-6"><?php echo $data['pricing_title']; ?></h2>
                <?php endif; ?>
                <?php if ($data['pricing_description']) : ?>
                    <p class="mb-6"><?php echo $data['pricing_description']; ?></p>
                <?php endif; ?>

                <?php if (!empty($data['details'])) : ?>
                    <div class="space-y-4">
                        <?php foreach ($data['details'] as $detail) : ?>
                            <div class="flex items-center justify-between p-4 rounded-md  bg-secondary/5 border border-secondary/20">
                                <div class="flex items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users w-5 h-5 text-primary">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    <?php if (!empty($detail['number'])) : ?>
                                        <span class="font-medium"><?php echo $detail['number']; ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($detail['price'])) : ?>
                                    <span class="text-2xl font-bold text-primary"><?php echo $detail['price']; ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['link'])) : ?>
                <div class="mt-6 space-y-3 mx-auto">
                    <?php link_5($data['link'], 'w-full !py-4 !text-lg !font-semibold') ?>
                    <?php if (!empty($data['pricing_contact'])) : ?>
                        <p class="text-center"><?php echo $data['pricing_contact']; ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>