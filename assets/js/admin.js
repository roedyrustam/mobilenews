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
});
