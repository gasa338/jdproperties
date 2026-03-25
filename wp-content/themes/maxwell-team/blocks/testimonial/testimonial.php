<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('testimonial');
$color_mode = $data['background'] ?? 'dark';
$card_bg = $data['card_bg'] ?? 'inherit';

$bg_class = '';
switch ($color_mode) {
    case 'dark':
        $bg_class = 'bg-surface';
        break;
    case 'light':
        $bg_class = 'bg-card';
        break;
    case 'dark_mode':
        $bg_class = 'bg-hero';
        break;
    default:
        $bg_class = 'bg-card';
        break;
}

$bg_box = '';

if ($color_mode == 'dark_mode') {
    $bg_box = $card_bg == 'bg_color' ? 'bg-white/5 border border-white/10 hover:border-accent/50' : '';
} else {
    $bg_box = $card_bg == 'inherit' ? '' : 'bg-card border-border hover:border-accent/50';
}
?>

<?php echo _spacing_full('testimonial',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="py-24 <?php echo $bg_class; ?> testimonial-<?php echo esc_attr($blocks_id);
                                                                                                    echo ' ' . _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6">
        <?php if ($data['top_title'] || $data['title'] || $data['text']): ?>
            <div class="max-w-2xl mb-12 text-center mx-auto">
                <?php if ($data['top_title']): ?>
                    <span class="maxwell-top-title mb-4 block text-center"><?php echo esc_html($data['top_title']); ?></span>
                <?php endif; ?>
                <?php echo _heading($data['title'], 'mb-8 ' . esc_attr($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground') . ''); ?>

                <?php if ($data['text']): ?>
                    <div class="text-center <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?> mb-12"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <?php if ($data['testimonials']): ?>
            <div class="max-w-4xl mx-auto">
                <!-- Swiper kontejner -->
                <div class="swiper mySwiperTestimonial z-1">
                    <div class="swiper-wrapper">
                        <?php foreach ($data['testimonials'] as $testimonial): ?>
                            <div class="swiper-slide">
                                <div class="rounded-2xl p-8 md:p-12 relative overflow-hidden <?php echo $color_mode == 'dark_mode' ? 'border border-accent/50 bg-transparent ' : 'bg-card border border-border'; ?>">
                                    <!-- Quote ikonica -->
                                    <div class="absolute top-8 left-8 w-12 h-12 rounded-xl text-accent bg-accent/10 flex items-center justify-center mb-6">
                                        <svg class="w-7 h-7 text-accent " width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="currentColor">
                                            <path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"></path>
                                            <path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"></path>
                                        </svg>
                                    </div>
                                    <!-- Content -->
                                    <div class="pt-8">
                                        <?php if ($testimonial['text']): ?>
                                            <blockquote class="text-2xl md:text-3xl mb-8 <?php echo $color_mode == 'dark_mode' ? "text-white" : "text-foreground-muted"; ?>"><?php echo apply_filters('the_content', $testimonial['text']); ?></blockquote>
                                        <?php endif; ?>
                                        <div class="flex items-center justify-between">
                                            <?php if ($testimonial['name'] || $testimonial['position']): ?>
                                                <div>
                                                    <?php if ($testimonial['name']): ?>
                                                        <div class="font-bold text-xl <?php echo $color_mode == 'dark_mode' ? "text-white" : "text-foreground-muted"; ?>"><?php echo esc_html($testimonial['name']); ?></div>
                                                    <?php endif; ?>
                                                    <?php if ($testimonial['position']): ?>
                                                        <div class="<?php echo $color_mode == 'dark_mode' ? "text-white" : "text-foreground-muted"; ?>"><?php echo esc_html($testimonial['position']); ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <div class="swiper-pagination mt-6"></div>

                    <!-- Navigacija - vraćena na originalno mesto -->
                    <div class="relative">
                        <div class="absolute right-2 -top-14 flex items-center justify-end gap-4 z-10">
                            <div tabindex="0" class="swiper-button-prev-custom">
                                <button class="group inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all duration-300 border border-accent bg-accent/10 hover:bg-accent hover:border-accent h-10 w-10 rounded-full">
                                    <svg class="text-accent group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <path d="m15 18-6-6 6-6"></path>
                                    </svg>
                                </button>
                            </div>
                            <div tabindex="0" class="swiper-button-next-custom">
                                <button class="group inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium transition-all duration-300 border border-accent bg-accent/10 hover:bg-accent hover:border-accent h-10 w-10 rounded-full">
                                    <svg class="text-accent group-hover:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                                        <path d="m9 18 6-6-6-6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<style>
    /* Stil za pagination bulletove */
    .swiper-pagination-bullet {
        opacity: 0.3 !important;
        transition: all 0.3s ease !important;
    }

    .swiper-pagination-bullet-active {
        opacity: 1 !important;
        width: 32px !important;
        border-radius: 9999px !important;
    }
</style>

<script>
    (function() {
        var containers = document.querySelectorAll('.mySwiperTestimonial');

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
            var nextEl = container.querySelector('.swiper-button-next-custom');
            var prevEl = container.querySelector('.swiper-button-prev-custom');

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
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    renderBullet: function(index, className) {
                        // Prvi bullet (aktivni) širi, ostali uski
                        if (index === 0) {
                            return '<span class="' + className + '" style="width: 32px; height: 8px; border-radius: 9999px; margin: 0 4px; background-color: rgb(234, 96, 62);"></span>';
                        } else {
                            return '<span class="' + className + '" style="width: 8px; height: 8px; border-radius: 9999px; opacity: 0.3; margin: 0 4px; background-color: rgb(234, 96, 62);"></span>';
                        }
                    }
                },
                on: {
                    init: function() {
                        console.log('Swiper ' + index + ' inicijalizovan');
                    }
                }
            });

            // Dodaj aktivnu klasu za paginaciju (tvoja originalna logika)
            swiperInstance.on('paginationUpdate', function() {
                var bullets = container.querySelectorAll('.swiper-pagination-bullet');
                bullets.forEach(function(bullet, i) {
                    if (i === swiperInstance.realIndex) {
                        bullet.classList.add('swiper-pagination-bullet-active');
                        bullet.classList.remove('bg-accent/30');
                        bullet.classList.add('bg-accent');
                        bullet.style.width = '32px';
                        bullet.style.opacity = '1';
                    } else {
                        bullet.classList.remove('swiper-pagination-bullet-active');
                        bullet.classList.remove('bg-accent');
                        bullet.classList.add('bg-accent/30');
                        bullet.style.width = '8px';
                        bullet.style.opacity = '0.3';
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