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

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($data['tabs'] as $key => $tab): ?>
                            <div>
                                <a class="group block bg-card rounded-lg overflow-hidden border border-border card-hover" href="/nekretnina/1">
                                    <div class="relative aspect-[4/3] bg-muted overflow-hidden">
                                        <div class="absolute inset-0 bg-gradient-to-br from-muted to-cream-dark flex items-center justify-center">
                                            <img src="http://jdproperties.test/wp-content/uploads/2026/03/category-apartments.jpg" alt="Property" class="w-full h-full object-cover">
                                        </div>
                                        <div class="image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="absolute top-3 left-3 flex gap-2">
                                            <div class="inline-flex items-center rounded-full px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent hover:bg-primary/80 bg-accent text-accent-foreground border-0 font-body text-xs">Prodaja</div>
                                            <div class="inline-flex items-center rounded-full px-2.5 py-0.5 font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent hover:bg-primary/80 bg-primary text-primary-foreground border-0 font-body text-xs">Novo</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-center gap-6 py-3 bg-secondary border-b border-border text-sm font-body font-semibold text-foreground">
                                        <div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-maximize w-4 h-4 text-accent">
                                                <path d="M8 3H5a2 2 0 0 0-2 2v3"></path>
                                                <path d="M21 8V5a2 2 0 0 0-2-2h-3"></path>
                                                <path d="M3 16v3a2 2 0 0 0 2 2h3"></path>
                                                <path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>
                                            </svg><span>92 m²</span></div>
                                        <div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bed-double w-4 h-4 text-accent">
                                                <path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"></path>
                                                <path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"></path>
                                                <path d="M12 4v6"></path>
                                                <path d="M2 18h20"></path>
                                            </svg><span>3 sobe</span></div>
                                        <div class="flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layers w-4 h-4 text-accent">
                                                <path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"></path>
                                                <path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"></path>
                                                <path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"></path>
                                            </svg><span>4./6 sprat</span></div>
                                    </div>
                                    <div class="p-5 space-y-3"><span class="text-xs font-body font-medium text-accent uppercase tracking-wider">Stan</span>
                                        <h3 class="font-heading text-lg font-semibold text-foreground leading-tight line-clamp-2 group-hover:text-accent transition-colors">Luksuzni trosoban stan na Vračaru</h3>
                                        <div class="flex items-center gap-1.5 text-muted-foreground"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-3.5 h-3.5">
                                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                                <circle cx="12" cy="10" r="3"></circle>
                                            </svg><span class="text-sm font-body">Vračar, Krunska ulica</span></div>
                                        <div class="pt-3 border-t border-border"><span class="font-heading text-xl font-bold text-foreground">185.000 EUR</span></div>
                                    </div>
                                </a>
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