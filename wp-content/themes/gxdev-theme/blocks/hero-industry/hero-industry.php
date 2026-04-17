<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('hero_industry');

$color_scheme = $data['background'] ?? 'light';
$top_title_as_h1 = $data['top_title_as_h1'] ?? 'no';

$align = $data['title']['align'] ?? 'left';
?>

<?php echo _spacing_full('hero-industry',$blocks_id,$data['margin'], $data['padding']); ?>
<section class="py-24 relative hero-industry-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> <?php echo _background($data['background']); ?>">
    <?php if ($color_scheme == 'dark'): ?>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, rgb(255, 255, 255) 1px, transparent 0px); background-size: 32px 32px;"></div>
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, rgb(0, 0, 0) 1px, transparent 0px); background-size: 32px 32px;"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[400px] bg-accent/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-primary/20 rounded-full blur-3xl"></div>
    <?php endif; ?>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl <?php echo $align == 'center' ? 'text-center mx-auto' : ''; ?>">
            <?php if (!empty($data['icon'])): ?>
                <div class="w-16 h-16 rounded-2xl bg-accent flex items-center justify-center mb-8">
                    <?php echo maxwell_render_icon($data['icon'], 'w-8 h-8 text-white'); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($data['top_title'])): ?>
                <?php if ($top_title_as_h1): ?>
                    <h1 class="maxwell-top-title mb-4 block <?php echo $align == 'center' ? 'text-center mx-auto' : ''; ?>"><?php echo $data['top_title']; ?></h1>
                <?php else: ?>
                    <span class="maxwell-top-title mb-4 block <?php echo $align == 'center' ? 'text-center mx-auto' : ''; ?>"><?php echo $data['top_title']; ?></span>
                <?php endif; ?>
            <?php endif; ?>
            <?php echo _heading($data['title'], 'mb-6' . ($color_scheme == 'dark_mode' ? ' text-white/80' : ' text-primary')); ?>
            <?php if (!empty($data['text'])): ?>
                <div class="text-xl mb-10 <?php echo esc_attr($color_scheme == 'dark_mode' ? 'text-white/80 [&_p]:text-white/80 [&_span]:text-white/80 [&_strong]:text-white/80 [&_em]:text-white/80' : 'text-muted-foreground'); ?>"><?php echo apply_filters('the_content', $data['text']); ?></div>
            <?php endif; ?>
            <div class="flex flex-wrap gap-4 <?php echo $align == 'center' ? 'items-center justify-center' : ''; ?>">
                <?php if (!empty($data['link_1'])): ?>
                    <?php echo _link_1($data['link_1']); ?>
                <?php endif; ?>
                <?php if (!empty($data['link_2'])): ?>
                    <?php
                    if ($color_scheme == 'dark') :
                        echo _link_6($data['link_2']);
                    else :
                        echo _link_2($data['link_2']);
                    endif;
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>