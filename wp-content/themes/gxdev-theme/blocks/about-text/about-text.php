<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('about_text');
$color_mode = $data['background'] ?? 'dark';
?>
<style>
    .about-text-<?php echo esc_attr($blocks_id); ?> .maxwell-content ul {
        list-style: none;
        padding-left: 0;
    }

    .about-text-<?php echo esc_attr($blocks_id); ?> .maxwell-content ul li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 8px;
        color: hsl(var(--foreground)) !important;
    }

    .about-text-<?php echo esc_attr($blocks_id); ?> .maxwell-content ul li::before {
        content: "";
        position: absolute;
        left: 0;
        top: 2px;
        width: 20px;
        height: 20px;
        color: inherit !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M21.801 10A10 10 0 1 1 17 3.335'%3E%3C/path%3E%3Cpath d='m9 11 3 3L22 4'%3E%3C/path%3E%3C/svg%3E");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }
</style>
<?php echo _spacing_full('about-text', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="about-text-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                <div class="mb-12 ">
                    <?php if (!empty($data['top_title'])) : ?>
                        <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
                    <?php endif; ?>

                    <?php echo _heading($data['title'], "mb-6" . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
                    <?php if (!empty($data['text'])) : ?>
                        <div class="text-lg mb-4 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'; ?> maxwell-content">
                            <?php echo apply_filters('the_content', $data['text']); ?>
                        </div>
                    <?php endif; ?>


                    <?php if (!empty($data['link'])) : ?>
                        <?php _link_1($data['link']); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (!empty($data['stats'])) : ?>
                <div class="bg-gradient-to-br from-primary to-accent rounded-lg p-12 text-center">
                    <?php if (!empty($data['stats']['number'])) : ?>
                        <div class="font-heading text-6xl font-bold text-primary-foreground mb-4"><?php echo $data['stats']['number']; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($data['stats']['label'])) : ?>
                        <p class="font-heading text-2xl text-primary-foreground mb-2"><?php echo $data['stats']['label']; ?></p>
                        <div class="w-12 h-0.5 bg-primary-foreground/30 mx-auto mb-4"></div>
                    <?php endif; ?>
                    <?php if (!empty($data['stats']['description'])) : ?>
                        <p class="text-primary-foreground/70 font-body"><?php echo $data['stats']['description']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>