<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_case_study');
$text_color = $data['text_color'] ?? 'inherit';
$background_color = $data['background_color'] ?? "transparent";
?>
<style>
    /* Koristite istu klasu kao u HTML-u - cta-2- */
    .hero-case-study-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo esc_attr($background_color); ?> !important;
        color: <?php echo esc_attr($text_color); ?> !important;
    }
</style>

<?php echo _spacing_full('hero-case-study',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="py-24 bg-gradient-hero relative hero-case-study-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> ">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl">
            <?php if (!empty($data['back_link'])): ?>
            <a class="inline-flex items-center gap-2 text-primary mb-8 hover:underline" href="<?php echo esc_url($data['back_link']['url']); ?>"><?php echo esc_html($data['back_link']['title']); ?> →</a>
            <?php endif; ?>
            <?php if (!empty($data['top_title'])): ?>
            <span class="maxwell-top-title mb-4 block"><?php echo esc_html($data['top_title']); ?></span>
            <?php endif; ?>
            
            <?php echo _heading($data['title'], 'mb-6'); ?>
            
            <?php if (!empty($data['text'])): ?>
            <p class="text-xl text-muted-foreground mb-10 max-w-2xl"><?php echo apply_filters('the_content', $data['text']); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>