<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_1');

$bg_image = get_image($data['bg_image']);

$text_color = $data['text_color'] ?? '#fff';
$overlay_color = $data['overlay_color']?? 'rgba(0, 0, 0, 0.5)';
?>
<style>
    .hero-1-<?php echo esc_attr($blocks_id); ?>,
    .hero-1-<?php echo esc_attr($blocks_id); ?> p,
    .hero-1-<?php echo esc_attr($blocks_id); ?> h1,
    .hero-1-<?php echo esc_attr($blocks_id); ?> h2,
    .hero-1-<?php echo esc_attr($blocks_id); ?> h3,
    .hero-1-<?php echo esc_attr($blocks_id); ?> h4,
    .hero-1-<?php echo esc_attr($blocks_id); ?> h5,
    .hero-1-<?php echo esc_attr($blocks_id); ?> h6,
    .hero-1-<?php echo esc_attr($blocks_id); ?> span,
    .hero-1-<?php echo esc_attr($blocks_id); ?> ul,
    .hero-1-<?php echo esc_attr($blocks_id); ?> li {
        color: <?php echo esc_attr($text_color); ?> !important;
    }
    
    .hero-1-<?php echo esc_attr($blocks_id); ?> .overlay {
        background-color: <?php echo esc_attr($overlay_color); ?> !important;
    }
</style>

<section class="hero-1-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="relative py-16 sm:py-20 lg:py-36">    
        <?php if ($bg_image) : ?>
        <!-- Background Image -->
        <img src="<?php echo esc_url($bg_image['url']); ?>" 
             alt="<?php echo esc_attr($bg_image['alt'] ?? ''); ?>"
             srcset="<?php echo $bg_image['srcset']; ?>"
             sizes="100vw"
             class="absolute inset-0 w-full h-full object-cover" fetchpriority="high">
        <?php endif; ?>
        
        <!-- Overlay layer - koristi custom klasu -->
        <div class="overlay absolute inset-0 z-0"></div>
    
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl">
                <?php if (!empty($data['top_title'])): ?>
                    <span class="mb-4 block maxwell-top-title"><?php echo esc_html($data['top_title']); ?></span>
                <?php endif; ?>
                <?php echo _heading($data['title'], 'mb-4'); ?>
                <?php if ($data['description']) : ?>
                    <div class="mb-8 content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
                <?php endif; ?>
                <div class="flex flex-col sm:flex-row gap-4">
                    <?php if ($data['link_1']) : ?>
                        <?php _link_1($data['link_1']); ?>
                    <?php endif; ?>
                    <?php if ($data['link_2']) : ?>
                        <?php _link_2($data['link_2'], 'text-white'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- SVG Shape divider na dnu -->
        <div class="absolute bottom-0 left-0 right-0 w-full overflow-hidden">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0 120L60 110C120 100 240 80 360 70C480 60 600 60 720 65C840 70 960 80 1080 85C1200 90 1320 90 1380 90L1440 90V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="#F2F0EE"></path>
            </svg>
        </div>

    </div>
</section>