<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('newsletter');
$color_mode = $data['background'] ?? 'dark';
?>

<?php echo _spacing_full('newsletter', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="border-t border-border newsletter-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container-luxury mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="text-center lg:text-left">
                <?php echo _heading($data['title'], 'mb-2'); ?>
                <?php if ($data['text']) : ?>
                    <div class="font-body text-muted-foreground max-w-md"><?php echo $data['text']; ?></div>
                <?php endif; ?>
            </div>
            <?php echo do_shortcode('[mc4wp_form id="' . $data['choose_newsletter'] . '"]'); ?>
        </div>
    </div>
</section>