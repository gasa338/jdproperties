<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('marque');
?>
<style>
    @keyframes scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .marquee__group {
        animation: scroll 60s linear infinite;
    }
</style>

<?php echo _spacing_full('marque',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="marque-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">
    <div class="relative m-auto flex gap-28 overflow-hidden py-6 bg-accent/5">
        <?php if (!empty($data['items'])): ?>
            <div class="marquee__group flex min-w-full flex-shrink-0 items-center justify-around gap-28">
                <?php foreach ($data['items'] as $item): ?>
                    <h2 class="text-4xl text-accent"><?php echo esc_html($item['text']); ?></h2>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- marquee__group End-->

        <?php if (!empty($data['items'])): ?>
            <div class="marquee__group flex min-w-full flex-shrink-0 items-center justify-around gap-28">
                <?php foreach ($data['items'] as $item): ?>
                    <h2 class="text-4xl text-accent"><?php echo esc_html($item['text']); ?></h2>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- marquee__group End-->
    </div>
</section>