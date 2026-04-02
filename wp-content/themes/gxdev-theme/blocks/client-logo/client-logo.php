<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('client_logo');
$color_mode = $data['background'] ?? 'dark';
?>
<style>
    .logo-scroll {
        height: 100px;
        display: flex;
        column-gap: 4rem;
        /* ⬅️ HORIZONTALNI RAZMAK */
        animation: logo-scroll 40s linear infinite;
    }

    .logo-scroll:hover {
        animation-play-state: paused;
    }

    @keyframes logo-scroll {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }
</style>
<section id="<?php echo esc_attr($anchor); ?>" class="overflow-hidden client-logo-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?> <?php echo _background($data['background']); ?>" <?php echo _padding($data['padding']); ?>>
    <div class="container mx-auto px-6 text-center">
        <?php if (!empty($data['title']) && $data['use_title'] == 'yes'): ?>
            <?php echo _heading($data['title'], 'mb-8' . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
        <?php endif; ?>
    </div>

    <!-- LOGO STRIP -->
    <div class="relative">
        <?php if ($color_mode !== 'dark_mode'): ?>
        <!-- gradient fade -->
        <div class="absolute left-0 top-0 h-full w-24 bg-gradient-to-r from-background to-transparent z-10"></div>
        <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-background to-transparent z-10"></div>
        <?php endif; ?>

        <?php if (!empty($data['gallery'])): ?>
            <div class="flex w-max logo-scroll pb-8">
                <?php foreach ($data['gallery'] as $logo): ?>
                    <img src="<?php echo $logo['url']; ?>" class="h-10 w-auto opacity-70 hover:opacity-100 transition shrink-0" alt="<?php echo $logo['alt']; ?>">
                <?php endforeach; ?>
                <?php foreach ($data['gallery'] as $logo): ?>
                    <img src="<?php echo $logo['url']; ?>" class="h-10 w-auto opacity-70 hover:opacity-100 transition shrink-0" alt="<?php echo $logo['alt']; ?>">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($data['text']) && $data['use_text'] == 'yes'): ?>
        <div class="flex justify-center max-w-5xl mx-auto <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : ''; ?>">
            <?php echo apply_filters('the_content', $data['text']); ?>
        </div>
    <?php endif; ?>
</section>