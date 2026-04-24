<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_slider');
// dd($data);
$bg_image = isset($data['bg_image']) ? get_image($data['bg_image']) : 0;
?>
<style>
    .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        transition: all 0.3s ease;
    }

    .swiper-pagination-bullet-active {
        width: 32px !important;
        background-color: rgb(59 130 246) !important;
        /* primarna boja */
    }
</style>

<?php echo _spacing_full('feature-slider', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="<?php echo $bg_class; ?> feature-slider-<?php echo esc_attr($blocks_id);
                                                                                                echo ' ' . _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6">
        <?php if (!empty($data['sliders'])): ?>
            <div class="relative">
                <div class="relative mb-12 flex flex-col md:flex-row justify-between items-start gap-8">
                    <div class="max-w-4xl md: max-w-md">
                        <?php if (!empty($data['top_title'])): ?>
                            <span class="maxwell-top-title mb-4 block"><?php echo esc_html($data['top_title']); ?></span>
                        <?php endif; ?>
                        <?php echo _heading($data['title'], 'mb-3'); ?>


                        <?php if (!empty($data['text'])) : ?>
                            <div class="text-lg text-muted-foreground mb-5"><?php echo apply_filters('the_content', $data['text']); ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Navigacioni dugmici IZNAD swiper-a -->
                    <div class="flex absolute bottom-0 right-0">
                        <div tabindex="0">
                            <button class="feature-slider-prev inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-all duration-300  border border-border bg-transparent hover:bg-accent/10 text-foreground hover:bg-accent/5 hover:border-accent/50 h-10 w-10 rounded-full
                            ">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                    <path d="m15 18-6-6 6-6"></path>
                                </svg>
                            </button>
                        </div>
                        <div tabindex="0">
                            <button class="feature-slider-next inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-all duration-300  border border-border bg-transparent hover:bg-accent/10 text-foreground hover:bg-accent/5 hover:border-accent/50 h-10 w-10 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="">
                                    <path d="m9 18 6-6-6-6"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="feature-slider-swiper swiper">
                    <div class="swiper-wrapper">
                        <?php $counter = 1; ?>
                        <?php foreach ($data['sliders'] as $slide): ?>
                            <div class="swiper-slide">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 min-h-[400px]">
                                    <div class="lg:col-span-2 bg-card rounded-lg p-8 md:p-12 border border-border relative overflow-hidden left-side">
                                        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                                        <div class="relative z-10">
                                            <div class="flex items-center gap-4 mb-6">
                                                <div class="w-12 h-12 rounded-lg bg-accent flex items-center justify-center bg-accent group-hover:bg-accent/30 transition-colors">
                                                    <svg class="text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up w-6 h-6 text-primary">
                                                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                                        <polyline points="16 7 22 7 22 13"></polyline>
                                                    </svg>
                                                </div>
                                                <span class="text-sm text-primary"><?php echo $counter; ?> / <?php echo count($data['sliders']); ?></span>
                                            </div>

                                            <div>
                                                <?php if (!empty($slide['title'])): ?>
                                                    <h3 class="text-xl md:text-2xl font-bold mb-4"><?php echo $slide['title']; ?></h3>
                                                <?php endif; ?>
                                                <?php if (!empty($slide['text'])): ?>
                                                    <div class="text-lg text-primary mb-8 max-w-xl leading-relaxed maxwell-content"><?php echo apply_filters('the_content', $slide['text']); ?></div>
                                                <?php endif; ?>


                                                <div class="flex items-center gap-4">
                                                    <div class="self-start">
                                                    <?php if (!empty($slide['link'])): ?>
                                                        <a href="<?php echo $slide['link']['url']; ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-accent text-white rounded-lg font-semibold hover:bg-accent/90 transition-colors">
                                                            <?php echo $slide['link']['title']; ?>
                                                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                                                                <path d="M5 12h14"></path>
                                                                <path d="m12 5 7 7-7 7"></path>
                                                            </svg>
                                                        </a>
                                                    <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-border bg-transparent text-foreground hover:bg-secondary hover:border-primary/50 h-10 w-10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-left w-5 h-5">
                                                                <path d="m15 18-6-6 6-6"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div>
                                                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-border bg-transparent text-foreground hover:bg-secondary hover:border-primary/50 h-10 w-10 rounded-full"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right w-5 h-5">
                                                                <path d="m9 18 6-6-6-6"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    <div class="flex gap-2 ml-4">
                                                        <button class="h-2 rounded-full transition-colors bg-primary w-8" style="width: 32px;"></button><button class="h-2 rounded-full transition-colors bg-primary/30 hover:bg-primary/50 w-2" style="width: 8px; transform: none;"></button><button class="h-2 rounded-full transition-colors bg-primary/30 hover:bg-primary/50 w-2" style="width: 8px;"></button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-row md:flex-col gap-6 right-side">
                                        <div class="flex-1 bg-card rounded-lg p-6 border border-border flex flex-col justify-center">
                                            <?php if (!empty($slide['left_top']['icon'])): ?>
                                                <div class="w-10 h-10 rounded-lg bg-accent flex items-center justify-center mb-4">
                                                    <?php echo maxwell_render_icon($slide['left_top']['icon'], 'w-5 h-5 text-white'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($slide['left_top']['number'])): ?>
                                                <div class=" text-4xl font-bold text-accent mb-2"><?php echo $slide['left_top']['number']; ?></div>
                                            <?php endif; ?>
                                            <?php if (!empty($slide['left_top']['text'])): ?>
                                                <div class="text-foreground"><?php echo $slide['left_top']['text']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 bg-hero rounded-lg p-6 flex flex-col justify-center text-white">
                                            <?php if (!empty($slide['left_bottom']['icon'])): ?>
                                                <div class="w-10 h-10 rounded-lg bg-primary-foreground/20 flex items-center justify-center mb-4">
                                                    <?php echo maxwell_render_icon($slide['left_bottom']['icon'], 'w-5 h-5 text-white'); ?>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($slide['left_bottom']['number'])): ?>
                                                <div class=" text-4xl font-bold mb-2"><?php echo $slide['left_bottom']['number']; ?></div>
                                            <?php endif; ?>
                                            <?php if (!empty($slide['left_bottom']['text'])): ?>
                                                <div class=""><?php echo $slide['left_bottom']['text']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php $counter++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<script>
    (function() {
        // Selektuj sve Swiper kontejnere unutar feature-slider blokova
        var containers = document.querySelectorAll('.feature-slider-swiper');

        function initSwiper(container, index) {
            if (!container) return false;

            if (typeof Swiper === 'undefined') {
                console.error('Swiper nije učitana!');
                return false;
            }

            // Proveri da li već postoji swiper instance
            if (container.swiper) {
                return true;
            }

            // Pronađi navigacione elemente za ovaj konkretni slider
            var parent = container.closest('.relative');
            var nextEl = parent ? parent.querySelector('.feature-slider-next') : null;
            var prevEl = parent ? parent.querySelector('.feature-slider-prev') : null;

            var swiperInstance = new Swiper(container, {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                grabCursor: true,
                speed: 600,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: nextEl,
                    prevEl: prevEl,
                },
                on: {
                    init: function() {
                        console.log('Swiper ' + index + ' inicijalizovan');
                    }
                }
            });

            // Dodaj aktivnu klasu za paginaciju
            swiperInstance.on('paginationUpdate', function() {
                var bullets = paginationEl.querySelectorAll('.swiper-pagination-bullet');
                bullets.forEach(function(bullet, i) {
                    if (i === swiperInstance.realIndex) {
                        bullet.classList.add('swiper-pagination-bullet-active');
                        bullet.classList.remove('bg-primary/30');
                        bullet.classList.add('bg-primary');
                        bullet.style.width = '32px';
                    } else {
                        bullet.classList.remove('swiper-pagination-bullet-active');
                        bullet.classList.remove('bg-primary');
                        bullet.classList.add('bg-primary/30');
                        bullet.style.width = '8px';
                    }
                });
            });

            container.swiper = swiperInstance;
            return true;
        }

        function tryInitAll(attempt = 0) {
            if (attempt > 10) {
                console.log('Prekinuto nakon 10 pokušaja za sve Swipere');
                return;
            }

            var allInit = true;
            containers.forEach(function(container, index) {
                if (!initSwiper(container, index)) {
                    allInit = false;
                }
            });

            if (!allInit) {
                setTimeout(function() {
                    tryInitAll(attempt + 1);
                }, 300);
            } else {
                console.log('Svi swiperi su uspešno inicijalizovani');
            }
        }

        // Čekaj da se Swiper biblioteka učita
        function waitForSwiper() {
            if (typeof Swiper !== 'undefined') {
                // Čekaj da se DOM potpuno učita
                if (document.readyState === 'complete') {
                    setTimeout(tryInitAll, 100);
                } else {
                    window.addEventListener('load', function() {
                        setTimeout(tryInitAll, 100);
                    });
                }
            } else {
                setTimeout(waitForSwiper, 100);
            }
        }

        // Pokreni inicijalizaciju
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', waitForSwiper);
        } else {
            waitForSwiper();
        }
    })();
</script>