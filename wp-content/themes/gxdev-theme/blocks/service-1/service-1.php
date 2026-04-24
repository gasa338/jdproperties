<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('service_1');
$color_mode = $data['background'] ?? 'light';
?>

<?php echo _spacing_full('service-1', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="service-1-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="absolute inset-0 opacity-50" style="background-image: radial-gradient(circle at 1px 1px, hsl(var(--primary) / 0.05) 1px, transparent 0); background-size: 32px 32px;"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-2xl mb-10">
            <?php if (!empty($data['top_title'])) : ?>
                <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
            <?php endif; ?>
            <?php echo _heading($data['title'], 'mb-6' . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
            <?php if (!empty($data['text'])) : ?>
                <div class="maxwell-content mb-2 text-lg <?php echo $color_mode === 'dark_mode' ? ' text-white/60' : ''; ?>"><?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>
        </div>
        <div class="grid md:grid-cols-3 gap-6 no-underline">
            <?php foreach ($data['items'] as $item): ?>
                <?php if (!empty($item['link'])): ?>
                    <a class="group relative p-8 rounded-lg <?php echo $color_mode === 'dark_mode' ? ' bg-white/5' : 'bg-card'; ?> border border-border hover:border-accent/50 hover:shadow-xl transition-all duration-500 no-underline" href="<?php echo esc_url($item['link']['url']); ?>" title="<?php echo esc_attr($item['link']['title']); ?>">
                        <?php if (!empty($item['icon'])): ?>
                            <div class="w-14 h-14 rounded-lg flex items-center justify-center mb-6 bg-accent text-white transition-all">
                                <?php echo maxwell_render_icon($item['icon'], 'w-7 h-7 text-white'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($item['title'])): ?>
                            <h3 class="text-2xl font-semibold mb-4 group-hover:text-accent transition-colors <?php echo $color_mode === 'dark_mode' ? ' text-white' : ''; ?>"><?php echo $item['title']; ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['text'])): ?>
                            <div class="text-muted-foreground mb-6 leading-relaxed maxwell-content <?php echo $color_mode === 'dark_mode' ? ' text-white/60' : ''; ?>"><?php echo $item['text']; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($item['link'])): ?>
                            <span class="inline-flex items-center gap-1.5 font-semibold text-accent  hover:gap-2.5 transition-all"><?php echo $item['link']['title']; ?> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up-right w-4 h-4">
                                    <path d="M7 7h10v10"></path>
                                    <path d="M7 17 17 7"></path>
                                </svg>
                            </span>
                        <?php endif; ?>
                    </a>
                <?php else: ?>
                    <div class="group relative p-8 rounded-lg <?php echo $color_mode === 'dark_mode' ? ' bg-white/5' : 'bg-card'; ?> border border-border hover:border-accent/50 hover:shadow-xl transition-all duration-500">
                        <?php if (!empty($item['icon'])): ?>
                            <div class="w-14 h-14 rounded-lg bg-accent flex items-center justify-center mb-6">
                                <?php echo maxwell_render_icon($item['icon'], 'w-7 h-7 text-white'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($item['title'])): ?>
                            <h3 class=" text-2xl font-semibold mb-4 group-hover:text-accent transition-colors <?php echo $color_mode === 'dark_mode' ? ' text-white' : ''; ?>"><?php echo $item['title']; ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($item['text'])): ?>
                            <div class="text-muted-foreground mb-6 leading-relaxed maxwell-content <?php echo $color_mode === 'dark_mode' ? ' text-white/60 [&_li]:text-white' : ''; ?>"><?php echo $item['text']; ?></div>
                        <?php endif; ?>
                        <?php if (!empty($item['link'])): ?>
                            <span class="inline-flex items-center gap-1.5 font-semibold text-accent mt-5 hover:gap-2.5 transition-all"><?php echo $item['link']['title']; ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M7 7h10v10"></path>
                                    <path d="M7 17 17 7"></path>
                                </svg>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</section>