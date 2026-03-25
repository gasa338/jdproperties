(function ($) {
    'use strict';

    function initAdvancedTitleField($field) {

        if ($field.data('initialized')) return;
        $field.data('initialized', true);

        var $settingsBtn = $field.find('.settings-toggle-btn');
        var $settingsPanel = $field.find('.settings-panel');

        /* ==============================
         * SETTINGS TOGGLE
         * ============================== */
        $settingsBtn.on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var isOpen = $settingsPanel.hasClass('open');

            $('.settings-panel').removeClass('open');
            $('.settings-toggle-btn').removeClass('active');

            if (!isOpen) {
                $settingsPanel.addClass('open');
                $settingsBtn.addClass('active');
            }

            // $('.setting-row input[name$="[use_custom_size]"]').on('change', function () {
            //     var $customRow = $('.custom-font-size-row');
            //     var isChecked = $(this).is(':checked');

            //     // Mali timeout da bi WordPress završio svoje manipulacije
            //     setTimeout(function () {
            //         $customRow.toggleClass('visible hidden', isChecked);
            //     }, 10);
            // });

        });

        /* ==============================
         * ALIGNMENT ✅ (FIXED)
         * ============================== */
        $field.find('.align-options .option-btn').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var value = $(this).data('value');

            $field.find('.align-options .option-btn').removeClass('active');
            $(this).addClass('active');

            // 🔥 trigger change on HIDDEN input
            $field.find('.align-value')
                .val(value)
                .trigger('change');
        });

        /* ==============================
         * TAG ✅ (FIXED)
         * ============================== */
        $field.find('.tag-options .option-btn').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            var value = $(this).data('value');

            $field.find('.tag-options .option-btn').removeClass('active');
            $(this).addClass('active');

            // 🔥 trigger change on HIDDEN input
            $field.find('.tag-value')
                .val(value)
                .trigger('change');
        });

        /* ==============================
         * FONT SIZE ❗ (NO trigger here)
         * ============================== */
        $field.find('.size-input').on('input', function () {
            var $input = $(this);
            var value = parseInt($input.val(), 10) || 10;

            value = Math.max(10, Math.min(200, value));
            $input.val(value);

            // ❗ browser already emits change naturally
        });

        /* ==============================
         * CLOSE ON OUTSIDE CLICK
         * ============================== */
        $(document).on('click.advancedTitle', function (e) {
            if (!$(e.target).closest('.acf-advanced-title-field').length) {
                $('.settings-panel').removeClass('open');
                $('.settings-toggle-btn').removeClass('active');
            }
        });

        $settingsPanel.on('click', function (e) {
            e.stopPropagation();
        });
    }

    function initAll() {
        $('.acf-advanced-title-field').each(function () {
            initAdvancedTitleField($(this));
        });
    }

    $(document).ready(initAll);

    if (typeof acf !== 'undefined') {
        acf.addAction('ready', initAll);
        acf.addAction('append', function ($el) {
            $el.find('.acf-advanced-title-field').each(function () {
                initAdvancedTitleField($(this));
            });
        });
    }

})(jQuery);
