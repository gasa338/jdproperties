<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('recommended_property');
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
        <div class="mb-12 text-center">
            <?php if (!empty($data['top_title'])) : ?>
                <?php _top_title($data['top_title']); ?>
            <?php endif; ?>
            <?php echo _heading($data['title'], "mb-6" . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
            <?php if (!empty($data['text'])) : ?>
                <div class="text-lg mb-8 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'; ?>">
                    <?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>
        </div>

        <div>
            <div dir="ltr" data-orientation="horizontal" class="w-full tab-container">
                <?php if (!empty($data['tabs'])): ?>
                    <?php if (count($data['tabs']) > 1): ?>
                        <div class="items-center justify-center w-full max-w-fit mx-auto flex p-2 <?php echo $color_mode == 'dark_mode' ? 'bg-white/5' : 'bg-card' ?> border border-border rounded-lg mb-12 tab-buttons">
                            <?php foreach ($data['tabs'] as $key_tab => $tab): ?>
                                <div class="flex-1 ">
                                    <button
                                        type="button"
                                        role="tab"
                                        data-tab-index="<?php echo $key_tab; ?>"
                                        class="tab-button whitespace-nowrap font-medium ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 w-full flex items-center justify-center gap-2 py-3 px-4 rounded-lg transition-all <?php echo $key_tab === 0 ? 'bg-accent text-white' : 'bg-transparent text-muted-foreground'; ?>"
                                        <?php echo $key_tab === 0 ? 'aria-selected="true"' : 'aria-selected="false"'; ?>>
                                        <?php echo maxwell_render_icon($tab['icon'], 'w-4 h-4 text-white'); ?>
                                        <span class="hidden sm:inline"><?php echo esc_html($tab['title']); ?></span>
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($data['tabs'] as $key => $tab): ?>
                        <div
                            data-tab-content="<?php echo $key; ?>"
                            role="tabpanel"
                            class="tab-content mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2"
                            <?php echo $key === 0 ? '' : 'hidden'; ?>>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                                <?php
                                $args = get_property_args($tab, 3);
                                $query = new WP_Query($args);
                                $found_posts = $query->found_posts;

                                // Proveri da li ima postova
                                if ($query->have_posts()) :

                                    while ($query->have_posts()) :
                                        $query->the_post();

                                        get_template_part('template-parts/content', 'property');

                                    endwhile;


                                else:
                                    echo '<p>No properties found.</p>';
                                endif;
                                ?>

                                <?php
                                $post_ids = [];
                                wp_reset_postdata(); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php if (count($data['tabs']) > 1): ?>
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
<?php endif; ?>