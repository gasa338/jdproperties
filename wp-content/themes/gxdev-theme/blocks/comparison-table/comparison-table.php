<?php

$blocks_id = $block['id'];
$blocks_class = isset($block['className']) ? $block['className'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('comparison_table');
$color_mode = $data['background'] ?? 'dark';
?>
<style>
    .tooltip-wrap {
        position: relative;
        display: inline-block;
    }

    .tooltip-wrap .tip {
        visibility: hidden;
        opacity: 0;
        width: 200px;
        background: white;
        color: hsl(var(--primary));
        font-size: 16px;
        line-height: 1.4;
        border-radius: 0;
        border: 1px solid #e2e8f0;
        padding: 8px 10px;
        position: absolute;
        bottom: calc(100% + 6px);
        left: 50%;
        transform: translateX(-50%);
        transition: opacity .2s ease;
        pointer-events: none;
        z-index: 50;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .25);
    }

    .tooltip-wrap .tip::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        border: 6px solid transparent;
        border-top-color: hsl(var(--accent));
    }

    .tooltip-wrap:hover .tip {
        visibility: visible;
        opacity: 1;
    }

    /* Per-column borders */
    thead tr th:nth-child(2),
    tbody tr td:nth-child(2) {
        border-left: 1px solid rgba(255, 255, 255, 0.15);
        border-right: 1px solid rgba(255, 255, 255, 0.15);
    }

    thead tr th:nth-child(2) {
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px 12px 0 0;
    }

    tbody tr:last-child td:nth-child(2) {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 0 0 12px 12px;
    }

    thead tr th:nth-child(2),
    tbody tr td:nth-child(2) {
        border-left: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
    }


    thead tr th:nth-child(2) {
        border-top: 1px solid #e2e8f0;
        border-radius: 12px 12px 0 0;
    }

    tbody tr:last-child td:nth-child(2) {
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0 0 12px 12px;
    }

    thead tr th:nth-child(3),
    tbody tr td:nth-child(3) {
        border-left: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
    }

    thead tr th:nth-child(3) {
        border-top: 1px solid #e2e8f0;
        border-radius: 12px 12px 0 0;
    }

    tbody tr:last-child td:nth-child(3) {
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0 0 12px 12px;
    }

    thead tr th:nth-child(4),
    tbody tr td:nth-child(4) {
        border-left: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
    }

    thead tr th:nth-child(4) {
        border-top: 1px solid #e2e8f0;
        border-radius: 12px 12px 0 0;
    }

    tbody tr:last-child td:nth-child(4) {
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0 0 12px 12px;
    }

    thead tr th:nth-child(5),
    tbody tr td:nth-child(5) {
        border-left: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
    }

    thead tr th:nth-child(5) {
        border-top: 1px solid #e2e8f0;
        border-radius: 12px 12px 0 0;
    }

    tbody tr:last-child td:nth-child(5) {
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0 0 12px 12px;
    }
</style>


<?php echo _spacing_full('comparison-table', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="comparison-table-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class);
                                                                                                            echo ' ' . _background($data['background']); ?>">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl items-center justify-center">
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

        <div class="max-w-7xl">
            <table class="w-full border-separate border-spacing-x-2">
                <thead class="sticky top-16 z-10">
                    <tr>
                        <?php foreach ($data['items'][0]['row'] as $kh => $header): ?>
                            <?php if ($kh == 0): ?>
                                <th class="w-48 bg-transparent"></th>
                            <?php else: ?>
                                <th class="text-xl font-bold text-center py-5 px-6 tracking-wide rounded-tl-2xl border-b  <?php echo $kh == 4 ? 'bg-hero text-white border-border' : 'bg-slate-50 text-primary border-border'; ?>">
                                    <?php echo $header['name']; ?>
                                </th>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($data['items'] as $key => $item): ?>
                        <?php if ($key >= 1): ?>
                            <tr>
                                <?php foreach ($item['row'] as $k => $el): ?>
                                    <?php if ($k == 0): ?>
                                        <td class="py-6 pr-6 pl-4 align-middle">
                                            <span class="text-primary text-xl font-bold"><?php echo $el['name']; ?></span>
                                        </td>
                                    <?php else: ?>
                                        <?php
                                        // Odredi klase na osnovu indeksa
                                        $tdClasses = "text-center py-6 px-4 align-middle  ";
                                        if ($k == 4) {
                                            $tdClasses .= "bg-hero";
                                        } else {
                                            $tdClasses .= "bg-slate-50";
                                        }
                                        ?>
                                        <td class="<?php echo $tdClasses; ?>">
                                            <div class="flex items-center justify-center gap-2">
                                                <span class="font-bold text-lg <?php echo $k == 4 ? 'text-white' : 'text-primary'; ?>">
                                                    <?php echo $el['name']; ?>
                                                </span>
                                                <?php if (!empty($el['popup'])): ?>
                                                    <div class="tooltip-wrap">
                                                        <div class="bg-accent text-white rounded-full inline-flex items-center justify-center">
                                                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                                                <circle cx="12" cy="16" r="1" fill="currentColor" />
                                                            </svg>
                                                        </div>
                                                        <div class="tip"><?php echo $el['popup']; ?></div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    </div>
</section>