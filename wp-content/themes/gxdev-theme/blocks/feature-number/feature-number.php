<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_number');
$color_mode = $data['background'] ?? 'dark';

$counter = count($data['numbers']);
?>
<?php echo _spacing_full('feature-number', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class=" feature-number-<?php echo esc_attr($blocks_id);
                                                                                                    echo ' ' . _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?> hairline-b">

    <div class="container mx-auto px-6">
        <div>
            <?php if ($data['top_title']): ?>
                <?php echo _top_title($data['top_title'], 'center'); ?>
            <?php endif; ?>

            <?php if (!empty($data['title'])) : ?>
                <?php echo _heading($data['title'], 'mb-6  ' . esc_attr($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground')); ?>
                <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-4"></div>
            <?php endif; ?>

            <?php if ($data['text']): ?>
                <div class="text-center max-w-2xl mx-auto <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/70' : 'text-muted-foreground'); ?> mb-16">
                    <?php echo apply_filters('the_content', $data['text']); ?>
                </div>
            <?php endif; ?>

            <div class="grid md:grid-cols-2 <?php echo $counter == 3 ? 'lg:grid-cols-3 max-w-4xl mx-auto' : 'lg:grid-cols-4 max-w-6xl mx-auto'; ?>  gap-4">
                <?php if ($data['numbers']): ?>
                    <?php foreach ($data['numbers'] as $number): ?>

                        <div class="text-center mx-auto justify-center items-center">

                            <?php if ($number['icon']): ?>
                                <?php echo maxwell_render_icon($number['icon'], 'w-8 h-8 !text-accent text-center mx-auto mb-3'); ?>
                            <?php endif; ?>

                            <?php if ($number['title']): ?>
                                <h3 class="h3-responsive text-3xl text-foreground">
                                    <?php echo esc_html($number['title']); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($number['text']): ?>
                                <div class="text-muted-foreground mt-1">
                                    <?php echo apply_filters('the_content', $number['text']); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>