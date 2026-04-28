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

<section class="relative overflow-hiddens cta-3-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> hairline-b bg-background">
    <!-- SOFT BLUSH OVERLAY (UMESTO TAMNOG) -->
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(190,173,141,0.08),transparent_70%)]"></div>

    <!-- LUXURY FRAME -->
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute inset-[20px] border border-accent/20"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl mx-auto text-center">

            <?php if (!empty($data['top_title'])): ?>
                <p class="maxwell-top-title mb-3"><?php echo esc_html($data['top_title']); ?></p>
                <div class="gold-divider mx-auto mb-4"></div>
            <?php endif; ?>

            <?php echo _heading($data['title'], 'mb-6'); ?>

            <?php if (!empty($data['text'])) : ?>
                <div class="text-lg sm:text-xl text-muted-foreground mb-10">
                    <?php echo apply_filters('the_content', $data['text']); ?>
                </div>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <?php if (!empty($data['link_1'])): ?>
                    <?php echo _link_1($data['link_1']); ?>
                <?php endif; ?>

                <?php if (!empty($data['link_2'])): ?>
                    <?php echo _link_2($data['link_2'], 'border border-accent/30 hover:bg-accent hover:text-white'); ?>
                <?php endif; ?>
            </div>

            <?php if (!empty($data['bottom_text'])) : ?>
                <p class="text-muted-foreground mt-10"><?php echo $data['bottom_text']; ?></p>
            <?php endif; ?>

        </div>
    </div>
</section>