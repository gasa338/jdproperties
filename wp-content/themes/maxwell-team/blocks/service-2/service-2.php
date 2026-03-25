<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('service_2');
$right = $data['right'];
?>
<style>
    .service-2-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }
</style>
<section class="service-2 py-8 sm:py-12 lg:py-18 service-2-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <?php if (!empty($data['top_title'])) { ?>
                <p class="maxwell-top-title"><?php echo $data['top_title']; ?></p>
            <?php } ?>
            <?php if (!empty($data['title'])) { ?>
                <h2 class="h2-responsive mt-2 mb-4"><?php echo $data['title']; ?></h2>
            <?php } ?>
            <?php if (!empty($data['description'])) { ?>
                <div class="max-w-2xl mx-auto content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php } ?>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <?php if (!empty($data['left'])) : ?>
                <div class="grid grid-cols-2 gap-6">
                    <?php foreach ($data['left'] as $item) : ?>
                        <div class="relative rounded-2xl overflow-hidden h-64 group hover:shadow-xl transition-all duration-300 [&_.overlay]:opacity-80 [&_.overlay]:group-hover:opacity-90 [&_.text-content]:z-20">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent z-10 transition-opacity duration-300"></div>
                            <!-- Background slika -->
                            <img
                                src="<?php echo $item['image']['url']; ?>"
                                alt="<?php echo $item['image']['alt']; ?>"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="text-content relative z-10 px-2 py-6 md:px-6 text-white flex flex-col justify-between h-full transition-opacity duration-300">
                                <div class="inline-flex item-center">
                                    <?php if (!empty($item['icon']['subtype'] == 'svg+xml')) {
                                        echo maxwell_render_svg($item['icon']['url'], 'w-8 h-8 md:w-6 md:h-6 mr-2 text-white/90');
                                    } ?>
                                    <h3 class="text-xl text-white font-bold mb-2"><?php echo $item['title']; ?></h3>
                                </div>

                                <?php if (!empty($item['link'])) : ?>
                                    <?php link_inline_arrow($item['link'], 'font-semibold text-white/90'); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Right Column - Details -->
            <div class="flex flex-col justify-center">
                <?php if (!empty($right['title'])) : ?>
                    <h3 class="text-xl md:text-3xl mb-6"><?php echo $right['title']; ?></h3>
                <?php endif; ?>
                <?php if (!empty($right['description'])) : ?>
                    <div class="mb-8 content-list-link"><?php echo apply_filters('the_content', $right['description']); ?></div>
                <?php endif; ?>

                <div class="space-y-6">
                    <?php if (!empty($right['items'])) : ?>
                        <?php foreach ($right['items'] as $item) : ?>
                            <div class="flex items-center">
                                <?php if (!empty($item['icon'])) : ?>
                                    <div class="flex-shrink-0 w-14 h-14 bg-button/10 rounded-xl flex items-center justify-center mr-4">
                                        <?php if (!empty($item['icon']['subtype'] == 'svg+xml')) {
                                            echo maxwell_render_svg($item['icon']['url'], 'w-6 h-6 text-primary');
                                        } ?>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <?php if (!empty($item['title'])) : ?>
                                        <h4 class="h4-responsive mt-2 mb-1"><?php echo $item['title']; ?></h4>
                                    <?php endif; ?>
                                    <?php if (!empty($item['description'])) : ?>
                                        <div class="content-list-link"><?php echo apply_filters('the_content', $item['description']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="inline-block max-w-max mt-8">
                    <?php if (!empty($right['link'])) : ?>
                        <?php link_1($right['link']); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>