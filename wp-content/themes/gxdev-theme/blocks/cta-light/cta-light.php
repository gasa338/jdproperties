<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('cta_light');
$layout = $data['layout'] ?? 'default';

$btn_layout = $data['btn_layout'] ?? 'dark';
$layout = $data['layout'] ?? 'dark';

$grid = $data['grid'] ?? 'default';
?>

<section class="py-24">
    <div class="container mx-auto px-6">

        <?php if ($layout === 'two_column') : ?>
            <div class="<?php echo esc_attr($grid == 'default' ? 'max-w-7xl' : 'max-w-4xl'); ?> mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">

                    <!-- Leva kolona (2/3) -->
                    <div class="md:col-span-2 text-left">
                        <?php echo _heading($data['title'], 'mb-6') ?>

                        <?php if ($data['text']) : ?>
                            <div class="text-lg text-muted-foreground max-w-2xl">
                                <?php echo apply_filters('the_content', $data['text']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Desna kolona (1/3) -->
                    <div class="md:col-span-1 flex md:justify-end">
                        <?php if ($data['link']) : ?>
                            <?php
                            switch ($btn_layout) {
                                case 'dark':
                                    echo _link_1($data['link']);
                                    break;
                                case 'light':
                                    echo _link_2($data['link']);
                                    break;
                                default:
                                    echo _link_1($data['link']);
                                    break;
                            }
                            ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        <?php else : ?>

            <!-- Default layout (postojeći) -->
            <div class="text-center">
                <?php echo _heading($data['title'], 'mb-6') ?>

                <?php if ($data['text']) : ?>
                    <div class="text-lg text-muted-foreground mb-10 max-w-2xl mx-auto">
                        <?php echo apply_filters('the_content', $data['text']); ?>
                    </div>
                <?php endif; ?>

                <?php if ($data['link']) : ?>
                    <?php
                    switch ($btn_layout) {
                        case 'dark':
                            echo _link_1($data['link']);
                            break;
                        case 'light':
                            echo _link_2($data['link']);
                            break;
                        default:
                            echo _link_1($data['link']);
                            break;
                    }
                    ?>
                <?php endif; ?>
            </div>

        <?php endif; ?>

    </div>
</section>