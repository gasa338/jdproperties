<?php

/**
 * ACF Advanced Title Field
 * Title field with alignment, tag and responsive font sizes
 * 
 * @package ACF_Advanced_Title
 */

if (!defined('ABSPATH')) {
    exit;
}

class acf_field_advanced_title extends acf_field
{

    function __construct()
    {
        $this->name = 'advanced_title';
        $this->label = __('Advanced Title', 'acf-advanced-title');
        $this->category = 'content';
        $this->defaults = array(
            'default_value' => '',
            'placeholder' => __('Enter title...', 'acf-advanced-title'),
            'maxlength' => '',
            'default_align' => 'left',
            'default_tag' => 'h2',
            'default_size_desktop' => 32,
            'default_size_tablet' => 28,
            'default_size_mobile' => 24,
        );

        parent::__construct();
    }

    function render_field_settings($field)
    {
        // Default value
        acf_render_field_setting($field, array(
            'label' => __('Default Value', 'acf'),
            'type' => 'text',
            'name' => 'default_value',
        ));

        // Placeholder
        acf_render_field_setting($field, array(
            'label' => __('Placeholder Text', 'acf'),
            'type' => 'text',
            'name' => 'placeholder',
        ));

        // Default alignment
        acf_render_field_setting($field, array(
            'label' => __('Default Alignment', 'acf'),
            'type' => 'select',
            'name' => 'default_align',
            'choices' => array(
                'left' => __('Left', 'acf'),
                'center' => __('Center', 'acf'),
                'right' => __('Right', 'acf'),
            )
        ));

        // Default tag
        acf_render_field_setting($field, array(
            'label' => __('Default HTML Tag', 'acf'),
            'type' => 'select',
            'name' => 'default_tag',
            'choices' => array(
                'h1' => 'H1',
                'h2' => 'H2',
                'h3' => 'H3',
                'h4' => 'H4',
                'h5' => 'H5',
                'h6' => 'H6',
                'p' => 'P',
                'div' => 'DIV'
            )
        ));

        // Default font sizes
        acf_render_field_setting($field, array(
            'label' => __('Default Font Size - Desktop (px)', 'acf'),
            'type' => 'number',
            'name' => 'default_size_desktop',
            'min' => 10,
            'max' => 200,
            'default_value' => 32
        ));

        acf_render_field_setting($field, array(
            'label' => __('Default Font Size - Tablet (px)', 'acf'),
            'type' => 'number',
            'name' => 'default_size_tablet',
            'min' => 10,
            'max' => 200,
            'default_value' => 28
        ));

        acf_render_field_setting($field, array(
            'label' => __('Default Font Size - Mobile (px)', 'acf'),
            'type' => 'number',
            'name' => 'default_size_mobile',
            'min' => 10,
            'max' => 200,
            'default_value' => 24
        ));
    }

    function render_field($field)
    {
        $value = is_array($field['value']) ? $field['value'] : array();
        $defaults = array(
            'text' => isset($field['default_value']) ? $field['default_value'] : '',
            'align' => isset($field['default_align']) ? $field['default_align'] : 'left',
            'tag' => isset($field['default_tag']) ? $field['default_tag'] : 'h2',
            'size_desktop' => isset($field['default_size_desktop']) ? $field['default_size_desktop'] : 32,
            'size_tablet' => isset($field['default_size_tablet']) ? $field['default_size_tablet'] : 28,
            'size_mobile' => isset($field['default_size_mobile']) ? $field['default_size_mobile'] : 24,
        );

        $value = wp_parse_args($value, $defaults);
        $field_name = isset($field['name']) ? $field['name'] : 'advanced_title';

        $this->input_admin_enqueue_scripts();
?>

        <div class="acf-advanced-title-field" data-field-name="<?php echo esc_attr($field_name); ?>">

            <!-- Title input with settings icon -->
            <div class="title-input-container">
                <input type="text"
                    class="title-text-input"
                    name="<?php echo esc_attr($field_name); ?>[text]"
                    value="<?php echo esc_attr($value['text']); ?>"
                    placeholder="<?php echo esc_attr($field['placeholder']); ?>">

                <button type="button" class="settings-toggle-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="3" stroke="#1C274C" stroke-width="1.5" />
                        <path d="M3.66122 10.6392C4.13377 10.9361 4.43782 11.4419 4.43782 11.9999C4.43781 12.558 4.13376 13.0638 3.66122 13.3607C3.33966 13.5627 3.13248 13.7242 2.98508 13.9163C2.66217 14.3372 2.51966 14.869 2.5889 15.3949C2.64082 15.7893 2.87379 16.1928 3.33973 16.9999C3.80568 17.8069 4.03865 18.2104 4.35426 18.4526C4.77508 18.7755 5.30694 18.918 5.83284 18.8488C6.07287 18.8172 6.31628 18.7185 6.65196 18.5411C7.14544 18.2803 7.73558 18.2699 8.21895 18.549C8.70227 18.8281 8.98827 19.3443 9.00912 19.902C9.02332 20.2815 9.05958 20.5417 9.15224 20.7654C9.35523 21.2554 9.74458 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8478 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.9021C15.0117 19.3443 15.2977 18.8281 15.7811 18.549C16.2644 18.27 16.8545 18.2804 17.3479 18.5412C17.6837 18.7186 17.9271 18.8173 18.1671 18.8489C18.693 18.9182 19.2249 18.7756 19.6457 18.4527C19.9613 18.2106 20.1943 17.807 20.6603 17C20.8677 16.6407 21.029 16.3614 21.1486 16.1272M20.3387 13.3608C19.8662 13.0639 19.5622 12.5581 19.5621 12.0001C19.5621 11.442 19.8662 10.9361 20.3387 10.6392C20.6603 10.4372 20.8674 10.2757 21.0148 10.0836C21.3377 9.66278 21.4802 9.13092 21.411 8.60502C21.3591 8.2106 21.1261 7.80708 20.6601 7.00005C20.1942 6.19301 19.9612 5.7895 19.6456 5.54732C19.2248 5.22441 18.6929 5.0819 18.167 5.15113C17.927 5.18274 17.6836 5.2814 17.3479 5.45883C16.8544 5.71964 16.2643 5.73004 15.781 5.45096C15.2977 5.1719 15.0117 4.6557 14.9909 4.09803C14.9767 3.71852 14.9404 3.45835 14.8478 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74458 2.35523 9.35523 2.74458 9.15224 3.23463C9.05958 3.45833 9.02332 3.71848 9.00912 4.09794C8.98826 4.65566 8.70225 5.17191 8.21891 5.45096C7.73557 5.73002 7.14548 5.71959 6.65205 5.4588C6.31633 5.28136 6.0729 5.18269 5.83285 5.15108C5.30695 5.08185 4.77509 5.22436 4.35427 5.54727C4.03866 5.78945 3.80569 6.19297 3.33974 7C3.13231 7.35929 2.97105 7.63859 2.85138 7.87273" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </button>
            </div>

            <!-- Settings Panel -->
            <div class="settings-panel">

                <div class="setting-row">
                    <label class="setting-label">Alignment</label>
                    <div class="setting-options align-options">
                        <button type="button" class="option-btn <?php echo $value['align'] == 'left' ? 'active' : ''; ?>" data-option="align" data-value="left">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor">
                                <line x1="2" y1="3" x2="14" y2="3" stroke-width="1.5" />
                                <line x1="2" y1="6" x2="10" y2="6" stroke-width="1.5" />
                                <line x1="2" y1="9" x2="14" y2="9" stroke-width="1.5" />
                                <line x1="2" y1="12" x2="10" y2="12" stroke-width="1.5" />
                            </svg>
                        </button>
                        <button type="button" class="option-btn <?php echo $value['align'] == 'center' ? 'active' : ''; ?>" data-option="align" data-value="center">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor">
                                <line x1="2" y1="3" x2="14" y2="3" stroke-width="1.5" />
                                <line x1="4" y1="6" x2="12" y2="6" stroke-width="1.5" />
                                <line x1="2" y1="9" x2="14" y2="9" stroke-width="1.5" />
                                <line x1="4" y1="12" x2="12" y2="12" stroke-width="1.5" />
                            </svg>
                        </button>
                        <button type="button" class="option-btn <?php echo $value['align'] == 'right' ? 'active' : ''; ?>" data-option="align" data-value="right">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" stroke="currentColor">
                                <line x1="2" y1="3" x2="14" y2="3" stroke-width="1.5" />
                                <line x1="6" y1="6" x2="14" y2="6" stroke-width="1.5" />
                                <line x1="2" y1="9" x2="14" y2="9" stroke-width="1.5" />
                                <line x1="6" y1="12" x2="14" y2="12" stroke-width="1.5" />
                            </svg>
                        </button>
                    </div>
                    <input type="hidden" name="<?php echo esc_attr($field_name); ?>[align]" value="<?php echo esc_attr($value['align']); ?>" class="align-value">
                </div>

                <div class="setting-row">
                    <label class="setting-label">HTML Tag</label>
                    <div class="setting-options tag-options">
                        <?php
                        $tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div');
                        foreach ($tags as $tag):
                        ?>
                            <button type="button" class="option-btn tag-btn <?php echo $value['tag'] == $tag ? 'active' : ''; ?>" data-option="tag" data-value="<?php echo $tag; ?>">
                                <?php echo strtoupper($tag); ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                    <input type="hidden" name="<?php echo esc_attr($field_name); ?>[tag]" value="<?php echo esc_attr($value['tag']); ?>" class="tag-value">
                </div>

                <div class="setting-row">
                    <label class="setting-label">Font Size (px)</label>
                    <div class="size-controls-inline">
                        <div class="size-input-wrapper">
                            <svg width="18" height="18" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="3" width="16" height="12" rx="1" />
                                <line x1="2" y1="15" x2="18" y2="15" />
                            </svg>
                            <input type="number" name="<?php echo esc_attr($field_name); ?>[size_desktop]" value="<?php echo esc_attr($value['size_desktop']); ?>" min="10" max="200" class="size-input">
                        </div>

                        <div class="size-input-wrapper">
                            <svg width="16" height="18" viewBox="0 0 16 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="2" width="12" height="16" rx="1" />
                            </svg>
                            <input type="number" name="<?php echo esc_attr($field_name); ?>[size_tablet]" value="<?php echo esc_attr($value['size_tablet']); ?>" min="10" max="200" class="size-input">
                        </div>

                        <div class="size-input-wrapper">
                            <svg width="14" height="18" viewBox="0 0 14 20" fill="none" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="2" width="10" height="16" rx="1" />
                            </svg>
                            <input type="number" name="<?php echo esc_attr($field_name); ?>[size_mobile]" value="<?php echo esc_attr($value['size_mobile']); ?>" min="10" max="200" class="size-input">
                        </div>
                    </div>
                </div>
            </div>

        </div>

<?php
    }

    function input_admin_enqueue_scripts()
    {
        $url = get_template_directory_uri() . '/acf-advanced-title/';

        wp_register_style('acf-advanced-title', $url . 'acf-advanced-title.css', array('acf-input'), '1.0.1');
        wp_enqueue_style('acf-advanced-title');

        wp_register_script('acf-advanced-title', $url . 'js/acf-advanced-title.js', array('jquery', 'acf-input'), '1.0.1', true);
        wp_enqueue_script('acf-advanced-title');
    }

    function format_value($value, $post_id, $field)
    {
        if (empty($value) || !is_array($value)) {
            return $value;
        }

        $defaults = array(
            'text' => '',
            'align' => 'left',
            'tag' => 'h2',
            'size_desktop' => 32,
            'size_tablet' => 28,
            'size_mobile' => 24,
        );

        $value = wp_parse_args($value, $defaults);
        $value['html'] = $this->get_html_output($value);

        return $value;
    }

    private function get_html_output($value)
    {
        $classes = array('advanced-title', 'align-' . $value['align']);
        $styles = array();

        $styles[] = 'text-align: ' . $value['align'];
        $styles[] = 'font-size: ' . intval($value['size_desktop']) . 'px';

        $html = sprintf(
            '<%1$s class="%2$s" style="%3$s" data-size-tablet="%4$s" data-size-mobile="%5$s">%6$s</%1$s>',
            esc_attr($value['tag']),
            esc_attr(implode(' ', $classes)),
            esc_attr(implode('; ', $styles)),
            esc_attr($value['size_tablet']),
            esc_attr($value['size_mobile']),
            esc_html($value['text'])
        );

        return $html;
    }

    function update_value($value, $post_id, $field)
    {
        if (is_array($value)) {
            if (isset($value['text'])) {
                $value['text'] = sanitize_text_field($value['text']);
            }

            $allowed_align = array('left', 'center', 'right');
            if (isset($value['align']) && !in_array($value['align'], $allowed_align)) {
                $value['align'] = 'left';
            }

            $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'div');
            if (isset($value['tag']) && !in_array($value['tag'], $allowed_tags)) {
                $value['tag'] = 'h2';
            }

            if (isset($value['size_desktop'])) {
                $value['size_desktop'] = max(10, min(200, intval($value['size_desktop'])));
            }
            if (isset($value['size_tablet'])) {
                $value['size_tablet'] = max(10, min(200, intval($value['size_tablet'])));
            }
            if (isset($value['size_mobile'])) {
                $value['size_mobile'] = max(10, min(200, intval($value['size_mobile'])));
            }
        }

        return $value;
    }

    public static function get_title_html($field_name, $post_id = null, $echo = false)
    {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        $value = get_field($field_name, $post_id);

        if (!$value || empty($value['text'])) {
            return '';
        }

        $html = isset($value['html']) ? $value['html'] : '';

        if ($echo) {
            echo $html;
            return;
        }

        return $html;
    }
}

add_action('acf/include_field_types', function ($version) {
    new acf_field_advanced_title();
});
?>