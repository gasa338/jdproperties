<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('service_3');
// dd($data);
$bg_image = isset($data['bg_image']) ? get_image($data['bg_image']) : 0;

$text_color = $data['text_color'] ?? '#fff';
$overlay_color = $data['overlay_color'] ?? 'rgba(0, 0, 0, 0.5)';
$bg_color = $data['background_color'] ?? 'rgba(0, 0, 0, 0.5)';
$border_color = $data['border_color'] ?? 'rgba(0, 0, 0, 0.5)';
$link_color = $data['link_color'] ?? 'rgba(0, 0, 0, 0.5)';
?>
<style>
    .service-3-<?php echo esc_attr($blocks_id); ?>,
    .service-3-<?php echo esc_attr($blocks_id); ?>p,
    .service-3-<?php echo esc_attr($blocks_id); ?>h1,
    .service-3-<?php echo esc_attr($blocks_id); ?>h2,
    .service-3-<?php echo esc_attr($blocks_id); ?>h3,
    .service-3-<?php echo esc_attr($blocks_id); ?>span,
    .service-3-<?php echo esc_attr($blocks_id); ?>ul,
    .service-3-<?php echo esc_attr($blocks_id); ?>li {
        color: <?php echo esc_attr($text_color); ?> !important;
    }

    .service-3-<?php echo esc_attr($blocks_id); ?>.overlay {
        background-color: <?php echo esc_attr($overlay_color); ?> !important;
    }

    .service-3-<?php echo esc_attr($blocks_id); ?>.bg-color {
        background-color: <?php echo esc_attr($bg_color); ?> !important;
    }

    .service-3-<?php echo esc_attr($blocks_id); ?>.border-color {
        border-color: <?php echo esc_attr($border_color); ?> !important;
        background-color: <?php echo esc_attr($link_color); ?> !important;
    }
</style>


<?php echo _spacing_full('service-3',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="py-24 bg-section-dark relative service-3-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> ">
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, rgba(3, 14, 65, 1) 1px, transparent 0px); background-size: 40px 40px;"></div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div style="opacity: 1; transform: none;">
                <?php if (!empty($data['top_title'])): ?>
                    <span class="mb-4 block maxwell-top-title text-accent text-sm font-medium tracking-wider uppercase"><?php echo esc_html($data['top_title']); ?></span>
                <?php endif; ?> 
                <?php if (!empty($data['title'])): ?>
                    <?php echo _heading($data['title'], 'mb-6 text-white') ?>
                <?php endif; ?>
                <?php if (!empty($data['text'])): ?>
                    <div class="text-white text-lg mb-8 leading-relaxed maxwell-content"><?php echo apply_filters('the_content', $data['text']); ?></div>
                <?php endif; ?>
<?php if (!empty($data['number'])): ?>
                    <div class="grid grid-cols-3 gap-6 mb-8">
                        <?php foreach ($data['number'] as $key => $value): ?>
                            <div>
                                <div class="text-3xl md:text-4xl font-bold text-white mb-1"><?php echo esc_html($value['number']); ?></div>
                                <div class="text-sm text-white/60"><?php echo esc_html($value['text']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($data['link_1'])): ?>
                    <?php _link_3($data['link_1']); ?>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($data['links'])): ?>
            <div class="grid grid-cols-2 gap-3" style="opacity: 1;">
                <?php foreach ($data['links'] as $key => $value): ?>
                <div style="opacity: 1; transform: none;">
                    <a class="flex items-center gap-3 p-4 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 hover:border-accent/50 transition-all duration-300 group" href="<?php echo esc_url($value['link']['url']); ?>" target="<?php echo esc_attr($value['link']['target']); ?>" title="<?php echo esc_attr($value['link']['title']); ?>">
                        <div class="w-10 h-10 rounded-lg bg-accent/20 flex items-center justify-center group-hover:bg-accent/30 transition-colors shrink-0">
                            <?php if (!empty($value['icon']['subtype'] == 'svg+xml')) : ?>
                                <?php echo maxwell_render_svg($value['icon']['url'], 'w-4 h-4 text-accent'); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url($value['icon']['url']); ?>" alt="<?php echo esc_attr($value['icon']['alt']); ?>" class="w-5 h-5 text-accent">
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($value['link'])): ?>
                        <span class="font-medium text-white group-hover:text-accent transition-colors"><?php echo esc_html($value['link']['title']); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>