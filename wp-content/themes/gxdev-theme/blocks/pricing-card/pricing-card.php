<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('pricing_card');
?>

<style>
.pricing-card-<?php echo esc_attr($blocks_id); ?> .overlay {
        background-color: <?php echo esc_attr($overlay_color); ?> !important;
    }
</style>
<section id="<?php echo esc_attr($anchor); ?>" class="py-8 sm:py-12 lg:py-18 pricing-card-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="max-w-6xl mx-auto p-12">
        <div class="text-center mb-12">
            <?php if (!empty($data['top_title'])) : ?>
                <p class="maxwell-top-title mb"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>
            <?php if (!empty($data['title'])) : ?>
                <h2 class="h2-responsive mt-2 mb-4"><?php echo $data['title']; ?></h2>
            <?php endif; ?>
            <?php if (!empty($data['description'])) : ?>
                <div class="max-w-2xl mx-auto content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>

        <?php if (!empty($data['items'])) : ?>
            <div class="grid gap-10 md:grid-cols-3">
                <?php foreach ($data['items'] as $key => $item) : ?>
                    <div class="group bg-secondary/10 rounded-3xl p-8 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md p-4 <?php echo ($key + 1) % 2 == 0 ? "ring-2 ring-secondary/40" : ""; ?>">
                        <?php if (!empty($item['title'])) : ?>
                            <h3 class="text-2xl font-semibold text-[#0F1729] mb-1">
                                <?php echo esc_html($item['title']); ?>
                            </h3>
                        <?php endif; ?>
                        <?php if (!empty($item['region'])) : ?>
                            <p class="text-secondary mb-4"><?php echo esc_html($item['region']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($item['description'])) : ?>
                            <div class="content-list-link"><?php echo apply_filters('the_content', $item['description']); ?></div>
                        <?php endif; ?>

                        <div class="flex items-center justify-between">
                            <?php if (!empty($item['price'])) : ?>
                                <p class="text-3xl font-bold text-primary duration-300 group-hover:text-secundary">
                                    <?php echo esc_html($item['price']); ?> €
                                </p>
                            <?php endif; ?>

                            <?php if ($item['link']) : ?>
                                <?php link_5($item['link']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($data['bottom_text'])) : ?>
            <div class="text-xs text-[#3F454F] text-center mt-4 max-w-3xl mx-auto">
                <?php echo apply_filters('the_content', $data['bottom_text']); ?>
            </div>
        <?php endif; ?>

    </div>
</section>