jQuery(document).ready(function ($) {
    const weatherWidget = $('#weather-widget');
    const localNewsContainer = $('#local-news-container');
    const scrollToTopBtn = $('#scroll-to-top');
    const bottomNav = $('#mobile-bottom-nav');

    // --- Dark Mode Logic ---
    const html = document.documentElement;
    const themeToggles = document.querySelectorAll(
        '#theme-toggle, #theme-toggle-mobile, #drawer-theme-toggle'
    );

    // Apply saved preference immediately on load
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        html.classList.add('dark');
    } else {
        html.classList.remove('dark');
    }

    themeToggles.forEach(toggle => {
        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });
    });

    // 1. Get User Location
    function getUserLocation() {
        fetch('https://ipapi.co/json/')
            .then(response => response.json())
            .then(data => {
                const city = data.city;
                console.log('Detected Location:', city);
                getWeather(city);
                getLocalNews(city);
            })
            .catch(error => {
                console.error('Error fetching location:', error);
                weatherWidget.html('<span class="weather-error">Weather unavailable</span>');
                getLocalNews('Jakarta');
            });
    }

    // 2. Fetch Weather
    function getWeather(city) {
        const apiKey = mobilenews_ajax.weather_api_key;
        if (apiKey) {
            const weatherUrl = `https://api.openweathermap.org/data/2.5/weather?q=${encodeURIComponent(city)}&units=metric&appid=${apiKey}`;
            fetch(weatherUrl)
                .then(res => res.json())
                .then(data => {
                    const temp = Math.round(data.main.temp);
                    const weatherMain = data.weather[0].main.toLowerCase();
                    let icon = '☀️';
                    if (weatherMain.includes('cloud')) icon = '☁️';
                    if (weatherMain.includes('rain')) icon = '🌧️';
                    if (weatherMain.includes('drizzle')) icon = '🌦️';
                    if (weatherMain.includes('thunder')) icon = '⚡';
                    if (weatherMain.includes('snow')) icon = '❄️';
                    if (weatherMain.includes('clear')) icon = '☀️';
                    if (weatherMain.includes('mist') || weatherMain.includes('fog')) icon = '🌫️';
                    renderWeatherWidget(city, temp, icon);
                })
                .catch(() => getWeatherOpenMeteo(city));
        } else {
            getWeatherOpenMeteo(city);
        }
    }

    function renderWeatherWidget(city, temp, icon) {
        const accuLink = `https://www.accuweather.com/id/search-locations?query=${encodeURIComponent(city)}`;
        const html = `
            <a href="${accuLink}" target="_blank" rel="noopener" class="weather-link" style="text-decoration:none; display:flex; align-items:center; color:inherit;">
                <div class="weather-info">
                    <span class="weather-icon" style="font-size:1.2rem; margin-right:5px;">${icon}</span>
                    <span class="weather-city" style="font-size:14px; font-weight:600;">${city}</span>
                    <span class="weather-temp" style="font-size:14px; margin-left:4px;">${temp}°C</span>
                </div>
            </a>
        `;
        weatherWidget.html(html);
    }

    function getWeatherOpenMeteo(city) {
        fetch('https://ipapi.co/json/')
            .then(res => res.json())
            .then(locData => {
                const lat = locData.latitude;
                const lon = locData.longitude;
                const weatherUrl = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`;
                fetch(weatherUrl)
                    .then(res => res.json())
                    .then(weatherData => {
                        const temp = Math.round(weatherData.current_weather.temperature);
                        const wcode = weatherData.current_weather.weathercode;
                        const icon = getWeatherIcon(wcode);
                        renderWeatherWidget(city, temp, icon);
                    });
            });
    }

    function getWeatherIcon(code) {
        if (code === 0) return '☀️';
        if (code >= 1 && code <= 3) return '⛅';
        if (code >= 45 && code <= 48) return '🌫️';
        if (code >= 51 && code <= 67) return '🌧️';
        if (code >= 71 && code <= 77) return '❄️';
        if (code >= 80 && code <= 82) return '🌦️';
        if (code >= 95 && code <= 99) return '⚡';
        return '🌡️';
    }

    // 3. Fetch Local News via AJAX
    function getLocalNews(city) {
        if ($('body').hasClass('home')) {
            const newsGrid = $('#local-news-grid');
            let skeletonHtml = '';
            for (let i = 0; i < 4; i++) {
                skeletonHtml += `
                    <div class="skeleton-card">
                        <div class="skeleton-image"></div>
                        <div class="skeleton-content">
                            <div class="skeleton-line"></div>
                            <div class="skeleton-line short"></div>
                        </div>
                    </div>
                `;
            }
            newsGrid.html(skeletonHtml);

            $.ajax({
                url: mobilenews_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_local_news',
                    nonce: mobilenews_ajax.nonce,
                    city: city
                },
                success: function (response) {
                    newsGrid.html(response);
                    $('.local-news-title span').text(city);
                }
            });
        }
    }

    // 4. Scroll to Top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            scrollToTopBtn.removeClass('opacity-0 invisible translate-y-10').addClass('opacity-100 visible translate-y-0');
        } else {
            scrollToTopBtn.addClass('opacity-0 invisible translate-y-10').removeClass('opacity-100 visible translate-y-0');
        }
    });

    scrollToTopBtn.on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: 0 }, 600);
        return false;
    });


    // 5. Archive Page Filtering
    $('.filter-chip').on('click', function (e) {
        e.preventDefault();
        const button = $(this);
        const tagId = button.data('tag-id');
        const catId = $('#current-archive-cat').val();

        $('.filter-chip').removeClass('active bg-primary text-white').addClass('bg-soft-gray text-text-dark dark:bg-zinc-800 dark:text-white');
        button.removeClass('bg-soft-gray text-text-dark dark:bg-zinc-800 dark:text-white').addClass('active bg-primary text-white');

        const container = $('#mobilenews-archive-posts-container');
        container.css('opacity', '0.5');

        $.ajax({
            url: mobilenews_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mobilenews_filter_archive',
                category_id: catId,
                tag_id: tagId,
                nonce: mobilenews_ajax.nonce
            },
            success: function (response) {
                container.html(response);
                container.css('opacity', '1');
            },
            error: function () {
                container.css('opacity', '1');
                alert('Gagal memuat berita.');
            }
        });
    });

    // 6. Load More Button
    $('#mobilenews-load-more').on('click', function () {
        const button = $(this);
        const spinner = $('#load-more-spinner');
        const catId = $('#current-archive-cat').val();
        const activeTag = $('.filter-chip.active').data('tag-id') || 'all';

        let currentPage = parseInt(button.data('page'));
        const maxPage = parseInt(button.data('max-page'));

        if (currentPage >= maxPage) {
            button.hide();
            return;
        }

        button.attr('disabled', true);
        spinner.removeClass('hidden');

        $.ajax({
            url: mobilenews_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mobilenews_filter_archive',
                category_id: catId,
                tag_id: activeTag,
                paged: currentPage + 1,
                nonce: mobilenews_ajax.nonce
            },
            success: function (response) {
                if (response.trim() !== '') {
                    $('#mobilenews-post-list').append(response);
                    button.data('page', currentPage + 1);
                    if ((currentPage + 1) >= maxPage) button.hide();
                } else {
                    button.hide();
                }
                button.attr('disabled', false);
                spinner.addClass('hidden');
            },
            error: function () {
                button.attr('disabled', false);
                spinner.addClass('hidden');
                alert('Gagal memuat berita.');
            }
        });
    });

    // 7. Reading Progress Bar
    const progressBar = $('#reading-progress-bar');
    if (progressBar.length) {
        $(window).scroll(function () {
            const scrollTop = $(window).scrollTop();
            const docHeight = $(document).height() - $(window).height();
            const scrollPercent = (scrollTop / docHeight) * 100;
            progressBar.css('width', scrollPercent + '%');
        });
    }

    // 8. Search Overlay
    const searchOverlay = $('#mobilenews-search-overlay');
    const searchInput = $('#mobilenews-search-input');
    const searchClose = $('#mobilenews-search-close');

    function openSearch() {
        searchOverlay.addClass('active').removeClass('hidden').css('display', 'flex');
        setTimeout(() => searchInput.focus(), 300);
        $('body').addClass('overflow-hidden');
    }

    function closeSearch() {
        searchOverlay.removeClass('active');
        setTimeout(() => {
            searchOverlay.addClass('hidden').css('display', 'none');
            $('body').removeClass('overflow-hidden');
        }, 500);
    }

    $(document).on('click', '.mobilenews-search-trigger, .search-toggle-btn', function (e) {
        e.preventDefault();
        openSearch();
    });

    searchClose.on('click', closeSearch);

    $(document).on('keydown', function (e) {
        if (e.key === "Escape") closeSearch();
    });

    // 9. Mobile Menu & Drawer
    const mobileMenuBtn = $('#mobile-menu-toggle');
    const mobileMenuCloseBtn = $('#mobile-menu-close');
    const mobileMenuBottomBtn = $('#mobile-menu-trigger-bottom');
    const mobileMenuOverlay = $('#mobile-menu-overlay');
    const mobileMenu = $('#mobile-menu-container');

    function openMobileMenu() {
        mobileMenuOverlay.removeClass('hidden pointer-events-none opacity-0').addClass('opacity-100 pointer-events-auto');
        mobileMenu.removeClass('hidden');
        setTimeout(() => mobileMenu.removeClass('-translate-x-full').addClass('translate-x-0'), 10);
        $('body').addClass('overflow-hidden');
    }

    function closeMobileMenu() {
        mobileMenuOverlay.removeClass('opacity-100 pointer-events-auto').addClass('opacity-0 pointer-events-none');
        mobileMenu.removeClass('translate-x-0').addClass('-translate-x-full');
        $('body').removeClass('overflow-hidden');
        setTimeout(() => {
            mobileMenuOverlay.addClass('hidden');
            mobileMenu.addClass('hidden');
        }, 300);
    }

    mobileMenuBtn.on('click', function (e) {
        e.preventDefault();
        openMobileMenu();
    });

    mobileMenuCloseBtn.on('click', closeMobileMenu);
    mobileMenuOverlay.on('click', closeMobileMenu);
    mobileMenuBottomBtn.on('click', function (e) {
        e.preventDefault();
        openMobileMenu();
    });

    mobileMenu.find('a').on('click', function () {
        if (!$(this).hasClass('mobile-menu-toggle')) {
            closeMobileMenu();
        }
    });

    // Submenu Toggle
    $(document).on('click', '.mobile-menu-toggle', function (e) {
        e.preventDefault();
        const btn = $(this);
        const submenu = btn.parent().next('ul');
        if (submenu.length) {
            submenu.slideToggle(300);
            btn.find('span').toggleClass('rotate-180');
            btn.toggleClass('text-primary');
        }
    });

    // Swipe to Close
    let touchStartX = 0;
    mobileMenu.on('touchstart', function (e) {
        touchStartX = e.originalEvent.touches[0].clientX;
    });

    mobileMenu.on('touchend', function (e) {
        const touchEndX = e.originalEvent.changedTouches[0].clientX;
        if (touchEndX - touchStartX < -100) {
            closeMobileMenu();
        }
    });

    // 10. Auto-Hide Bottom Nav
    let lastScrollTop = 0;
    if (mobilenews_ajax.bottom_nav_autohide) {
        $(window).scroll(function () {
            let st = $(this).scrollTop();
            if (st > lastScrollTop && st > 100) {
                bottomNav.css('transform', 'translateY(100%)');
            } else {
                bottomNav.css('transform', 'translateY(0)');
            }
            lastScrollTop = st;
        });
    }

    // Init
    getUserLocation();
});
