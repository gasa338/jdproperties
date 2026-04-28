<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_image');
?>

<?php echo _spacing_full('hero-image', $blocks_id, $data['margin'], []); ?>

<section class="relative overflow-hidden <?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">

    <div class="grid lg:grid-cols-2 min-h-[720px]">

        <!-- LEFT SIDE (CONTENT) -->
        <div class="bg-primary text-primary-foreground flex items-center">
            <div class="container-luxury px-6 sm:px-10 lg:px-16 py-20 lg:py-28">

                <?php if (!empty($data['top_title'])): ?>
                    <div class="flex items-center gap-3 mb-6">
                        <span class="w-12 h-px bg-accent"></span>
                        <p class="eyebrow text-accent">
                            <?php echo esc_html($data['top_title']); ?>
                        </p>
                    </div>
                <?php endif; ?>

                <?php echo _heading($data['title'], 'mb-8 text-primary-foreground') ?>

                <div class="gold-divider mb-8"></div>

                <?php if (!empty($data['text'])): ?>
                    <div class="text-primary-foreground/80 text-base sm:text-lg max-w-xl leading-relaxed mb-10">
                        <?php echo apply_filters('the_content', $data['text']); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($data['link_1']) || !empty($data['link_2'])): ?>
                    <div class="flex flex-wrap gap-5 items-center mb-12">
                        <?php if (!empty($data['link_1'])): ?>
                            <?php _link_1_backup($data['link_1'], 'text-white') ?>
                        <?php endif; ?>

                        <?php if (!empty($data['link_2'])): ?>
                            <a class="text-xs tracking-[0.32em] uppercase border-b border-primary-foreground/40 hover:border-accent hover:text-accent transition-all pb-1"
                               href="<?php echo esc_url($data['link_2']['url']); ?>">
                                <?php echo esc_html($data['link_2']['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- RIGHT SIDE (IMAGE) -->
        <div class="relative hidden lg:block">

            <?php if (!empty($data['image'])): ?>
                <img 
                    src="<?php echo esc_url($data['image']['url']); ?>" 
                    alt="<?php echo esc_attr($data['image']['alt']); ?>" 
                    class="absolute inset-0 w-full h-full object-cover"
                >
            <?php endif; ?>

            <!-- overlay -->
            <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/20 to-black/60"></div>

            <!-- frame -->
            <div class="absolute inset-6 border border-white/20 pointer-events-none"></div>

            <!-- floating card -->
            <?php if (!empty($data['collection']['title'])): ?>
                <div class="absolute bottom-10 left-10 bg-white/95 backdrop-blur-sm shadow-luxury px-6 py-5 max-w-xs">
                    <p class="eyebrow mb-1 text-accent">
                        <?php echo esc_html($data['collection']['top_title']); ?>
                    </p>
                    <p class="font-heading text-lg text-foreground">
                        <?php echo esc_html($data['collection']['title']); ?>
                    </p>
                    <div class="text-script italic text-accent text-sm mt-1">
                        <?php echo esc_html($data['collection']['text']); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>

    </div>

    <!-- MOBILE IMAGE -->
    <?php if (!empty($data['image'])): ?>
        <div class="lg:hidden relative h-[320px]">
            <img 
                src="<?php echo esc_url($data['image']['url']); ?>" 
                alt="<?php echo esc_attr($data['image']['alt']); ?>" 
                class="w-full h-full object-cover"
            >
        </div>
    <?php endif; ?>

</section>