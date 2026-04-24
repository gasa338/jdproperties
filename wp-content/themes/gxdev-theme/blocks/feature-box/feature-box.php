<?php

use SimplePie\Item;

$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_box');
$background = $data['background'] ?? 'dark_mode';
?>

<section class="py-24 bg-hero relative overflow-hidden">
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 1px 1px, rgb(255, 255, 255) 1px, transparent 0px); background-size: 32px 32px;"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div>
            <?php if (!empty($data['top_title'])) : ?>
                <span class="maxwell-top-title mb-4 block text-center"><?php echo $data['top_title']; ?></span>
            <?php endif; ?>
            <?php echo _heading($data['title'], 'mb-16 text-white' . ($data['top_title'] ? '' : ' text-center')) ?>

            <div class="grid md:grid-cols-2 gap-8">
                <?php if (!empty($data['features'])) : ?>
                    <?php foreach ($data['features'] as $feature) : ?>
                        <div class="p-8 rounded-lg bg-white/5 border border-white/10 hover:border-accent/50 transition-colors group">
                            <?php if (!empty($feature['icon'])) : ?>
                                <div class="w-14 h-14 rounded-lg bg-accent/20 flex items-center justify-center mb-6 group-hover:bg-accent/30 transition-colors">
                                    <?php echo maxwell_render_icon($feature['icon'], 'w-7 h-7 text-accent'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($feature['title'])) : ?>
                                <h3 class="font-display text-xl font-bold text-white mb-3 "><?php echo $feature['title']; ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($feature['text'])) : ?>
                                <div class="text-white/70"><?php echo $feature['text']; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>