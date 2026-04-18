<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('properties_list');
$reverse = $data['revers'] ?? 'no';
$color_mode = $data['color_mode'] ?? 'dark';
$layout = $data['layout'] ?? 'default';
$layout_number = $data['layout_number'] ?? 'two';
$color_mode = $data['background'];

// Umesto da menjate postojeći $query, uradite ovo:


?>
<style>
    .case-item.hidden-case-item {
        display: none;
    }

    .case-study-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    /* Animacija za prikazivanje novih elemenata */
    .case-item.show-case-item {
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
<?php echo _spacing_full('properties-list', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="properties-list-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class);
                                                                                                            echo ' ' . _background($data['background']); ?>">

    <?php

    $args = get_property_args($data);
    $query = new WP_Query($args);
    $found_posts = $query->found_posts;
    ?>
    <?php if ($query->have_posts()) : ?>
        <div class="container mx-auto px-6 <?php echo $layout_number === 'two' ? 'max-w-5xl' : ''; ?>">

            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-4">
                <div class="max-w-2xl">
                    <?php if (!empty($data['top_title'])) : ?>
                        <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
                    <?php endif; ?>
                    <?php echo _heading($data['title'], "mb-6" . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
                    <?php if (!empty($data['text'])) : ?>
                        <div class="text-lg maxwell-content <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?>"><?php echo apply_filters('the_content', $data['text']); ?></div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($data['link'])) : ?>
                    <?php echo _link_1($data['link'], ''); ?>
                <?php endif; ?>
            </div>
            <?php
            // The Loop.

            ?>
            <div class="grid <?php echo $layout_number === 'two' ? 'md:grid-cols-2' : 'md:grid-cols-3'; ?> gap-6 ">
                <?php
                $counter = 0;
                while ($query->have_posts()) :
                    $query->the_post();
                    $counter++;
                    $hidden_class = ($counter > 6) ? 'hidden-case-item' : '';
                ?>
                    <div class="case-item <?php echo $hidden_class; ?>">
                        <?php get_template_part('template-parts/content', 'property'); ?>
                    </div>
                <?php
                endwhile;
                wp_reset_postdata();
                ?>

            </div>
        </div>

        <?php if ($found_posts > 6) : ?>
            <div class="text-center mt-8">
                <button id="load-more-btn" class="px-6 py-3 bg-accent text-white rounded-lg hover:bg-accent/80 transition-colors">
                    <?php echo $data['button_text'] ?? 'Load More' ?>
                </button>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <?php
        if (!empty($data['fallback_content'])) {
            echo gxdev_render_global_content($data['fallback_content']->post_name);
        }
        ?>
    <?php endif; ?>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadMoreBtn = document.getElementById('load-more-btn');

        if (loadMoreBtn) {
            let itemsToShow = 6;
            const allItems = document.querySelectorAll('.case-item');
            const totalItems = allItems.length;

            // Prikazujemo inicijalni broj elemenata
            function showItems(count) {
                allItems.forEach((item, index) => {
                    if (index < count) {
                        item.classList.remove('hidden-case-item');
                        if (index >= itemsToShow - 6) {
                            item.classList.add('show-case-item');
                        }
                    } else {
                        item.classList.add('hidden-case-item');
                        item.classList.remove('show-case-item');
                    }
                });
            }

            // Inicijalno prikazivanje
            showItems(itemsToShow);

            // Load more funkcionalnost
            loadMoreBtn.addEventListener('click', function() {
                // Određujemo koliko još elemenata ima za prikazati
                const remainingItems = totalItems - itemsToShow;
                const nextBatch = Math.min(6, remainingItems);

                if (nextBatch > 0) {
                    itemsToShow += nextBatch;
                    showItems(itemsToShow);
                }

                // Sakrivamo gumb ako su svi elementi prikazani
                if (itemsToShow >= totalItems) {
                    loadMoreBtn.style.display = 'none';
                }
            });
        }
    });
</script>