<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_3');

$bg_image = get_image($data['bg_image']);

$text_color = $data['text_color'] ?? '#ffffff';
$overlay_color = $data['overlay_color'] ?? 'rgba(0, 0, 0, 0.5)';
?>
<style>
    .hero-3-<?php echo esc_attr($blocks_id); ?>,
    .hero-3-<?php echo esc_attr($blocks_id); ?> p,
    .hero-3-<?php echo esc_attr($blocks_id); ?> h1,
    .hero-3-<?php echo esc_attr($blocks_id); ?> span {
        color: <?php echo $text_color ?> !important;
    }

    .overlay-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $overlay_color ?> !important;
    }
    .block-editor__container img {
        height: 100% !important;
    }
</style>

<section class="hero-3-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> " id="<?php echo esc_attr($anchor); ?>">
    <div class="relative py-16 sm:py-20 lg:py-36">
        <?php if ($bg_image) : ?>
            <!-- Background Image -->
            <img src="<?php echo esc_url($bg_image['url']); ?>"
                alt="<?php echo esc_attr($bg_image['alt'] ?? ''); ?>"
                srcset="<?php echo $bg_image['srcset']; ?>"
                sizes="100vw"
                class="absolute inset-0 w-full !h-full object-cover overflow-hidden" fetchpriority="high">
        <?php endif; ?>

        <!-- Overlay layer - koristi custom klasu -->
        <div class="overlay-<?php echo esc_attr($blocks_id); ?> absolute inset-0 z-0"></div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="relative h-full max-w-2xl flex flex-col justify-end pb-12">
                <?php if ($data['back_link']) : ?>
                    <a class="inline-flex items-center gap-2 mb-4" href="<?php echo $data['back_link']['url']; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-4 h-4">
                            <path d="m12 19-7-7 7-7"></path>
                            <path d="M19 12H5"></path>
                        </svg>
                        <?php echo $data['back_link']['title']; ?>
                    </a>
                <?php endif; ?>
                <?php if ($data['title']) : ?>
                    <h1 class="h1-responsive mb-4"><?php echo $data['title']; ?></h1>
                <?php endif; ?>
                <?php if ($data['description']) : ?>
                    <div class="content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</section>