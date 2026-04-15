<?php
// Dohvati taksonomiju iz argumenata
$taxonomy = $args['taxonomy'] ?? '';

if ($taxonomy === 'cat') {
    $prop_categories = [];
} else {
    $prop_categories = get_terms([
        'taxonomy'   => 'cat',
        'post_type'  => 'properties',
        'hide_empty' => false,
    ]);
}

if ($taxonomy === 'jd-type') {
    $prop_types = [];
} else {
    $prop_types = get_terms([
        'taxonomy'   => 'jd-type',
        'post_type'  => 'properties',
        'hide_empty' => true,
    ]);
}

if ($taxonomy === 'location') {
    $locations = [];
} else {
    $locations = get_terms([
        'taxonomy'   => 'location',
        'post_type'  => 'properties',
        'hide_empty' => true,
        'number'     => 0, // sve lokacije, JS ce prikazati prvih 12
    ]);
}
$chevron_up   = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-4 h-4 text-muted-foreground"><path d="m18 15-6-6-6 6"></path></svg>';
$chevron_down = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-muted-foreground"><path d="m6 9 6 6 6-6"></path></svg>';

$input_classes = 'flex w-full border border-input bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm font-body rounded-sm h-10 text-sm';

// Funkcije za dohvat vrednosti za filtere
$min_price = get_min_price();
$max_price = get_max_price();
?>
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
                    data-value=""><?php echo __('Svi oglasi', 'gxdev'); ?></button>
                <?php if (! is_wp_error($prop_categories)) : foreach ($prop_categories as $cat) : ?>
                        <button
                            class="prop-category-btn text-left text-sm font-body px-3 py-2 rounded-sm transition-colors text-muted-foreground hover:text-foreground hover:bg-secondary/50"
                            data-value="<?php echo esc_attr($cat->slug); ?>"><?php echo esc_html($cat->name); ?></button>
                <?php endforeach;
                endif; ?>
            </div>
        </div>

        <?php if (!empty($prop_types)) : ?>
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
        <?php endif; ?>

        <?php if (!empty($locations)) : ?>
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
        <?php endif; ?>

        <!-- 5. Cena — range slider -->
        <div class="filter-section border-b border-border pb-5 mb-5">
            <button class="filter-toggle flex items-center justify-between w-full text-left mb-3">
                <span class="font-heading text-sm font-semibold text-foreground uppercase tracking-wider">Cena (EUR)</span>
                <?php echo $chevron_up; ?>
            </button>
            <div class="filter-content px-1">
                <div class="price-range-wrap relative pt-5 pb-2">
                    <input type="range" id="price-min" class="range-input" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" step="1000" value="<?php echo $min_price; ?>">
                    <input type="range" id="price-max" class="range-input" min="<?php echo $min_price; ?>" max="<?php echo $max_price; ?>" step="1000" value="<?php echo $max_price; ?>">
                    <div class="range-track">
                        <div class="range-fill" id="price-fill"></div>
                    </div>
                </div>
                <div class="flex items-center justify-between text-xs font-body text-muted-foreground mt-2">
                    <span id="price-min-label"><?php echo $min_price; ?> €</span>
                    <span id="price-max-label"><?php echo $max_price; ?> €</span>
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