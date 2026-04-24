<?php

/**
 * Get the URL, alt and srcset of an image by its ID.
 *
 * @param int $image_id The ID of the image.
 * @return array An array containing the URL, alt and srcset of the image.
 *     - string 'url' The URL of the image.
 *     - string 'alt' The alt text of the image.
 *     - string 'srcset' The srcset of the image.
 */
function get_image($image_id): array
{
    return [
        'url' => wp_get_attachment_url($image_id),
        'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', TRUE),
        'srcset' => wp_get_attachment_image_srcset($image_id),
    ];
}

/**
 * Renders an SVG image.
 *
 * This function takes an URL or path to an SVG image and returns the SVG content
 * with optional classes and aria-label added.
 *
 * @param string $svg_url The URL or path to the SVG image.
 * @param string $classes Optional. The classes to add to the SVG element.
 * @param string $aria_label Optional. The aria-label attribute for the SVG element.
 * @return string The SVG content with optional classes and aria-label added.
 */
function maxwell_render_svg($svg_url, $classes = '', $aria_label = '')
{
    // Check if the URL is empty
    if (empty($svg_url)) {
        return '';
    }

    // Check if the URL is valid
    if (!filter_var($svg_url, FILTER_VALIDATE_URL)) {
        return '';
    }

    // If the URL is local, convert it to a file path
    $wp_upload_dir = wp_upload_dir();
    $site_url = site_url();

    $file_path = str_replace($site_url, ABSPATH, $svg_url);

    // If the file exists, get its content
    if (file_exists($file_path)) {
        $svg_content = file_get_contents($file_path);
    } else {
        // If it's not a local file, try to get it via wp_remote_get
        $response = wp_remote_get($svg_url);

        if (is_wp_error($response)) {
            return '';
        }

        $svg_content = wp_remote_retrieve_body($response);
    }


    // Check if the content is an SVG
    if (strpos($svg_content, '<svg') === false) {
        return '';
    }

    // Add classes if provided
    if (!empty($classes)) {
        $svg_content = preg_replace(
            '/<svg([^>]*)>/',
            '<svg$1 class="' . esc_attr($classes) . '">',
            $svg_content
        );
    }

    // Add focusable="false" for IE
    $svg_content = str_replace('<svg', '<svg focusable="false"', $svg_content);

    return $svg_content;
}

function _heading($data, $class = '')
{
    // Validacija i osnovne vrednosti
    $text = isset($data['text']) ? $data['text'] : '';
    if (empty($text)) {
        return '';
    }
    $tag = isset($data['tag']) ? $data['tag'] : 'h2';

    // Tailwind klase za align
    $align_classes = [
        'left' => 'text-left',
        'center' => 'text-center',
        'right' => 'text-right'
    ];

    $align = isset($data['align']) ? $data['align'] : 'left';
    $tailwind_class = isset($align_classes[$align]) ? $align_classes[$align] : 'text-left';

    // Osnovna klasa
    $class = "{$tag}-responsive {$tailwind_class} {$class}";

    // Inline style za custom veličine
    $style = '';

    if (isset($data['use_custom_size']) && $data['use_custom_size']) {
        $styles = [];

        // Desktop veličina (osnovna)
        if (isset($data['size_desktop']) && is_numeric($data['size_desktop'])) {
            $styles[] = "font-size: {$data['size_desktop']}px;";
        }

        if (isset($data['size_tablet']) && is_numeric($data['size_tablet'])) {
            $styles[] = "@media (max-width: 1024px) { font-size: {$data['size_tablet']}px !important; }";
        }

        if (isset($data['size_mobile']) && is_numeric($data['size_mobile'])) {
            $styles[] = "@media (max-width: 768px) { font-size: {$data['size_mobile']}px !important; }";
        }

        if (!empty($styles)) {
            $media_queries = implode(' ', $styles);
            $style = ' style="' . $media_queries . '"';
            return "<{$tag} class=\"{$class}\"{$style}>{$text}</{$tag}>";
        }
    }

    // Kreiranje HTML-a bez custom size
    return "<{$tag} class=\"{$class}\">{$text}</{$tag}>";
}

function _spacing($data)
{
    // Desktop veličina (osnovna)
    if (isset($data['desktop']) && is_numeric($data['desktop'])) {
        $styles[] = "margin-bottom: {$data['desktop']}px;";
    }

    if (isset($data['tablet']) && is_numeric($data['tablet'])) {
        $styles[] = "@media (max-width: 1024px) { margin-bottom: {$data['tablet']}px !important; }";
    }

    if (isset($data['mobile']) && is_numeric($data['mobile'])) {
        $styles[] = "@media (max-width: 768px) { margin-bottom: {$data['mobile']}px !important; }";
    }

    if (!empty($styles)) {
        $media_queries = implode(' ', $styles);
        $style = ' style="' . $media_queries . '"';
        return $style;
    }
    return '';
}

function _padding($data)
{
    // Desktop veličina (osnovna)
    if (isset($data['desktop']) && is_numeric($data['desktop'])) {
        $styles[] = "padding-bottom: {$data['desktop']}px; padding-top: {$data['desktop']}px;";
    }

    if (isset($data['tablet']) && is_numeric($data['tablet'])) {
        $styles[] = "@media (max-width: 1024px) { padding-bottom: {$data['tablet']}px !important; padding-top: {$data['tablet']}px !important; }";
    }

    if (isset($data['mobile']) && is_numeric($data['mobile'])) {
        $styles[] = "@media (max-width: 768px) { padding-bottom: {$data['mobile']}px !important; padding-top: {$data['mobile']}px !important; }";
    }

    if (!empty($styles)) {
        $media_queries = implode(' ', $styles);
        $style = ' style="' . $media_queries . '"';
        return $style;
    }
    return '';
}

/**
 * Postavlja poziciju i širinu naslova
 * @param string $position - 'left' ili 'center'
 * @param string $width - 'small', 'medium' ili 'large'
 * @return string Tailwind klase za pozicioniranje i širinu
 */
function _title_position($position = 'left', $width = 'medium')
{
    // Mapiranje pozicija na Tailwind klase
    $positionClasses = [
        'left' => 'text-left mr-auto',
        'center' => 'md:text-center md:mx-auto flex flex-col items-start md:items-center justify-center'
    ];

    // Mapiranje širina na Tailwind klase
    $widthClasses = [
        'small' => 'max-w-2xl',
        'medium' => 'max-w-3xl',
        'large' => 'max-w-5xl'
    ];

    // Validacija parametara
    $validPositions = ['left', 'center'];
    $validWidths = ['small', 'medium', 'large'];

    if (!in_array($position, $validPositions)) {
        $position = 'left';
    }

    if (!in_array($width, $validWidths)) {
        $width = 'medium';
    }

    // Kombinovanje klasa
    return $positionClasses[$position] . ' ' . $widthClasses[$width];
}

/**
 * Populate CF7 forms in ACF select field.
 *
 * This function is a filter that populates the 'choose_form' select field
 * with all the available Contact Form 7 forms.
 *
 * @param array $field The ACF field.
 * @return array The modified ACF field.
 */
function populate_cf7_forms_in_acf($field)
{
    // Check if the field is the one we want to populate
    if ($field['name'] === 'choose_form' || $field['_name'] === 'choose_form') {

        // Reset the choices array
        $field['choices'] = array();

        // Add an empty option
        $field['choices'][''] = '— Izaberite formu —';

        // Get all the available CF7 forms
        $forms = get_posts(array(
            'post_type' => 'wpcf7_contact_form',
            'numberposts' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'post_status' => 'publish'
        ));

        // Populate the choices with the forms
        foreach ($forms as $form) {
            $field['choices'][$form->ID] = $form->post_title . ' (ID: ' . $form->ID . ')';
        }

        // Optional: add a message if there are no forms
        if (empty($forms)) {
            $field['choices'][''] = 'Nema dostupnih Contact Form 7 formi';
            $field['disabled'] = true;
        }

        // Optional: set a default value
        // $field['default_value'] = '';
    }

    return $field;
}
add_filter('acf/load_field/name=choose_form', 'populate_cf7_forms_in_acf');

function _background($data)
{
    if (empty($data)) {
        return '';
    }

    switch ($data) {
        case 'dark':
            $bg_class = 'bg-surface';
            break;
        case 'light':
            $bg_class = 'bg-white';
            break;
        case 'dark_mode':
            $bg_class = 'bg-gradient-navy';
            break;
        default:
            $bg_class = 'bg-white';
            break;
    }

    return $bg_class;
}



function _spacing_full($block_name, $block_id, $data_margin, $data_padding)
{
    $block_class = $block_name . '-' . $block_id;
    $styles = [];

    // DESKTOP
    $desktop = [];

    if (isset($data_margin['desktop']) && is_numeric($data_margin['desktop'])) {
        $desktop[] = "margin-bottom: {$data_margin['desktop']}px;";
    }

    if (isset($data_padding['desktop']) && is_numeric($data_padding['desktop'])) {
        $desktop[] = "padding-top: {$data_padding['desktop']}px;";
        $desktop[] = "padding-bottom: {$data_padding['desktop']}px;";
    }

    if (!empty($desktop)) {
        $styles[] = ".{$block_class} { " . implode(' ', $desktop) . " }";
    }

    // TABLET
    $tablet = [];

    if (isset($data_margin['tablet']) && is_numeric($data_margin['tablet'])) {
        $tablet[] = "margin-bottom: {$data_margin['tablet']}px;";
    }

    if (isset($data_padding['tablet']) && is_numeric($data_padding['tablet'])) {
        $tablet[] = "padding-top: {$data_padding['tablet']}px;";
        $tablet[] = "padding-bottom: {$data_padding['tablet']}px;";
    }

    if (!empty($tablet)) {
        $styles[] = "@media (max-width: 1024px) { .{$block_class} { " . implode(' ', $tablet) . " } }";
    }

    // MOBILE
    $mobile = [];

    if (isset($data_margin['mobile']) && is_numeric($data_margin['mobile'])) {
        $mobile[] = "margin-bottom: {$data_margin['mobile']}px;";
    }

    if (isset($data_padding['mobile']) && is_numeric($data_padding['mobile'])) {
        $mobile[] = "padding-top: {$data_padding['mobile']}px;";
        $mobile[] = "padding-bottom: {$data_padding['mobile']}px;";
    }

    if (!empty($mobile)) {
        $styles[] = "@media (max-width: 768px) { .{$block_class} { " . implode(' ', $mobile) . " } }";
    }

    return '<style>' . implode("\n", $styles) . '</style>';
}


/**
 * Helper function for estimated reading time
 */
function maxwell_estimated_reading_time($post_id)
{
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 words per minute

    return $reading_time;
}


function maxwell_related_posts($post_id = null, $posts_per_page = 2)
{

    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $categories = wp_get_post_categories($post_id);

    if (empty($categories)) {
        return;
    }

    $args = [
        'post_type'      => 'post',
        'posts_per_page' => $posts_per_page,
        'post__not_in'   => [$post_id],
        'category__in'   => $categories,
        'orderby'        => 'rand'
    ];


    $query = new WP_Query($args);

    if ($query->have_posts()) {

        echo '<div class="related-posts grid grid-cols-1 md:grid-cols-2 gap-8">';

        while ($query->have_posts()) {
            $query->the_post();

            get_template_part('template-parts/content', 'blog_card');
        }

        echo '</div>';
    }

    wp_reset_postdata();
}


/**
 * Renderuje ikonicu (SVG ili sliku) sa uniformnim klasama
 *
 * @param array $icon_data Podaci o ikonici (url, alt, subtype)
 * @param string $classes CSS klase koje se primenjuju
 * @return void
 */
function maxwell_render_icon($icon_data, $classes = 'w-5 h-5 text-white')
{
    if (empty($icon_data['url'])) {
        return;
    }

    if (isset($icon_data['subtype']) && $icon_data['subtype'] == 'svg+xml') {
        echo maxwell_render_svg($icon_data['url'], $classes);
    } else {
        $alt = isset($icon_data['alt']) ? $icon_data['alt'] : '';
?>
        <img src="<?php echo esc_url($icon_data['url']); ?>"
            alt="<?php echo esc_attr($alt); ?>"
            class="<?php echo esc_attr($classes); ?>">
    <?php
    }
}


/**
 * Generiše HTML za share opcije (LinkedIn, Twitter, Facebook, Copy Link i Save/Bookmark)
 * 
 * @param string $url URL članka koji se deli
 * @param string $title Naslov članka koji se deli (opciono)
 * @param string $additionalClasses Dodatne CSS klase za wrapper (opciono)
 * @return string HTML za share komponentu
 */
function _share_component($url, $title = '', $additionalClasses = '')
{
    // Enkodiranje URL-a i naslova za deljenje
    $encodedUrl = urlencode($url);
    $encodedTitle = urlencode($title ?: 'Check this out!');

    // Generisanje share linkova
    $linkedinUrl = "https://www.linkedin.com/sharing/share-offsite/?url={$encodedUrl}";
    $twitterUrl = "https://twitter.com/intent/tweet?url={$encodedUrl}&text={$encodedTitle}";
    $facebookUrl = "https://www.facebook.com/sharer/sharer.php?u={$encodedUrl}";
    ?>
    <div class="p-3 <?php echo $additionalClasses; ?>">
        <h3 class="font-semibold text-foreground flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 w-4 h-4">
                <circle cx="18" cy="5" r="3"></circle>
                <circle cx="6" cy="12" r="3"></circle>
                <circle cx="18" cy="19" r="3"></circle>
                <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line>
                <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line>
            </svg>
            <?php echo __("Share: ", 'maxwell'); ?>
        </h3>
        <div class="flex gap-3">
            <a href="<?php echo $linkedinUrl; ?>" target="_blank" rel="noopener noreferrer"
                class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-white transition-all bg-accent hover:bg-accent group cursor-pointer"
                title="Share on LinkedIn">
                <svg class="w-4 h-4 text-white group-hover:text-white transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path>
                    <rect width="4" height="12" x="2" y="9"></rect>
                    <circle cx="4" cy="4" r="2"></circle>
                </svg>
            </a>

            <a href="<?php echo $twitterUrl; ?>" target="_blank" rel="noopener noreferrer"
                class="w-8 h-8  rounded-lg flex items-center justify-center shrink-0 text-white transition-all bg-accent hover:bg-accent group cursor-pointer"
                title="Share on Twitter">
                <svg class="w-4 h-4 text-white group-hover:text-white transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                </svg>
            </a>

            <a href="<?php echo $facebookUrl; ?>" target="_blank" rel="noopener noreferrer"
                class="w-8 h-8  rounded-lg flex items-center justify-center shrink-0 text-accent transition-all bg-accent hover:bg-accent group cursor-pointer"
                title="Share on Facebook">
                <svg class="w-4 h-4 text-white group-hover:text-white transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                </svg>
            </a>

            <button onclick="copyToClipboard('<?php echo $url; ?>', this)"
                class="relative w-8 h-8  rounded-lg flex items-center justify-center shrink-0 text-white transition-all bg-accent hover:bg-accent group cursor-pointer"
                title="Copy link"
                id="{$uniqueId}">
                <svg class="w-4 h-4 text-white group-hover:text-white transition-colors" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect>
                    <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path>
                </svg>
                <span class="copy-tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-accent/30 text-accent text-xs py-1 px-2 rounded opacity-0 transition-opacity pointer-events-none whitespace-nowrap z-10 group-hover:opacity-100">
                    Copy link
                </span>
                <span class="copy-success-tooltip absolute -top-8 left-1/2 -translate-x-1/2 bg-accent text-white text-xs py-1 px-2 rounded opacity-0 transition-opacity pointer-events-none whitespace-nowrap z-10">
                    ✓ Copied!
                </span>
            </button>
        </div>
    </div>

    <style>
        .copy-tooltip,
        .copy-success-tooltip {
            transition: opacity 0.2s ease-in-out;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .copy-success-tooltip.show {
            opacity: 1;
        }

        .copy-tooltip.hide {
            opacity: 0;
        }
    </style>

    <script>
        function copyToClipboard(text, buttonElement) {
            // Proveri da li je Clipboard API podržan
            if (!navigator.clipboard) {
                fallbackCopyTextToClipboard(text, buttonElement);
                return;
            }

            // Sakrij regular tooltip
            const regularTooltip = buttonElement.querySelector('.copy-tooltip');
            regularTooltip.style.opacity = '0';

            navigator.clipboard.writeText(text).then(function() {
                // Prikaži success tooltip
                const successTooltip = buttonElement.querySelector('.copy-success-tooltip');
                successTooltip.classList.add('show');

                // Sakrij success tooltip posle 2 sekunde
                setTimeout(function() {
                    successTooltip.classList.remove('show');
                    // Vrati regular tooltip
                    setTimeout(() => {
                        regularTooltip.style.opacity = '';
                    }, 200);
                }, 2000);
            }, function(err) {
                console.error('Could not copy text: ', err);
                fallbackCopyTextToClipboard(text, buttonElement);
            });
        }

        function fallbackCopyTextToClipboard(text, buttonElement) {
            const textArea = document.createElement("textarea");
            textArea.value = text;

            // Make the textarea out of viewport
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);

            textArea.focus();
            textArea.select();

            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    // Sakrij regular tooltip
                    const regularTooltip = buttonElement.querySelector('.copy-tooltip');
                    regularTooltip.style.opacity = '0';

                    // Prikaži success tooltip
                    const successTooltip = buttonElement.querySelector('.copy-success-tooltip');
                    successTooltip.classList.add('show');

                    // Sakrij success tooltip posle 2 sekunde
                    setTimeout(function() {
                        successTooltip.classList.remove('show');
                        // Vrati regular tooltip
                        setTimeout(() => {
                            regularTooltip.style.opacity = '';
                        }, 200);
                    }, 2000);
                }
            } catch (err) {
                console.error('Fallback: Could not copy text: ', err);
                alert('Press Ctrl+C (or Cmd+C on Mac) to copy the link:\n' + text);
            }

            document.body.removeChild(textArea);
        }
    </script>
<?php
}

/**
 * @param $post_id
 * get post excerpt by 260 karacer
 *
 * @return bool|string
 */
function maxxwell_get_the_excerpt($post_id)
{

    $excerpt = get_the_excerpt($post_id);

    $excerpt = substr($excerpt, 0, 95);
    $result = substr($excerpt, 0, strrpos($excerpt, ' '));

    return $result;
}


function maxwell_get_cpt($post_type = 'case-study', int $post_number = 4): array
{
    $args = array(
        'post_type' => $post_type,
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $post_number,
    );
    $query = new WP_Query($args);
    // The Loop.
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $output[] = [
                'title' => get_the_title(),
                'link' => ['url' => get_the_permalink(), 'title' => get_the_title(), 'target' => '_blank'],
                'image' => get_image(get_post_thumbnail_id($post_id)),
                'tag' => _case_study_primary_category($post_id),
                'main_text' => maxxwell_get_the_excerpt($post_id),
            ];
        }

        wp_reset_postdata();
    }

    return $output;
}


function gxdev_get_custom_tax($post_id, $tax = '') {
    $terms = get_the_terms($post_id, $tax);
    $result = [];
    
    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            $term_link = get_term_link($term);
            if (!is_wp_error($term_link)) {
                $result[] = [
                    'name' => $term->name,
                    'link' => $term_link
                ];
            }
        }
    }
    
    return $result;
}


// U functions.php
/**
 * Dohvata i renderuje sadržaj iz global_contents CPT-a po slugu
 * 
 * @param string $slug Slug globalnog sadržaja
 * @return string
 */
function gxdev_render_global_content($slug) {

    $content_post = get_page_by_path($slug, OBJECT, 'global-content');

    if (!$content_post || $content_post->post_status !== 'publish') {
        return '<!-- Global content not found: ' . esc_html($slug) . ' -->';
    }

    $content = $content_post->post_content;

    // WordPress standardni rendering (blokovi + filteri)
    $output = apply_filters('the_content', $content);

    return $output;
}


function jd_get_related_properties($args = [])
{
    $defaults = [
        'category' => $args['category'],
        'posts_per_page' => 3,
        'exclude_id' => get_the_ID(),
    ];

    $args = wp_parse_args($args, $defaults);

    // 🔎 base query
    $query_args = [
        'post_type'      => 'properties',
        'posts_per_page' => $args['posts_per_page'],
        'post__not_in'   => [$args['exclude_id']],
        // 'meta_key'       => 'property_price',
        // 'orderby'        => 'meta_value_num',
        // 'order'          => 'DESC',
    ];

    // TAX filter (ako postoji)
    // if (!empty($args['category'])) {
    //     $query_args['tax_query'] = [
    //         [
    //             'taxonomy' => 'cat',
    //             'field'    => 'slug',
    //             'terms'    => $args['category'],
    //         ]
    //     ];
    // }
    $query = new WP_Query($query_args);

    // 🧠 fallback ako nema rezultata
    if (!$query->have_posts()) {
        // unset($query_args['tax_query']);
        $query = new WP_Query($query_args);
    }

    return $query;
}


// Funkcije za dohvat vrednosti za filtere
function get_min_price() {
  $min = get_option('property_price_min', 0);
  return $min === null ? 100 : (int)$min;
}

function get_max_price() {
  $max = get_option('property_price_max', 1000000);
  return $max === null ? 1200000 : (int)$max;
}

// 1. Prvo definišite funkciju koja kreira args
function get_property_args($data, $per_page = -1) {
    $args = array(
        'post_type' => 'properties',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => $per_page,
    );

    $tax_query = array();

    if (! empty($data['property_type']) && $data['use_type'] == 'yes') {
        $tax_query[] = array(
            'taxonomy' => 'jd-type',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($data['property_type']),
        );
    }

    if (! empty($data['property_location']) && $data['use_location'] == 'yes') {
        $tax_query[] = array(
            'taxonomy' => 'location',
            'field'    => 'id',
            'terms'    => sanitize_text_field($data['property_location']),
        );
    }

    if (! empty($data['property_category']) && $data['use_category'] == 'yes') {
        $tax_query[] = array(
            'taxonomy' => 'cat',
            'field'    => 'slug',
            'terms'    => sanitize_text_field($data['property_category']),
        );
    }

    if (! empty($tax_query)) {
        $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    return $args;
}