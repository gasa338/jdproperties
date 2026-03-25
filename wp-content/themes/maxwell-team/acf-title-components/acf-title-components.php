<?php
if (!defined('ABSPATH')) exit;

class acf_field_title_components extends acf_field {

    function __construct() {
        $this->name = 'title_components';
        $this->label = __('Title Components', 'acf');
        $this->category = 'content';

        parent::__construct();
    }

    function render_field($field) {

        $value = wp_parse_args($field['value'], [
            'top_title' => '',
            'top_icon' => '',
            'text' => '',
            'description' => '',
            'align' => 'left',
            'tag' => 'h2',
            'use_custom_size' => false,
            'size_desktop' => 32,
            'size_tablet' => 28,
            'size_mobile' => 24,
        ]);

        $name = esc_attr($field['name']);
        $this->input_admin_enqueue_scripts();
        ?>

        <div class="acf-advanced-title-field">

            <!-- TOP TITLE -->
            <input type="text" name="<?= $name ?>[top_title]" value="<?= esc_attr($value['top_title']) ?>" placeholder="Top title">

            <!-- ICON -->
            <input type="text" name="<?= $name ?>[top_icon]" value="<?= esc_attr($value['top_icon']) ?>" placeholder="Icon URL (SVG)">

            <!-- MAIN TITLE -->
            <input type="text" class="title-text-input" name="<?= $name ?>[text]" value="<?= esc_attr($value['text']) ?>" placeholder="Title">

            <!-- DESCRIPTION -->
            <textarea name="<?= $name ?>[description]" rows="3"><?= esc_textarea($value['description']) ?></textarea>

            <!-- SETTINGS -->
            <div class="settings-panel">

                <select name="<?= $name ?>[align]" class="align-value">
                    <option value="left" <?= selected($value['align'], 'left', false) ?>>Left</option>
                    <option value="center" <?= selected($value['align'], 'center', false) ?>>Center</option>
                    <option value="right" <?= selected($value['align'], 'right', false) ?>>Right</option>
                </select>

                <select name="<?= $name ?>[tag]" class="tag-value">
                    <?php foreach (['h1','h2','h3','h4','h5','h6','p','div'] as $tag): ?>
                        <option value="<?= $tag ?>" <?= selected($value['tag'], $tag, false) ?>>
                            <?= strtoupper($tag) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label>
                    <input type="checkbox" name="<?= $name ?>[use_custom_size]" value="1" <?= checked($value['use_custom_size'], true, false) ?>>
                    Custom font size
                </label>

                <div class="custom-font-size-row <?= $value['use_custom_size'] ? 'visible' : 'hidden' ?>">
                    <input type="number" name="<?= $name ?>[size_desktop]" value="<?= $value['size_desktop'] ?>">
                    <input type="number" name="<?= $name ?>[size_tablet]" value="<?= $value['size_tablet'] ?>">
                    <input type="number" name="<?= $name ?>[size_mobile]" value="<?= $value['size_mobile'] ?>">
                </div>
            </div>
        </div>
        <?php
    }

    function format_value($value, $post_id, $field) {
        if (!is_array($value)) return $value;

        $value['html'] = self::render_html($value);
        return $value;
    }

    public static function render_html($v) {
        ob_start(); ?>
        <div class="advanced-title align-<?= esc_attr($v['align']) ?>">
            <?php if (!empty($v['top_title'])): ?>
                <div class="top-title">
                    <?php if (!empty($v['top_icon'])): ?>
                        <img src="<?= esc_url($v['top_icon']) ?>" alt="">
                    <?php endif; ?>
                    <span><?= esc_html($v['top_title']) ?></span>
                </div>
            <?php endif; ?>

            <<?= esc_attr($v['tag']) ?>
                style="font-size:<?= intval($v['size_desktop']) ?>px"
                data-tablet="<?= intval($v['size_tablet']) ?>"
                data-mobile="<?= intval($v['size_mobile']) ?>">
                <?= esc_html($v['text']) ?>
            </<?= esc_attr($v['tag']) ?>>

            <?php if (!empty($v['description'])): ?>
                <p class="description"><?= esc_html($v['description']) ?></p>
            <?php endif; ?>
        </div>
        <?php
        return ob_get_clean();
    }

    function input_admin_enqueue_scripts() {
        $url = get_template_directory_uri() . '/acf-title-components/';
        wp_enqueue_script('acf-title-components', $url . 'js/acf-title-components.js', ['acf-input'], '1.0', true);
        wp_enqueue_style('acf-title-components', $url . 'css/acf-title-components.css', ['acf-input'], '1.0');
    }
}

add_action('acf/include_field_types', fn() => new acf_field_title_components());
