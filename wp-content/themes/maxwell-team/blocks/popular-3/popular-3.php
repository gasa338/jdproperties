<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('popular_3');
?>
<style>
    .popular-3-<?php echo esc_attr($blocks_id); ?> {
        background-color: <?php echo $data['background_color'] ?? "#ffffff" ?>;
    }

    /* Stilovi za swiper */
    .tours-swiper {
        padding: 10px 0 40px 0;
        width: 100%;
    }

    .tours-swiper .swiper-slide {
        height: auto;
    }

    .tours-swiper .swiper-button-next,
    .tours-swiper .swiper-button-prev {
        color: #000;
        background: rgba(255, 255, 255, 0.8);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .tours-swiper .swiper-button-next:after,
    .tours-swiper .swiper-button-prev:after {
        font-size: 18px;
        font-weight: bold;
    }

    .tours-swiper .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background: #ccc;
        opacity: 0.7;
    }

    .tours-swiper .swiper-pagination-bullet-active {
        background: #000;
        opacity: 1;
    }

    /* Responsive styles */
    @media (max-width: 767px) {
        .tours-swiper .swiper-slide {
            opacity: 1;
            transition: opacity 0.3s;
        }

        .tours-swiper .swiper-slide-active {
            opacity: 1;
        }

        /* Hide navigation on mobile if you prefer */
        .tours-swiper .swiper-button-next,
        .tours-swiper .swiper-button-prev {
            display: none;
        }
    }
</style>
<!-- Popular Tours Section -->
<section class="py-8 sm:py-12 lg:py-18 popular-3-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" id="<?php echo esc_attr($anchor); ?>">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <?php if (!empty($data['top_title'])) : ?>
                <p class="maxwell-top-title"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>
            <?php if (!empty($data['title'])) : ?>
                <h2 class="h2-responsive mt-2 mb-4"><?php echo $data['title']; ?></h2>
            <?php endif; ?>
            <?php if (!empty($data['description'])) : ?>
                <div class="max-w-2xl mx-auto  content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>

        <!-- Swiper container -->
        <div class="swiper tours-swiper">
            <div class="swiper-wrapper">
                <?php if (!empty($data['items'])) : ?>
                    <?php foreach ($data['items'] as $item) : ?>
                        <div class="swiper-slide">
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition h-full">
                                <div class="h-48 relative overflow-hidden">
                                    <img src="<?php echo $item['image']['url']; ?>"
                                        class="w-full h-full object-cover"
                                        alt="<?php echo $item['image']['url']; ?>">

                                    <!-- Tag - gore desno -->
                                    <?php if (!empty($item['tag'])): ?>
                                        <div class="absolute top-4 right-4">
                                            <a href="<?php echo $item['tag']['url']; ?>"
                                                class="text-sm text-white bg-black bg-opacity-50 px-2 py-1 rounded-xl"
                                                aria-label="View all <?php echo $item['tag']['title']; ?> tours">
                                                <?php echo $item['tag']['title']; ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Naslov - dole levo -->
                                    <?php if (!empty($item['title'])): ?>
                                        <div class="absolute bottom-0 left-0 w-full">
                                            <h3 class="font-semibold text-lg text-white bg-dark bg-opacity-20 backdrop-blur-md px-3 py-2">
                                                <?php echo $item['title']; ?>
                                            </h3>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <?php if (!empty($item['time'])): ?>
                                            <span class="inline-flex items-center text-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4 mr-2">
                                                    <path fill="currentColor" d="M256 0a256 256 0 1 1 0 512 256 256 0 1 1 0-512zM232 120l0 136c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2 280 120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
                                                </svg>
                                                <span class="font-semibild"><?php echo $item['time']; ?></span>
                                            </span>
                                        <?php endif; ?>
                                        <?php if (!empty($item['price'])): ?>
                                            <span class="text-primary font-semibold"><?php echo $item['price']; ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($item['description'])): ?>
                                        <div class="mb-4 content-list-link"><?php echo apply_filters('the_content', $item['description']); ?></div>
                                    <?php endif; ?>
                                    <?php if (!empty($item['link'])): ?>
                                        <a href="<?php echo esc_url($item['link']['url']); ?>"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-semibold ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border-2 border-primary bg-transparent hover:!text-white hover:bg-primary h-9 rounded-md px-4">
                                            <?php echo esc_html($item['link']['title']); ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-3 h-3">
                                                <path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-105.4 105.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
                                            </svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="p-2">
                    <path fill="currentColor" d="M566.6 342.6C579.1 330.1 579.1 309.8 566.6 297.3L406.6 137.3C394.1 124.8 373.8 124.8 361.3 137.3C348.8 149.8 348.8 170.1 361.3 182.6L466.7 288L96 288C78.3 288 64 302.3 64 320C64 337.7 78.3 352 96 352L466.7 352L361.3 457.4C348.8 469.9 348.8 490.2 361.3 502.7C373.8 515.2 394.1 515.2 406.6 502.7L566.6 342.7z" />
                </svg>
            </div>
            <div class="swiper-button-prev">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="p-2">
                    <path fill="currentColor" d="M73.4 297.4C60.9 309.9 60.9 330.2 73.4 342.7L233.4 502.7C245.9 515.2 266.2 515.2 278.7 502.7C291.2 490.2 291.2 469.9 278.7 457.4L173.3 352L544 352C561.7 352 576 337.7 576 320C576 302.3 561.7 288 544 288L173.3 288L278.7 182.6C291.2 170.1 291.2 149.8 278.7 137.3C266.2 124.8 245.9 124.8 233.4 137.3L73.4 297.3z" />
                </svg>
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination "></div>
        </div>

        <?php if (!empty($data['link'])): ?>
            <div class="flex justify-center items-center mt-2">
                <div class="text-center max-w-[200px] mx-auto">
                    <?php link_1($data['link']); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
(function() {
    // Selektuj sve Swiper kontejnere unutar popular-3 blokova
    var containers = document.querySelectorAll('.tours-swiper');

    function initSwiper(container) {
        if (!container) return;

        if (typeof Swiper === 'undefined') {
            return false;
        }

        if (container.swiper) {
            return true;
        }

        var swiperInstance = new Swiper(container, {
            slidesPerView: 1.2,
            spaceBetween: 16,
            loop: true,
            grabCursor: true,
            pagination: {
                el: container.querySelector('.swiper-pagination'),
                clickable: false,
            },
            navigation: {
                nextEl: container.querySelector('.swiper-button-next'),
                prevEl: container.querySelector('.swiper-button-prev'),
            },
            breakpoints: {
                768: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 4, spaceBetween: 24 }
            },
            on: {
                init: function() {
                }
            }
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
        containers.forEach(function(container) {
            if (!initSwiper(container)) {
                allInit = false;
            }
        });

        if (!allInit) {
            setTimeout(function() {
                tryInitAll(attempt + 1);
            }, 200);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(tryInitAll, 100);
        });
    } else {
        setTimeout(tryInitAll, 100);
    }
})();
</script>
