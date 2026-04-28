<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_home');
?>

<?php echo _spacing_full('hero-image', $blocks_id, $data['margin'], []); ?>
<section class="relative overflow-hidden <?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">

    <style>
        @media (min-width: 1024px) {
            .hero-left-panel {
                clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);
            }
        }
    </style>

    <!-- DESNA STRANA (SLIKA) -->
    <?php if (!empty($data['image'])): ?>
        <div class="relative lg:absolute lg:inset-y-0 lg:right-0 w-full h-[55vw] lg:h-full">
            <img src="<?php echo esc_url($data['image']['url']); ?>" 
                 alt="<?php echo esc_attr($data['image']['alt']); ?>" 
                 class="w-full h-full object-cover">
        </div>
    <?php endif; ?>

    <!-- LEVA TAMNA POVRŠINA -->
    <div class="hero-left-panel relative z-10 bg-primary text-primary-foreground w-full lg:w-[38%] lg:min-h-[85vh] flex items-center">
        <div class="px-6 sm:px-10 lg:px-16 py-14 lg:py-28 w-full">
            
            <div class="max-w-sm">
                <?php if (!empty($data['top_title'])): ?>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-10 h-px bg-accent"></span>
                        <p class="eyebrow"><?php echo esc_html($data['top_title']); ?></p>
                    </div>
                    <?php echo _heading($data['title'], 'mb-8 text-primary-foreground') ?>
                    <div class="ornament-divider mb-8 max-w-md text-accent">
                        <svg width="10" height="10" viewBox="0 0 14 14" fill="none">
                            <path d="M7 0L8.5 5.5L14 7L8.5 8.5L7 14L5.5 8.5L0 7L5.5 5.5Z" fill="currentColor"></path>
                        </svg>
                    </div>
                <?php endif; ?>

                <?php if (!empty($data['text'])): ?>
                    <div class="text-primary-foreground/80 font-body text-base leading-relaxed mb-10">
                        <?php echo apply_filters('the_content', $data['text']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($data['link_1']) || !empty($data['link_2'])): ?>
                    <div class="flex flex-wrap gap-4 items-center">
                        <?php if (!empty($data['link_1'])): ?>
                            <?php _link_1($data['link_1']) ?>
                        <?php endif; ?>
                        <?php if (!empty($data['link_2'])): ?>
                            <a class="inline-flex items-center gap-2 text-primary-foreground hover:text-accent transition-colors font-body text-xs tracking-[0.32em] uppercase border-b border-primary-foreground/30 hover:border-accent pb-1"
                               href="<?php echo esc_url($data['link_2']['url']); ?>">
                                <?php echo esc_html($data['link_2']['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</section>