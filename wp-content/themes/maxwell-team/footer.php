<?php

$footer_data = get_field('footer_data', 'option');
$social_network = get_field('social_network', 'option');
?>

<footer class="bg-footer text-primary no-underline">
    <div class="container py-16 px-4 mx-auto">
        <div class="grid sm:grid-cols-2 lg:grid-cols-[1.4fr,repeat(4,1fr)] gap-8">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <?php if (!empty($footer_data['logo'])) : ?>
                        <img src="<?php echo $footer_data['logo']['url']; ?>" alt="<?php echo $footer_data['logo']['alt']; ?>">
                    <?php endif; ?>
                </div>

                <?php if (!empty($footer_data['description'])) : ?>
                    <div class="mb-6"><?php echo apply_filters('the_content', $footer_data['description']); ?></div>
                <?php endif; ?>

                <?php if (!empty($footer_data['contact_data'])) : ?>
                    <div class="flex items-center gap-3 mb-6">
                        <ul class="space-y-4 text-foreground-muted">
                            <?php foreach ($footer_data['contact_data'] as $item) : ?>
                                <li>
                                    <?php if ($item['text']['url'] == '#'): ?>
                                        <div class="flex items-center gap-3 transition-colors">
                                            <?php if (!empty($item['icon'])): ?>
                                                <?php echo maxwell_render_svg($item['icon']['url'], 'w-6 h-6'); ?>
                                            <?php endif; ?>
                                            <?php echo $item['text']['title']; ?>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?php echo esc_url($item['text']['url']); ?>" class="flex items-center gap-3 hover:text-accent transition-colors no-underline">
                                            <?php if (!empty($item['icon'])): ?>
                                                <?php echo maxwell_render_svg($item['icon']['url'], 'w-6 h-6'); ?>
                                            <?php endif; ?>
                                            <?php echo $item['text']['title']; ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <?php if (!empty($social_network)) : ?>
                    <div class="flex items-center gap-3 mb-6">
                        <?php foreach ($social_network as $key => $social) : ?>
                            <?php if (!empty($social['link']['url']) && !empty($social['link']['url'])) : ?>
                                <a href="<?php echo $social['link']['url']; ?>" class="hover:text-secondary hover:scale-110 transition-all duration-300 w-10 h-10 no-underline" aria-label="<?php echo $social['link']['title']; ?> social media link">
                                    <div class="w-12 h-12 rounded-xl bg-accent flex items-center justify-center text-white">
                                        <?php echo maxwell_render_icon($social['icon'], 'w-6 h-6 !text-white'); ?>
                                    </div>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php
            $menu_locations = get_nav_menu_locations();
            if (!empty($menu_locations['footer-menu-1'])) :
                $menu_1_id = $menu_locations['footer-menu-1'];
                $menu_1 = wp_get_nav_menu_object($menu_1_id);
                $menu_1_items = wp_get_nav_menu_items($menu_1_id);

                if ($menu_1) :
            ?>
                    <div>
                        <h2 class="text-primary font-bold text-lg mb-6"><?php echo $menu_1->name ?></h2>
                        <ul class="space-y-3">
                            <?php foreach ($menu_1_items as $item) : ?>
                                <li>
                                    <a class="text-foreground hover:text-foreground-muted transition-colors  no-underline" href="<?php echo esc_url($item->url) ?>">
                                        <?php echo esc_html($item->title) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php
            $menu_2_id = $menu_locations['footer-menu-2'];
            if (!empty($menu_locations['footer-menu-2'])) :
                $menu_2 = wp_get_nav_menu_object($menu_2_id);
                $menu_2_items = wp_get_nav_menu_items($menu_2_id);

                if ($menu_2) :
            ?>
                    <div>
                        <h2 class="font-bold text-lg mb-6"><?php echo $menu_2->name ?></h2>
                        <ul class="space-y-3">
                            <?php foreach ($menu_2_items as $item) : ?>
                                <li>
                                    <a class="text-foreground hover:text-foreground-muted transition-colors no-underline" href="<?php echo esc_url($item->url) ?>">
                                        <?php echo esc_html($item->title) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


            <?php
            $menu_3_id = $menu_locations['footer-menu-3'];
            if (!empty($menu_locations['footer-menu-3'])) :
                $menu_3 = wp_get_nav_menu_object($menu_3_id);
                $menu_3_items = wp_get_nav_menu_items($menu_3_id);

                if ($menu_3) :
            ?>
                    <div>
                        <h2 class="font-bold text-lg mb-6"><?php echo $menu_3->name ?></h2>
                        <ul class="space-y-3">
                            <?php foreach ($menu_3_items as $item) : ?>
                                <li>
                                    <a class="text-foreground hover:text-foreground-muted transition-colors no-underline" href="<?php echo esc_url($item->url) ?>">
                                        <?php echo esc_html($item->title) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


            <?php
            $menu_4_id = $menu_locations['footer-menu-4'];
            if (!empty($menu_locations['footer-menu-4'])) :
                $menu_4 = wp_get_nav_menu_object($menu_4_id);
                $menu_4_items = wp_get_nav_menu_items($menu_4_id);

                if ($menu_4) :
            ?>
                    <div>
                        <h2 class="text-foreground font-bold text-lg mb-6"><?php echo $menu_4->name ?></h2>
                        <ul class="space-y-3">
                            <?php foreach ($menu_4_items as $item) : ?>
                                <li>
                                    <a class="text-foreground hover:text-foreground-muted transition-colors no-underline" href="<?php echo esc_url($item->url) ?>">
                                        <?php echo esc_html($item->title) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        </div>
        <div class="border-t border-foreground mt-12 pt-8 text-center text-foreground/60 flex justify-between items-center">
            <?php
            $menu_5_id = $menu_locations['footer-menu-5'];
            if (!empty($menu_locations['footer-menu-5'])) :
                $menu_5 = wp_get_nav_menu_object($menu_5_id);
                $menu_5_items = wp_get_nav_menu_items($menu_5_id);

                if ($menu_5) :
            ?>
                    <div class="flex gap-4">
                        <?php foreach ($menu_5_items as $item) : ?>
                            <a class="transition-colors no-underline" href="<?php echo esc_url($item->url) ?>">
                                <?php echo esc_html($item->title) ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <span>© <?php echo date('Y'); ?> All rights reserved.</span>
        </div>
    </div>

</footer>
<!-- </div>#page -->
<?php wp_footer(); ?>

<script>
    // Mobile menu toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Mobile submenu toggle
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('hidden');
    }
</script>
</body>

</html>