<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('info_box');
?>

<style>
    .info-box-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }
</style>

<section class="py-4 sm:py-6 lg:py-8 border-b border-gray-200 info-box-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if ($data['items']) : ?>
                <?php foreach ($data['items'] as $item) : ?>
                    <div class="flex items-center gap-3">
                        <?php if ($item['icon']) : ?>
                            <div class="w-14 h-14 rounded-xl bg-secondary/10 flex items-center justify-center">
                                    <?php echo maxwell_render_icon($item['icon'], 'w-8 h-8 text-secondary'); ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <?php if ($item['title']) : ?>
                                <p><?php echo $item['title']; ?></p>
                            <?php endif; ?>
                            <?php if ($item['description']) : ?>
                                <p class="font-semibold text-primary"><?php echo $item['description']; ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>