<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('contact_form_2');

$color_mode = $data['background'] ?? 'dark';
?>

<?php echo _spacing_full('contact-form-2', $blocks_id, $data['margin'], $data['padding']); ?>
<section class="py-16 sm:py-20 lg:py-24 cta-2-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> <?php echo esc_attr($data['background']); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 grid-cols-1 gap-12 max-w-7xl mx-auto">
            <div>
                <?php echo _heading($data['title'], 'mb-6 ' . ($color_mode === 'dark_mode' ? ' text-white' : ' text-foreground')); ?>
                <?php if (!empty($data['text'])) : ?>
                    <div class="maxwell-content <?php echo $color_mode === 'dark_mode' ? ' text-white' : ' text-foreground'; ?>">
                        <?php echo apply_filters('the_content', $data['text']); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="rounded-lg p-8 shadow-lg">
                <?php if (!empty($data['form_title'])) : ?>
                    <h2 class="text-3xl mb-6 <?php echo $color_mode === 'dark_mode' ? ' text-white' : ' text-foreground'; ?>"><?php echo esc_html($data['form_title']); ?></h2>
                <?php endif; ?>
                <?php if (!empty($data['form_text'])) : ?>
                    <div class="mb-8 <?php echo $color_mode === 'dark_mode' ? ' text-white/60' : ' text-foreground'; ?>"><?php echo apply_filters('the_content', $data['form_text']); ?></div>
                <?php endif; ?>
                <?php echo do_shortcode('[contact-form-7 id="' . $data['choose_form'] . '"]'); ?>
            </div>
        </div>
    </div>
</section>