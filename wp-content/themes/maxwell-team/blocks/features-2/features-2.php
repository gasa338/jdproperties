<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$revers = get_field('revers', $block['id']);
$data = get_field('features_2');
$background_color = $data['background_color'] ?? '#fff';
$revers = $data['reverse'] == 'yes' ? true : false;
?>
<style>
    .features-2-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo esc_attr($background_color); ?> !important;
    }
</style>

<section class="py-8 sm:py-12 lg:py-18 features-2-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="px-4 mx-auto max-w-7xl">
        <div class="grid items-center grid-cols-1 gap-12 lg:grid-cols-2">
            <div class="<?php echo $revers ? 'lg:order-2' : 'lg:order-1'; ?>">
                <?php if (!empty($data['top_title'])) : ?>
                    <p class="maxwell-top-title"><?php echo $data['top_title']; ?></p>
                <?php endif; ?>

                <?php if (!empty($data['title'])) : ?>
                    <h2 class="h2-responsive mt-4"><?php echo $data['title']; ?></h2>
                <?php endif; ?>

                <?php if (!empty($data['content'])) : ?>
                    <div class="my-4  content-list-link"><?php echo apply_filters('the_content', $data['content']); ?></div>
                <?php endif; ?>

                <?php if (!empty($data['link'])) : ?>
                    <?php link_3($data['link']); ?>
                <?php endif; ?>
            </div>

            <?php if (!empty($data['image'])) : ?>
                <div class="<?php echo $revers ? 'lg:order-1' : 'lg:order-2'; ?>">
                    <img class="w-full rounded-xl overflow-hidden shadow-sm hover:shadow-md transition" src="<?php echo $data['image']['url']; ?>" alt="<?php echo $data['image']['alt']; ?>" />
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>