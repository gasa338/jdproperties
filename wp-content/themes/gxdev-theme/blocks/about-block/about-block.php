<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('about_block');
$text_color = $data['text_color'] ?? '';
$overlay_color = $data['overlay_color'] ?? '';
$bg_color = $data['background_color'] ?? '';
$border_color = $data['border_color'] ?? '';
$link_color = $data['link_color'] ?? '';

$lists_type = [
    'list-maxwell-dics',
    'list-maxwell-square',
    'list-maxwell-decimal',
    'list-maxwell-circle'
];
?>
<style>
    .about-block-<?php echo esc_attr($blocks_id); ?>,
    .about-block-<?php echo esc_attr($blocks_id); ?>p,
    .about-block-<?php echo esc_attr($blocks_id); ?>h1,
    .about-block-<?php echo esc_attr($blocks_id); ?>h2,
    .about-block-<?php echo esc_attr($blocks_id); ?>h3,
    .about-block-<?php echo esc_attr($blocks_id); ?>span,
    .about-block-<?php echo esc_attr($blocks_id); ?>ul,
    .about-block-<?php echo esc_attr($blocks_id); ?>li {
        color: <?php echo esc_attr($text_color); ?> !important;
    }

    .about-block-<?php echo esc_attr($blocks_id); ?>.overlay {
        background-color: <?php echo esc_attr($overlay_color); ?> !important;
    }

    .about-block-<?php echo esc_attr($blocks_id); ?>.bg-color {
        background-color: <?php echo esc_attr($bg_color); ?> !important;

    }

    .about-block-<?php echo esc_attr($blocks_id); ?>.border-color {
        border-color: <?php echo esc_attr($border_color); ?> !important;
    }
</style>
<?php echo _spacing_full('about-block',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="about-block-<?php echo esc_attr($blocks_id) . ' ' . esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6">
        <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
            <?php if (!empty($data['image'])): $image = get_image($data['image']); ?>
                <div class="flex justify-center">
                    <div class="inline-block rounded-lg border border-primary/20 bg-primary/10 p-6">
                        <img src="<?php echo $image['url']; ?>" class="rounded-lg" alt="<?php echo $image['alt']; ?>" srcset="<?php echo $image['url']; ?>" />
                    </div>
                </div>
            <?php endif; ?>
            <!-- col End -->

            <div class="md:sticky md:top-24 self-start">
                <?php if (!empty($data['top_title'])): ?>
                    <span class="mb-4 block maxwell-top-title"><?php echo esc_html($data['top_title']); ?></span>
                <?php endif; ?>
                <?php echo _heading($data['title']) ?>
                <?php if (!empty($data['text'])): ?>
                    <div class="maxwell-content mb-2"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>

                <?php if (!empty($data['items'])): ?>
                    <div class="mb-10 mt-6 grid gap-6 md:grid-cols-2">
                        <?php foreach ($data['items'] as $item): ?>
                            <div class="flex items-center gap-3">
                                <div class="flex w-8 h-8 rounded-lg items-center justify-center bg-accent/20 text-white">
                                    <?php echo maxwell_render_icon($item['icon'], 'w-4 h-4 text-accent'); ?>
                                </div>
                                <?php if (!empty($item['title'])): ?>
                                    <h3 class="text-lg ">
                                        <?php echo esc_html($item['title']); ?>
                                    </h3>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['static'])): ?>
                    <div class="md:-ms-48 ms-0">
                        <div class="rounded-lg p-6 border border-border-color bg-white dark:bg-default-50">
                            <div class="grid md:grid-cols-3">
                                <?php $item_count = count($data['static']); ?>
                                <?php foreach ($data['static'] as $key => $stat): ?>
                                    <div class="text-center p-6 md:p-0 <?php echo ($key !== count($data['static']) - 1) ? ' border-border-color border-r-0 border-b md:border-r md:border-b-0' : ''; ?>">
                                        <h3 class="text-4xl font-medium"><?php echo esc_html($stat['number']); ?></h3>
                                        <p class="mt-1 text-lg"><?php echo esc_html($stat['text']); ?></p>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>