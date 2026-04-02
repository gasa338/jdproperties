<?php

/**
 * ACF Background Select Field
 * Simple image-based radio buttons for background selection
 * 
 * @package ACF_Background_Select
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class acf_field_background_select extends acf_field
{

    /**
     * Initialize field
     */
    function __construct()
    {
        $this->name = 'background_select';
        $this->label = __('Background Select', 'acf-background-select');
        $this->category = 'choice';
        $this->defaults = array(
            'choices' => array(),
            'default_value' => '',
            'return_format' => 'value',
            'allow_custom' => 0,
            'custom_label' => __('Custom Background', 'acf-background-select'),
            'preview_width' => 150,  // Fixed width
            'preview_height' => 100  // Fixed height
        );

        parent::__construct();
    }

    /**
     * Render field settings - SIMPLIFIED!
     */
    function render_field_settings($field)
    {
        // Choices - super simple for clients
        acf_render_field_setting($field, array(
            'label' => __('Background Options', 'acf'),
            'instructions' => __('Add each option on a new line.', 'acf') . '<br>' .
                __('Format: value|Label|Image ID', 'acf') . '<br><br>' .
                '<strong>Example:</strong><br>' .
                'light|Light Background<br>' .
                'dark|Dark Background<br>' .
                'pattern|Pattern Background',
            'type' => 'textarea',
            'name' => 'choices',
            'rows' => 6
        ));

        // Default value
        acf_render_field_setting($field, array(
            'label' => __('Default Selection', 'acf'),
            'instructions' => __('Enter the value of the default background', 'acf'),
            'type' => 'text',
            'name' => 'default_value',
            'placeholder' => 'light'
        ));

        // Return format - simplified options
        acf_render_field_setting($field, array(
            'label' => __('Return Format', 'acf'),
            'instructions' => __('What should be returned by get_field()', 'acf'),
            'type' => 'select',
            'name' => 'return_format',
            'choices' => array(
                'value' => __('Value (recommended)', 'acf'),
                'url' => __('Image URL', 'acf'),
                'id' => __('Image ID', 'acf')
            ),
        ));

        // Allow custom background (optional)
        acf_render_field_setting($field, array(
            'label' => __('Allow Custom Background', 'acf'),
            'instructions' => __('Allow users to upload their own background image', 'acf'),
            'type' => 'true_false',
            'name' => 'allow_custom',
            'ui' => 1,
            'default_value' => 0
        ));

        // Custom background label (only if custom is allowed)
        acf_render_field_setting($field, array(
            'label' => __('Custom Background Label', 'acf'),
            'instructions' => __('Label for the custom background option', 'acf'),
            'type' => 'text',
            'name' => 'custom_label',
            'placeholder' => __('Custom Background', 'acf-background-select'),
            'conditional_logic' => array(
                array(
                    'field' => 'allow_custom',
                    'operator' => '==',
                    'value' => '1'
                )
            )
        ));
    }

    /**
     * Parse choices from textarea
     */
    private function parse_choices($choices_text)
    {
        $choices = array();
        $lines = explode("\n", $choices_text);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $parts = explode('|', $line);

            if (count($parts) >= 3) {
                // Format: value|Label|Image ID
                $value = trim($parts[0]);
                $label = trim($parts[1]);
                
                $background_image = get_field('background_image', 'option');
                $name_image_map = $this->create_name_image_map($background_image);
                
                
                $image_id = $name_image_map[$value] ?? null;
                

                if (is_numeric($image_id) && $image_id > 0) {
                    // Get image URL - we'll resize it to our fixed dimensions
                    $image_url = $this->get_resized_image_url($image_id, 150, 100);
                    $full_url = wp_get_attachment_url($image_id);

                    $choices[$value] = array(
                        'label' => $label,
                        'image_id' => $image_id,
                        'preview_url' => $image_url,
                        'full_url' => $full_url
                    );
                }
            } elseif (count($parts) == 2) {
                // Format: value|Label (no image)
                $value = trim($parts[0]);
                $label = trim($parts[1]);
                $choices[$value] = array(
                    'label' => $label,
                    'image_id' => '',
                    'preview_url' => '',
                    'full_url' => ''
                );
            }
            // Ignore single values (must have label)
        }

        return $choices;
    }

    private function create_name_image_map($array)
    {
        $result = array();

        foreach ($array as $item) {
            if (isset($item['name']) && isset($item['image'])) {
                $result[$item['name']] = $item['image'];
            }
        }

        return $result;
    }
    /**
     * Get resized image URL
     */
    private function get_resized_image_url($image_id, $width = 150, $height = 100)
    {
        $image_url = wp_get_attachment_image_url($image_id, 'full');

        if (!$image_url) {
            return '';
        }

        // Check if image exists and get its dimensions
        $image_path = get_attached_file($image_id);
        if (file_exists($image_path)) {
            $image_size = getimagesize($image_path);
            if ($image_size[0] < 100 || $image_size[1] < 60) {
                // Image is too small, return original
                return $image_url;
            }
        }

        // Use WordPress image resizing
        $resized = image_get_intermediate_size($image_id, array($width, $height));
        if ($resized) {
            return $resized['url'];
        }

        // If no resized version exists, return original
        return $image_url;
    }

    /**
     * Render field input
     */
    function render_field($field)
    {
        $choices = $this->parse_choices($field['choices']);
        $value = $field['value'] ?: $field['default_value'];
        $field_name = $field['name'];
        $preview_width = 150;  // Fixed
        $preview_height = 100; // Fixed

        // Enqueue scripts and styles
        $this->input_admin_enqueue_scripts();
?>

        <div class="acf-background-select" data-field-name="<?php echo esc_attr($field_name); ?>">

            <?php if (empty($choices)): ?>
                <div class="acf-notice notice-warning">
                    <p><?php _e('No background options defined. Add options in field settings.', 'acf-background-select'); ?></p>
                </div>
            <?php else: ?>
                <div class="background-options">
                    <?php foreach ($choices as $option_value => $option_data):
                        $option_id = $field_name . '-' . sanitize_title($option_value);
                        $is_selected = ($value == $option_value);
                        $image_src = $option_data['preview_url'];
                    ?>

                        <div class="background-option <?php echo $is_selected ? 'selected' : ''; ?>"
                            data-value="<?php echo esc_attr($option_value); ?>"
                            title="<?php echo esc_attr($option_data['label']); ?>">

                            <input type="radio"
                                id="<?php echo esc_attr($option_id); ?>"
                                name="<?php echo esc_attr($field_name); ?>"
                                value="<?php echo esc_attr($option_value); ?>"
                                <?php checked($is_selected); ?>
                                class="background-radio">

                            <label for="<?php echo esc_attr($option_id); ?>" class="background-option-label">
                                <div class="option-preview" style="width: <?php echo $preview_width; ?>px; height: <?php echo $preview_height; ?>px;">
                                    <?php if ($image_src): ?>
                                        <img src="<?php echo esc_url($image_src); ?>"
                                            alt="<?php echo esc_attr($option_data['label']); ?>"
                                            width="<?php echo $preview_width; ?>"
                                            height="<?php echo $preview_height; ?>">
                                        <div class="checkmark">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13.3334 4L6.00008 11.3333L2.66675 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-image-placeholder">
                                            <span class="placeholder-text"><?php echo esc_html(substr($option_data['label'], 0, 2)); ?></span>
                                        </div>
                                        <div class="checkmark">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M13.3334 4L6.00008 11.3333L2.66675 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="option-label">
                                    <?php echo esc_html($option_data['label']); ?>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($field['allow_custom']): ?>
                        <?php
                        $is_custom_selected = ($value == 'custom');
                        $custom_id = $field_name . '-custom';
                        ?>

                        <div class="background-option custom-background <?php echo $is_custom_selected ? 'selected' : ''; ?>"
                            data-value="custom"
                            title="<?php echo esc_attr($field['custom_label']); ?>">

                            <input type="radio"
                                id="<?php echo esc_attr($custom_id); ?>"
                                name="<?php echo esc_attr($field_name); ?>"
                                value="custom"
                                <?php checked($is_custom_selected); ?>
                                class="background-radio">

                            <label for="<?php echo esc_attr($custom_id); ?>" class="background-option-label">
                                <div class="option-preview custom-option" style="width: <?php echo $preview_width; ?>px; height: <?php echo $preview_height; ?>px;">
                                    <span class="dashicons dashicons-plus-alt2"></span>
                                    <div class="checkmark">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M13.3334 4L6.00008 11.3333L2.66675 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="option-label">
                                    <?php echo esc_html($field['custom_label']); ?>
                                </div>
                            </label>
                        </div>

                        <?php if ($is_custom_selected): ?>
                            <div class="custom-background-upload" style="display: block; margin-top: 20px; padding-top: 20px; border-top: 1px solid #ddd;">
                                <div class="upload-instructions">
                                    <p><?php _e('Upload your custom background image. Minimum size: 100×60 pixels.', 'acf-background-select'); ?></p>
                                </div>
                                <?php
                                $custom_field_name = $field_name . '_custom';
                                $custom_image = get_field($custom_field_name) ?: '';

                                // Render ACF image field
                                acf_render_field(array(
                                    'key' => 'field_' . uniqid(),
                                    'label' => __('Select Image', 'acf-background-select'),
                                    'name' => $custom_field_name,
                                    'type' => 'image',
                                    'value' => $custom_image,
                                    'return_format' => 'id',
                                    'preview_size' => 'medium',
                                    'library' => 'all',
                                    'min_width' => 100,
                                    'min_height' => 60,
                                    'mime_types' => 'jpg,jpeg,png,gif,webp',
                                    'wrapper' => array(
                                        'class' => 'custom-image-upload'
                                    )
                                ));
                                ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <input type="hidden" class="background-hidden-value" value="<?php echo esc_attr($value); ?>">
            <?php endif; ?>
        </div>

<?php
    }

    /**
     * Enqueue scripts and styles
     */
    function input_admin_enqueue_scripts()
    {
        $url = get_template_directory_uri() . '/acf-image-select/';

        // CSS
        wp_register_style('acf-background-select', $url . 'acf-image-select.css', array('acf-input'), '1.0.0');
        wp_enqueue_style('acf-background-select');

        // JS
        wp_register_script('acf-background-select', $url . 'js/acf-image-select.js', array('jquery', 'acf-input'), '1.0.0', true);
        wp_enqueue_script('acf-background-select');
    }

    /**
     * Format value for display
     */
    function format_value($value, $post_id, $field)
    {
        if (empty($value)) {
            return $value;
        }

        $choices = $this->parse_choices($field['choices']);

        // Handle custom background
        if ($value == 'custom' && $field['allow_custom']) {
            $custom_field_name = $field['name'] . '_custom';
            $custom_image = get_field($custom_field_name, $post_id);

            switch ($field['return_format']) {
                case 'url':
                    return $custom_image ? wp_get_attachment_url($custom_image) : '';
                case 'id':
                    return $custom_image;
                case 'value':
                default:
                    return 'custom';
            }
        }

        // Handle predefined options
        if (isset($choices[$value])) {
            $choice = $choices[$value];

            switch ($field['return_format']) {
                case 'url':
                    return $choice['full_url'];
                case 'id':
                    return $choice['image_id'];
                case 'value':
                default:
                    return $value;
            }
        }

        return $value;
    }

    /**
     * Update value
     */
    function update_value($value, $post_id, $field)
    {
        return $value;
    }

    /**
     * Load value
     */
    function load_value($value, $post_id, $field)
    {
        return $value ?: $field['default_value'];
    }

    /**
     * Validate value
     */
    function validate_value($valid, $value, $field, $input)
    {
        if (empty($value)) {
            return $valid;
        }

        $choices = $this->parse_choices($field['choices']);

        if ($value == 'custom' && !$field['allow_custom']) {
            return __('Custom background is not allowed', 'acf-background-select');
        }

        if ($value != 'custom' && !isset($choices[$value])) {
            return __('Invalid background selection', 'acf-background-select');
        }

        return $valid;
    }

    /**
     * Get selected background info
     */
    public static function get_selected_background($field_name, $post_id = null)
    {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        $value = get_field($field_name, $post_id);

        if (!$value) {
            return false;
        }

        $field_object = get_field_object($field_name, $post_id);

        if (!$field_object) {
            return false;
        }

        // Create instance to access parse_choices
        $field_instance = new self();
        $choices = $field_instance->parse_choices($field_object['choices']);

        if ($value == 'custom' && $field_object['allow_custom']) {
            $custom_image = get_field($field_name . '_custom', $post_id);
            return array(
                'type' => 'custom',
                'value' => 'custom',
                'label' => $field_object['custom_label'],
                'image_id' => $custom_image,
                'image_url' => $custom_image ? wp_get_attachment_url($custom_image) : ''
            );
        }

        if (isset($choices[$value])) {
            return array(
                'type' => 'predefined',
                'value' => $value,
                'label' => $choices[$value]['label'],
                'image_id' => $choices[$value]['image_id'],
                'image_url' => $choices[$value]['full_url']
            );
        }

        return false;
    }
}

// Initialize the field
add_action('acf/include_field_types', function ($version) {
    new acf_field_background_select();
});
?>