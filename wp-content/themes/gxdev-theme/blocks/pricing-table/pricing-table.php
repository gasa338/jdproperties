<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('pricing_table');
?>
<style>
    @media (max-width: 768px) {
        .mobile-card {
            display: block;
        }

        .pricing-table {
            display: none;
        }
    }

    .pricing-table-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }

    .mobile-box-<?php echo $blocks_id; ?> {
        background-color: <?php echo '#ffffff' . dechex(80) ?? "#ffffffff" ?>;
    }
</style>

<!-- Pricing Table -->
<div class="py-8 sm:py-12 lg:py-18 pricing-table-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="max-w-5xl mx-auto px-4">
        <div class="text-center mb-12">
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
        <!-- Table -->
        <div class="overflow-x-auto md:block hidden rounded-lg overflow-hidden shadow-md">
            <table class="w-full bg-white">
                <thead>
                    <tr class="text-white bg-primary">
                        <th class="py-2 px-6 text-left font-semibold sticky-header"><?php echo esc_html($data['header']['route']); ?></th>
                        <th class="py-2 px-6 text-center font-semibold sticky-header"><?php echo esc_html($data['header']['distance']); ?></th>
                        <th class="py-2 px-6 text-center font-semibold sticky-header"><?php echo esc_html($data['header']['price']); ?></th>
                        <th class="py-2 px-6 text-center font-semibold sticky-header"><?php echo esc_html($data['header']['reserve']); ?></th>
                    </tr>
                </thead>
                <?php if ($data['items']) : ?>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($data['items'] as $item) : ?>

                            <?php if (!empty($item['title'])) : ?>
                                <tr>
                                    <td colspan="4" class="py-2 px-6 font-bold">
                                        <?php if (!empty($item['title'])) : ?>
                                            <div class="inline-flex items-center text-primary">
                                                <?php if (!empty($item['icon'])) : ?>
                                                    <?php if (!empty($item['icon']['subtype'] == 'svg+xml')) : ?>
                                                        <?php echo maxwell_render_svg($item['icon']['url'], 'mr-2 w-4 h-4'); ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if (!empty($item['link'])) : ?>
                                                    <a href="<?php echo $item['link']['url']; ?>" class="text-primary !underline">
                                                        <?php echo esc_html($item['title']); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <?php echo esc_html($item['title']); ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($item['data'])) : ?>
                                <?php foreach ($item['data'] as $route) : ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 text-primary">
                                            <div><?php echo esc_html($route['route']); ?></div>
                                        </td>
                                        <td class="px-6 text-center">
                                            <?php if (!empty($route['distance'])) : ?>
                                                <span>~<?php echo esc_html($route['distance']); ?></span>
                                            <?php endif; ?>
                                            <?php if (!empty($route['time'])) : ?>
                                                <span class="text-sm"> / ~<?php echo esc_html($route['time']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if (!empty($route['price'])): ?>
                                            <td class="px-6 text-center">
                                                <div class="font-bold text-primary"><?php echo esc_html($route['price']); ?></div>
                                            </td>
                                        <?php endif; ?>
                                        <td class="px-6 text-center">
                                            <?php add_inline_contact(); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>

        <?php if (!empty($data['items'])) : ?>
            <div class="visible md:hidden space-y-6">
                <?php foreach ($data['items'] as $item) : ?>
                    <div class="rounded-lg p-6 mobile-box-<?php echo $blocks_id; ?>">
                        <?php if (!empty($item['title'])) : ?>
                            <h3 class="font-bold text-lg mb-4 text-primary">
                                <?php echo maxwell_render_svg($item['icon']['url']); ?>
                                <?php echo esc_html($item['title']); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if (!empty($item['data'])) : ?>
                            <?php foreach ($item['data'] as $route) : ?>
                                <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
                                    <h4 class="font-semibold"><?php echo esc_html($route['route']); ?></h4>
                                    <p class=" mb-2">~<?php echo esc_html($route['distance']); ?> | ~<?php echo esc_html($route['time']); ?></p>
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="font-bold text-lg text-primary"><?php echo esc_html($route['price']); ?></span>
                                    </div>
                                    <?php add_inline_contact(); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>