<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('features_challenge');
$layout = $data['layout'] ?? 'default';
$layout_right = $data['layout_right'] ?? 'default';
$color_mode = $data['background'] ?? 'dark';
?>
<?php echo _spacing_full('feature-challenge',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="<?php echo _background($data['background']) ?> feature-challenge-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="container mx-auto px-6">
        <div class="<?php echo esc_attr($layout == 'horizontal' ? 'max-w-7xl' : 'max-w-4xl'); ?> mx-auto">
            <?php if ($layout == 'horizontal'): ?>
                <!-- Horizontalni layout: Levo naslov i tekst, desno challenges -->
                <div class="grid <?php echo esc_attr($layout_right == 'one_column' ? 'md:grid-cols-2' : 'md:grid-cols-6'); ?> gap-12 items-start">
                    <!-- Leva kolona - naslov i tekst -->
                    <div class="<?php echo esc_attr($layout_right == 'one_column' ? '' : 'md:col-span-2'); ?>">
                        <?php if ($data['top_title']): ?>
                            <span class="maxwell-top-title mb-4 block"><?php echo esc_html($data['top_title']); ?></span>
                        <?php endif; ?>
                        <?php echo _heading($data['title'], 'mb-8 ' . ($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground')); ?>
                        <?php if (!empty($data['text'])): ?>
                            <div class="text-lg mb-12 maxwell-content <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?>"><?php echo apply_filters('the_content', $data['text']); ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Desna kolona - challenges -->
                    <?php if (!empty($data['challenges'])): ?>
                        <div class="<?php echo esc_attr($layout_right == 'one_column' ? '' : 'md:col-span-4'); ?>">
                            <div class="grid gap-6 <?php echo esc_attr($layout_right == 'one_column' ? 'md:grid-cols-1' : 'md:grid-cols-2'); ?> ">
                                <?php foreach ($data['challenges'] as $challenge): ?>
                                    <div class="p-4 rounded-lg border border-border <?php echo esc_attr($color_mode == 'dark_mode' ? 'bg-white/5 border border-white/10 hover:border-accent' : 'bg-card border hover:border-accent'); ?> transition-all duration-300">
                                         
                                        <div class="flex gap-4">
                                            <?php if (!empty($challenge['icon'])) : ?>
                                                <div class="flex-shrink-0">
                                                    <div class="p-2 rounded-lg ">
                                                        <?php echo maxwell_render_icon($challenge['icon'], 'w-6 h-6 text-accent '); ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>

                                            <div class="flex-1">
                                                <?php if (!empty($challenge['title'])) : ?>
                                                    <h3 class="text-lg font-bold mb-1 transition-colors <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground'); ?>"><?php echo esc_html($challenge['title']); ?></h3>
                                                <?php endif; ?>
                                                <?php if (!empty($challenge['text'])) : ?>
                                                    <div class="<?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?>"><?php echo apply_filters('the_content', $challenge['text']); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <!-- Originalni vertikalni layout -->
                <div>
                    <?php if ($data['top_title']): ?>
                        <span class="maxwell-top-title mb-4 block"><?php echo esc_html($data['top_title']); ?></span>
                    <?php endif; ?>
                    <?php echo _heading($data['title'], 'mb-8 ' . ($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground')); ?>
                    <?php if (!empty($data['text'])): ?>
                        <div class="text-lg mb-12 maxwell-content <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?>"><?php echo apply_filters('the_content', $data['text']); ?></div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($data['challenges'])): ?>
                    <div class="grid md:grid-cols-2 gap-6">
                        <?php foreach ($data['challenges'] as $challenge): ?>
                            <div class="group p-4 rounded-lg border border-border <?php echo esc_attr($color_mode == 'dark_mode' ? 'bg-white/5 border border-white/10' : 'bg-card border border-border'); ?>  hover:shadow-md hover:shadow-accent/5 hover:border-accent/50 transition-all duration-300">
                                <div class="flex gap-2">
                                    <?php if (!empty($challenge['icon'])) : ?>
                                        <div class="flex-shrink-0">
                                            <div class="rounded-lg">
                                                <?php echo maxwell_render_icon($challenge['icon'], 'w-6 h-6 text-accent'); ?>
                                            </div>  
                                        </div>
                                    <?php endif; ?>

                                    <div class="flex-1">
                                        <?php if (!empty($challenge['title'])) : ?>
                                            <h3 class="text-xl font-bold mb-2 transition-colors <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white' : 'text-foreground'); ?>"><?php echo esc_html($challenge['title']); ?></h3>
                                        <?php endif; ?>
                                        <?php if (!empty($challenge['text'])) : ?>
                                            <div class="<?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?>"><?php echo apply_filters('the_content', $challenge['text']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</section>