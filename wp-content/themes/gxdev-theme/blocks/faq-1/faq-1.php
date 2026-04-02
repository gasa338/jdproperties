<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('faq_1');
$color_mode = $data['background'] ?? 'dark';
$layout = $data['layout'] ?? 'default';
?>

<?php echo _spacing_full('faq-1', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="faq-1-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">

        <div class="max-w-2xl mx-auto text-center m-0 p-0">
            <?php if (!empty($data['top_title'])) : ?>
                <p class="maxwell-top-title"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>
            <?php echo _heading($data['title'], 'mb-6' . ($color_mode === 'dark_mode' ? ' text-white' : '')) ?>
            <?php if (!empty($data['description'])) : ?>
                <div class="mx-auto mt-4 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?>"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>

        <?php
        // Determine layout
        $layout = isset($data['layout']) ? $data['layout'] : 'default';

        if ($layout === 'two_column') :
        ?>
            <!-- Two Column Layout -->
            <div class="grid max-w-6xl mx-auto mt-8 gap-6 md:grid-cols-2 md:mt-16 accordion-container-<?php echo $blocks_id; ?>">
                <?php if (!empty($data['items'])) : ?>
                    <?php
                    $items_count = count($data['items']);
                    $half_items = ceil($items_count / 2);
                    $columns = array_chunk($data['items'], $half_items);

                    foreach ($columns as $column_index => $column_items) :
                    ?>
                        <div class="space-y-4">
                            <?php foreach ($column_items as $key => $item) :
                                $original_key = $column_index === 0 ? $key : $half_items + $key;
                            ?>
                                <div class="accordion-item transition-all duration-200 <?php echo $color_mode === 'dark_mode' ? 'bg-white/5' : 'bg-card'; ?> border-b border-accent/5">
                                    <button type="button" class="accordion-button flex items-center justify-between w-full px-4 py-5 sm:p-6">
                                        <div class="flex justify-between items-center w-full">
                                            <h3 class="text-left h4-responsive <?php echo $color_mode === 'dark_mode' ? 'text-white' : ''; ?>"><?php echo $item['question']; ?></h3>
                                            <div class="w-10 h-10 inline-flex items-center justify-center rounded-full border border-accent/50">
                                                <svg class="w-6 h-6 <?php echo $color_mode === 'dark_mode' ? 'text-accent' : ''; ?> transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </div>
                                        </div>
                                    </button>
                                    <div class="hidden accordion-content px-4 pb-5 sm:px-6 sm:pb-6 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?>">
                                        <?php echo apply_filters('the_content', $item['answer']); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php else : ?>
            <!-- Default Layout (Single Column) -->
            <div class="max-w-3xl mx-auto mt-8 space-y-4 md:mt-16 accordion-container-<?php echo $blocks_id; ?>">
                <?php if (!empty($data['items'])) : ?>
                    <?php foreach ($data['items'] as $key => $item) : ?>
                        <div class="accordion-item transition-all duration-200 <?php echo $color_mode === 'dark_mode' ? 'bg-white/5' : 'bg-card'; ?> border-b border-accent/5">
                            <button type="button" class="accordion-button flex items-center justify-between w-full px-4 py-5 sm:p-6">
                                <div class="flex justify-between items-center w-full">
                                    <h3 class="text-left h4-responsive font-semibold <?php echo $color_mode === 'dark_mode' ? 'text-white' : ''; ?>"><?php echo $item['question']; ?></h3>
                                    <div class="w-10 h-10 inline-flex items-center justify-center rounded-full border border-accent/50">
                                        <svg class="w-6 h-6 <?php echo $color_mode === 'dark_mode' ? 'text-accent' : ''; ?> transition-transform duration-200 <?php echo $key === 0 ? 'rotate-180' : ''; ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </button>
                            <div class="<?php echo $key === 0 ? '' : 'hidden'; ?> accordion-content px-4 pb-5 sm:px-6 sm:pb-6 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?>">
                                <?php echo apply_filters('the_content', $item['answer']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($data['bottom_text'])) : ?>
            <div class="text-center mt-9 maxwell-content <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?>">
                <?php echo apply_filters('the_content', $data['bottom_text']); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    const accordionItems = document.querySelectorAll('.accordion-container-<?php echo $blocks_id; ?> .accordion-item');
    accordionItems.forEach((item, index) => {
        const button = item.querySelector('button');
        const content = item.querySelector('.accordion-content');
        const icon = button.querySelector('svg');

        // Dodaj event listener na klik
        button.addEventListener('click', function() {
            const isCurrentlyOpen = !content.classList.contains('hidden');

            // Zatvori sve ostale accordion iteme
            accordionItems.forEach((otherItem, otherIndex) => {
                if (otherIndex !== index) {
                    const otherContent = otherItem.querySelector('.accordion-content');
                    const otherIcon = otherItem.querySelector('svg');
                    otherContent.classList.add('hidden');
                    otherIcon.classList.remove('rotate-180');
                }
            });

            // Toggle trenutni accordion
            if (isCurrentlyOpen) {
                content.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-180');
            } else {
                content.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            }
        });
    });
</script>