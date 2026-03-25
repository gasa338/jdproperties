<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('service_5');
?>

<style>
    .service-5-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }
</style>
<!-- 4. Trust Signals sekcija -->
<section class="py-8 sm:py-12 lg:py-18 service-5-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <?php if (!empty($data['top_title'])) : ?>
                <p class="maxwell-top-title"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>
            <?php if (!empty($data['title'])) : ?>
                <h2 class="h2-responsive mt-2 mb-4"><?php echo $data['title']; ?></h2>
            <?php endif; ?>
            <?php if (!empty($data['description'])) : ?>
                <div class="max-w-2xl mx-auto content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <?php if (!empty($data['items'])) : ?>
                <?php foreach ($data['items'] as $item) : ?>
                    <div class="bg-white p-8 rounded-xl hover:shadow-md">
                        <?php if (!empty($item['icon'])) : ?>
                            <div class="rounded-2xl w-20 h-20 mb-3 bg-secondary-light">
                                <?php if (!empty($item['icon']['subtype'] == 'svg+xml')) {
                                    echo maxwell_render_svg($item['icon']['url'], 'text-secondary rounded-md p-4');
                                } else {
                                ?>
                                    <img src="<?php echo $item['icon']['url']; ?>" alt="<?php echo $item['icon']['alt']; ?>" class="w-20 h-20">
                                <?php

                                } ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($item['title'])) : ?>
                            <h3 class="h3-responsive mb-4"><?php echo $item['title']; ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['description'])) : ?>
                            <div class="content-list-link"><?php echo apply_filters('the_content', $item['description']); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>