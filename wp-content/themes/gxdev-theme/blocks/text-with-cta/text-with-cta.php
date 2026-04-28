<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('text_with_cta');

$two_column = $data['two_column'];
?>

<?php echo _spacing_full('text-with-cta', $blocks_id, $data['margin'], $data['padding']); ?>
<section class="text-with-cta-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']); ?>">
    <div class="container mx-auto px-6 py-24">

        <?php if ($two_column == 'yes'): ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-20 items-center">

                <!-- TEXT -->
                <div>
                    <?php if ($data['top_title']): ?>
                        <?php _top_title($data['top_title'], 'left'); ?>
                    <?php endif; ?>

                    <?php echo _heading($data['title'], "mb-6 font-heading tracking-tight"); ?>

                    <?php if (!empty($data['text'])): ?>
                        <div class="text-muted-foreground leading-relaxed mb-10 max-w-xl">
                            <?php echo apply_filters('the_content', $data['text']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($data['items'])): ?>
                        <div class="space-y-4 mb-12">
                            <?php foreach ($data['items'] as $item): ?>
                                <div class="flex items-start gap-4">

                                    <!-- ICON -->
                                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-accent/10 flex items-center justify-center mt-1">
                                        <?php if ($data['svg_icon']['subtype'] == 'svg+xml') : ?>
                                            <?php echo maxwell_render_svg($data['svg_icon']['url'], 'w-3.5 h-3.5 text-accent'); ?>
                                        <?php endif; ?>
                                    </div>

                                    <!-- TEXT -->
                                    <p class="text-foreground leading-relaxed">
                                        <?php echo $item['text']; ?>
                                    </p>

                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- CTA -->
                <div>
                    <?php if (!empty($data['cta_section'])): ?>

                        <div class="rounded-lg bg-background-soft border border-border p-10">

                            <?php if (!empty($data['cta_section']['title'])): ?>
                                <h3 class="font-heading text-2xl font-semibold text-foreground mb-4">
                                    <?php echo $data['cta_section']['title']; ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($data['cta_section']['text'])): ?>
                                <div class="text-muted-foreground leading-relaxed mb-8">
                                    <?php echo apply_filters('the_content', $data['cta_section']['text']); ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($data['cta_section']['link'])): ?>

                                <a href="<?php echo $data['cta_section']['link']['url']; ?>"
                                    class="inline-flex items-center gap-2 text-sm font-medium text-foreground hover:text-accent transition-colors no-underline">

                                    <?php echo $data['cta_section']['link']['title']; ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2">
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
            <!-- može ostati isto uz iste izmene -->
        <?php endif; ?>

    </div>
</section>