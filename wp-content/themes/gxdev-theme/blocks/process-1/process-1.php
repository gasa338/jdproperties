<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('process_1');
$text_color = $data['text_color'] ?? 'inherit';
$background_color = $data['background_color'] ?? "transparent";
$color_mode = $data['color_mode'] ?? 'dark';
$layout = $data['layout'] ?? 'left';
?>

<?php echo _spacing_full('process-1',$blocks_id,$data['margin'], $data['padding']); ?>
<section class="process-1-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6 max-w-7xl grid lg:grid-cols-2 gap-24">
        <!-- RIGHT: sticky panel -->
        <aside class="hidden lg:block self-start">
            <?php if ($data['top_title']): ?>
                <?php _top_title($data['top_title'], 'left') ?>
            <?php endif; ?>
            <?php if (!empty($data['title'])): ?>
                <?php echo _heading($data['title'], 'mt-4 mb-6'); ?>
                <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-8"></div>
            <?php endif; ?>
            <?php if ($data['text']): ?>
                <div class="text-muted-foreground max-w-sm">
                    <?php echo apply_filters('the_content', $data['text']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($data['link']) && $data['use_link'] == 'yes'): ?>
                <div class="mt-6">
                    <?php echo _link_1($data['link']); ?>
                </div>
            <?php endif; ?>
        </aside>
        <?php if ($data['process']): ?>
            <div class="relative">

                <!-- Vertical line -->
                <div class="absolute left-6 top-0 h-full w-px bg-accent"></div>

                <div class="space-y-16">
                    <?php foreach ($data['process'] as $key => $step): ?>
                        <div class="relative flex gap-10">
                            <div class="relative z-10 w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center font-semibold">
                                <?php echo $key + 1; ?>
                            </div>
                            <div class="max-w-md">
                                <?php if ($step['title']): ?>
                                    <h3 class="text-xl font-semibold mb-3">
                                        <?php echo $step['title']; ?>
                                    </h3>
                                <?php endif; ?>

                                <?php if ($step['text']): ?>
                                    <div>
                                        <?php echo apply_filters('the_content', $step['text']); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>