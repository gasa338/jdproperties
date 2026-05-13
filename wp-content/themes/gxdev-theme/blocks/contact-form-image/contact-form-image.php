<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('contact_form_image');

?>


<?php echo _spacing_full('contact-form-image', $blocks_id, $data['margin'], []); ?>
<section class="relative overflow-hidden  contact-form-image-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">

    <div class="grid lg:grid-cols-[1fr_760px] min-h-auto bg-gradient-luxury">

        <!-- LEFT SIDE -->
        <div class="relative py-12 lg:py-20">
            <div class="relative z-10 px-6 lg:px-16 py-20 lg:py-28">

                <!-- TOP -->
                <div class="max-w-[620px]">

                    <?php if (!empty($data['top_title'])) : ?>
                        <div class="flex items-center gap-4 mb-8">
                            <span class="eyebrow">
                                <?php echo esc_html($data['top_title']); ?>
                            </span>
                            <span class="w-16 h-px bg-accent/40"></span>
                        </div>
                    <?php endif; ?>
                    <?php echo _heading($data['title'], 'mb-8 text-white'); ?>
                    <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-8"></div>
                    <?php if (!empty($data['text'])) : ?>
                        <div class="mb-8 maxwell-content text-white/60">
                            <?php echo apply_filters('the_content', $data['text']); ?>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if (!empty($data['data'])) : ?>

                    <div class="grid sm:grid-cols-2 max-w-[620px]">
                        <div class="space-y-2">
                            <?php foreach ($data['data'] as $item): ?>
                                <div class="flex items-start gap-4">
                                    <?php if (!empty($item['icon'])): ?>
                                        <div class="w-12 h-12 rounded-lg flex items-center justify-center shrink-0">
                                            <?php echo maxwell_render_icon($item['icon'], 'w-12 h-12 rounded-md p-2 text-accent'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="flex-1">

                                        <?php if (!empty($item['title'])) : ?>
                                            <h3 class="text-accent text-lg mb-1">
                                                <?php echo esc_html($item['title']); ?>
                                            </h3>
                                        <?php endif; ?>

                                        <?php if (!empty($item['text'])) : ?>
                                            <div class="text-white/60 maxwell-content">
                                                <?php echo apply_filters('the_content', $item['text']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

        </div>

        <?php if (!empty($data['background_image'])): ?>
            <!-- RIGHT IMAGE -->
            <div class="relative">
                <img
                    src="<?php echo $data['background_image']['url']; ?>"
                    alt="<?php echo $data['background_image']['alt']; ?>"
                    class="absolute inset-0 w-full h-full object-cover">

                <!-- darker overlay -->
                <div class="absolute inset-0 bg-black/20"></div>

                <!-- overlay -->
                <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/20 to-black/60"></div>

                <!-- frame -->
                <div class="absolute inset-6 border border-white/20 pointer-events-none"></div>
            </div>
        <?php endif; ?>

    </div>

    <!-- FLOATING FORM -->
    <div class="absolute inset-y-0 left-0 w-full hidden xl:flex items-center pointer-events-none">

        <div class="container mx-auto px-6 lg:px-10 w-full">

            <div class="max-w-[680px] ml-[28%] pointer-events-auto">

                <div class="bg-card border border-bordershadow-[0_40px_120px_rgba(0,0,0,0.45)] p-10 relative z-20 rounded-lg">

                    <?php if (!empty($data['form_top_title'])): ?>
                        <div class="flex items-center gap-4 mb-6">
                            <span class="w-14 h-px bg-accent/50"></span>
                            <span class="eyebrow text-accent">
                                <?php echo esc_html($data['form_top_title']); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($data['form_title'])): ?>
                        <h3 class="h3-responsive mb-10">
                            <?php echo esc_html($data['form_title']); ?>
                        </h3>
                    <?php endif; ?>

                    <?php echo do_shortcode('[contact-form-7 id="' . $data['choose_form'] . '"]'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MOBILE FORM -->
    <div class="xl:hidden bg-[#F8F5F1] px-6 py-12">

        <div class="max-w-[760px] mx-auto">

            <?php if (!empty($data['form_top_title'])): ?>
                <div class="flex items-center gap-4 mb-6">
                    <span class="w-14 h-px bg-accent/50"></span>
                    <span class="eyebrow text-accent">
                        <?php echo esc_html($data['form_top_title']); ?>
                    </span>
                </div>
            <?php endif; ?>


            <?php if (!empty($data['form_title'])): ?>
                <h3 class="h3-responsive mb-10">
                    <?php echo esc_html($data['form_title']); ?>
                </h3>
            <?php endif; ?>

            <!-- mobile form fields -->
            <?php echo do_shortcode('[contact-form-7 id="' . $data['choose_form'] . '"]'); ?>

        </div>
    </div>
</section>