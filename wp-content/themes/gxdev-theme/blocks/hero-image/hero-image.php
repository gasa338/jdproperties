<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_image');
?>

<?php echo _spacing_full('hero-image', $blocks_id, $data['margin'], []); ?>
<section class="relative overflow-hidden bg-background hairline-b <?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="absolute inset-0 bg-pattern-ornament opacity-[0.04] pointer-events-none" aria-hidden="true"></div>
    <div class="absolute -top-40 -right-40 w-[500px] h-[500px] rounded-full bg-blush opacity-60 blur-3xl pointer-events-none" aria-hidden="true"></div>
    <div class="container-luxury mx-auto px-6 sm:px-10 lg:px-16 relative z-10 py-24 sm:py-28 lg:py-32">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7">
                <?php if (!empty($data['top_title'])): ?>
                    <div class="flex items-center gap-3 mb-6"><span class="w-10 h-px bg-accent"></span>
                        <p class="eyebrow"><?php echo esc_html($data['top_title']); ?></p>
                    </div>
                    <?php echo _heading($data['title'], 'mb-8') ?>
                    <div class="ornament-divider mb-8 max-w-md"><svg width="10" height="10" viewBox="0 0 14 14" fill="none">
                            <path d="M7 0L8.5 5.5L14 7L8.5 8.5L7 14L5.5 8.5L0 7L5.5 5.5Z" fill="currentColor"></path>
                        </svg>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['text'])): ?>
                    <div class="text-muted-foreground font-body text-base sm:text-lg max-w-2xl leading-relaxed mb-10"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>

                <?php if (!empty($data['link_1']) || !empty($data['link_2'])): ?>
                    <div class="flex flex-wrap gap-4 items-center">
                        <?php if (!empty($data['link_1'])): ?>
                            <a class="inline-flex items-center gap-3 bg-foreground text-background hover:bg-accent transition-colors duration-500 font-body text-xs tracking-[0.32em] uppercase px-10 py-4" href="<?php echo esc_url($data['link_1']['url']); ?>">
                                <?php echo esc_html($data['link_1']['title']); ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-3.5 h-3.5">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($data['link_2'])): ?>
                            <a class="inline-flex items-center gap-2 text-foreground hover:text-accent transition-colors font-body text-xs tracking-[0.32em] uppercase border-b border-foreground/30 hover:border-accent pb-1" href="<?php echo esc_url($data['link_2']['url']); ?>">
                                <?php echo esc_html($data['link_2']['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="lg:col-span-5 hidden lg:block relative h-[520px]">
                <?php if (!empty($data['image'])): ?>
                    <div class="absolute inset-0 overflow-hidden shadow-luxury">
                        <img src="<?php echo esc_url($data['image']['url']); ?>" alt="<?php echo esc_attr($data['image']['alt']); ?>" class="w-full h-full object-cover">
                        <div class="absolute inset-4 border border-white/30 pointer-events-none"></div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['collection']['top_title']) || !empty($data['collection']['title']) || !empty($data['collection']['text'])): ?>
                    <div class="absolute -bottom-6 -left-6 bg-background border border-border shadow-luxury px-6 py-5">
                        <p class="eyebrow mb-1"><?php echo esc_html($data['collection']['top_title']); ?></p>
                        <p class="font-heading text-lg text-foreground"><?php echo esc_html($data['collection']['title']); ?></p>
                        <div class="text-script italic text-accent text-sm mt-1"><?php echo esc_html($data['collection']['text']); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>