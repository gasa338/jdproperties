<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('popular_1');
?>

<style>
    .popular-1-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }
</style>

<!-- Popular Tours Section - Version 1 -->
<section class="py-8 sm:py-12 lg:py-18 popular-1-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <?php if ($data['top_title']) : ?>
                <p class="maxwell-top-title"><?php echo esc_html($data['top_title']); ?></p>
            <?php endif; ?>

            <?php if ($data['title']) : ?>
                <h2 class="h2-responsive mt-2 mb-4"><?php echo esc_html($data['title']); ?></h2>
            <?php endif; ?>

            <?php if ($data['description']) : ?>
                <div class="max-w-2xl mx-auto  content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if ($data['items']) : ?>
                <?php foreach ($data['items'] as $item) : ?>
                    <div class="tour-card bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                        <div class="h-56 relative overflow-hidden">
                            <?php if ($item['image']) : ?>
                                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr($item['image']['alt']); ?>" class="w-full h-full object-cover">
                            <?php endif; ?>
                            <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/80 via-black/50 to-transparent">
                                <h3 class="h3-responsive text-white mb-1"><?php echo esc_html($item['name']); ?></h3>
                                <p class="text-white/80 text-sm"><?php echo esc_html($item['tag']); ?></p>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="mb-6 content-list-link"><?php echo apply_filters('the_content', $item['description']); ?></div>
                            <div class="flex justify-between items-center">
                                <?php if ($item['price']) : ?>
                                    <div class="flex">
                                        <span class="font-bold text-xl"><?php echo esc_html($item['price']); ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($item['link']) : ?>
                                    <?php link_inline_arrow($item['link']); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="text-center mt-12">
            <?php if ($data['link']) : ?>
                <?php link_inline_arrow($data['link']); ?>
            <?php endif; ?>
        </div>
    </div>
</section>