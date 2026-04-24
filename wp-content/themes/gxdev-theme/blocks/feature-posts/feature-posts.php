<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('feature_posts');
?>

<?php

$query = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 3
]);

if ($query->have_posts()) :
?>

    <section class="py-20 bg-background">
        <div class="container mx-auto px-6">

            <div class="grid gap-8 md:grid-cols-2">

                <?php
                $i = 0;

                while ($query->have_posts()) :
                    $query->the_post();
                    $i++;
                ?>

                    <?php if ($i === 1) : ?>

                        <!-- BIG POST -->

                        <article class="group relative overflow-hidden rounded-lg border border-border bg-card md:col-span-2">

                            <div class="aspect-[16/9] overflow-hidden">
                                <?php the_post_thumbnail('large', [
                                    'class' => 'w-full h-full object-cover transition duration-500 group-hover:scale-105'
                                ]); ?>
                            </div>

                            <div class="p-8">

                                <span class="text-sm font-medium text-accent">
                                    <?php echo get_the_category()[0]->name ?? ''; ?>
                                </span>

                                <h3 class="mt-2 text-2xl md:text-3xl font-semibold text-foreground">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <p class="mt-4 text-muted-foreground max-w-2xl">
                                    <?php echo wp_trim_words(get_the_excerpt(), 25); ?>
                                </p>

                            </div>

                        </article>

                    <?php else : ?>

                        <!-- SMALL POSTS -->

                        <article class="group border border-border rounded-lg bg-card overflow-hidden hover:shadow-lg transition">

                            <div class="aspect-[16/10] overflow-hidden">
                                <?php the_post_thumbnail('medium', [
                                    'class' => 'w-full h-full object-cover transition duration-500 group-hover:scale-105'
                                ]); ?>
                            </div>

                            <div class="p-6">

                                <span class="text-sm text-accent font-medium">
                                    <?php echo get_the_category()[0]->name ?? ''; ?>
                                </span>

                                <h3 class="mt-2 text-lg font-semibold text-foreground">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <p class="mt-3 text-sm text-muted-foreground">
                                    <?php echo wp_trim_words(get_the_excerpt(), 18); ?>
                                </p>

                            </div>

                        </article>

                    <?php endif; ?>

                <?php endwhile; ?>

            </div>
        </div>
    </section>

<?php
    wp_reset_postdata();
endif;
