<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('horizontal_tab');
$text_color = $data['text_color'] ?? 'inherit';
$color_mode = $data['background'] ?? 'dark';
$reverse = $data['reverse'] ?? false;
?>
<style>
    /* Koristite istu klasu kao u HTML-u - cta-2- */
    .horizontal-tab-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo esc_attr($background_color); ?> !important;
        color: <?php echo esc_attr($text_color); ?> !important;
    }

    /* Dodatni CSS za bolje iskustvo */
    .tab-button {
        transition: all 0.2s ease;
    }

    .tab-button:hover:not(.bg-accent) {
        background-color: rgba(var(--accent-rgb), 0.1);
    }

    .tab-content {
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<?php echo _spacing_full('horizontal-tab', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="horizontal-tab-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?> ">
    <div class="container mx-auto px-6">
        <div class="max-w-2xl mb-12 text-center mx-auto">
            <?php if (!empty($data['top_title'])): ?>
                <span class="maxwell-top-title mb-4 block"><?php echo esc_html($data['top_title']); ?></span>
            <?php endif; ?>

            <?php echo _heading($data['title'], '' . $color_mode == "dark_mode" ? "text-white" : ""); ?>
        </div>
        <div>

            <div dir="ltr" data-orientation="horizontal" class="w-full tab-container">
                <?php if (!empty($data['tabs'])): ?>
                    <div class="items-center justify-center w-full max-w-fit mx-auto flex p-2 <?php echo $color_mode == 'dark_mode' ? 'bg-white/5' : 'bg-card' ?> border border-border rounded-xl mb-12 tab-buttons">
                        <?php foreach ($data['tabs'] as $key_tab => $tab): ?>
                            <div class="flex-1 ">
                                <button
                                    type="button"
                                    role="tab"
                                    data-tab-index="<?php echo $key_tab; ?>"
                                    class="tab-button whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl transition-all <?php echo $key_tab === 0 ? 'bg-accent text-white' : 'bg-transparent text-muted-foreground'; ?>"
                                    <?php echo $key_tab === 0 ? 'aria-selected="true"' : 'aria-selected="false"'; ?>>
                                    <?php echo maxwell_render_icon($tab['icon'], 'w-4 h-4 text-white'); ?>
                                    <span class="hidden sm:inline"><?php echo esc_html($tab['title']); ?></span>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php foreach ($data['tabs'] as $key => $tab): ?>
                        <div
                            data-tab-content="<?php echo $key; ?>"
                            role="tabpanel"
                            class="tab-content mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            <?php echo $key === 0 ? '' : 'hidden'; ?>>
                            <!-- start content -->
                            <?php if (!empty($tab['variable_content'])): ?>
                                <?php if ($tab['variable_content'][0]['acf_fc_layout'] == 'grid_element'):
                                    $content = $tab['variable_content'][0];
                                ?>

                                    <div class="max-w-4xl mx-auto">
                                        <div class="text-center mb-12">
                                            <?php if (!empty($content['title'])): ?>
                                                <h3 class=" text-3xl font-bold mb-4 <?php echo $key === 0 ? 'text-primary' : ''; ?> <?php echo $color_mode == "dark_mode" ? "!text-white" : ""; ?>"><?php echo $content['title']; ?></h3>
                                            <?php endif; ?>
                                            <?php if (!empty($content['content'])): ?>
                                                <div class="text-lg <?php echo $color_mode == "dark_mode" ? "text-white/60" : "text-muted-foreground"; ?>  max-w-2xl mx-auto"><?php echo apply_filters('the_content', $content['content']); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if (!empty($content['items'])): ?>
                                            <div class="grid md:grid-cols-2 gap-6">
                                                <?php foreach ($content['items'] as $item): ?>
                                                    <div class="p-6 rounded-xl bg-white/5 border border-accent/5 hover:border-accent/50 transition-colors">
                                                        <div class="flex items-start gap-4">
                                                            <div class="w-8 h-8 rounded-xl bg-accent flex items-center justify-center shrink-0">
                                                                <?php echo maxwell_render_icon($item['icon'], 'w-4 h-4 text-white'); ?>
                                                            </div>
                                                            <?php if (!empty($item['text'])): ?>
                                                                <div class="<?php echo $color_mode == "dark_mode" ? "text-white/60" : ""; ?>">
                                                                    <?php echo apply_filters('the_content', $item['text']); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($tab['variable_content'][0]['acf_fc_layout'] == 'image_text'):
                                    $data = $tab['variable_content'][0];
                                ?>
                                    <div class="max-w-4xl mx-auto">
                                        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center lg:flex-row-reverse">
                                            <div class="<?php echo esc_attr($reverse == 'yes' ? 'order-1' : 'order-2'); ?>">
                                                <div class="relative">
                                                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border border-border/50">
                                                        <?php if (!empty($data['image'])):  $image = get_image($data['image']); ?>
                                                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" srcset="<?php echo esc_attr($image['srcset']); ?>" class="w-full h-auto object-cover aspect-square">
                                                        <?php endif; ?>
                                                        <div class="absolute inset-0 bg-gradient-to-t from-primary/20 via-transparent to-transparent"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="<?php echo esc_attr($reverse == 'yes' ? 'order-2' : 'order-1'); ?>">
                                                <h3 class=" text-4xl md:text-5xl font-bold mb-6 <?php echo $color_mode == "dark_mode" ? "text-white" : ""; ?>"><?php echo esc_html($data['title']); ?></h3>
                                                <?php if (!empty($data['text'])): ?>
                                                    <div class="<?php echo esc_attr($color_mode == 'dark' ? 'text-white/60' : 'text-muted-foreground'); ?> text-lg mb-10 maxwell-content"><?php echo apply_filters('the_content', $data['text']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <!-- end content -->

                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>



<script>
    (function() {
        const tabContainer = document.querySelector('.tab-container');
        if (!tabContainer) return;

        const tabButtons = tabContainer.querySelectorAll('.tab-button');
        const tabContents = tabContainer.querySelectorAll('.tab-content');

        // Funkcija za promenu taba
        function switchTab(tabIndex) {
            // Ukloni active klase sa svih tab dugmadi
            tabButtons.forEach(button => {
                button.classList.remove('bg-accent', 'text-white');
                button.classList.add('bg-transparent', 'text-muted-foreground');
                button.setAttribute('aria-selected', 'false');
            });

            // Sakrij sve tab sadržaje
            tabContents.forEach(content => {
                content.hidden = true;
            });

            // Postavi aktivni tab
            const activeButton = tabContainer.querySelector(`.tab-button[data-tab-index="${tabIndex}"]`);
            const activeContent = tabContainer.querySelector(`.tab-content[data-tab-content="${tabIndex}"]`);

            if (activeButton) {
                activeButton.classList.remove('bg-transparent', 'text-muted-foreground');
                activeButton.classList.add('bg-accent', 'text-white');
                activeButton.setAttribute('aria-selected', 'true');
            }

            if (activeContent) {
                activeContent.hidden = false;
            }
        }

        // Dodaj event listener za svako tab dugme
        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabIndex = this.getAttribute('data-tab-index');
                switchTab(tabIndex);
            });

            // Dodaj keyboard navigation
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    const tabIndex = this.getAttribute('data-tab-index');
                    switchTab(tabIndex);
                }

                // Arrow key navigation
                if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                    e.preventDefault();
                    const currentIndex = parseInt(this.getAttribute('data-tab-index'));
                    let newIndex;

                    if (e.key === 'ArrowRight') {
                        newIndex = (currentIndex + 1) % tabButtons.length;
                    } else {
                        newIndex = (currentIndex - 1 + tabButtons.length) % tabButtons.length;
                    }

                    switchTab(newIndex);
                    tabButtons[newIndex].focus();
                }
            });
        });

        // Inicijalno postavi prvi tab kao aktivan (ako već nije)
        if (tabButtons.length > 0) {
            const firstActive = Array.from(tabButtons).find(btn => btn.classList.contains('bg-accent'));
            if (!firstActive) {
                switchTab(0);
            }
        }
    })();
</script>