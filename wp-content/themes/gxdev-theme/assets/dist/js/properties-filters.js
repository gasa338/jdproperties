jQuery(document).ready(function($) {

    /* ------------------------------------------------------------------ */
    /* STATE                                                                  */
    /* ------------------------------------------------------------------ */
    const state = {
        search:       '',
        propCategory: '',          // slug taksonomije prop-category
        propTypes:    [],          // niz slug-ova prop-type
        locations:    [],          // niz slug-ova location
        priceMin:     0,
        priceFiltered: false,
        priceMax:     500000,
        areaMin:      '',
        areaMax:      '',
        rooms:        [],          // niz vrednosti property_structure
        floors:       [],          // niz vrednosti property_floor
        bldFloors:    [],          // niz vrednosti property_floors_in_building
        orderby:      'date',
        order:        'DESC',
        paged:        1,
        perPage:      9,
    };

    let debounceTimer = null;

    /* ------------------------------------------------------------------ */
    /* INICIJALIZACIJA                                                        */
    /* ------------------------------------------------------------------ */
    function init() {
        bindEvents();
        fetchProperties();
    }

    /* ------------------------------------------------------------------ */
    /* BIND EVENTS                                                            */
    /* ------------------------------------------------------------------ */
    function bindEvents() {

        // Search
        $('#filter-search').on('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                state.search = $('#filter-search').val();
                state.paged = 1;
                fetchProperties();
            }, 400);
        });

        // Tip oglasa (prop-category) — radio dugmad
        $(document).on('click', '.prop-category-btn', function () {
            $('.prop-category-btn').removeClass('bg-accent/10 text-accent font-medium')
                .addClass('text-muted-foreground hover:text-foreground hover:bg-secondary/50');
            $(this).addClass('bg-accent/10 text-accent font-medium')
                .removeClass('text-muted-foreground hover:text-foreground hover:bg-secondary/50');
            state.propCategory = $(this).data('value');
            state.paged = 1;
            fetchProperties();
        });

        // Tip nekretnine — checkbox
        $(document).on('change', '.prop-type-cb', function () {
            state.propTypes = [];
            $('.prop-type-cb:checked').each(function () {
                state.propTypes.push($(this).val());
            });
            state.paged = 1;
            fetchProperties();
        });

        // Lokacija — checkbox
        $(document).on('change', '.location-cb', function () {
            state.locations = [];
            $('.location-cb:checked').each(function () {
                state.locations.push($(this).val());
            });
            state.paged = 1;
            fetchProperties();
        });

        // Prikaži više lokacija
        $('#show-more-locations').on('click', function () {
            $('.location-extra').removeClass('hidden');
            $(this).hide();
        });

        // Cena — range slider
        $('#price-min, #price-max').on('input', function () {
            let minVal = parseInt($('#price-min').val());
            let maxVal = parseInt($('#price-max').val());

            // Spreči ukrštanje klizača
            if (minVal > maxVal) {
                if ($(this).attr('id') === 'price-min') {
                    minVal = maxVal;
                    $('#price-min').val(minVal);
                } else {
                    maxVal = minVal;
                    $('#price-max').val(maxVal);
                }
            }

            state.priceMin = minVal;
            state.priceMax = maxVal;
            state.priceFiltered = (minVal > 0 || maxVal < 500000);

            // Ažuriraj labele
            $('#price-min-label').text(formatPrice(minVal) + ' €');
            $('#price-max-label').text(formatPrice(maxVal) + ' €');

            // Ažuriraj fill traku
            updatePriceFill();

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                state.paged = 1;
                fetchProperties();
            }, 400);
        });

        // Površina — input polja
        $('#area-min, #area-max').on('input', function () {
            state.areaMin = $('#area-min').val();
            state.areaMax = $('#area-max').val();
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                state.paged = 1;
                fetchProperties();
            }, 500);
        });

        // Broj soba — oblačići (toggle)
        $(document).on('click', '.room-btn', function () {
            const val = $(this).data('value');
            toggleBubble($(this), state.rooms, val);
            state.paged = 1;
            fetchProperties();
        });

        // Sprat — oblačići
        $(document).on('click', '.floor-btn', function () {
            const val = $(this).data('value');
            toggleBubble($(this), state.floors, val);
            state.paged = 1;
            fetchProperties();
        });

        // Broj spratova zgrade — oblačići
        $(document).on('click', '.bld-floor-btn', function () {
            const val = $(this).data('value');
            toggleBubble($(this), state.bldFloors, val);
            state.paged = 1;
            fetchProperties();
        });

        // Sortiranje
        $('#sort-select').on('change', function () {
            const val = $(this).val();
            switch (val) {
                case 'date_desc':  state.orderby = 'date';             state.order = 'DESC'; break;
                case 'date_asc':   state.orderby = 'date';             state.order = 'ASC';  break;
                case 'price_asc':  state.orderby = 'meta_value_num';   state.order = 'ASC';  state.metaKey = '_property_price'; break;
                case 'price_desc': state.orderby = 'meta_value_num';   state.order = 'DESC'; state.metaKey = '_property_price'; break;
                case 'area_asc':   state.orderby = 'meta_value_num';   state.order = 'ASC';  state.metaKey = 'property_squarespace'; break;
                case 'area_desc':  state.orderby = 'meta_value_num';   state.order = 'DESC'; state.metaKey = 'property_squarespace'; break;
                default:           state.orderby = 'date';             state.order = 'DESC';
            }
            state.paged = 1;
            fetchProperties();
        });

        // Paginacija — event delegation
        $(document).on('click', '.page-btn', function () {
            if ($(this).hasClass('active') || $(this).prop('disabled')) return;
            state.paged = parseInt($(this).data('page'));
            fetchProperties();
            $('html, body').animate({ scrollTop: $('#properties-grid').offset().top - 100 }, 300);
        });

        // Collapse/expand filter sekcija
        $(document).on('click', '.filter-toggle', function () {
            const $content = $(this).siblings('.filter-content');
            $content.slideToggle(200);
            $(this).find('svg').toggleClass('rotate-180');
        });

        // Reset filtera
        $('#reset-filters').on('click', function () {
            resetFilters();
        });
    }

    /* ------------------------------------------------------------------ */
    /* AJAX FETCH                                                             */
    /* ------------------------------------------------------------------ */
    function fetchProperties() {
        const $grid = $('#properties-grid');

        $grid.css('opacity', '0.5');

        $.ajax({
            url:  propertiesAjax.ajaxurl,
            type: 'POST',
            data: {
                action:       'filter_properties',
                nonce:        propertiesAjax.nonce,
                search:       state.search,
                prop_category: state.propCategory,
                prop_types:   state.propTypes,
                locations:    state.locations,
                price_min:    state.priceMin,
                price_filtered: state.priceFiltered ? '1' : '0',
                price_max:    state.priceMax,
                area_min:     state.areaMin,
                area_max:     state.areaMax,
                rooms:        state.rooms,
                floors:       state.floors,
                bld_floors:   state.bldFloors,
                orderby:      state.orderby,
                order:        state.order,
                meta_key:     state.metaKey || '',
                paged:        state.paged,
                per_page:     state.perPage,
            },
            success: function (response) {
                if (response.success) {
                    $grid.html(response.data.html).css('opacity', '1');
                    $('#results-count').text(response.data.total);
                    renderPagination(response.data.total_pages, state.paged);
                } else {
                    $grid.html('<p class="col-span-full text-center text-muted-foreground py-12">Nema rezultata.</p>').css('opacity', '1');
                    $('#results-count').text('0');
                    $('#properties-pagination').empty();
                }
            },
            error: function () {
                $grid.html('<p class="col-span-full text-center text-muted-foreground py-12">Greška pri učitavanju. Pokušajte ponovo.</p>').css('opacity', '1');
            }
        });
    }

    /* ------------------------------------------------------------------ */
    /* PAGINACIJA                                                             */
    /* ------------------------------------------------------------------ */
    function renderPagination(totalPages, current) {
        const $pagination = $('#properties-pagination');
        $pagination.empty();

        if (totalPages <= 1) return;

        const btnBase = 'page-btn inline-flex items-center justify-center h-9 min-w-9 px-3 rounded-sm border text-sm font-body transition-colors cursor-pointer';
        const btnNormal = 'border-border text-muted-foreground hover:border-accent hover:text-accent bg-background';
        const btnActive = 'border-accent text-accent bg-accent/10 font-semibold active';
        const btnDisabled = 'border-border text-muted-foreground/40 cursor-not-allowed opacity-50';

        // Prethodna
        const prevDisabled = current === 1 ? btnDisabled : btnNormal;
        $pagination.append(
            `<button class="${btnBase} ${prevDisabled}" data-page="${current - 1}" ${current === 1 ? 'disabled' : ''}>‹</button>`
        );

        // Brojevi stranica — prikaži max 7
        const pages = getPageRange(current, totalPages);
        pages.forEach(function (p) {
            if (p === '...') {
                $pagination.append(`<span class="inline-flex items-center justify-center h-9 px-2 text-sm text-muted-foreground">…</span>`);
            } else {
                const cls = p === current ? btnActive : btnNormal;
                $pagination.append(
                    `<button class="${btnBase} ${cls}" data-page="${p}">${p}</button>`
                );
            }
        });

        // Sledeća
        const nextDisabled = current === totalPages ? btnDisabled : btnNormal;
        $pagination.append(
            `<button class="${btnBase} ${nextDisabled}" data-page="${current + 1}" ${current === totalPages ? 'disabled' : ''}>›</button>`
        );
    }

    function getPageRange(current, total) {
        if (total <= 7) {
            return Array.from({ length: total }, (_, i) => i + 1);
        }
        const pages = [];
        pages.push(1);
        if (current > 3) pages.push('...');
        for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
            pages.push(i);
        }
        if (current < total - 2) pages.push('...');
        pages.push(total);
        return pages;
    }

    /* ------------------------------------------------------------------ */
    /* HELPERS                                                               */
    /* ------------------------------------------------------------------ */
    function toggleBubble($btn, arr, val) {
        const idx = arr.indexOf(val);
        if (idx === -1) {
            arr.push(val);
            $btn.addClass('border-accent text-accent bg-accent/10');
        } else {
            arr.splice(idx, 1);
            $btn.removeClass('border-accent text-accent bg-accent/10');
        }
    }

    function formatPrice(val) {
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updatePriceFill() {
        const min = parseInt($('#price-min').val());
        const max = parseInt($('#price-max').val());
        const range = 500000;
        const leftPct  = (min / range) * 100;
        const rightPct = 100 - (max / range) * 100;
        $('#price-fill').css({ left: leftPct + '%', right: rightPct + '%' });
    }

    function resetFilters() {
        // State reset
        state.search       = '';
        state.propCategory = '';
        state.propTypes    = [];
        state.locations    = [];
        state.priceMin     = 0;
        state.priceFiltered = false;
        state.priceMax     = 500000;
        state.areaMin      = '';
        state.areaMax      = '';
        state.rooms        = [];
        state.floors       = [];
        state.bldFloors    = [];
        state.orderby      = 'date';
        state.order        = 'DESC';
        state.metaKey      = '';
        state.paged        = 1;

        // UI reset
        $('#filter-search').val('');
        $('.prop-category-btn').first().addClass('bg-accent/10 text-accent font-medium')
            .removeClass('text-muted-foreground hover:text-foreground hover:bg-secondary/50');
        $('.prop-category-btn').not(':first').removeClass('bg-accent/10 text-accent font-medium')
            .addClass('text-muted-foreground hover:text-foreground hover:bg-secondary/50');
        $('.prop-type-cb, .location-cb').prop('checked', false);
        $('#price-min').val(0);
        $('#price-max').val(500000);
        $('#price-min-label').text('0 €');
        $('#price-max-label').text('500.000 €');
        updatePriceFill();
        $('#area-min, #area-max').val('');
        $('.room-btn, .floor-btn, .bld-floor-btn').removeClass('border-accent text-accent bg-accent/10');
        $('#sort-select').val('date_desc');

        fetchProperties();
    }

    /* ------------------------------------------------------------------ */
    /* DOM READY                                                              */
    /* ------------------------------------------------------------------ */
    $(document).ready(function () {
        // Inicijalizuj fill za price range
        updatePriceFill();
        init();
    });

});