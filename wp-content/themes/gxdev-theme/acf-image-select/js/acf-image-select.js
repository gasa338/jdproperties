// acf-background-select-simple.js
(function($) {
    'use strict';
    
    // Ultra-simple solution that WILL work
    function initializeSimpleBackgroundSelect() {
        $('.acf-background-select').each(function() {
            var $container = $(this);
            console.log($container);
            
            // Remove any existing click handlers
            $container.find('.background-option, .background-option-label').off('click');
            
            // Add new click handler
            $container.find('.background-option').on('click', function(e) {
                e.preventDefault();
                
                var $option = $(this);
                var $radio = $option.find('input[type="radio"]');
                var value = $radio.val();
                
                console.log('Simple: Clicked on option with value:', value);
                
                // Uncheck all
                $container.find('input[type="radio"]').prop('checked', false);
                
                // Check this one
                $radio.prop('checked', true);
                
                // Update visuals
                $container.find('.background-option').removeClass('selected');
                $option.addClass('selected');
                
                // Update label display
                var label = $option.find('.option-label').text();
                $container.find('.selected-background .value').text(label);
                $container.find('.selected-background').show();
                
                // Handle custom background
                if (value === 'custom') {
                    $container.find('.custom-background-upload').slideDown(200);
                } else {
                    $container.find('.custom-background-upload').slideUp(200);
                }
                
                // IMPORTANT: Trigger ACF change event
                $radio.trigger('change');
                
                // Also trigger on container for good measure
                $container.trigger('change');
                
                return false;
            });
            
            // Initialize current selection
            var $checked = $container.find('input[type="radio"]:checked');
            if ($checked.length) {
                $checked.closest('.background-option').addClass('selected');
                var label = $checked.closest('.background-option').find('.option-label').text();
                $container.find('.selected-background .value').text(label);
                $container.find('.selected-background').show();
            }
        });
    }
    
    // Run on document ready
    $(document).ready(function() {
        initializeSimpleBackgroundSelect();
    });
    
    // Run when ACF adds fields
    $(document).on('acf/setup_fields', function() {
        setTimeout(initializeSimpleBackgroundSelect, 100);
    });
    
    // Run on window load
    $(window).on('load', function() {
        setTimeout(initializeSimpleBackgroundSelect, 300);
    });
    
    // Also run every second for 5 seconds after page load (catch-all)
    var attempts = 0;
    var interval = setInterval(function() {
        initializeSimpleBackgroundSelect();
        attempts++;
        if (attempts >= 5) {
            clearInterval(interval);
        }
    }, 1000);
    
})(jQuery);