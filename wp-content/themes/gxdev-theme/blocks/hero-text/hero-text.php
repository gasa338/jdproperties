<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_text');

?>

<?php echo _spacing_full('hero-text',$blocks_id,$data['margin'], $data['padding']); ?>
<section class="relative bg-gradient-navy pt-32 pb-24 overflow-hidden hero-text-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="absolute top-20 right-[10%] w-72 h-72 rounded-full border border-primary-foreground/8 animate-pulse-subtle"></div>
    <div class="absolute bottom-10 left-[5%] w-48 h-48 rounded-full border border-primary-foreground/5"></div>
    <div class="absolute top-1/3 right-[25%] w-3 h-3 rounded-full bg-accent opacity-60"></div>
    <div class="absolute bottom-1/4 right-[15%] w-2 h-2 rounded-full bg-accent opacity-40"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-3xl">
            <?php echo _heading($data['title'], 'font-bold text-primary-foreground leading-[1.08] mb-6'); ?>
            <?php if (!empty($data['text'])): ?>
                <div class="text-lg sm:text-xl text-primary-foreground/65 max-w-2xl mb-10 leading-relaxed"><?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <?php if (!empty($data['link_1']) && !empty($data['link_1'])): ?>
                    <a href="<?php echo esc_url($data['link_1']['url']); ?>" class="inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-7 py-3.5 text-sm font-semibold text-accent-foreground hover:opacity-90 transition-opacity shadow-lg shadow-accent/20 no-underline"><?php echo esc_html($data['link_1']['title']); ?></a>
                <?php endif; ?>
                <?php if (!empty($data['link_2']) && !empty($data['link_2'])): ?>
                    <a href="<?php echo esc_url($data['link_2']['url']); ?>" class="inline-flex items-center justify-center gap-2 rounded-lg border border-primary-foreground/20 px-7 py-3.5 text-sm font-semibold text-primary-foreground hover:bg-primary-foreground/5 transition-colors no-underline"><?php echo esc_html($data['link_2']['title']); ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                        <path d="M5 12h14"></path>
                        <path d="m12 5 7 7-7 7"></path>
                    </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-primary-foreground/30">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down w-4 h-4 animate-bounce">
                <path d="M12 5v14"></path>
                <path d="m19 12-7 7-7-7"></path>
            </svg>
        </div>
    </div>
</section>