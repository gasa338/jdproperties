<?php

function rockit_get_post_toc($content) {

    $blocks = parse_blocks($content);

    $toc = [];

    foreach ($blocks as $block) {

        if ($block['blockName'] === 'core/heading') {

            $level = $block['attrs']['level'] ?? 2;

            if ($level > 4) continue;

            $text = wp_strip_all_tags($block['innerHTML']);

            $id = sanitize_title($text);

            $toc[] = [
                'title' => $text,
                'id' => $id,
                'level' => $level
            ];
        }
    }

    return $toc;
}

function rockit_add_heading_anchor($block_content, $block) {

    if ($block['blockName'] !== 'core/heading') {
        return $block_content;
    }

    $level = $block['attrs']['level'] ?? 2;

    if ($level > 4) return $block_content;

    $text = wp_strip_all_tags($block_content);

    $id = sanitize_title($text);

    $block_content = preg_replace(
        '/<h([2-4])(.*?)>/',
        '<h$1 id="'.$id.'"$2 class="group scroll-mt-32">',
        $block_content
    );

    $anchor = '<a href="#'.$id.'" class="ml-2 opacity-0 group-hover:opacity-100 text-gray-400 hover:text-gray-700 transition">#</a>';

    $block_content = str_replace(
        '</h'.$level.'>',
        $anchor.'</h'.$level.'>',
        $block_content
    );

    return $block_content;
}

add_filter('render_block','rockit_add_heading_anchor',10,2);

function rockit_render_toc($content) {

    $toc = rockit_get_post_toc($content);

    if (!$toc) return;
    ?>

    <nav class="hidden lg:block sticky top-32">
    
    <h3 class="h3-responsive mb-4 font-semibold">Table of contents</h3>

        <ul class="space-y-2">

        <?php foreach ($toc as $item): ?>
            <?php 
            $padding = '';
            if ($item['level'] == 3) $padding = 'pl-3';
            if ($item['level'] == 4) $padding = 'pl-6';
            ?>
            <li class="<?php echo $padding; ?>">
                <a href="#<?php echo $item['id']; ?>" class="toc-link block transition no-underline">
                <?php echo $item['title']; ?>
                </a>
            </li>
        <?php endforeach; ?>

        </ul>
    </nav>
<?php 
}