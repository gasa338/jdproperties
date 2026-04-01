<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('faq_2');
$color_mode = $data['background'] ?? 'dark';
$layout = $data['layout'] ?? 'default';
?>

<?php echo _spacing_full('faq-2', $blocks_id, $data['margin'], $data['padding']); ?>
<div class="space-y-3 faq-2-<?php echo $blocks_id; ?>">

    <?php if (!empty($data['items'])) : ?>
        <?php foreach ($data['items'] as $index => $faq) : ?>
            <details
                class="faq-item border border-border rounded-xl px-6 bg-card group"
                <?php echo $index === 0 ? 'open' : ''; ?>>
                <summary class="flex items-center justify-between py-4 cursor-pointer font-heading text-base font-semibold text-foreground list-none">

                    <?php echo esc_html($faq['question']); ?>

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="flex-shrink-0 transition-transform duration-200 group-open:rotate-180">
                        <path d="m6 9 6 6 6-6" />
                    </svg>

                </summary>

                <div class="pb-4 pt-0">
                    <div class="font-body text-sm text-muted-foreground leading-relaxed">
                        <?php echo apply_filters('the_content', $faq['answer']); ?>
                    </div>
                </div>
            </details>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    const items = document.querySelectorAll('.faq-container-<?php echo $blocks_id; ?> .faq-item');

    items.forEach((item) => {
        item.addEventListener('toggle', function() {

            if (item.open) {
                items.forEach((other) => {
                    if (other !== item) {
                        other.removeAttribute('open');
                    }
                });
            }

        });
    });
</script>