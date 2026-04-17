<?php

/**
 * Template Name: Properties Taxonomy
 */

get_header();

// Učitaj taksonomije dinamički
$prop_categories = get_terms([
    'taxonomy'   => 'cat',
    'post_type'  => 'properties',
    'hide_empty' => false,
]);

$prop_types = get_terms([
    'taxonomy'   => 'jd-type',
    'post_type'  => 'properties',
    'hide_empty' => true,
]);

$locations = get_terms([
    'taxonomy'   => 'location',
    'post_type'  => 'properties',
    'hide_empty' => true,
    'number'     => 0, // sve lokacije, JS ce prikazati prvih 12
]);

$chevron_up   = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-4 h-4 text-muted-foreground"><path d="m18 15-6-6-6 6"></path></svg>';
$chevron_down = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-muted-foreground"><path d="m6 9 6 6 6-6"></path></svg>';

$input_classes = 'flex w-full border border-input bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm font-body rounded-sm h-10 text-sm';

$page_id = get_the_ID();
$additional_pages = get_field('additional_content', $page_id);
?>

<main >
    <section class="pt-8">
        <div class="relative bg-gradient-navy py-24 overflow-hidden mb-24>">
            <div class="absolute top-20 right-[10%] w-72 h-72 rounded-full border border-primary-foreground/8 animate-pulse-subtle"></div>
            <div class="absolute bottom-10 left-[5%] w-48 h-48 rounded-full border border-primary-foreground/5"></div>
            <div class="absolute top-1/3 right-[25%] w-3 h-3 rounded-full bg-accent opacity-60"></div>
            <div class="absolute bottom-1/4 right-[15%] w-2 h-2 rounded-full bg-accent opacity-40"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="h1-responsive font-bold text-primary-foreground mb-6"><?php echo the_title(); ?></h1>
                    <?php if (!empty($term->description)): ?>
                        <div class="text-lg sm:text-xl text-primary-foreground/65 max-w-2xl mb-10 leading-relaxed"><?php echo the_content() ?></div>
                    <?php endif; ?>
                </div>
                <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-primary-foreground/30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down w-4 h-4 animate-bounce">
                        <path d="M12 5v14"></path>
                        <path d="m19 12-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>
        <?php if (!empty($additional_pages) && isset($additional_pages['top'])): ?>
            <?php echo gxdev_render_global_content($additional_pages['top']->post_name); ?>
        <?php endif; ?>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8 sm:mb-12 lg:mb-16">
            <div class="flex gap-8">

                <!-- ===== SIDEBAR FILTERI ===== -->
                <aside class="hidden lg:block w-72 flex-shrink-0">
                    <div class="sticky top-24 bg-card border border-border rounded-lg p-6 max-h-[calc(100vh-7rem)] overflow-y-auto" id="properties-filters">

                        <div class="flex items-center justify-between mb-6">
                            <h2 class="font-heading text-lg font-semibold text-foreground"><?php echo __("Filteri", 'gxdev'); ?></h2>
                            <button id="reset-filters" class="text-xs font-body text-muted-foreground hover:text-accent transition-colors"><?php echo __("Resetuj", 'gxdev'); ?></button>
                        </div>

                        <!-- 1. Search -->
                        <div class="mb-5 pb-5 border-b border-border">
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted-foreground">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <path d="m21 21-4.3-4.3"></path>
                                </svg>
                                <input
                                    id="filter-search"
                                    class="<?php echo $input_classes; ?> pl-10"
                                    placeholder="Pretraga..."
                                    type="text"
                                    value="<?php echo esc_attr(get_search_query()); ?>">
                            </div>
                        </div>

                        <!-- 2. Tip oglasa (prop-category) -->
                        <div class="filter-section border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider"><?php echo __("Tip oglasa", "gxdev"); ?></span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content flex flex-col gap-2">
                                <button
                                    class="prop-category-btn text-left text-sm font-body px-3 py-2 rounded-sm transition-colors bg-accent/10 text-accent font-medium"
                                    data-value="">Svi oglasi</button>
                                <?php if (! is_wp_error($prop_categories)) : foreach ($prop_categories as $cat) : ?>
                                        <button
                                            class="prop-category-btn text-left text-sm font-body px-3 py-2 rounded-sm transition-colors text-muted-foreground hover:text-foreground hover:bg-secondary/50"
                                            data-value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
                                <?php endforeach;
                                endif; ?>
                            </div>
                        </div>

                        <!-- 3. Tip nekretnine (prop-type) -->
                        <div class="filter-section border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider"><?php echo __("Tip nekretnine", "gxdev"); ?></span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content space-y-2.5">
                                <?php if (! is_wp_error($prop_types)) : foreach ($prop_types as $type) : ?>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input
                                                type="checkbox"
                                                class="prop-type-cb peer h-4 w-4 shrink-0 rounded-sm border border-border accent-accent cursor-pointer"
                                                value="<?php echo esc_attr($type->slug); ?>">
                                            <span class="text-sm font-body text-muted-foreground group-hover:text-foreground transition-colors">
                                                <?php echo esc_html($type->name); ?>
                                            </span>
                                        </label>
                                <?php endforeach;
                                endif; ?>
                            </div>
                        </div>

                        <!-- 4. Lokacija (taxonomy=location) — checkbox sa "prikaži više" -->
                        <div class="filter-section border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider"><?php echo __("Lokacija", "gxdev"); ?></span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content space-y-2.5">
                                <?php if (! is_wp_error($locations)) :
                                    $loc_count = 0;
                                    foreach ($locations as $loc) :
                                        $loc_count++;
                                        $hidden_class = $loc_count > 12 ? 'location-extra hidden' : '';
                                ?>
                                        <label class="flex items-center gap-3 cursor-pointer group <?php echo $hidden_class; ?>">
                                            <input
                                                type="checkbox"
                                                class="location-cb peer h-4 w-4 shrink-0 rounded-sm border border-border accent-accent cursor-pointer"
                                                value="<?php echo esc_attr($loc->slug); ?>">
                                            <span class="text-sm font-body text-muted-foreground group-hover:text-foreground transition-colors">
                                                <?php echo esc_html($loc->name); ?>
                                            </span>
                                        </label>
                                <?php endforeach;
                                endif; ?>

                                <?php if (count($locations) > 12) : ?>
                                    <button id="show-more-locations" class="text-xs font-body text-accent hover:underline mt-1">
                                        + <?php echo __("Prikaži više lokacija", "gxdev") ?>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- 5. Cena — range slider -->
                        <div class="filter-section border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider">Cena (EUR)</span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content px-1">
                                <div class="price-range-wrap relative pt-5 pb-2">
                                    <input type="range" id="price-min" class="range-input" min="0" max="500000" step="1000" value="0">
                                    <input type="range" id="price-max" class="range-input" min="0" max="500000" step="1000" value="500000">
                                    <div class="range-track">
                                        <div class="range-fill" id="price-fill"></div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between text-xs font-body text-muted-foreground mt-2">
                                    <span id="price-min-label">0 €</span>
                                    <span id="price-max-label">500.000 €</span>
                                </div>
                            </div>
                        </div>

                        <!-- 6. Površina — range (input polja od/do) -->
                        <div class="filter-section border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider"><?php echo __("Površina", "gxdev"); ?> (m²)</span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content">
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" id="area-min" class="<?php echo $input_classes; ?>" placeholder="Od" min="0">
                                    <input type="number" id="area-max" class="<?php echo $input_classes; ?>" placeholder="Do" min="0">
                                </div>
                            </div>
                        </div>

                        <!-- 7. Broj soba — oblačići (property_structure) -->
                        <div class="filter-section border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider"><?php echo __("Broj soba", "gxdev"); ?></span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content flex flex-wrap gap-2">
                                <?php
                                $rooms = ['1', '2', '3', '4', '5+'];
                                foreach ($rooms as $r) :
                                ?>
                                    <button
                                        class="room-btn inline-flex items-center justify-center h-8 w-8 rounded-full border border-border text-sm font-body text-muted-foreground hover:border-accent hover:text-accent transition-colors"
                                        data-value="<?php echo esc_attr($r); ?>"><?php echo esc_html($r); ?></button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- 8. Sprat — oblačići (property_floor) -->
                        <div class="filter-section border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider"><?php echo __("Sprat", "gxdev"); ?></span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content flex flex-wrap gap-2">
                                <?php
                                $floors = ['PR', '1', '2', '3', '4', '5', '6+'];
                                foreach ($floors as $f) :
                                ?>
                                    <button
                                        class="floor-btn inline-flex items-center justify-center h-8 px-3 rounded-full border border-border text-sm font-body text-muted-foreground hover:border-accent hover:text-accent transition-colors"
                                        data-value="<?php echo esc_attr($f); ?>"><?php echo esc_html($f); ?></button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- 9. Broj spratova zgrade (property_floors_in_building) -->
                        <div class="filter-section last:border-0 last:mb-0 last:pb-0 border-b border-border pb-5 mb-5">
                            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider"><?php echo __("Spratova u zgradi", "gxdev"); ?></span>
                                <?php echo $chevron_up; ?>
                            </button>
                            <div class="filter-content flex flex-wrap gap-2">
                                <?php
                                $bld_floors = ['P', '1', '2', '3', '4', '5', '6', '7', '8+'];
                                foreach ($bld_floors as $bf) :
                                ?>
                                    <button
                                        class="bld-floor-btn inline-flex items-center justify-center h-8 px-3 rounded-full border border-border text-sm font-body text-muted-foreground hover:border-accent hover:text-accent transition-colors"
                                        data-value="<?php echo esc_attr($bf); ?>"><?php echo esc_html($bf); ?></button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                    </div>
                </aside>
                <!-- ===== KRAJ SIDEBAR ===== -->

                <!-- ===== GLAVNI SADRŽAJ ===== -->
                <div class="flex-1 min-w-0">

                    <!-- Toolbar: broj rezultata + sortiranje -->
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-sm font-body text-muted-foreground">
                            <span id="results-count" class="font-semibold text-foreground">...</span> nekretnina
                        </p>
                        <select
                            id="sort-select"
                            class="flex items-center justify-between border border-input bg-background px-3 py-2 ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 w-48 font-body rounded-sm h-10 text-sm">
                            <option value="date_desc"><?php echo __("Najnovije", "gxdev"); ?></option>
                            <option value="date_asc"><?php echo __("Najstarije", "gxdev"); ?></option>
                            <option value="price_asc"><?php echo __("Cena: rastuće", "gxdev"); ?></option>
                            <option value="price_desc"><?php echo __("Cena: opadajuće", "gxdev"); ?></option>
                            <option value="area_asc"><?php echo __("Površina: rastuće", "gxdev"); ?></option>
                            <option value="area_desc"><?php echo __("Površina: opadajuće", "gxdev"); ?></option>
                        </select>
                    </div>

                    <!-- Grid rezultata -->
                    <div id="properties-grid" class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-6">
                        <!-- AJAX će popuniti ovde -->
                        <div class="col-span-full flex justify-center py-12">
                            <div class="properties-loading-spinner"></div>
                        </div>
                    </div>

                    <!-- Paginacija -->
                    <div id="properties-pagination" class="flex items-center justify-center gap-2 mt-10">
                        <!-- AJAX popunjava -->
                    </div>

                </div>
                <!-- ===== KRAJ GLAVNOG SADRŽAJA ===== -->

            </div>
        </div>
        <?php      
        if (!empty($additional_pages)) {
            foreach ($additional_pages['bottom'] as $page) : ?>
                <?php echo gxdev_render_global_content($page->post_name); ?>
            <?php endforeach; ?>
        <?php } ?>
    </section>
</main>

<?php
// Prosleđujemo podatke u JS
wp_localize_script('properties-filters', 'propertiesAjax', [
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce'   => wp_create_nonce('properties_filter_nonce'),
]);
?>

<?php get_footer(); ?>