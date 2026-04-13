<?php

/**
 * Template Name: Properties
 */

get_header();
$chevron_up   = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-up w-4 h-4 text-muted-foreground"><path d="m18 15-6-6-6 6"></path></svg>';
$chevron_down = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 text-muted-foreground"><path d="m6 9 6 6 6-6"></path></svg>';

$input_classes = 'flex w-full border border-input bg-background px-3 py-2 ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm font-body rounded-sm h-10 text-sm';

$location_name = single_term_title("", false);
$term = get_queried_object();
$term_id = $term->term_id;

$additional_pages = get_field('additional_content', $term->taxonomy . '_' . $term->term_id);
?>
<style>
    :root {
        --pagination-border: #e5e7eb;
        --pagination-text: #6b7280;
        --pagination-accent: #f59e0b;
        --pagination-accent-bg: rgba(245, 158, 11, 0.1);
        --pagination-hover: #f59e0b;
        --pagination-disabled: #9ca3af;
    }

    nav.navigation h2 {
        display: none;
    }

    .nav-links {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.4rem;
    }

    .nav-links .page-numbers {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 2.25rem;
        min-width: 2.25rem;
        padding: 0 0.75rem;
        border-radius: 0.125rem;
        border: 1px solid var(--pagination-border);
        font-size: 0.875rem;
        font-family: system-ui, -apple-system, sans-serif;
        font-weight: 400;
        text-decoration: none;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        color: var(--pagination-text);
        background-color: #ffffff;
    }

    .nav-links a.page-numbers:hover {
        border-color: var(--pagination-hover);
        color: var(--pagination-hover);
        background-color: #ffffff;
        transform: translateY(-1px);
    }

    .nav-links .page-numbers.current {
        border-color: var(--pagination-accent);
        color: var(--pagination-accent);
        background-color: var(--pagination-accent-bg);
        font-weight: 600;
    }

    .nav-links .page-numbers.prev.disabled,
    .nav-links .page-numbers.next.disabled {
        opacity: 0.5;
        cursor: not-allowed;
        color: var(--pagination-disabled);
    }

    .nav-links .page-numbers.dots {
        border: none;
        cursor: default;
        color: var(--pagination-text);
        background: transparent;
    }

    .nav-links .page-numbers.dots:hover {
        border: none;
        color: var(--pagination-text);
        transform: none;
    }

    /* Fokus stil za pristupačnost */
    .nav-links .page-numbers:focus-visible {
        outline: 2px solid var(--pagination-accent);
        outline-offset: 2px;
        border-radius: 0.125rem;
    }

    /* Responsive dizajn */
    @media (max-width: 768px) {
        .nav-links {
            gap: 0.375rem;
        }

        .nav-links .page-numbers {
            height: 2rem;
            min-width: 2rem;
            padding: 0 0.5rem;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 640px) {
        .nav-links {
            gap: 0.25rem;
            flex-wrap: wrap;
        }
    }
</style>

<main>
    <section class="pt-8">
    
        <div class="relative bg-gradient-purple py-24 overflow-hidden mb-24
         hero-text-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
            <div class="absolute top-20 right-[10%] w-72 h-72 rounded-full border border-primary-foreground/8 animate-pulse-subtle"></div>
            <div class="absolute bottom-10 left-[5%] w-48 h-48 rounded-full border border-primary-foreground/5"></div>
            <div class="absolute top-1/3 right-[25%] w-3 h-3 rounded-full bg-accent opacity-60"></div>
            <div class="absolute bottom-1/4 right-[15%] w-2 h-2 rounded-full bg-accent opacity-40"></div>
            <div class="container mx-auto px-6 relative z-10">
                <div class="max-w-3xl">
                    <h1 class="h1-responsive font-bold text-primary-foreground mb-6"><?php echo $location_name; ?></h1>
                    <?php if (!empty($term->description)): ?>
                        <div class="text-lg sm:text-xl text-primary-foreground/65 max-w-2xl mb-10 leading-relaxed"><?php echo wp_kses_post($term->description); ?></div>
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

        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex gap-8">

                <!-- ===== GLAVNI SADRŽAJ ===== -->
                <div class="flex-1 min-w-0">

                    <!-- Grid rezultata -->
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 gap-6">
                        <?php
                        while (have_posts()) :
                            the_post();

                            /**
                             * Run the loop for the search to output the results.
                             * If you want to overload this in a child theme then include a file
                             * called content-search.php and that will be used instead.
                             */
                            get_template_part('template-parts/content-property');

                        endwhile;
                        ?>
                    </div>

                    <!-- Paginacija -->
                    <div class="flex items-center justify-center gap-2 mt-10">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,      // Broj stranica prikazanih sa leve i desne strane trenutne
                            'prev_text' => __('< Previous', 'textdomain'),
                            'next_text' => __('Next >', 'textdomain'),
                        ));
                        ?>
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