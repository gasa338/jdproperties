<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('case_study');
$reverse = $data['revers'] ?? 'no';
$color_mode = $data['color_mode'] ?? 'dark';
$layout = $data['layout'] ?? 'default';
$layout_number = $data['layout_number'] ?? 'two';
$color_mode = $data['background'];

$load_element = $data['load_element'] ?? 'four';
$dynamic_load = $data['dynamic_load'] ?? "no";
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
<?php echo _spacing_full('case-study', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="case-study-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class);
                                                                                                        echo ' ' . _background($data['background']); ?>">
    <div class="container mx-auto px-6 <?php echo $layout_number === 'two' ? 'max-w-5xl' : ''; ?>">
        <?php if ($layout === 'horizontal') : ?>
            <div class="container mx-auto px-6">
                <div class="flex flex-col lg:flex-row gap-12">
                    <!-- Leva fiksna strana - header -->
                    <div class="lg:w-1/3 lg:self-start">
                        <div class="max-w-2xl">
                            <?php if (!empty($data['top_title'])) : ?>
                                <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
                            <?php endif; ?>

                            <?php echo _heading($data['title'], "mb-6" . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>

                            <?php if (!empty($data['text'])) : ?>
                                <div class="text-lg mb-8 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'; ?>">
                                    <?php echo apply_filters('the_content', $data['text']); ?></div>
                            <?php endif; ?>


                            <?php if (!empty($data['link'])) : ?>
                                <?php echo _link_1($data['link'], ''); ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Desna strana - boxevi u parovima -->
                    <?php if (!empty($data['items'])) : ?>
                        <div class="lg:w-2/3">
                            <div class="flex flex-col gap-6">
                                <?php
                                $chunks = array_chunk($data['items'], 2);
                                foreach ($chunks as $chunk) :
                                ?>
                                    <div class="grid md:grid-cols-2 gap-6">
                                        <?php foreach ($chunk as $item) : ?>
                                            <div class="block h-full">
                                                <div class="relative h-full rounded-lg overflow-hidden <?php echo $color_mode === 'dark_mode' ? 'bg-white/5' : 'bg-card'; ?> border border-border hover:border-accent/50 transition-all duration-500">
                                                    <div class="relative h-48 overflow-hidden">
                                                        <?php if ($item['image']) : $image = get_image($item['image']); ?>
                                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                                        <?php endif; ?>
                                                        <div class="absolute inset-0 bg-gradient-to-t from-card via-transparent to-transparent"></div>
                                                    </div>
                                                    <div class="p-6">
                                                        <?php if ($item['title']) : ?>
                                                            <h3 class="text-2xl font-bold mb-2 group-hover:text-accent <?php echo $color_mode === 'dark_mode' ? 'text-white' : ''; ?> transition-colors"><?php echo $item['title']; ?></h3>
                                                        <?php endif; ?>
                                                        <?php if ($item['main_text']) : ?>
                                                            <div class="mb-4 <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?> maxwell-content"><?php echo apply_filters('the_content', $item['main_text']); ?></div>
                                                        <?php endif; ?>

                                                        <?php if ($item['link']) : ?>
                                                            <?php echo _link_3($item['link'], '!text-accent no-underline'); ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-16">
                <div class="max-w-2xl">
                    <?php if (!empty($data['top_title'])) : ?>
                        <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
                    <?php endif; ?>
                    <?php echo _heading($data['title'], "mb-6" . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
                    <?php if (!empty($data['text'])) : ?>
                        <div class="text-lg maxwell-content <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?>"><?php echo apply_filters('the_content', $data['text']); ?></div>
                    <?php endif; ?>
                </div>
                <?php if ($load_element == 'no') : ?>
                    <?php if (!empty($data['link'])) : ?>
                        <?php echo _link_1($data['link'], ''); ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <?php if ($data['dynamic_load'] === 'yes') :
                $data['items'] = maxwell_get_cpt('case-study', -1);
                
            endif; ?>

            <?php if (!empty($data['items'])) : ?>
                <?php
                switch ($load_element) {
                    case 'four':
                        $initial_count = 4;
                        break;
                    case 'six':
                        $initial_count = 6;
                        break;
                    default:
                        $initial_count = 4;
                }


                $counter = 0;
                ?>
                <div class="grid <?php echo $layout_number === 'two' ? 'md:grid-cols-2' : 'md:grid-cols-3'; ?> gap-6 ">

                    <?php foreach ($data['items'] as $item) :
                        $counter++;
                        $hidden_class = ($counter > $initial_count) ? 'hidden-case-item' : '';
                    ?>
                        <div class="case-item <?php echo $hidden_class; ?>">
                            <div class="block h-full">
                                <div class="relative h-full rounded-lg overflow-hidden <?php echo $color_mode === 'dark_mode' ? 'bg-white/5' : 'bg-card'; ?> border border-border hover:border-accent/30 transition-all duration-500">
                                    <div class="relative h-48 overflow-hidden">
                                        <?php if ($data['dynamic_load'] === 'yes') : ?>
                                            <img src="<?php echo $item['image']['url']; ?>" alt="<?php echo $item['image']['alt']; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        <?php else: ?>
                                            <?php if ($item['image']) : $image = get_image($item['image']); ?>
                                                <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-gradient-to-t from-card via-transparent to-transparent"></div>
                                    </div>
                                    <div class="p-6">
                                        <?php if ($item['title']) : ?>
                                            <?php if ( !empty($item['link'])): ?>
                                                <a href="<?php echo $item['link']['url'] ?>" title="<?php echo $item['link']['title'] ?>" class="text-2xl font-bold mb-4 <?php echo $color_mode === 'dark_mode' ? 'text-white' : 'text-primary'; ?> transition-colors no-underline"><?php echo $item['title']; ?></a>
                                            <?php else: ?>
                                                <h3 class="text-2xl font-bold mb-4 <?php echo $color_mode === 'dark_mode' ? 'text-white' : ''; ?> transition-colors"><?php echo $item['title']; ?></h3>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (!empty($item['tag'])) : ?>
                                            <div class="mb-3">
                                                <?php if (is_array($item['tag'])): ?>
                                                    <a href="<?php echo $item['tag']['link']; ?>" class="px-3 py-1 rounded-full text-xs font-medium bg-accent text-white no-underline">
                                                        <?php echo $item['tag']['name']; ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-accent text-white">
                                                        <?php echo $item['tag']; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($item['main_text']) : ?>
                                            <div class="mb-4 maxwell-content <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : 'text-foreground-muted'; ?>"><?php echo $item['main_text']; ?></div>
                                        <?php endif; ?>

                                        <?php if ($item['link']) : ?>
                                            <?php echo _link_3(['url' => $item['link']['url'], 'title' => $data['button_text']], '!text-accent no-underline'); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($data['items']) > $initial_count) : ?>
                    <div class="text-center mt-8">
                        <button id="load-more-btn" class="px-6 py-3 bg-accent text-white rounded-lg hover:bg-accent/80 transition-colors">
                            Load More
                        </button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>
<?php if ($load_element != 'no') : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    
    if (loadMoreBtn) {
        let itemsToShow = <?php echo ($load_element === 'four') ? 4 : 6; ?>;
        const allItems = document.querySelectorAll('.case-item');
        const totalItems = allItems.length;
        
        // Prikazujemo inicijalni broj elemenata
        function showItems(count) {
            allItems.forEach((item, index) => {
                if (index < count) {
                    item.classList.remove('hidden-case-item');
                    if (index >= itemsToShow - <?php echo ($load_element === 'four') ? 4 : 6; ?>) {
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
            const nextBatch = Math.min(<?php echo ($load_element === 'four') ? 4 : 6; ?>, remainingItems);
            
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
<?php endif; ?>
