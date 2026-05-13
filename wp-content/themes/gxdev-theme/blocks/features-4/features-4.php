<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_4');
$background_color = $data['background_color'] ?? '#fff';
$reverse = $data['revers'] ?? 'no';
$color_mode = $data['background'] ?? 'dark';
// dd($data['spacing']);
?>
<?php echo _spacing_full('features-4', $blocks_id, $data['margin'], []); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="relative overflow-hidden features-4-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6 relative z-10" <?php echo _padding($data['padding']); ?>>
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center lg:flex-row-reverse">
            <div class="<?php echo esc_attr($reverse == 'yes' ? 'order-1' : 'order-2'); ?>">
                <div class="relative">
                    <div class="relative overflow-hidden ">
                        <?php if (!empty($data['image'])):  $image = get_image($data['image']); ?>
                            <img class="inset-0 w-full h-full object-cover" src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" srcset="<?php echo esc_attr($image['srcset']); ?>">
                        <?php endif; ?>
                        <!-- overlay -->
                        <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/20 to-black/60"></div>

                        <!-- frame -->
                        <div class="absolute inset-6 border border-white/20 pointer-events-none"></div>
                    </div>
                </div>
            </div>
            <div class="<?php echo esc_attr($reverse == 'yes' ? 'order-2' : 'order-1'); ?>">
                <?php if (!empty($data['top_title'])): ?>
                    <?php _top_title($data['top_title'], 'left') ?>
                <?php endif; ?>
                <?php if (!empty($data['title'])): ?>
                    <?php echo _heading($data['title'], 'mb-6 ' . esc_attr($color_mode == 'dark_mode' ? 'text-white' : '')) ?>
                    <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-8"></div>
                <?php endif; ?>
                <?php if (!empty($data['text'])): ?>
                    <div class="<?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60 [&_li]:!text-white [&_span]:!text-white [&_strong]:!text-white' : 'text-muted-foreground [&_li]:!text-foreground [&_span]:!text-muted-foreground [&_strong]:!text-muted-foreground'); ?> text-lg mb-10 leading-relaxed maxwell-content"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>
                <?php if (!empty($data['features'])): ?>
                    <div class="grid sm:grid-cols-2 gap-6 mb-6">
                        <?php foreach ($data['features'] as $key => $value): ?>
                            <div class="flex gap-4">
                                <div class="w-12 h-12 rounded-lg flex items-center justify-center shrink-0 bg-accent">
                                    <?php echo maxwell_render_svg($value['icon']['url'], 'w-6 h-6 text-white'); ?>
                                </div>
                                <div>
                                    <?php if (!empty($value['title'])): ?>
                                        <h3 class="font-semibold mb-1 text-xl <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white' : ''); ?>"><?php echo esc_html($value['title']); ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($value['text'])): ?>
                                        <p class="<?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?>"><?php echo esc_html($value['text']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>


                <?php if (!empty($data['link_1']) && $data['use_link_1'] == 'yes') : ?>
                    <?php echo _link_1($data['link_1']); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>