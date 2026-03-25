<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('contact_us');
$contact_data = get_field('contact_options', 'options');
?>

<style>
    .contact-us-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }
</style>

<section id="<?php echo esc_attr($anchor); ?>" class="py-8 sm:py-12 lg:py-18 contact-us-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-4">
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
        <div class="grid md:grid-cols-2 gap-6 max-w-3xl mx-auto text-white">
            <!-- WhatsApp kartica -->
            <a href="https://wa.me/<?php echo $contact_data['whatsapp']; ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="relative overflow-hidden rounded-2xl bg-[#25D366] p-8 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md hover:!text-white">
                <div class="flex flex-col items-center text-center gap-4">
                    <?php if (!empty($contact_data['viber_icon']['subtype'] == 'svg+xml')) : ?>
                        <div class="w-20 h-20 rounded-full flex items-center justify-center">
                            <?php echo maxwell_render_icon($contact_data['viber_icon'], 'w-12 h-12'); ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="text-3xl font-bold mb-2 text-white">WhatsApp</h3>
                        <?php if (!empty($data['whatsapp_text'])) : ?>
                            <div class="mb-4"><?php echo $data['whatsapp_text'] ?></div>
                        <?php endif; ?>
                        <?php if (!empty($contact_data['whatsapp'])) : ?>
                            <span class="text-xl font-bold"><?php echo $contact_data['whatsapp']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>

            <!-- Viber kartica -->
            <a href="viber://chat?number=<?php echo $contact_data['viber']; ?>"
                class="relative overflow-hidden rounded-2xl bg-[#7360F2] p-8 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md hover:!text-white">
                <div class="flex flex-col items-center text-center gap-4">
                    <?php if (!empty($contact_data['whatsapp_icon']['subtype'] == 'svg+xml')) : ?>
                        <div class="w-20 h-20 rounded-full flex items-center justify-center">
                            <?php echo maxwell_render_icon($contact_data['whatsapp_icon'], 'w-12 h-12'); ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 class="text-3xl font-bold mb-2 text-white">Viber</h3>
                        <?php if (!empty($data['viber_text'])) : ?>
                            <div class="mb-4"><?php echo $data['viber_text'] ?></div>
                        <?php endif; ?>
                        <?php if (!empty($contact_data['viber'])) : ?>
                            <span class="text-xl font-bold"><?php echo $contact_data['viber']; ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>