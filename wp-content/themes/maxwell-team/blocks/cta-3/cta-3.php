<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('cta_3');
$color_mode = $data['background'];
?>
<?php echo _spacing_full('cta-3', $blocks_id, $data['margin'], $data['padding']); ?>

<section class="relative overflow-hidden cta-3-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?> ">

    <?php if ($color_mode == "dark_mode") : ?>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, rgb(255, 255, 255) 1px, transparent 0px); background-size: 32px 32px;"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-accent/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-primary/20 rounded-full blur-3xl"></div>
    <?php endif; ?>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl mx-auto text-center">
            <?php echo _heading($data['title'], 'mb-6' . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
            <?php if (!empty($data['text'])) : ?>
                <div class="text-lg sm:text-xl <?php echo ($color_mode === 'dark_mode' ? ' text-white/60' : ' text-muted-foreground'); ?> mb-10"><?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <?php if (!empty($data['link_1'])): ?>
                    <?php echo _link_1($data['link_1']); ?>
                <?php endif; ?>
                <?php if (!empty($data['link_2'])): ?>
                    <?php
                    if ($color_mode === 'dark_mode') :
                        echo _link_6($data['link_2']);
                    else :
                        echo _link_2($data['link_2']);
                    endif;
                    ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($data['bottom_text'])) : ?>
                <p class="<?php echo ($color_mode === 'dark_mode' ? ' text-white/60' : ' text-muted-foreground'); ?> mt-10"><?php echo $data['bottom_text']; ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>