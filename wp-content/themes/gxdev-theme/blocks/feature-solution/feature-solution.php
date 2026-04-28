<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_solution');

$color_mode = $data['background'] ?? 'dark';
$layout = $data['layout'] ?? 'left';
$box_title = $data['box_title'] ?? 'small';

$grid_columns = $data['column_number'] ?? 'two';
$grid_classes = '';
switch ($grid_columns) {
    case 'two':
        $grid_classes = 'md:grid-cols-2 gap-8';
        break;
    case 'three':
        $grid_classes = 'md:grid-cols-3 gap-8';
        break;
    case 'four':
        $grid_classes = 'md:grid-cols-4 gap-4';
        break;
    case 'five':
        $grid_classes = 'md:grid-cols-5 gap-4';
        break;
    default:
        $grid_classes = 'md:grid-cols-2 gap-8';
        break;
}
?>
<?php echo _spacing_full('feature-solution', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="relative overflow-hidden feature-solution-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6 relative z-10">
        <div>
            <div class="<?php echo _title_position($data['title_position'], $data['title_size']); ?>">
                <?php if ($data['top_title']): ?>
                    <?php echo _top_title($data['top_title'], 'center'); ?>
                <?php endif; ?>
                <?php if (!empty($data['title'])): ?>
                    <?php echo _heading($data['title'], 'mb-4 ' . ($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground')); ?>
                    <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-8"></div>
                <?php endif; ?>
                <?php if ($data['text']): ?>
                    <div class="<?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?> mb-8"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>
            </div>

            <?php if ($data['solutions']): ?>
                <div class="grid <?php echo $grid_classes; ?>">
                    <?php foreach ($data['solutions'] as $solution): ?>
                        <div class="group p-8 rounded-lg <?php echo esc_attr($color_mode == 'dark_mode' ? 'bg-white/5 border border-white/10 hover:border-accent/50' : 'bg-card border-border hover:border-accent/50'); ?> <?php echo $layout == 'center' ? " flex flex-col items-center justify-center text-center " : "" ?> border transition-colors group">
                            <?php if ($solution['icon']): ?>
                                <div class="rounded-lg flex items-center justify-center mb-6 ">
                                    <?php echo maxwell_render_svg($solution['icon']['url'], 'w-14 h-14 !text-accent'); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($solution['title']): ?>
                                <h3 class=" font-bold <?php echo $box_title == "small" ? 'text-xl' : 'text-3xl'; ?> <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white' : 'text-gradient'); ?> mb-3">
                                    <?php echo esc_html($solution['title']); ?>
                                </h3>
                            <?php endif; ?>
                            <?php if ($solution['text']): ?>
                                <div class="<?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?> mb-4">
                                    <?php echo apply_filters('the_content', $solution['text']); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ($solution['link']): ?>
                                <a href="<?php echo esc_url($solution['link']['url']); ?>" class="inline-flex items-center gap-1 text-accent font-medium no-underline" title="<?php echo "read more about " . esc_attr($solution['title']); ?>">
                                    <?php echo esc_html($solution['link']['title']); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($data['bottom_text']): ?>
            <div class="<?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/80' : 'text-muted-foreground'); ?> text-center mx-auto mt-8 max-w-3xl"><?php echo apply_filters('the_content', $data['bottom_text']); ?></div>
        <?php endif; ?>
    </div>
</section>