<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('contact_form_1');

$color_mode = $data['background'];
?>

<section class="py-16 sm:py-20 lg:py-24 cta-2-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> <?php echo esc_attr($data['background']); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-6 gap-12 max-w-7xl mx-auto">
            <div class="lg:col-span-2">
                <?php echo _heading($data['title'], ' mb-6' . ($color_mode == 'dark_mode' ? ' text-white' : ' text-foreground')); ?>
                <?php if (!empty($data['data'])) : ?>
                    <div class="space-y-6">
                        <?php foreach ($data['data'] as $item): ?>
                            <div class="flex items-start gap-4 px-6 py-4 rounded-xl bg-card border border-border hover:border-accent/50 transition-transform duration-300">
                                <?php if (!empty($item['icon'])): ?>
                                    <div class="w-18 h-18 rounded-xl bg-accent flex items-center justify-center shrink-0">
                                        <?php echo maxwell_render_icon($item['icon'], 'w-16 h-16 rounded-md p-2 text-white'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($item['text'])) : ?>
                                    <div class="maxwell-content <?php echo $color_mode === 'dark_mode' ? ' text-white' : ' text-foreground'; ?>">
                                        <?php echo apply_filters('the_content', $item['text']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="lg:col-span-4 bg-white/5 rounded-2xl p-8 shadow-lg">
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