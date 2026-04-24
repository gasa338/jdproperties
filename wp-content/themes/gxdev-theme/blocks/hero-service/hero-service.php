<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_4');

$bg_image = get_image($data['bg_image']);

$text_color = $data['text_color'] ?? '#ffffff';
$overlay_color = $data['overlay_color'] ?? 'rgba(0, 0, 0, 0.5)';
?>
<style>
    .hero-service-<?php echo esc_attr($blocks_id); ?>,
    .hero-service-<?php echo esc_attr($blocks_id); ?>p,
    .hero-service-<?php echo esc_attr($blocks_id); ?>h2,
    .hero-service-<?php echo esc_attr($blocks_id); ?>span {
        color: <?php echo $text_color ?> !important;
    }

    .overlay-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $overlay_color ?> !important;
    }

    .block-editor__container img {
        height: 100% !important;
    }
</style>

<?php echo _spacing_full('hero-service',$blocks_id,$data['margin'], $data['padding']); ?>
<section class="py-24 bg-gradient-hero relative hero-service-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> ">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl">
            <div class="w-16 h-16 rounded-lg bg-accent flex items-center justify-center mb-8">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-8 h-8 text-primary">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>

                <?php if (!empty($data['top_title'])): ?>
                    <span class="mb-4 block maxwell-top-title"><?php echo esc_html($data['top_title']); ?></span>
                <?php endif; ?>
            </div>
            <?php if (!empty($data['title'])): ?>
                <?php echo _heading($data['title'], 'mb-6'); ?>
            <?php endif; ?>
            <?php if (!empty($data['text'])): ?>
                <div class="text-xl text-muted-foreground mb-10 max-w-2xl"><?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>
            <div class="flex flex-wrap gap-4">
                <?php if (!empty($data['link_1'])): ?>
                    <?php _link_1($data['link_1']); ?>
                <?php endif; ?>
                <?php if (!empty($data['link_2'])): ?>
                    <?php _link_2($data['link_2']); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>