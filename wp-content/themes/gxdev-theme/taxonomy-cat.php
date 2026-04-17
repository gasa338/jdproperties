<?php

/**
 * Template Name: Properties
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

$page_id = get_the_ID();
$additional_pages = get_field('additional_content', $page_id);
$term = get_queried_object();
?>

<main >
    <section class="pt-8">
        <div class="relative bg-gradient-navy py-24 overflow-hidden mb-24">
            <div class="absolute top-20 right-[10%] w-72 h-72 rounded-full border border-primary-foreground/8 animate-pulse-subtle"></div>
            <div class="absolute bottom-10 left-[5%] w-48 h-48 rounded-full border border-primary-foreground/5"></div>
            <div class="absolute top-1/3 right-[25%] w-3 h-3 rounded-full bg-accent opacity-60"></div>
            <div class="absolute bottom-1/4 right-[15%] w-2 h-2 rounded-full bg-accent opacity-40"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="h1-responsive font-bold text-primary-foreground mb-6"><?php echo $term->name; ?></h1>
                    <?php if (!empty($term->description)): ?>
                        <div class="text-lg sm:text-xl text-primary-foreground/65 max-w-2xl mb-10 leading-relaxed"><?php echo $term->description; ?></div>
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
                <?php get_template_part('template-parts/content', 'filters', ['taxonomy'=> $term->taxonomy]); ?>
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

<?php get_footer(); ?>