<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_text');

?>

<?php echo _spacing_full('hero-text', $blocks_id, $data['margin'], []); ?>
<section class="relative bg-primary overflow-hidden hero-text-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="absolute inset-0">
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-gold-glow/8 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full bg-gold-glow/10 blur-3xl -translate-x-1/2 translate-y-1/2"></div>
    </div>
    <div class="container-luxury mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-28 relative z-10 text-center">
        <div style="opacity: 1; filter: blur(0px); transform: none;">
            <?php if (!empty($data['top_title'])): ?>
                <div class="gold-divider mx-auto mb-6"></div>
                <p class="text-gold-light font-body text-sm tracking-[0.25em] uppercase mb-4"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>

            <?php echo _heading($data['title'], 'font-bold text-primary-foreground leading-[1.08] mb-6'); ?>
            
            <?php if (!empty($data['text'])): ?>
                <div class="text-primary-foreground/60 font-body text-lg max-w-3xl mx-auto leading-relaxed"><?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>