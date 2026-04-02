<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('service_4');
$revers = $data['reverse'] == 'yes' ? true : false;
?>
<style>
    .service-4-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }
</style>
<section id="<?php echo esc_attr($anchor); ?>" class="service-4 py-8 sm:py-12 lg:py-18 service-4-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <?php if (!empty($data['main_top_title'])) : ?>
                <p class="maxwell-top-title"><?php echo $data['main_top_title']; ?></p>
            <?php endif; ?>
            <?php if (!empty($data['main_title'])) : ?>
                <h2 class="h2-responsive mt-2 mb-4"><?php echo $data['main_title']; ?></h2>
            <?php endif; ?>
            <?php if (!empty($data['main_description'])) : ?>
                <div class="max-w-2xl mx-auto content-list-link"><?php echo apply_filters('the_content', $data['main_description']); ?></div>
            <?php endif; ?>
        </div>

        <div class="space-y-16">
            <div class="grid lg:grid-cols-2 gap-8 items-center">
                <div class="<?php echo $revers ? 'lg:order-2' : 'lg:order-1'; ?>">
                    <div class="relative rounded-2xl overflow-hidden group">
                        <?php if ($data['image']) : ?>
                            <img src="<?php echo $data['image']['url']; ?>" alt="<?php echo $data['image']['alt']; ?>" class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                        <?php endif; ?>
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4">
                            <div class="w-14 h-14 rounded-xl bg-secondary flex items-center justify-center">
                                <?php if (!empty($data['icon']['subtype'] == 'svg+xml')) : ?>
                                    <?php echo maxwell_render_svg($data['icon']['url'], 'w-7 h-7 text-primary'); ?>
                                <?php else : ?>
                                    <img src="<?php echo $data['icon']['url']; ?>" alt="<?php echo $data['icon']['alt']; ?>" class="w-7 h-7">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="absolute top-4 right-4">
                            <?php if (!empty($data['price'])) : ?>
                                <span class="px-4 py-2 bg-secondary rounded-full text-primary font-bold"><?php echo $data['price']; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="<?php echo $revers ? 'lg:order-1' : 'lg:order-2'; ?>">
                    <?php if (!empty($data['title'])) : ?>
                        <h3 class="text-2xl md:text-3xl font-bold mb-4"><?php echo $data['title']; ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($data['description'])) : ?>
                        <div class="mb-6"><?php echo $data['description']; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($data['includes'])) : ?>
                        <div class="mb-6">
                            <?php if (!empty($data['include_text'])) : ?>
                                <h4 class="font-semibold mb-3"><?php echo $data['include_text']; ?></h4>
                            <?php endif; ?>
                            <ul class="grid sm:grid-cols-2 gap-2">
                                <?php foreach ($data['includes'] as $include) : ?>
                                    <li class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-5 h-5 text-secondary">
                                            <path d="M20 6 9 17l-5-5"></path>
                                        </svg>
                                        <span class="text-primary"><?php echo $include['include']; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="mb-6">
                        <?php if (!empty($data['popular_text'])) : ?>
                            <h4 class="font-semibold mb-3"><?php echo $data['popular_text']; ?></h4>
                        <?php endif; ?>
                        <?php if (!empty($data['populars'])) : ?>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($data['populars'] as $popular) : ?>
                                    <span class="px-2 py-1 bg-gray-50 rounded-full"><?php echo $popular['popular']; ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($data['link'])) : ?>
                        <?php link_1($data['link'], 'max-w-fit !text-white') ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>