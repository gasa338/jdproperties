<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('about_block');
?>
<?php echo _spacing_full('about-block', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="about-block-<?php echo esc_attr($blocks_id) ?> <?php echo _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6">
        <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
            <?php if (!empty($data['image'])): $image = get_image($data['image']); ?>
                <div class="flex justify-center">
                    <div class="inline-block relative">
                        <img src="<?php echo $image['url']; ?>" class="rounded-lg" alt="<?php echo $image['alt']; ?>" srcset="<?php echo $image['url']; ?>" />

                        <!-- overlay -->
                        <!-- <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/20 to-black/60"></div> -->
                        <!-- frame -->
                        <div class="absolute inset-6 border border-white/20 pointer-events-none"></div>

                    </div>
                </div>
            <?php endif; ?>
            <!-- col End -->

            <div class="md:sticky md:top-24 self-start">
                <?php if ($data['top_title']): ?>
                    <?php echo _top_title($data['top_title'], 'left'); ?>
                <?php endif; ?>



                <?php if (!empty($data['title'])) : ?>
                    <?php echo _heading($data['title'], 'mb-6'); ?>
                    <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-6"></div>
                <?php endif; ?>

                <?php if (!empty($data['text'])): ?>
                    <div class="maxwell-content text-muted-foreground mb-2"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>

                <?php if (!empty($data['items'])): ?>
                    <div class="mb-10 mt-6 grid gap-6 md:grid-cols-2">
                        <?php foreach ($data['items'] as $item): ?>
                            <div class="flex items-center gap-3">
                                <div class="flex w-8 h-8 rounded-lg items-center justify-center">
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
                        <div class="rounded-lg p-6 border border-border bg-white">
                            <div class="grid md:grid-cols-3">
                                <?php $item_count = count($data['static']); ?>
                                <?php foreach ($data['static'] as $key => $stat): ?>
                                    <div class="text-center p-6 md:p-0 <?php echo ($key !== count($data['static']) - 1) ? ' border-accent border-r-0 border-b md:border-r md:border-b-0' : ''; ?>">
                                        <h3 class="h3-responsive"><?php echo esc_html($stat['number']); ?></h3>
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