<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('about_text');
$color_mode = $data['background'] ?? 'dark';
?>
<style>
    .about-text-<?php echo esc_attr($blocks_id); ?>.maxwell-content ul {
        list-style: none;
        padding-left: 0;
    }

    .about-text-<?php echo esc_attr($blocks_id); ?>.maxwell-content ul li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 8px;
        color: hsl(var(--foreground)) !important;
    }

    .about-text-<?php echo esc_attr($blocks_id); ?>.maxwell-content ul li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 2px;
        width: 20px;
        height: 20px;
        color: hsl(var(--accent));
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M21.801 10A10 10 0 1 1 17 3.335'%3E%3C/path%3E%3Cpath d='m9 11 3 3L22 4'%3E%3C/path%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<?php echo _spacing_full('about-text', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="about-text-<?php echo esc_attr($blocks_id); ?> <?php echo _background($color_mode); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Leva kolona - Tekstualni sadržaj -->
            <div>
                <div class="mb-14">
                    <!-- Eyebrow / top title -->
                    <?php if (!empty($data['top_title'])) : ?>
                        <?php _top_title($data['top_title'], 'left'); ?>
                    <?php endif; ?>

                    <!-- Glavni naslov -->
                    <?php if (!empty($data['title'])) : ?>
                        <?php echo _heading($data['title'], 'mb-6'); ?>
                        <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-4"></div>
                    <?php endif; ?>
                </div>

                <!-- Glavni tekst -->
                <?php if (!empty($data['text'])) : ?>
                    <div class="text-muted-foreground font-body leading-relaxed mb-6 maxwell-content">
                        <?php echo apply_filters('the_content', $data['text']); ?>
                    </div>
                <?php endif; ?>

                <!-- Link dugme -->
                <?php if (!empty($data['link'])) : ?>
                    <a class="inline-flex items-center gap-2 text-accent font-body font-medium hover:gap-3 transition-all" 
                       href="<?php echo esc_url($data['link']['url']); ?>" 
                       <?php echo (!empty($data['link']['target']) ? 'target="' . esc_attr($data['link']['target']) . '"' : ''); ?>>
                        <?php echo esc_html($data['link']['title']); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                            <path d="M5 12 h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Desna kolona - Stats / Info box -->
            <?php if (!empty($data['stats'])) : ?>
                <div class="relative bg-background border border-border p-14 text-center luxury-frame">
                    <?php if (!empty($data['stats']['top_label'])) : ?>
                        <p class="eyebrow mb-4"><?php echo $data['stats']['top_label']; ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['stats']['number'])) : ?>
                        <div class="font-heading text-7xl text-foreground mb-2">
                            <?php echo $data['stats']['number']; ?>
                            <?php if (!empty($data['stats']['number_suffix'])) : ?>
                                <span class="text-accent"><?php echo esc_html($data['stats']['number_suffix']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($data['stats']['label'])) : ?>
                        <p class="font-heading text-2xl text-foreground mb-3">
                            <?php echo $data['stats']['label']; ?>
                        </p>
                    <?php endif; ?>
                    
                    <div class="gold-divider mx-auto mb-4"></div>
                    
                    <?php if (!empty($data['stats']['description'])) : ?>
                        <p class="text-muted-foreground font-body text-sm"><?php echo esc_html($data['stats']['description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
</section>