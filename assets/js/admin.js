jQuery(document).ready(function ($) {
    // Initialize Color Picker
    if ($.isFunction($.fn.wpColorPicker)) {
        $('.mobilenews-color-picker').wpColorPicker();
    }

    // Tab Switching Logic with Persistence
    const activeTab = localStorage.getItem('mobilenews_active_tab');
    if (activeTab) {
        $('.mobilenews-tab-link').removeClass('active');
        $('.mobilenews-tab-content').removeClass('active');
        $(`.mobilenews-tab-link[data-tab="${activeTab}"]`).addClass('active');
        $('#' + activeTab).addClass('active');
    }

    $('.mobilenews-tab-link').on('click', function (e) {
        e.preventDefault();

        const tabID = $(this).data('tab');

        // Remove active class from all tabs and content
        $('.mobilenews-tab-link').removeClass('active');
        $('.mobilenews-tab-content').removeClass('active');

        // Add active class to clicked tab
        $(this).addClass('active');

        // Show corresponding content
        $('#' + tabID).addClass('active');

        // Persist tab selection
        localStorage.setItem('mobilenews_active_tab', tabID);

        // Smooth scroll to top on mobile
        if ($(window).width() <= 1024) {
            $('html, body').animate({
                scrollTop: $(".mobilenews-admin-content").offset().top - 100
            }, 500);
        }
    });

    // Save Bar Feedback
    $('form').on('change', 'input, select, textarea', function() {
        $('.mobilenews-admin-save-bar').addClass('unsaved-changes');
    });

    // --- Image Ad Support ---

    // 1. Media Uploader Logic
    $('.mobilenews-image-upload-btn').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        const input = button.closest('.mobilenews-media-control').find('.mobilenews-media-id-input');
        const preview = button.closest('.mobilenews-media-control').find('.mobilenews-media-preview');

        const mediaUploader = wp.media({
            title: 'Select Ad Image',
            button: { text: 'Use Image' },
            multiple: false
        }).on('select', function() {
            const attachment = mediaUploader.state().get('selection').first().toJSON();
            input.val(attachment.id).trigger('change');
            preview.html(`<img src="${attachment.url}" style="max-width:200px; display:block; margin-bottom:10px; border-radius:8px; border:1px solid #ddd;">`);
        }).open();
    });

    $('.mobilenews-image-remove-btn').on('click', function(e) {
        e.preventDefault();
        const button = $(this);
        button.closest('.mobilenews-media-control').find('.mobilenews-media-id-input').val('').trigger('change');
        button.closest('.mobilenews-media-control').find('.mobilenews-media-preview').empty();
    });

    // 2. Ad Type Toggle Logic
    function toggleAdFields() {
        $('.ad-code-field, .ad-image-field, .ad-url-field').closest('tr').hide();

        $('input[name*="_type"]:checked').each(function() {
            const type = $(this).val();
            const slot = $(this).attr('name').match(/ads_(.*)_type/)[1];
            
            if (type === 'code') {
                $(`.ad-slot-${slot}.ad-code-field`).closest('tr').show();
            } else {
                $(`.ad-slot-${slot}.ad-image-field, .ad-slot-${slot}.ad-url-field`).closest('tr').show();
            }
        });
    }

    $(document).on('change', 'input[name*="_type"]', toggleAdFields);
    toggleAdFields(); // Run on load
});
