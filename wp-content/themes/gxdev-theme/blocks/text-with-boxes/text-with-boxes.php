<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('text_with_boxes');
$color_mode = $data['background'];
?>
<?php echo _spacing_full('text-with-boxes', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="relative overflow-hidden text-with-boxes-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-6xl mx-auto">
            <?php if (!empty($data['top_title']) && $data['use_top_title'] == 'yes'): ?>
                <span class="maxwell-top-title mb-4 block "><?php echo esc_html($data['top_title']); ?></span>
            <?php endif; ?>
            <?php echo _heading($data['title'], 'mb-8 ' . ($color_mode == 'dark_mode' ? 'text-white' : '')) ?>
            <?php if (!empty($data['content'])): ?>
                <?php foreach ($data['content'] as $content): ?>
                    <?php if ($content['acf_fc_layout'] == 'text' && !empty($content['text'])): ?>
                        <div class="text-xl mb-10 max-w-4xl maxwell-content <?php echo $color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'; ?>">
                            <?php echo apply_filters('the_content', $content['text']) ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($content['acf_fc_layout'] == 'items' && !empty($content['items'])): ?>
                        <div class="grid md:grid-cols-3 gap-6 mb-4">
                            <?php foreach ($content['items'] as $item): ?>
                                <div class="group flex items-center gap-4 px-5 py-2 rounded-xl <?php echo $color_mode == 'dark_mode' ? 'bg-white/5' : 'bg-card'; ?> border border-border hover:border-accent/50 transition-all duration-300">
                                    <?php if ($item['icon']) : ?>
                                        <div class="w-8 h-8 rounded-xl flex items-center justify-center shrink-0">
                                            <?php echo maxwell_render_icon($item['icon'], 'w-6 h-6 text-accent shrink-0'); ?>
                                        </div><?php endif; ?>
                                        <div class="flex-1">
                                    <?php if (!empty($item['title'])): ?>
                                        <h3 class="text-lg <?php echo $color_mode == 'dark_mode' ? 'text-white' : 'text-foreground'; ?> font-semibold mb-1.5"><?php echo esc_html($item['title']); ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($item['text'])): ?>
                                        <p class="<?php echo $color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'; ?>"><?php echo esc_html($item['text']); ?></p>
                                    <?php endif; ?>
                                        </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>