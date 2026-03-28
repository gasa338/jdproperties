<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_number');
$color_mode = $data['background'] ?? 'dark';
$card_bg = $data['card_bg'] ?? 'dark';

$bg_class = '';
switch ($color_mode) {
    case 'dark':
        $bg_class = 'bg-surface';
        break;
    case 'light':
        $bg_class = 'bg-card';
        break;
    case 'dark_mode':
        $bg_class = 'bg-hero';
        break;
    default:
        $bg_class = 'bg-card';
        break;
}

$bg_box = '';

if ($color_mode == 'dark_mode') {
    $bg_box = $card_bg == 'bg_color' ? 'bg-white/5 border border-white/10 hover:border-accent/50' : '';
} else {
    $bg_box = $card_bg == 'inherit' ? '' : 'bg-card border-border hover:border-accent/50';
}
?>
<?php echo _spacing_full('feature-number',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="py-24 <?php echo $bg_class; ?> feature-number-<?php echo esc_attr($blocks_id);
                                                                                                    echo ' ' . _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">

    <div class="container mx-auto px-6">
        <div>
            <?php if ($data['top_title']): ?>
                <span class="maxwell-top-title mb-4 block text-center"><?php echo esc_html($data['top_title']); ?></span>
            <?php endif; ?>
            <?php echo _heading($data['title'], 'mb-8 ' . esc_attr($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground') . ''); ?>

            <?php if ($data['text']): ?>
                <div class="text-center <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/80' : 'text-muted-foreground'); ?> mb-12"><?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php if ($data['numbers']): ?>
                    <?php foreach ($data['numbers'] as $number): ?>
                        <div class="group text-center p-8 rounded-2xl <?php echo esc_attr($bg_box); ?> transition-colors">
                            <?php if ($number['icon']): ?>
                                <div class="w-12 h-12 rounded-2xl flex items-center justify-center mx-auto mb-6 bg-secondary transition-all">
                                    <?php echo maxwell_render_icon($number['icon'], 'w-4.5 h-4.5 !text-accent'); ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($number['title']): ?>
                                <div class="text-4xl font-bold mb-3 text-accent"><?php echo esc_html($number['title']); ?></div>
                            <?php endif; ?>
                            <?php if ($number['text']): ?>
                                <div class="maxwell-content <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/80' : 'text-muted-foreground'); ?>"><?php echo apply_filters('the_content', $number['text']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>