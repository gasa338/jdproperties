(function ($) {
    'use strict';

    function initAdvancedTitle($field) {

        if ($field.data('initialized')) return;
        $field.data('initialized', true);

        /* ==============================
         * CUSTOM FONT SIZE TOGGLE
         * ============================== */
        $field.find('input[name$="[use_custom_size]"]').on('change', function () {
            const isChecked = $(this).is(':checked');
            const $row = $field.find('.custom-font-size-row');

            $row.toggleClass('visible', isChecked);
            $row.toggleClass('hidden', !isChecked);

            $(this).trigger('change'); // 🔥 ACF sync
        });

        /* ==============================
         * FONT SIZE INPUT LIMIT
         * ============================== */
        $field.find('.custom-font-size-row input[type="number"]').on('input', function () {
            let value = parseInt(this.value, 10) || 10;
            value = Math.max(10, Math.min(200, value));
            this.value = value;
            $(this).trigger('change');
        });

        /* ==============================
         * LIVE PREVIEW (EDITOR)
         * ============================== */
        $field.find('input, textarea, select').on('input change', function () {
            const $block = $field.closest('.wp-block');
            if (!$block.length) return;

            const title = $field.find('input[name$="[text]"]').val() || '';
            const desc  = $field.find('textarea[name$="[description]"]').val() || '';
            const top   = $field.find('input[name$="[top_title]"]').val() || '';

            $block.find('.advanced-title').text(title);
            $block.find('.advanced-title-desc').text(desc);
            $block.find('.advanced-title-top span').text(top);
        });
    }

    function initAll(context) {
        $('.acf-advanced-title-field', context || document).each(function () {
            initAdvancedTitle($(this));
        });
    }

    $(document).ready(() => initAll());

    if (typeof acf !== 'undefined') {
        acf.addAction('ready', initAll);
        acf.addAction('append', function ($el) {
            initAll($el);
        });
    }

})(jQuery);
