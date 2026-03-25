<?php
function maxwell_team_set_yoast_share_image($post_id, $post, $update)
{

    // Autosave / revision
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;

    // Samo publish
    if ($post->post_status !== 'publish') return;

    // Ako Yoast već ima sliku → ne diraj
    if (get_post_meta($post_id, '_yoast_wpseo_opengraph-image', true)) {
        return;
    }

    $image_id = null;

    $image = get_field('share_image', 'option');
    // Polylang ako postoji
    if (function_exists('pll_get_post_language')) {
        $lang = pll_get_post_language($post_id);

        $image_sl = $image['sl_image']['ID'];
        $image_en = $image['en_image']['ID'];
        if ($lang === 'sl' && $image_sl) {
            $image_id = $image_sl;
        } elseif ($lang === 'en' && $image_en) {
            $image_id = $image_en;
        }
    }

    // Fallback
    if (! $image_id && $image) {
        $image_id = $image['default_image']['ID'];
    }

    if (! $image_id) return;

    $image_url = wp_get_attachment_url($image_id);
    if (! $image_url) return;

    // ✅ Upis u Yoast meta (VIDLJIVO U UI-JU)
    update_post_meta($post_id, '_yoast_wpseo_opengraph-image', $image_url);
    update_post_meta($post_id, '_yoast_wpseo_twitter-image', $image_url);
}
add_action('save_post', 'maxwell_team_set_yoast_share_image', 20, 3);
