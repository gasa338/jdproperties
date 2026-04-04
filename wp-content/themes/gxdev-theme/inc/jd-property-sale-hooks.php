<?php


/**
 * JD Properties — Prodaja (kuća/stanovi)
 *
 * Uključi u functions.php:
 * require_once get_template_directory() . '/includes/jd-property-sale-hooks.php';
 */

if (! defined('ABSPATH')) exit;


// =============================================================================
// KAČENJE FUNKCIJA NA HOOK POZICIJE
// =============================================================================

add_action('jd_sale_gallery',         'jd_sale_output_gallery',         10);
add_action('jd_sale_action_buttons',  'jd_sale_output_action_buttons',  10);
add_action('jd_sale_action_buttons',  'jd_sale_output_share_message_button',  20);

add_action('jd_sale_content',         'jd_sale_output_title',           10);
add_action('jd_sale_content',         'jd_sale_output_stats',           20);
add_action('jd_sale_content',         'jd_sale_output_description',     30);
add_action('jd_sale_content',         'jd_sale_output_features',        40);
// add_action('jd_sale_content',         'jd_sale_output_financing',       50);
// add_action('jd_sale_content',         'jd_sale_output_documentation',   60);
// add_action('jd_sale_content',         'jd_sale_output_neighbourhood',   70);
// add_action('jd_sale_content',         'jd_sale_output_additional',      80);
add_action('jd_sale_content',         'jd_sale_output_map',             85);
add_action('jd_sale_content',         'jd_sale_output_faq',            90);
// add_action( 'jd_sale_content',         'jd_sale_output_similar',        95);

// add_action( 'jd_sale_sidebar',         'jd_sale_output_price_card',      10 );
add_action('jd_sale_sidebar',         'jd_sale_output_schedule_form',   20);
// add_action('jd_sale_sidebar',         'jd_sale_output_mortgage_calc',   30);
// add_action('jd_sale_sidebar',         'jd_sale_output_valuation',       40);
add_action('jd_sale_sidebar',         'jd_sale_output_compare',         50);

add_action('jd_sale_after_content',   'jd_sale_output_cta_banner',      10);
add_action('jd_sale_after_content',   'jd_sale_output_similar',         20);


// =============================================================================
// GALERIJA
// =============================================================================

function jd_sale_output_gallery()
{
    $post_id = get_the_ID();
    $gallery = get_field('gallery', $post_id);

    if ($gallery && is_array($gallery)):
        // Pripremi niz slika za JSON
        $images_data = [];
        foreach ($gallery as $image) {
            $images_data[] = [
                'full' => $image['url'],
                'thumb' => $image['sizes']['medium'],
                'caption' => $image['caption'] ?: $image['title'] ?: '',
                'alt' => $image['alt'] ?: $image['title'] ?: ''
            ];
        }
        $images_json = json_encode($images_data);

        // Izdvoji samo URL-ove za početni prikaz
        $image_urls = array_column($images_data, 'thumb');
?>

        <div
            class="grid grid-cols-4 grid-rows-2 gap-2 rounded-xl overflow-hidden aspect-[21/9] relative gallery-grid"
            data-gallery='<?php echo esc_attr($images_json); ?>'>
            <!-- MAIN IMAGE (prva slika) -->
            <div class="col-span-2 row-span-2 relative cursor-pointer group gallery-item" data-index="0">
                <img src="<?php echo esc_url($image_urls[0]); ?>"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    alt="<?php echo esc_attr($images_data[0]['alt']); ?>">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                <?php if (count($image_urls) > 5): ?>
                    <div class="absolute bottom-3 right-3 bg-black/70 text-white text-sm px-2 py-1 rounded-lg">
                        +<?php echo count($image_urls) - 5; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- SMALL IMAGES (do 4 slike) -->
            <?php for ($i = 1; $i <= 4; $i++) :
                if (empty($image_urls[$i])) continue; ?>
                <div class="relative cursor-pointer group overflow-hidden gallery-item" data-index="<?php echo $i; ?>">
                    <img src="<?php echo esc_url($image_urls[$i]); ?>"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        alt="<?php echo esc_attr($images_data[$i]['alt']); ?>">
                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Modal/Lightbox Galerija -->
        <div id="gallery-modal" class="gallery-modal">
            <div class="modal-content">
                <button class="close-modal" aria-label="Zatvori galeriju">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>

                <button class="nav-btn prev-btn" aria-label="Prethodna slika">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                <button class="nav-btn next-btn" aria-label="Sledeća slika">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>

                <div class="modal-image-container">
                    <img id="modal-image" src="" alt="" />
                    <div id="modal-caption" class="modal-caption"></div>
                    <div class="image-counter">
                        <span id="current-index">1</span> / <span id="total-images"><?php echo count($images_data); ?></span>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>


    <style>
        /* Gallery Grid Hover Efekti */
        .gallery-grid {
            position: relative;
        }

        .gallery-item {
            cursor: pointer;
            overflow: hidden;
        }

        .gallery-item img {
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.05);
        }

        /* Modal/Lightbox Stilovi */
        .gallery-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.95);
            z-index: 9999;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .gallery-modal.active {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-image-container {
            position: relative;
            max-width: 90%;
            max-height: 90%;
            text-align: center;
        }

        #modal-image {
            max-width: 100%;
            max-height: 85vh;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
            transition: opacity 0.3s ease;
        }

        .modal-caption {
            position: absolute;
            bottom: -50px;
            left: 0;
            right: 0;
            color: white;
            background: rgba(0, 0, 0, 0.7);
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .image-counter {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            background: rgba(0, 0, 0, 0.6);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            backdrop-filter: blur(5px);
        }

        /* Navigation buttons */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-50%) scale(1.1);
        }

        .prev-btn {
            left: 20px;
        }

        .next-btn {
            right: 20px;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            color: white;
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-modal:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* Loading animacija */
        .modal-image-container.loading::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Responsive dizajn */
        @media (max-width: 768px) {
            .nav-btn {
                width: 40px;
                height: 40px;
            }

            .nav-btn svg {
                width: 24px;
                height: 24px;
            }

            .close-modal {
                width: 40px;
                height: 40px;
                top: 15px;
                right: 15px;
            }

            .modal-caption {
                font-size: 12px;
                bottom: -40px;
                padding: 8px 15px;
            }

            .image-counter {
                font-size: 12px;
                top: -35px;
            }
        }

        @media (max-width: 640px) {
            .gallery-grid {
                aspect-ratio: 16/9;
            }
        }
    </style>
<?php
}


// =============================================================================
// DUGMAD ZA AKCIJE
// =============================================================================

function jd_sale_output_action_buttons()
{
    $url   = urlencode(get_permalink());
    $title = urlencode(get_the_title());
?>
    <div class="flex flex-wrap items-center gap-3 w-fit">
        <!-- 
        <button class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border transition-all font-body text-sm border-border text-muted-foreground hover:border-accent hover:text-accent">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
            </svg>
            Sačuvaj
        </button>

        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg border border-border text-muted-foreground hover:border-accent hover:text-accent transition-all font-body text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2" />
                <path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6" />
                <rect x="6" y="14" width="12" height="8" rx="1" />
            </svg>
            Štampaj PDF
        </button> -->


        <?php
        $post_id = get_the_ID();
        $url = get_permalink($post_id);
        $title = get_the_title($post_id);
        echo _share_component($url, $title, 'flex items-center gap-3'); ?>

    </div>
<?php
}

function jd_sale_output_share_message_button()
{
    $url   = get_permalink();
    $title = get_the_title();

    $text = urlencode($title . ' ' . $url);
?>

    <div class="flex items-center gap-4 w-fit">
        <span><b><?php echo __("Podeli kroz poruku: ", 'maxwell'); ?></b></span>

        <!-- WhatsApp -->
        <div class="flex items-center gap-3">
            <a href="https://wa.me/?text=<?php echo $text; ?>"
                target="_blank"
                rel="noopener noreferrer nofollow"
                aria-label="Podeli na WhatsApp"
                title="Pošalji putem WhatsApp-a"
                class="group relative flex items-center justify-center w-10 h-10 rounded-full bg-muted 
                hover:bg-[#25D366] hover:text-white 
                transition-all duration-200 ease-out 
                hover:scale-105 active:scale-95 shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg"
                    width="18" height="18"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    class="transition-transform duration-200 group-hover:scale-110">
                    <path d="M20.52 3.48A11.8 11.8 0 0 0 12.05 0C5.45 0 .08 5.37.08 11.98c0 2.11.55 4.17 1.6 5.99L0 24l6.2-1.63a11.9 11.9 0 0 0 5.85 1.49h.01c6.6 0 11.97-5.37 11.97-11.98 0-3.2-1.25-6.21-3.51-8.4zM12.06 21.8h-.01a9.8 9.8 0 0 1-5-1.37l-.36-.21-3.68.97.98-3.59-.23-.37a9.76 9.76 0 0 1-1.5-5.25c0-5.42 4.41-9.83 9.83-9.83 2.63 0 5.1 1.02 6.96 2.88a9.8 9.8 0 0 1 2.88 6.96c0 5.42-4.41 9.83-9.83 9.83zm5.53-7.36c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.66.15-.2.3-.76.97-.93 1.17-.17.2-.34.22-.64.07-.3-.15-1.25-.46-2.38-1.47-.88-.78-1.47-1.74-1.64-2.03-.17-.3-.02-.46.13-.6.13-.13.3-.34.45-.5.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.66-1.6-.9-2.2-.24-.58-.49-.5-.66-.5h-.57c-.2 0-.52.07-.8.37-.27.3-1.05 1.02-1.05 2.5s1.07 2.9 1.22 3.1c.15.2 2.1 3.2 5.08 4.48.71.3 1.27.48 1.7.62.71.23 1.35.2 1.86.12.57-.08 1.76-.72 2-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z" />
                </svg>
            </a>
        </div>

        <!-- Viber -->
        <div class="flex items-center gap-3">
            <a href="viber://share?text=<?php echo $text; ?>"
                rel="nofollow"
                aria-label="Podeli na Viber"
                title="Pošalji putem Vibera"
                class="group relative flex items-center justify-center w-10 h-10 rounded-full bg-muted 
                hover:bg-purple-600 hover:text-white 
                transition-all duration-200 ease-out 
                hover:scale-105 active:scale-95 shadow-sm hover:shadow-md">

                <svg xmlns="http://www.w3.org/2000/svg"
                    width="18" height="18"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    class="transition-transform duration-200 group-hover:scale-110">
                    <path d="M21.8 13.1c-.3-2.2-1.5-4.2-3.3-5.6C16.5 5.7 14.3 5 12 5c-1.1 0-2.1.1-3.1.4-.5.1-.8.6-.7 1.1.1.5.6.8 1.1.7.8-.2 1.7-.3 2.7-.3 1.9 0 3.7.6 5.1 1.8 1.4 1.1 2.3 2.7 2.6 4.4.1.5.5.8 1 .8h.1c.6-.1 1-.6.9-1.1zM12 2C6.5 2 2 6 2 10.9c0 2.7 1.5 5.1 3.9 6.7V22l4.2-2.2c.6.1 1.2.2 1.9.2 5.5 0 10-4 10-8.9S17.5 2 12 2z" />
                </svg>
            </a>
        </div>

    </div>

<?php
}

// =============================================================================
// NASLOV, LOKACIJA I CENA (jednokratna + cena po m²)
// =============================================================================

function jd_sale_output_title()
{
    $post_id       = get_the_ID();
    $price         = get_field('property_price', $post_id);
    $area          = get_field('property_squarespace', $post_id);
?>
    <div>
        <div class="flex flex-wrap gap-2 mb-3 py-4 border-t border-border">
            <?php
            $type_terms = gxdev_get_custom_tax($post_id, 'jd-type');
            if (!empty($type_terms)) : ?>
                <a href="<?php echo esc_url($type_terms[0]['link']); ?>" title="<?php echo esc_attr($type_terms[0]['name']); ?>" class="inline-flex items-center rounded-full px-4 py-2  font-semibold bg-accent text-accent-foreground font-body">
                    <?php echo esc_html($type_terms[0]['name']); ?>
                </a>
            <?php endif; ?>
            <?php
            $category_terms = gxdev_get_custom_tax($post_id, 'cat');
            if (!empty($category_terms)) : ?>
                <a href="<?php echo esc_url($category_terms[0]['link']); ?>" title="<?php echo esc_attr($category_terms[0]['name']); ?>" class="inline-flex items-center rounded-full px-4 py-2  font-semibold bg-primary text-primary-foreground font-body">
                    <?php echo esc_html($category_terms[0]['name']); ?>
                </a>
            <?php endif; ?>
        </div>

        <?php the_title('<h1 class="h2-responsive">', '</h1>'); ?>

        <?php
        $opstina = get_field('opstina', $post_id);
        $opstinski_region = get_field('opstinski_region', $post_id);
        $geo_duzina = get_field('geo_duzina', $post_id); // longitude
        $geo_sirina = get_field('geo_sirina', $post_id); // latitude

        if (!empty($opstina) || !empty($opstinski_region)) :
            $adresa = trim($opstina . ', ' . $opstinski_region, ', ');
            $has_coordinates = !empty($geo_duzina) && !empty($geo_sirina);

            // Kreiraj Google Maps link
            if ($has_coordinates) {
                // Link sa koordinatama
                $map_link = 'https://www.google.com/maps?q=' . esc_attr($geo_sirina) . ',' . esc_attr($geo_duzina);
                $map_title = 'Pogledaj na Google Maps';
            } else {
                // Link sa adresom
                $map_link = 'https://www.google.com/maps/search/' . urlencode($adresa);
                $map_title = 'Pogledaj lokaciju na Google Maps';
            }
        ?>
            <div class="flex items-center gap-2 text-muted-foreground mb-5 group">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent flex-shrink-0">
                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                    <circle cx="12" cy="10" r="3" />
                </svg>

                <?php if ($map_link) : ?>
                    <a href="<?php echo esc_url($map_link); ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="font-body hover:text-accent transition-colors duration-300 inline-flex items-center gap-1"
                        title="<?php echo esc_attr($map_title); ?>">
                        <?php echo esc_html($adresa); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6" />
                            <polyline points="15 3 21 3 21 9" />
                            <line x1="10" y1="14" x2="21" y2="3" />
                        </svg>
                    </a>
                <?php else : ?>
                    <span class="font-body"><?php echo esc_html($adresa); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($price)): ?>
            <div class="flex flex-wrap items-baseline gap-4">
                <span class="font-heading text-3xl sm:text-4xl font-bold text-foreground">
                    <?php echo number_format($price, 0, ',', '.'); ?> EUR
                </span>
                <?php
                if ($category_terms[0]['name'] !== 'izdavanje'):
                    $price_per_m2 = ($area > 0) ? round($price / $area) : 0;
                    if ($price_per_m2) : ?>
                        <span class="font-body text-base text-muted-foreground">
                            <?php echo number_format($price_per_m2, 0, ',', '.'); ?> EUR/m²
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php
}


// =============================================================================
// STATISTIKE
// =============================================================================

function jd_sale_output_stats()
{
    $post_id   = get_the_ID();
    $area      = get_field('property_squarespace',      $post_id) ?: '';
    $rooms     = get_field('property_structure',     $post_id) ?: '';
    $floor = get_field('property_floor', $post_id) ?: '';
    $floors_in_building     = get_field('property_floors_in_building',     $post_id) ?: '';

?>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

        <div class="bg-secondary rounded-xl p-5 text-center border border-border">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-accent mx-auto mb-2">
                <path d="M8 3H5a2 2 0 0 0-2 2v3" />
                <path d="M21 8V5a2 2 0 0 0-2-2h-3" />
                <path d="M3 16v3a2 2 0 0 0 2 2h3" />
                <path d="M16 21h3a2 2 0 0 0 2-2v-3" />
            </svg>
            <div class="font-body text-muted-foreground mb-1"><?php echo __("Površina", "gxdev"); ?></div>
            <div class="font-heading text-2xl font-bold text-foreground"><?php echo !empty($area) ? $area : "---"; ?> m²</div>
        </div>

        <div class="bg-secondary rounded-xl p-5 text-center border border-border">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent mx-auto mb-2 w-10 h-10 ">
                <path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8" />
                <path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4" />
                <path d="M12 4v6" />
                <path d="M2 18h20" />
            </svg>
            <div class="font-body text-muted-foreground mb-1"><?php echo __("Sobe", "gxdev"); ?></div>
            <div class="font-heading text-2xl font-bold text-foreground"><?php echo !empty($rooms) ? $rooms : "---"; ?></div>
        </div>

        <div class="bg-secondary rounded-xl p-5 text-center border border-border">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-accent mx-auto mb-2">
                <path d="m21 16-4 4-4-4" />
                <path d="M17 20V4" />
                <path d="m3 8 4-4 4 4" />
                <path d="M7 4v16" />
            </svg>
            <div class="font-body text-muted-foreground mb-1"><?php echo __("Sprat", "gxdev"); ?></div>
            <div class="font-heading text-2xl font-bold text-foreground"><?php echo !empty($floor) ? $floor : "---"; ?></div>
        </div>

        <div class="bg-secondary rounded-xl p-5 text-center border border-border">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-accent mx-auto mb-2">
                <path d="M2 20h20" />
                <path d="M4 20V8l4-4 4 4v12" />
                <path d="M14 20V4l4-4 4 4v16" />
                <path d="M8 12h.01" />
                <path d="M12 12h.01" />
                <path d="M16 12h.01" />
            </svg>
            <div class="font-body text-muted-foreground mb-1"><?php echo __("Spratnost", "gxdev"); ?></div>
            <div class="font-heading text-2xl font-bold text-foreground"><?php echo !empty($floors_in_building) ? $floors_in_building : "---"; ?></div>
        </div>

    </div>
<?php
}


// =============================================================================
// OPIS
// =============================================================================

function jd_sale_output_description()
{
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M10 9H8" />
                <path d="M16 13H8" />
                <path d="M16 17H8" />
            </svg>
            <?php echo __("Opis nekretnine", "gxdev"); ?>
        </h2>
        <div class="font-body text-muted-foreground leading-relaxed text-base maxwell-content">
            <?php the_content(); ?>
        </div>
    </div>
<?php
}


// =============================================================================
// KARAKTERISTIKE
// =============================================================================

function jd_sale_output_features()
{

    $post_id = get_the_ID();
    $heating = get_field('property_heating', $post_id);
    $parking_spaces = get_field('property_parking_spaces', $post_id);
    $toilettes = get_field('property_toilettes', $post_id);
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                <path d="m9 11 3 3L22 4" />
            </svg>
            <?php echo __('Karakteristike', 'gxdev'); ?>
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <?php if (!empty($heating)): ?>
                <div class="flex items-center gap-2.5 font-body text-sm text-foreground bg-secondary/60 rounded-lg px-4 py-3 border border-border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent flex-shrink-0">
                        <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                    <span><b><?php echo __('Grejanje: ', 'maxwell') ?></b></span>
                    <?php echo esc_html($heating); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($toilettes)): ?>
                <div class="flex items-center gap-2.5 font-body text-sm text-foreground bg-secondary/60 rounded-lg px-4 py-3 border border-border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent flex-shrink-0">
                        <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                    <span><b><?php echo __('Kupatila: ', 'maxwell') ?></b></span>
                    <?php echo esc_html($toilettes); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($parking_spaces)): ?>
                <div class="flex items-center gap-2.5 font-body text-sm text-foreground bg-secondary/60 rounded-lg px-4 py-3 border border-border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent flex-shrink-0">
                        <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                    <span><b><?php echo __('Parking mesto: ', 'maxwell') ?></b></span>
                    <?php echo esc_html($parking_spaces); ?>
                </div>
            <?php endif; ?>

            <?php
            $features = gxdev_get_custom_tax($post_id, 'feature');
            if (!empty($features)) :
                foreach ((array) $features as $feature) : ?>
                    <div class="flex items-center gap-2.5 font-body text-sm text-foreground bg-secondary/60 rounded-lg px-4 py-3 border border-border">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent flex-shrink-0">
                            <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                            <path d="m9 11 3 3L22 4" />
                        </svg>
                        <a href="<?php echo $feature['link'] ?>"><?php echo esc_html($feature['name']); ?></a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php
}


// =============================================================================
// FINANSIRANJE I KREDIT
// =============================================================================

function jd_sale_output_financing()
{
    $post_id      = get_the_ID();
    $price        = 185000;
    $downpayment  = 20;
    $banks        = get_post_meta($post_id, '_property_banks', true) ?: [
        'Banca Intesa',
        'Raiffeisen banka',
        'UniCredit banka',
        'OTP banka',
    ];

    $loan_amount   = $price * (1 - $downpayment / 100);
    $monthly_est   = round($loan_amount * 0.005); // ~0.5% gruba procena rate
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <rect width="20" height="14" x="2" y="5" rx="2" />
                <line x1="2" x2="22" y1="10" y2="10" />
            </svg>
            Finansiranje i kredit
        </h2>

        <div class="grid sm:grid-cols-3 gap-4 mb-5">
            <div class="bg-secondary rounded-xl p-5 border border-border text-center">
                <div class="text-xs font-body text-muted-foreground mb-1">Cena nekretnine</div>
                <div class="font-heading text-xl font-bold text-foreground">
                    <?php echo number_format($price, 0, ',', '.'); ?> EUR
                </div>
            </div>
            <div class="bg-secondary rounded-xl p-5 border border-border text-center">
                <div class="text-xs font-body text-muted-foreground mb-1">Učešće (<?php echo esc_html($downpayment); ?>%)</div>
                <div class="font-heading text-xl font-bold text-foreground">
                    <?php echo number_format($price * $downpayment / 100, 0, ',', '.'); ?> EUR
                </div>
            </div>
            <div class="bg-accent/10 rounded-xl p-5 border border-accent/30 text-center">
                <div class="text-xs font-body text-muted-foreground mb-1">Okvirna mesečna rata*</div>
                <div class="font-heading text-xl font-bold text-accent">
                    ~<?php echo number_format($monthly_est, 0, ',', '.'); ?> EUR
                </div>
            </div>
        </div>

        <p class="text-xs font-body text-muted-foreground mb-4">
            * Orijentacioni iznos za kredit od <?php echo number_format($loan_amount, 0, ',', '.'); ?> EUR na 20 godina. Konačne uslove dobijate od banke.
        </p>

        <?php if (! empty($banks)) : ?>
            <div class="bg-secondary rounded-xl p-5 border border-border">
                <p class="font-body text-sm font-medium text-foreground mb-3">Sarađujemo sa bankama:</p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ((array) $banks as $bank) : ?>
                        <span class="font-body text-xs bg-card border border-border rounded-full px-3 py-1.5 text-foreground">
                            <?php echo esc_html($bank); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php
}


// =============================================================================
// DOKUMENTACIJA I PRAVNI STATUS
// =============================================================================

function jd_sale_output_documentation()
{
    $post_id      = get_the_ID();
    $ownership    = get_post_meta($post_id, '_property_ownership',    true) ?: '1/1 — čista svojina';
    $land_book    = get_post_meta($post_id, '_property_land_book',   true) ?: 'Uknjiženo';
    $permit       = get_post_meta($post_id, '_property_permit',       true) ?: 'Ima upotrebnu dozvolu';
    $encumbrance  = get_post_meta($post_id, '_property_encumbrance',  true) ?: 'Bez tereta i hipoteke';
    $cadaster     = get_post_meta($post_id, '_property_cadaster',     true) ?: 'Upisano u katastar';
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M9 13h6" />
                <path d="M9 17h3" />
            </svg>
            Dokumentacija i pravni status
        </h2>

        <div class="grid sm:grid-cols-2 gap-3">
            <?php
            $docs = [
                ['label' => 'Vlasnički list',      'value' => $ownership,   'icon' => 'check'],
                ['label' => 'Uknjižba',            'value' => $land_book,   'icon' => 'check'],
                ['label' => 'Upotrebna dozvola',   'value' => $permit,      'icon' => 'check'],
                ['label' => 'Tereti/hipoteka',     'value' => $encumbrance, 'icon' => 'check'],
                ['label' => 'Katastar',            'value' => $cadaster,    'icon' => 'check'],
            ];
            foreach ($docs as $doc) : ?>
                <div class="flex items-start gap-3 bg-secondary/60 rounded-lg px-4 py-3 border border-border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent flex-shrink-0 mt-0.5">
                        <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                    <div>
                        <div class="text-xs font-body text-muted-foreground"><?php echo esc_html($doc['label']); ?></div>
                        <div class="font-body text-sm text-foreground font-medium"><?php echo esc_html($doc['value']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
}


// =============================================================================
// OKOLINA (škole, prodavnice, saobraćaj...)
// =============================================================================

function jd_sale_output_neighbourhood()
{
    $post_id = get_the_ID();
    $items   = get_post_meta($post_id, '_property_neighbourhood', true) ?: [
        ['category' => 'Škole',       'name' => 'OŠ Sveti Sava',         'distance' => '5 min pešice'],
        ['category' => 'Škole',       'name' => 'Gimnazija Vračar',       'distance' => '8 min pešice'],
        ['category' => 'Prodavnice',  'name' => 'Maxi supermarket',       'distance' => '3 min pešice'],
        ['category' => 'Prodavnice',  'name' => 'Farmer\'s Market',       'distance' => '10 min pešice'],
        ['category' => 'Saobraćaj',   'name' => 'Autobuska stanica',      'distance' => '2 min pešice'],
        ['category' => 'Saobraćaj',   'name' => 'Tramvajska stanica',     'distance' => '4 min pešice'],
        ['category' => 'Zdravstvo',   'name' => 'Dom zdravlja Vračar',    'distance' => '7 min pešice'],
        ['category' => 'Rekreacija',  'name' => 'Park Čubura',            'distance' => '6 min pešice'],
    ];

    $icons = [
        'Škole'      => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
        'Prodavnice' => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
        'Saobraćaj'  => '<rect width="16" height="16" x="4" y="3" rx="2"/><path d="M4 11h16"/><path d="M12 3v8"/><path d="m8 19-2 3"/><path d="m18 22-2-3"/><path d="M8 15h.01"/><path d="M16 15h.01"/>',
        'Zdravstvo'  => '<path d="M11 2a2 2 0 0 0-2 2v5H4a2 2 0 0 0-2 2v2c0 1.1.9 2 2 2h5v5c0 1.1.9 2 2 2h2a2 2 0 0 0 2-2v-5h5a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-5V4a2 2 0 0 0-2-2h-2z"/>',
        'Rekreacija' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    ];

    $grouped = [];
    foreach ((array) $items as $item) {
        $grouped[$item['category']][] = $item;
    }
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <circle cx="12" cy="12" r="10" />
                <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20" />
                <path d="M2 12h20" />
            </svg>
            Okolina
        </h2>

        <div class="grid sm:grid-cols-2 gap-4">
            <?php foreach ($grouped as $category => $places) : ?>
                <div class="bg-secondary/60 rounded-xl p-4 border border-border">
                    <div class="flex items-center gap-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                            <?php echo $icons[$category] ?? '<circle cx="12" cy="12" r="10"/>'; ?>
                        </svg>
                        <span class="font-body text-sm font-semibold text-foreground"><?php echo esc_html($category); ?></span>
                    </div>
                    <div class="space-y-2">
                        <?php foreach ($places as $place) : ?>
                            <div class="flex items-center justify-between">
                                <span class="font-body text-sm text-foreground"><?php echo esc_html($place['name']); ?></span>
                                <span class="font-body text-xs text-muted-foreground bg-card px-2 py-0.5 rounded-full border border-border">
                                    <?php echo esc_html($place['distance']); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
}


// =============================================================================
// DODATNI PODACI
// =============================================================================

function jd_sale_output_additional()
{
    $post_id      = get_the_ID();
    $heating      = get_post_meta($post_id, '_property_heating',      true) ?: 'Centralno grejanje';
    $parking      = get_post_meta($post_id, '_property_parking',      true) ?: 'Podzemna garaža';
    $year_built   = get_post_meta($post_id, '_property_year_built',   true) ?: '2019';
    $energy_class = get_post_meta($post_id, '_property_energy_class', true) ?: 'A';
    $condition    = get_post_meta($post_id, '_property_condition',    true) ?: 'Novogradnja';
    $orientation  = get_post_meta($post_id, '_property_orientation',  true) ?: 'Jug-istok';
?>
    <div>
        <details class="border border-border rounded-xl px-6 bg-card">
            <summary class="flex items-center justify-between py-4 cursor-pointer font-heading text-lg font-semibold text-foreground list-none">
                <span class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <rect width="16" height="20" x="4" y="2" rx="2" ry="2" />
                        <path d="M9 22v-4h6v4" />
                        <path d="M8 6h.01" />
                        <path d="M16 6h.01" />
                        <path d="M12 6h.01" />
                        <path d="M12 10h.01" />
                        <path d="M12 14h.01" />
                    </svg>
                    Dodatni podaci o nekretnini
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </summary>
            <div class="pb-4 pt-2 grid grid-cols-2 gap-4 font-body text-sm text-muted-foreground">
                <?php if ($heating) : ?><div><span class="text-foreground font-medium">Grejanje:</span> <?php echo esc_html($heating); ?></div><?php endif; ?>
                <?php if ($parking) : ?><div><span class="text-foreground font-medium">Parking:</span> <?php echo esc_html($parking); ?></div><?php endif; ?>
                <?php if ($year_built) : ?><div><span class="text-foreground font-medium">Godina gradnje:</span> <?php echo esc_html($year_built); ?></div><?php endif; ?>
                <?php if ($energy_class) : ?><div><span class="text-foreground font-medium">Energetska klasa:</span> <?php echo esc_html($energy_class); ?></div><?php endif; ?>
                <?php if ($condition) : ?><div><span class="text-foreground font-medium">Stanje:</span> <?php echo esc_html($condition); ?></div><?php endif; ?>
                <?php if ($orientation) : ?><div><span class="text-foreground font-medium">Orijentacija:</span> <?php echo esc_html($orientation); ?></div><?php endif; ?>
            </div>
        </details>
    </div>
<?php
}


// =============================================================================
// MAPA
// =============================================================================

function jd_sale_output_map()
{
    $post_id = get_the_ID();
    $opstina = get_field('opstina', $post_id);
    $opstinski_region = get_field('opstinski_region', $post_id);
    $location = $opstina . ", " . $opstinski_region;
    $geo_duzina = get_field('geo_duzina', $post_id); // longitude
    $geo_sirina = get_field('geo_sirina', $post_id); // latitude
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                <circle cx="12" cy="10" r="3" />
            </svg>
            <?php echo __("Lokacija", 'gxdev'); ?>
        </h2>
        <?php if (!empty($geo_duzina) || !empty($geo_sirina)): ?>
            <div class="rounded-xl overflow-hidden border border-border aspect-[16/9]">
                <iframe
                    title="Lokacija nekretnine"
                    src="https://maps.google.com/maps?q=<?php echo $geo_sirina; ?>,<?php echo $geo_duzina; ?>&z=15&output=embed"
                    class="w-full h-full"
                    loading="lazy"
                    allowfullscreen>
                </iframe>
            </div>
        <?php endif; ?>
        <p class="font-body text-sm text-muted-foreground mt-3">
            📍 <?php echo esc_html($location); ?>
        </p>
    </div>
<?php
}


// =============================================================================
// ČESTA PITANJA
// =============================================================================

function jd_sale_output_faq()
{
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
            </svg>
            <?php echo __('Česta pitanja', 'gxdev'); ?>
        </h2>
        <?php echo gxdev_render_global_content('faq-prodaja-stana'); ?>
    </div>
<?php
}


// =============================================================================
// SIDEBAR — KARTICA SA CENOM I AGENTOM
// =============================================================================

function jd_sale_output_price_card()
{
    $post_id = get_the_ID();
    $price   = get_post_meta($post_id, '_property_price', true) ?: '185000';
    $area    = get_post_meta($post_id, '_property_area',  true) ?: '92';
    $phone   = get_post_meta($post_id, '_agent_phone',    true) ?: '+381 11 123 4567';
    $email   = get_post_meta($post_id, '_agent_email',    true) ?: 'info@jdproperties.rs';
    $agent   = get_post_meta($post_id, '_agent_name',     true) ?: 'JD Properties';
    $wa      = preg_replace('/[^0-9]/', '', $phone);
    $title   = urlencode(get_the_title());
    $price_per_m2 = ($area > 0) ? round($price / $area) : 0;
?>
    <div class="bg-card border border-border rounded-xl p-6 sticky top-24 space-y-6">

        <div>
            <div class="font-heading text-3xl font-bold text-foreground">
                <?php echo number_format($price, 0, ',', '.'); ?> EUR
            </div>
            <?php if ($price_per_m2) : ?>
                <p class="text-sm font-body text-muted-foreground">
                    <?php echo number_format($price_per_m2, 0, ',', '.'); ?> EUR/m²
                </p>
            <?php endif; ?>
        </div>

        <div class="bg-secondary rounded-xl p-5 border border-border">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-full bg-accent/20 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <div>
                    <p class="font-heading text-sm font-semibold text-foreground"><?php echo esc_html($agent); ?></p>
                    <p class="font-body text-xs text-muted-foreground">Ovlašćeni agent</p>
                </div>
            </div>
            <div class="space-y-2 text-sm font-body text-muted-foreground">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                    </svg>
                    <span><?php echo esc_html($phone); ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    <span><?php echo esc_html($email); ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <span>Pon - Pet: 09-18h</span>
                </div>
            </div>
        </div>
    </div>

    <div class="space-y-3">
        <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"
            class="flex items-center justify-center gap-2 w-full bg-accent text-accent-foreground font-body text-sm font-semibold tracking-wide px-6 py-3.5 rounded-lg hover:bg-accent/90 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
            </svg>
            Pozovite nas
        </a>
        <a href="https://wa.me/<?php echo esc_attr($wa); ?>?text=Zanima%20me%20nekretnina%3A%20<?php echo $title; ?>"
            target="_blank" rel="noopener noreferrer"
            class="flex items-center justify-center gap-2 w-full border border-border text-foreground font-body text-sm tracking-wide px-6 py-3.5 rounded-lg hover:bg-secondary transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
            </svg>
            WhatsApp
        </a>
    </div>

    <div class="grid grid-cols-2 gap-3 pt-2">
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent mx-auto mb-1">
                <path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z" />
            </svg>
            <p class="text-xs font-body text-muted-foreground">Proverena dokumentacija</p>
        </div>
        <div class="text-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent mx-auto mb-1">
                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                <path d="m9 11 3 3L22 4" />
            </svg>
            <p class="text-xs font-body text-muted-foreground">Ovlašćena agencija</p>
        </div>
    </div>

    </div>
<?php
}


// =============================================================================
// SIDEBAR — ZAKAŽI RAZGLEDANJE
// =============================================================================

function jd_sale_output_schedule_form()
{
?>
    <div class="bg-card border border-border rounded-xl p-6 space-y-4">
        <h3 class="font-heading text-base font-semibold text-foreground flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                <line x1="16" x2="16" y1="2" y2="6" />
                <line x1="8" x2="8" y1="2" y2="6" />
                <line x1="3" x2="21" y1="10" y2="10" />
            </svg>
            <?php echo __('Zakaži razgledanje', 'gxdev'); ?>
        </h3>

        <?php echo do_shortcode('[contact-form-7 id="f76702a" title="Zakaži razgledanje"]') ?>
    </div>
<?php
}


// =============================================================================
// SIDEBAR — KALKULATOR KREDITA
// =============================================================================

function jd_sale_output_mortgage_calc()
{
    $price = 185000;
?>
    <div class="bg-card border border-border rounded-xl p-6 space-y-4">
        <h3 class="font-heading text-base font-semibold text-foreground flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <rect width="16" height="20" x="4" y="2" rx="2" />
                <line x1="8" x2="16" y1="6" y2="6" />
                <line x1="8" x2="16" y1="10" y2="10" />
                <line x1="8" x2="12" y1="14" y2="14" />
            </svg>
            Kalkulator kredita
        </h3>

        <div class="space-y-3">
            <div>
                <label class="flex justify-between text-xs font-body text-muted-foreground mb-1">
                    <span>Cena nekretnine</span>
                    <span id="calc-price-label"><?php echo number_format($price, 0, ',', '.'); ?> EUR</span>
                </label>
                <input type="range" id="calc-price"
                    min="10000" max="1000000" step="5000"
                    value="<?php echo esc_attr($price); ?>"
                    class="w-full accent-accent">
            </div>

            <div>
                <label class="flex justify-between text-xs font-body text-muted-foreground mb-1">
                    <span>Učešće</span>
                    <span id="calc-down-label">20%</span>
                </label>
                <input type="range" id="calc-down" min="10" max="80" step="5" value="20" class="w-full accent-accent">
            </div>

            <div>
                <label class="flex justify-between text-xs font-body text-muted-foreground mb-1">
                    <span>Rok otplate</span>
                    <span id="calc-years-label">20 god.</span>
                </label>
                <input type="range" id="calc-years" min="5" max="30" step="5" value="20" class="w-full accent-accent">
            </div>

            <div>
                <label class="flex justify-between text-xs font-body text-muted-foreground mb-1">
                    <span>Kamatna stopa</span>
                    <span id="calc-rate-label">3.5%</span>
                </label>
                <input type="range" id="calc-rate" min="1" max="10" step="0.1" value="3.5" class="w-full accent-accent">
            </div>
        </div>

        <div class="bg-accent/10 rounded-xl p-4 border border-accent/30 text-center">
            <div class="text-xs font-body text-muted-foreground mb-1">Mesečna rata</div>
            <div class="font-heading text-2xl font-bold text-accent" id="calc-result">—</div>
            <div class="text-xs font-body text-muted-foreground mt-1" id="calc-loan-amount"></div>
        </div>

        <p class="text-xs font-body text-muted-foreground">* Orijentacioni iznos. Konačne uslove dobijate od banke.</p>
    </div>

    <script>
        (function() {
            const price = document.getElementById('calc-price');
            const down = document.getElementById('calc-down');
            const years = document.getElementById('calc-years');
            const rate = document.getElementById('calc-rate');
            const result = document.getElementById('calc-result');
            const loanEl = document.getElementById('calc-loan-amount');

            function fmt(n) {
                return new Intl.NumberFormat('sr-RS').format(Math.round(n));
            }

            function calc() {
                const P = parseFloat(price.value);
                const d = parseFloat(down.value) / 100;
                const n = parseFloat(years.value) * 12;
                const r = parseFloat(rate.value) / 100 / 12;
                const loan = P * (1 - d);
                const monthly = r === 0 ? loan / n : loan * r * Math.pow(1 + r, n) / (Math.pow(1 + r, n) - 1);

                document.getElementById('calc-price-label').textContent = fmt(P) + ' EUR';
                document.getElementById('calc-down-label').textContent = down.value + '%';
                document.getElementById('calc-years-label').textContent = years.value + ' god.';
                document.getElementById('calc-rate-label').textContent = parseFloat(rate.value).toFixed(1) + '%';
                result.textContent = '~' + fmt(monthly) + ' EUR';
                loanEl.textContent = 'Iznos kredita: ' + fmt(loan) + ' EUR';
            }

            [price, down, years, rate].forEach(el => el.addEventListener('input', calc));
            calc();
        })();
    </script>
<?php
}


// =============================================================================
// SIDEBAR — PROCENA VREDNOSTI
// =============================================================================

function jd_sale_output_valuation()
{
?>
    <div class="bg-gradient-to-br from-secondary to-card border border-border rounded-xl p-6 space-y-3">
        <h3 class="font-heading text-base font-semibold text-foreground flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7" />
                <path d="M4 12V20a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V12" />
                <path d="M15 22v-4a3 3 0 0 0-3-3v0a3 3 0 0 0-3 3v4" />
                <path d="M2 7h20" />
                <path d="M22 7v3a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7" />
            </svg>
            Besplatna procena vrednosti
        </h3>
        <p class="font-body text-sm text-muted-foreground">
            Imate nekretninu i razmišljate o prodaji? Zakažite besplatnu procenu tržišne vrednosti.
        </p>
        <a href="<?php echo esc_url(get_permalink(get_page_by_path('procena-vrednosti')) ?: home_url('/kontakt')); ?>"
            class="flex items-center justify-center gap-2 w-full bg-primary text-primary-foreground font-body text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-primary/90 transition-colors">
            Zatražite procenu
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
            </svg>
        </a>
    </div>
<?php
}


// =============================================================================
// SIDEBAR — UPOREDI NEKRETNINE
// =============================================================================

function jd_sale_output_compare()
{
    $post_id = get_the_ID();
?>
    <div class="bg-card border border-border rounded-xl p-6 space-y-3">
        <h3 class="font-heading text-base font-semibold text-foreground flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M16 3h5v5" />
                <path d="M8 3H3v5" />
                <path d="M21 3l-7 7-4-4-7 7" />
            </svg>
            Uporedi nekretnine
        </h3>
        <p class="font-body text-sm text-muted-foreground">
            Dodajte ovu nekretninu u poređenje sa sličnim oglasima.
        </p>
        <button
            onclick="jdAddToCompare(<?php echo $post_id; ?>, '<?php echo esc_js(get_the_title()); ?>')"
            class="flex items-center justify-center gap-2 w-full border border-border text-foreground font-body text-sm tracking-wide px-5 py-2.5 rounded-lg hover:bg-secondary transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Dodaj u poređenje
        </button>
    </div>

    <script>
        function jdAddToCompare(id, title) {
            let list = JSON.parse(localStorage.getItem('jd_compare') || '[]');
            if (list.find(i => i.id === id)) {
                alert('Nekretnina je već u poređenju.');
                return;
            }
            if (list.length >= 3) {
                alert('Možete porediti najviše 3 nekretnine.');
                return;
            }
            list.push({
                id,
                title
            });
            localStorage.setItem('jd_compare', JSON.stringify(list));
            alert('"' + title + '" je dodato u poređenje (' + list.length + '/3).');
        }
    </script>
<?php
}


// =============================================================================
// POSLE SADRŽAJA — CTA BANER
// =============================================================================

function jd_sale_output_cta_banner()
{
?>
    <div class="my-12">
        <?php
        echo gxdev_render_global_content('cta-prodaja');
        ?>
    </div>
<?php
}


// =============================================================================
// POSLE SADRŽAJA — SLIČNE NEKRETNINE NA PRODAJU
// =============================================================================

function jd_sale_output_similar()
{
    $post_id = get_the_ID();
    $category_terms = gxdev_get_custom_tax($post_id, 'cat');
    $category = !empty($category_terms) ? $category_terms[0]['name'] : 'prodaja';
    $query = jd_get_related_properties([
        'category' => $category,
        'posts_per_page' => 3,
    ]);

?>
    <?php if ($query->have_posts()) : ?>
        <div class="mt-16" style="opacity: 1; transform: none;">
            <h2 class="font-heading text-2xl sm:text-3xl font-semibold text-foreground mb-8"><?php echo __ ('Slične nekretnine', 'gxdev'); ?></h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php get_template_part('template-parts/content', 'property', [
                        'post_id' => get_the_ID()
                    ]); ?>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
<?php
}
