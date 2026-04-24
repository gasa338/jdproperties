<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('blog_1');
$posts = get_post_by_type('choose', 'post', 3, $data['posts']);
$color_mode = $data['background'] ?? 'light';
?>

<?php echo _spacing_full('blog-1', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="blog-1-<?php echo esc_attr($blocks_id); ?> <?php echo _background($color_mode); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <?php if (!empty($data['top_title'])) : ?>
                <p class="maxwell-top-title mb-2"><?php echo $data['top_title']; ?></p>
            <?php endif; ?>

            <?php if (!empty($data['title'])) : ?>
                <h2 class="h2-responsive mt-2 mb-4"><?php echo $data['title']; ?></h2>
            <?php endif; ?>

            <?php if (!empty($data['description'])) : ?>
                <div class="max-w-2xl mx-auto content-list-link"><?php echo apply_filters('the_content', $data['description']); ?></div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php foreach ($posts as $post) : ?>
                <article class="bg-card rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition z-10">
                    <?php if (!empty($post['primary_category'])) : ?>
                        <div class="h-64 bg-cover bg-center relative z-10">
                            <a href="<?php echo $post['primary_category']['link']; ?>" class="absolute top-4 left-4 bg-accent text-white px-3 py-1 rounded-full hover:bg-accent/80 no-underline">
                                <?php echo $post['primary_category']['name']; ?></a>
                            <a href="<?php echo $post['link']['url']; ?>" title="read more about <?php echo $post['link']['title']; ?>">
                                <img src="<?php echo $post['image']['url']; ?>" alt="<?php echo $post['image']['alt']; ?>" class="w-full h-64 overflow-hidden object-cover">
                            </a>
                            <!-- <div class="absolute inset-0 bg-gradient-to-t from-accent/30 via-accent/40 to-transparent"></div> -->
                        </div>
                    <?php endif; ?>
                    <div class="p-6 z-20">
                        <h3 class="h3-responsive no-underline mb-3 hover:underline">
                            <a href="<?php echo $post['link']; ?>" class="text-accent no-underline" title="read more about <?php echo $post['title']; ?>" target="_blank">
                                <?php echo $post['title']; ?>
                            </a>
                        </h3>
                        <p class="mb-4"><?php echo $post['excerpt']; ?></p>
                        <div class="flex justify-between items-center">
                            <span class=""><?php echo $post['date']; ?></span>

                            <?php if (!empty($post['link'])) : ?>
                                <?php _link_3($post['link'], 'no-underline', "Read more about " . $post['title']); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($data['to_page'])) : ?>
            <div class="text-center mt-12">
                <?php echo _link_1($data['to_page']); ?>
            </div>
        <?php endif; ?>
    </div>
</section>