<?php

/**
 * JD Properties — Hook registracija i template funkcije
 *
 * Uključi ovaj fajl u functions.php:
 * require_once get_template_directory() . '/includes/jd-property-hooks.php';
 */

if (! defined('ABSPATH')) exit;


// =============================================================================
// KAČENJE FUNKCIJA NA HOOK POZICIJE
// Redosled se kontroliše trećim parametrom (prioritet) — manji broj = više
// =============================================================================

add_action('jd_property_gallery',        'jd_output_gallery',        10);

add_action('jd_property_action_buttons', 'jd_output_action_buttons', 10);

add_action('jd_property_content',        'jd_output_title',          10);
add_action('jd_property_content',        'jd_output_stats',          20);
add_action('jd_property_content',        'jd_output_description',    30);
add_action('jd_property_content',        'jd_output_features',       40);
add_action('jd_property_content',        'jd_output_additional',     50);
add_action('jd_property_content',        'jd_output_map',            60);
add_action('jd_property_content',        'jd_output_faq',            70);

add_action('jd_property_sidebar',        'jd_output_agent_card',     10);
add_action('jd_property_sidebar',        'jd_output_pricing_promo',  20);

add_action('jd_property_after_content',  'jd_output_cta_banner',     10);
add_action('jd_property_after_content',  'jd_output_similar',        20);


// =============================================================================
// GALERIJA
// =============================================================================

function jd_output_gallery()
{
    $post_id = get_the_ID();
    $title   = get_the_title();

    // Ovde možeš da koristiš ACF, custom meta ili attachment-e
    $images = get_post_meta($post_id, '_property_images', true);

    // Fallback Unsplash slike ako nema postavljenih
    $fallback = [
        'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=1200&q=80',
        'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1200&q=80',
        'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=1200&q=80',
        'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?w=1200&q=80',
        'https://images.unsplash.com/photo-1600573472592-401b489a3cdc?w=1200&q=80',
    ];

    if (empty($images)) {
        $images = $fallback;
    }
?>
    <div class="grid grid-cols-4 grid-rows-2 gap-2 rounded-xl overflow-hidden aspect-[21/9]">

        <div class="col-span-2 row-span-2 relative cursor-pointer group">
            <img
                src="<?php echo esc_url($images[0]); ?>"
                alt="<?php echo esc_attr($title); ?> - glavna slika"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/20 transition-colors"></div>
            <button class="absolute bottom-4 right-4 bg-primary/80 text-primary-foreground p-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21 21-6-6m6 6v-4.8m0 4.8h-4.8" />
                    <path d="M3 16.2V21m0 0h4.8M3 21l6-6" />
                    <path d="M21 7.8V3m0 0h-4.8M21 3l-6 6" />
                    <path d="M3 7.8V3m0 0h4.8M3 3l6 6" />
                </svg>
            </button>
        </div>

        <?php for ($i = 1; $i <= 4; $i++) :
            if (empty($images[$i])) continue;
        ?>
            <div class="relative cursor-pointer group overflow-hidden">
                <img
                    src="<?php echo esc_url($images[$i]); ?>"
                    alt="<?php echo esc_attr($title); ?> - slika <?php echo $i + 1; ?>"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/20 transition-colors"></div>
            </div>
        <?php endfor; ?>

    </div>
<?php
}


// =============================================================================
// DUGMAD ZA AKCIJE (sačuvaj, štampaj, podeli)
// =============================================================================

function jd_output_action_buttons()
{
    $url   = urlencode(get_permalink());
    $title = urlencode(get_the_title());
?>
    <div class="flex flex-wrap items-center gap-3 mb-8 print:hidden">

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
        </button>

        <div class="flex items-center gap-3">
            <span class="text-sm font-body text-muted-foreground">Podeli:</span>

            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"
                target="_blank" rel="noopener noreferrer"
                class="p-2 rounded-full bg-muted hover:bg-accent hover:text-accent-foreground transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                </svg>
            </a>

            <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>"
                target="_blank" rel="noopener noreferrer"
                class="p-2 rounded-full bg-muted hover:bg-accent hover:text-accent-foreground transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z" />
                </svg>
            </a>

            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $url; ?>"
                target="_blank" rel="noopener noreferrer"
                class="p-2 rounded-full bg-muted hover:bg-accent hover:text-accent-foreground transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
                    <rect width="4" height="12" x="2" y="9" />
                    <circle cx="4" cy="4" r="2" />
                </svg>
            </a>

            <button onclick="navigator.clipboard.writeText(window.location.href)"
                class="p-2 rounded-full bg-muted hover:bg-accent hover:text-accent-foreground transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2" />
                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2" />
                </svg>
            </button>
        </div>

    </div>
<?php
}


// =============================================================================
// NASLOV, LOKACIJA I CENA
// =============================================================================

function jd_output_title()
{
    $post_id       = get_the_ID();
    $location      = get_post_meta($post_id, '_property_location', true)  ?: 'Dorćol, Cara Dušana, Beograd';
    $price         = get_post_meta($post_id, '_property_price', true)      ?: '650';
    $listing_type  = get_post_meta($post_id, '_listing_type', true)        ?: 'Izdavanje';
    $is_new        = get_post_meta($post_id, '_property_is_new', true)     ?: '1';
    $property_type = get_post_meta($post_id, '_property_type', true)       ?: 'Stan';
?>
    <div>
        <div class="flex flex-wrap gap-2 mb-3">
            <?php if ($listing_type) : ?>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-accent text-accent-foreground font-body">
                    <?php echo esc_html($listing_type); ?>
                </span>
            <?php endif; ?>

            <?php if ($property_type) : ?>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary text-primary-foreground font-body">
                    <?php echo esc_html($property_type); ?>
                </span>
            <?php endif; ?>

            <?php if ($is_new) : ?>
                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-purple-glow text-primary-foreground font-body">
                    Novo
                </span>
            <?php endif; ?>
        </div>

        <h1 class="font-heading text-3xl sm:text-4xl lg:text-5xl font-semibold text-foreground mb-3 leading-tight">
            <?php the_title(); ?>
        </h1>

        <?php if ($location) : ?>
            <div class="flex items-center gap-2 text-muted-foreground mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                    <circle cx="12" cy="10" r="3" />
                </svg>
                <span class="font-body"><?php echo esc_html($location); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($price) : ?>
            <div class="flex flex-wrap items-baseline gap-4">
                <span class="font-heading text-3xl sm:text-4xl font-bold text-foreground">
                    <?php echo esc_html($price); ?> EUR/mesec
                </span>
            </div>
        <?php endif; ?>
    </div>
<?php
}


// =============================================================================
// STATISTIKE (površina, sobe, kupatila, sprat)
// =============================================================================

function jd_output_stats()
{
    $post_id   = get_the_ID();
    $area      = get_post_meta($post_id, '_property_area',      true) ?: '65';
    $rooms     = get_post_meta($post_id, '_property_rooms',     true) ?: '2';
    $bathrooms = get_post_meta($post_id, '_property_bathrooms', true) ?: '1';
    $floor     = get_post_meta($post_id, '_property_floor',     true) ?: '3/5';
?>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

        <?php if ($area) : ?>
            <div class="bg-secondary rounded-xl p-5 text-center border border-border">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent mx-auto mb-2">
                    <path d="M8 3H5a2 2 0 0 0-2 2v3" />
                    <path d="M21 8V5a2 2 0 0 0-2-2h-3" />
                    <path d="M3 16v3a2 2 0 0 0 2 2h3" />
                    <path d="M16 21h3a2 2 0 0 0 2-2v-3" />
                </svg>
                <div class="text-xs font-body text-muted-foreground mb-1">Površina</div>
                <div class="font-heading text-lg font-bold text-foreground"><?php echo esc_html($area); ?> m²</div>
            </div>
        <?php endif; ?>

        <?php if ($rooms) : ?>
            <div class="bg-secondary rounded-xl p-5 text-center border border-border">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent mx-auto mb-2">
                    <path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8" />
                    <path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4" />
                    <path d="M12 4v6" />
                    <path d="M2 18h20" />
                </svg>
                <div class="text-xs font-body text-muted-foreground mb-1">Sobe</div>
                <div class="font-heading text-lg font-bold text-foreground"><?php echo esc_html($rooms); ?></div>
            </div>
        <?php endif; ?>

        <?php if ($bathrooms) : ?>
            <div class="bg-secondary rounded-xl p-5 text-center border border-border">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent mx-auto mb-2">
                    <path d="M10 4 8 6" />
                    <path d="M17 19v2" />
                    <path d="M2 12h20" />
                    <path d="M7 19v2" />
                    <path d="M9 5 7.621 3.621A2.121 2.121 0 0 0 4 5v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5" />
                </svg>
                <div class="text-xs font-body text-muted-foreground mb-1">Kupatila</div>
                <div class="font-heading text-lg font-bold text-foreground"><?php echo esc_html($bathrooms); ?></div>
            </div>
        <?php endif; ?>

        <?php if ($floor) : ?>
            <div class="bg-secondary rounded-xl p-5 text-center border border-border">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent mx-auto mb-2">
                    <path d="m21 16-4 4-4-4" />
                    <path d="M17 20V4" />
                    <path d="m3 8 4-4 4 4" />
                    <path d="M7 4v16" />
                </svg>
                <div class="text-xs font-body text-muted-foreground mb-1">Sprat</div>
                <div class="font-heading text-lg font-bold text-foreground"><?php echo esc_html($floor); ?></div>
            </div>
        <?php endif; ?>

    </div>
<?php
}


// =============================================================================
// OPIS NEKRETNINE
// =============================================================================

function jd_output_description()
{
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                <path d="M10 9H8" />
                <path d="M16 13H8" />
                <path d="M16 17H8" />
            </svg>
            Opis nekretnine
        </h2>
        <div class="font-body text-muted-foreground leading-relaxed text-base maxwell-content">
            Ekskluzivan dvosoban stan na jednoj od najpoželjnijih lokacija – Dorćol

            <p>Uživajte u svakodnevnom pogledu na Dunav iz moderno dizajniranog prostora koji odiše stilom i funkcionalnošću. Enterijer je pažljivo biran kako bi pružio maksimalan komfor i estetski doživljaj.</p>

            <p>Zašto izdvajamo ovu nekretninu:</p>

            <ul>
                <li>✨ Savremeno uređen enterijer bez dodatnih ulaganja</li>
                <li>🌅 Panoramski pogled na reku</li>
                <li>🏙️ Atraktivna mikrolokacija u centru dešavanja</li>
            </ul>

            <p>Dodatne pogodnosti:</p>

            <ul>
                <li>Kompletno opremljena kuhinja</li>
                <li>Kvalitetan nameštaj uključen u cenu</li>
                <li>Svetao i funkcionalan raspored</li>
            </ul>

            <p>👉 Nekretnina koja pruža premium životni stil u urbanom okruženju</p>
        </div>
    </div>
<?php
}


// =============================================================================
// KARAKTERISTIKE
// =============================================================================

function jd_output_features()
{
    $features = get_post_meta(get_the_ID(), '_property_features', true) ?: [
        'Pogled na Dunav',
        'Klima',
        'Veš mašina',
        'Terasa 8m²',
        'Internet',
        'Lift',
    ];
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                <path d="m9 11 3 3L22 4" />
            </svg>
            Karakteristike
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <?php foreach ((array) $features as $feature) : ?>
                <div class="flex items-center gap-2.5 font-body text-sm text-foreground bg-secondary/60 rounded-lg px-4 py-3 border border-border">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent flex-shrink-0">
                        <path d="M21.801 10A10 10 0 1 1 17 3.335" />
                        <path d="m9 11 3 3L22 4" />
                    </svg>
                    <?php echo esc_html($feature); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
}


// =============================================================================
// DODATNI PODACI (accordion)
// =============================================================================

function jd_output_additional()
{
    $post_id      = get_the_ID();
    $heating      = get_post_meta($post_id, '_property_heating',      true) ?: 'Centralno grejanje';
    $parking      = get_post_meta($post_id, '_property_parking',      true) ?: 'Garaža';
    $year_built   = get_post_meta($post_id, '_property_year_built',   true) ?: '2018';
    $energy_class = get_post_meta($post_id, '_property_energy_class', true) ?: 'B';
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
                        <path d="M16 10h.01" />
                        <path d="M16 14h.01" />
                        <path d="M8 10h.01" />
                        <path d="M8 14h.01" />
                    </svg>
                    Dodatni podaci o nekretnini
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m6 9 6 6 6-6" />
                </svg>
            </summary>
            <div class="pb-4 pt-2 grid grid-cols-2 gap-4 font-body text-sm text-muted-foreground">
                <?php if ($heating) : ?>
                    <div><span class="text-foreground font-medium">Grejanje:</span> <?php echo esc_html($heating); ?></div>
                <?php endif; ?>
                <?php if ($parking) : ?>
                    <div><span class="text-foreground font-medium">Parking:</span> <?php echo esc_html($parking); ?></div>
                <?php endif; ?>
                <?php if ($year_built) : ?>
                    <div><span class="text-foreground font-medium">Godina gradnje:</span> <?php echo esc_html($year_built); ?></div>
                <?php endif; ?>
                <?php if ($energy_class) : ?>
                    <div><span class="text-foreground font-medium">Energetska klasa:</span> <?php echo esc_html($energy_class); ?></div>
                <?php endif; ?>
            </div>
        </details>
    </div>
<?php
}


// =============================================================================
// MAPA
// =============================================================================

function jd_output_map()
{
    $location = get_post_meta(get_the_ID(), '_property_location', true) ?: 'Dorćol, Cara Dušana, Beograd, Srbija';
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                <circle cx="12" cy="10" r="3" />
            </svg>
            Lokacija
        </h2>
        <div class="rounded-xl overflow-hidden border border-border aspect-[16/9]">
            <iframe
                title="Lokacija nekretnine"
                src="https://maps.google.com/maps?q=<?php echo urlencode($location); ?>&t=&z=15&ie=UTF8&iwloc=&output=embed"
                class="w-full h-full"
                loading="lazy"
                allowfullscreen>
            </iframe>
        </div>
        <p class="font-body text-sm text-muted-foreground mt-3">
            📍 <?php echo esc_html($location); ?>
        </p>
    </div>
<?php
}


// =============================================================================
// ČESTA PITANJA
// =============================================================================

function jd_output_faq()
{
    $faqs = [
        [
            'question' => 'Koji su koraci pri iznajmljivanju ove nekretnine?',
            'answer'   => 'Kontaktirajte nas, zakažite razgledanje, dogovorite uslove i potpišite ugovor o zakupu.',
        ],
        [
            'question' => 'Da li je moguće finansiranje putem kredita?',
            'answer'   => 'Za nekretnine na prodaju — da, sarađujemo sa više banaka. Za izdavanje — nije primenjivo.',
        ],
        [
            'question' => 'Koliki su dodatni troškovi?',
            'answer'   => 'Agencijska provizija iznosi jednu mesečnu kiriju. Komunalije su obračunate posebno.',
        ],
        [
            'question' => 'Da li je moguće zakazati razgledanje?',
            'answer'   => 'Naravno! Kontaktirajte nas telefonom ili putem forme i zakažite besplatno razgledanje u terminu koji vam odgovara.',
            'open'     => true,
        ],
    ];

    // Ovde možeš da povučeš FAQ i iz custom meta ako imaš ACF repeater
    $custom_faqs = get_post_meta(get_the_ID(), '_property_faqs', true);
    if (! empty($custom_faqs)) {
        $faqs = $custom_faqs;
    }
?>
    <div>
        <h2 class="font-heading text-xl font-semibold text-foreground mb-6 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
            </svg>
            Česta pitanja
        </h2>
        <div class="space-y-3">
            <?php foreach ($faqs as $faq) : ?>
                <details class="border border-border rounded-xl px-6 bg-card" <?php echo ! empty($faq['open']) ? 'open' : ''; ?>>
                    <summary class="flex items-center justify-between py-4 cursor-pointer font-heading text-base font-semibold text-foreground list-none">
                        <?php echo esc_html($faq['question']); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0">
                            <path d="m6 9 6 6 6-6" />
                        </svg>
                    </summary>
                    <div class="pb-4 pt-0">
                        <p class="font-body text-sm text-muted-foreground leading-relaxed">
                            <?php echo esc_html($faq['answer']); ?>
                        </p>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
<?php
}


// =============================================================================
// SIDEBAR — AGENT KARTICA SA KONTAKTOM
// =============================================================================

function jd_output_agent_card()
{
    $post_id = get_the_ID();
    $price   = get_post_meta($post_id, '_property_price',    true) ?: '650';
    $phone   = get_post_meta($post_id, '_agent_phone',       true) ?: '+381 11 123 4567';
    $email   = get_post_meta($post_id, '_agent_email',       true) ?: 'info@jdproperties.rs';
    $agent   = get_post_meta($post_id, '_agent_name',        true) ?: 'JD Properties';
    $wa      = preg_replace('/[^0-9]/', '', $phone);
    $title   = urlencode(get_the_title());
?>
    <div class="bg-card border border-border rounded-xl p-6 sticky top-24 space-y-6">

        <div>
            <div class="font-heading text-3xl font-bold text-foreground">
                <?php echo esc_html($price); ?> EUR/mesec
            </div>
            <p class="text-sm font-body text-muted-foreground">mesečna cena</p>
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

        <div class="space-y-3">
            <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"
                class="flex items-center justify-center gap-2 w-full bg-accent text-accent-foreground font-body text-sm font-semibold tracking-wide px-6 py-3.5 rounded-lg hover:bg-accent/90 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                </svg>
                Pozovite nas
            </a>

            <a href="<?php echo esc_url(get_permalink(get_page_by_path('kontakt'))); ?>"
                class="flex items-center justify-center gap-2 w-full bg-primary text-primary-foreground font-body text-sm font-semibold tracking-wide px-6 py-3.5 rounded-lg hover:bg-primary/90 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="16" x="2" y="4" rx="2" />
                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                </svg>
                Pošaljite upit
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
// SIDEBAR — PROMO CENOVNIK
// =============================================================================

function jd_output_pricing_promo()
{
    $cenovnik_url = get_permalink(get_page_by_path('cenovnik'));
?>
    <div class="bg-gradient-to-br from-primary to-accent rounded-xl p-6 text-primary-foreground">
        <h3 class="font-heading text-lg font-semibold mb-2">Koliko košta naša usluga?</h3>
        <p class="font-body text-sm text-primary-foreground/70 mb-4">
            Transparentne cene bez skrivenih troškova. Pogledajte naš detaljan cenovnik.
        </p>
        <a href="<?php echo esc_url($cenovnik_url); ?>"
            class="inline-flex items-center gap-2 bg-primary-foreground text-primary font-body text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-primary-foreground/90 transition-colors">
            Pogledaj cenovnik
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
            </svg>
        </a>
    </div>
<?php
}


// =============================================================================
// POSLE SADRŽAJA — CTA BANER
// =============================================================================

function jd_output_cta_banner()
{
    $phone = get_option('jd_contact_phone', '+381 11 123 4567');
    $kontakt_url = get_permalink(get_page_by_path('kontakt'));
?>
    <div class="mt-16 print:hidden">
        <div class="bg-gradient-to-r from-primary via-accent to-primary rounded-2xl p-10 sm:p-14 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-purple-glow/10 to-transparent"></div>
            <div class="relative z-10">
                <h2 class="font-heading text-3xl sm:text-4xl text-primary-foreground mb-4">
                    Zainteresovani ste za ovu nekretninu?
                </h2>
                <p class="font-body text-primary-foreground/70 mb-8 max-w-xl mx-auto">
                    Zakažite besplatno razgledanje ili nas kontaktirajte za više informacija. Naš tim stručnjaka je tu za vas.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="tel:<?php echo esc_attr(preg_replace('/\s+/', '', $phone)); ?>"
                        class="inline-flex items-center gap-2 bg-primary-foreground text-primary font-body text-sm font-semibold tracking-wide px-8 py-3.5 rounded-lg hover:bg-primary-foreground/90 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                        </svg>
                        <?php echo esc_html($phone); ?>
                    </a>
                    <a href="<?php echo esc_url($kontakt_url); ?>"
                        class="inline-flex items-center gap-2 border border-primary-foreground/30 text-primary-foreground font-body text-sm tracking-wide px-8 py-3.5 rounded-lg hover:bg-primary-foreground/10 transition-colors">
                        Pošaljite upit
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="m12 5 7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php
}


// =============================================================================
// POSLE SADRŽAJA — SLIČNE NEKRETNINE
// =============================================================================

function jd_output_similar()
{
    $post_id = get_the_ID();

    $similar = new WP_Query([
        'post_type'      => 'property',
        'posts_per_page' => 3,
        'post__not_in'   => [$post_id],
        'orderby'        => 'rand',
    ]);

    if (! $similar->have_posts()) return;
?>
    <div class="mt-16">
        <h2 class="font-heading text-2xl sm:text-3xl font-semibold text-foreground mb-8">Slične nekretnine</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($similar->have_posts()) : $similar->the_post();
                $s_id    = get_the_ID();
                $s_price = get_post_meta($s_id, '_property_price', true);
                $s_area  = get_post_meta($s_id, '_property_area',  true);
                $s_rooms = get_post_meta($s_id, '_property_rooms', true);
                $s_floor = get_post_meta($s_id, '_property_floor', true);
                $s_loc   = get_post_meta($s_id, '_property_location', true);
                $s_type  = get_post_meta($s_id, '_property_type', true);
                $s_listing = get_post_meta($s_id, '_listing_type', true);
            ?>
                <a class="group block bg-card rounded-lg overflow-hidden border border-border card-hover" href="<?php the_permalink(); ?>">

                    <div class="relative aspect-[4/3] bg-muted overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-500']); ?>
                        <?php else : ?>
                            <div class="absolute inset-0 bg-gradient-to-br from-muted to-muted-foreground/10 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-muted-foreground/30">
                                    <rect width="16" height="20" x="4" y="2" rx="2" ry="2" />
                                    <path d="M9 22v-4h6v4" />
                                    <path d="M8 6h.01" />
                                    <path d="M16 6h.01" />
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="absolute top-3 left-3 flex gap-2">
                            <?php if ($s_listing) : ?>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-accent text-accent-foreground font-body">
                                    <?php echo esc_html($s_listing); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex items-center justify-center gap-6 py-3 bg-secondary border-b border-border text-sm font-body font-semibold text-foreground">
                        <?php if ($s_area) : ?>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                                    <path d="M8 3H5a2 2 0 0 0-2 2v3" />
                                    <path d="M21 8V5a2 2 0 0 0-2-2h-3" />
                                    <path d="M3 16v3a2 2 0 0 0 2 2h3" />
                                    <path d="M16 21h3a2 2 0 0 0 2-2v-3" />
                                </svg>
                                <span><?php echo esc_html($s_area); ?> m²</span>
                            </div>
                        <?php endif; ?>

                        <?php if ($s_rooms) : ?>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                                    <path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8" />
                                    <path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4" />
                                    <path d="M12 4v6" />
                                    <path d="M2 18h20" />
                                </svg>
                                <span><?php echo esc_html($s_rooms); ?> sobe</span>
                            </div>
                        <?php endif; ?>

                        <?php if ($s_floor) : ?>
                            <div class="flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-accent">
                                    <path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z" />
                                    <path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65" />
                                    <path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65" />
                                </svg>
                                <span><?php echo esc_html($s_floor); ?> sprat</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="p-5 space-y-3">
                        <?php if ($s_type) : ?>
                            <span class="text-xs font-body font-medium text-accent uppercase tracking-wider"><?php echo esc_html($s_type); ?></span>
                        <?php endif; ?>

                        <h3 class="font-heading text-lg font-semibold text-foreground leading-tight line-clamp-2 group-hover:text-accent transition-colors">
                            <?php the_title(); ?>
                        </h3>

                        <?php if ($s_loc) : ?>
                            <div class="flex items-center gap-1.5 text-muted-foreground">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0" />
                                    <circle cx="12" cy="10" r="3" />
                                </svg>
                                <span class="text-sm font-body"><?php echo esc_html($s_loc); ?></span>
                            </div>
                        <?php endif; ?>

                        <?php if ($s_price) : ?>
                            <div class="pt-3 border-t border-border">
                                <span class="font-heading text-xl font-bold text-foreground">
                                    <?php echo esc_html($s_price); ?> EUR
                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                </a>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </div>
    </div>
<?php
}
