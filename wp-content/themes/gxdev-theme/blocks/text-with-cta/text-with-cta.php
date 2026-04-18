<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('text_with_cta');

$two_column = $data['two_column'];
?>

<?php echo _spacing_full('text-with-cta', $blocks_id, $data['margin'], $data['padding']); ?>
<section class="text-with-cta-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']); ?>">
    <div class="container mx-auto px-6">
        <?php if ($two_column == 'yes'): ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div>
                    <?php if ($data['top_title']): ?>
                        <p class="maxwell-top-title mb-3"><?php echo $data['top_title']; ?></p>
                    <?php endif; ?>
                    <?php echo _heading($data['title'], "mb-4"); ?>
                    <?php if (!empty($data['text'])): ?>
                        <div class="text-muted-foreground leading-relaxed mb-8"><?php echo apply_filters('the_content', $data['text']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($data['items'])): ?>
                        <div class="space-y-3 mb-12">
                            <?php foreach ($data['items'] as $item): ?>
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-accent/15 flex items-center justify-center mt-0.5">
                                        <?php if ($data['svg_icon']['subtype'] == 'svg+xml') : ?>
                                            <?php echo maxwell_render_svg($data['svg_icon']['url'], 'w-3.5 h-3.5 text-accent'); ?>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-foreground leading-relaxed"><?php echo $item['text']; ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if (!empty($data['cta_section'])): ?>
                        <div class="rounded-2xl bg-primary p-8 sm:p-10">
                            <?php if (!empty($data['cta_section']['title'])): ?>
                                <h3 class="font-display text-xl sm:text-2xl font-bold text-primary-foreground mb-3"><?php echo $data['cta_section']['title']; ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($data['cta_section']['text'])): ?>
                                <div class="text-primary-foreground/65 leading-relaxed mb-6"><?php echo apply_filters('the_content', $data['cta_section']['text']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($data['cta_section']['link'])): ?>
                                <a href="<?php echo $data['cta_section']['link']['url']; ?>" class="inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-7 py-3.5 text-sm font-semibold text-accent-foreground hover:opacity-90 transition-opacity shadow-lg shadow-accent/20 no-underline"><?php echo $data['cta_section']['link']['title']; ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="max-w-3xl mx-auto">
                <?php if ($data['top_title']): ?>
                    <p class="maxwell-top-title mb-3"><?php echo $data['top_title']; ?></p>
                <?php endif; ?>
                <?php echo _heading($data['title'], "mb-4"); ?>
                <?php if (!empty($data['text'])): ?>
                    <div class="text-muted-foreground leading-relaxed mb-8"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>
                <?php if (!empty($data['items'])): ?>
                    <div class="space-y-3 mb-12">
                        <?php foreach ($data['items'] as $item): ?>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-accent/15 flex items-center justify-center mt-0.5">
                                    <?php if ($data['svg_icon']['subtype'] == 'svg+xml') : ?>
                                        <?php echo maxwell_render_svg($data['svg_icon']['url'], 'w-3.5 h-3.5 text-accent'); ?>
                                    <?php endif; ?>
                                </div>
                                <p class="text-foreground leading-relaxed"><?php echo $item['text']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($data['cta_section'])): ?>
                    <div class="rounded-2xl bg-primary p-8 sm:p-10">
                        <?php if (!empty($data['cta_section']['title'])): ?>
                            <h3 class="font-display text-xl sm:text-2xl font-bold text-primary-foreground mb-3"><?php echo $data['cta_section']['title']; ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($data['cta_section']['text'])): ?>
                            <div class="text-primary-foreground/65 leading-relaxed mb-6"><?php echo apply_filters('the_content', $data['cta_section']['text']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($data['cta_section']['link'])): ?>
                            <a href="<?php echo $data['cta_section']['link']['url']; ?>" class="inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-7 py-3.5 text-sm font-semibold text-accent-foreground hover:opacity-90 transition-opacity shadow-lg shadow-accent/20 no-underline"><?php echo $data['cta_section']['link']['title']; ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</section>