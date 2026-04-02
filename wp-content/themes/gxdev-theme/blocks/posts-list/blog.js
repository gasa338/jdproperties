/**
 * Blog funkcionalnosti - Load More i filtriranje
 */
(function($) {
    'use strict';
    
    // Proveri da li smo na blog stranici
    if ($('#posts-container').length === 0) return;
    
    const Blog = {
        // State
        currentPage: 1,
        maxPages: parseInt($('#load-more').data('max-pages')) || 1,
        currentCategory: $('#load-more').data('category') || '',
        isLoading: false,
        postsPerPage: blogConfig.postsPerPage || 6,
        
        // Elementi
        $container: $('#posts-container'),
        $loadMore: $('#load-more'),
        $loadingIndicator: $('#loading-indicator'),
        $categoryFilters: $('.category-filter'),
        $searchInput: $('#search-input'),
        
        // Timeout za search debounce
        searchTimeout: null,
        
        /**
         * Inicijalizacija
         */
        init: function() {
            this.bindEvents();
            this.updateLoadMoreVisibility();
        },
        
        /**
         * Bindovanje događaja
         */
        bindEvents: function() {
            // Load More klik
            this.$loadMore.on('click', (e) => {
                e.preventDefault();
                this.loadMorePosts();
            });
            
            // Kategorije - koristimo event delegation zbog mogućih dinamičkih promena
            this.$categoryFilters.on('click', (e) => {
                e.preventDefault();
                const $target = $(e.currentTarget);
                const category = $target.data('category');
                this.filterByCategory(category);
            });
            
            // Pretraga sa debounce-om
            this.$searchInput.on('input', () => {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    this.searchPosts(this.$searchInput.val());
                }, 500);
            });
        },
        
        /**
         * Učitavanje više postova
         */
        loadMorePosts: function() {
            if (this.isLoading) return;
            if (this.currentPage >= this.maxPages) {
                this.$loadMore.hide();
                return;
            }
            
            this.isLoading = true;
            const nextPage = this.currentPage + 1;
            
            // Prikaži loading
            this.$loadingIndicator.removeClass('hidden');
            this.$loadMore.prop('disabled', true).text('Loading...');
            
            // AJAX zahtev
            $.ajax({
                url: blogConfig.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: nextPage,
                    category: this.currentCategory,
                    posts_per_page: this.postsPerPage
                },
                success: (response) => {
                    if (response.success && response.html) {
                        // Dodaj nove postove
                        this.$container.append(response.html);
                        
                        // Ažuriraj trenutnu stranicu i maksimalne stranice
                        this.currentPage = response.page;
                        this.maxPages = response.max_pages;
                        
                        // Ažuriraj data atribute
                        this.$loadMore.data('page', this.currentPage);
                        this.$loadMore.data('max-pages', this.maxPages);
                        
                        // Proveri da li ima još stranica
                        this.updateLoadMoreVisibility();
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Load More error:', error);
                    alert('Došlo je do greške prilikom učitavanja postova.');
                },
                complete: () => {
                    // Sakrij loading
                    this.isLoading = false;
                    this.$loadingIndicator.addClass('hidden');
                    this.$loadMore.prop('disabled', false).text('Load More Articles');
                }
            });
        },
        
        /**
         * Filtriranje po kategoriji
         */
        filterByCategory: function(category) {
            // Resetuj stranicu
            this.currentPage = 1;
            this.currentCategory = category;
            
            // Ažuriraj URL bez reloadovanja stranice
            const url = new URL(window.location.href);
            if (category) {
                url.searchParams.set('category', category);
            } else {
                url.searchParams.delete('category');
            }
            window.history.pushState({}, '', url);
            
            // Ažuriraj aktivnu klasu na filterima
            this.$categoryFilters.each(function() {
                const $this = $(this);
                if ($this.data('category') === category) {
                    $this.removeClass('bg-light text-accent')
                         .addClass('bg-accent text-white');
                } else {
                    $this.removeClass('bg-accent text-white')
                         .addClass('bg-light text-accent');
                }
            });
            
            // Učitaj postove za prvu stranu
            this.loadPostsByFilter();
        },
        
        /**
         * Pretraga postova
         */
        searchPosts: function(searchTerm) {
            // Implementacija pretrage - možeš dodati ako ti treba
            console.log('Searching for:', searchTerm);
        },
        
        /**
         * Učitavanje postova nakon filter promene
         */
        loadPostsByFilter: function() {
            this.isLoading = true;
            
            // Prikaži loading i očisti container
            this.$loadingIndicator.removeClass('hidden');
            this.$container.empty();
            
            // Sakrij load more dok se učitava
            this.$loadMore.hide();
            
            $.ajax({
                url: blogConfig.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'load_more_posts',
                    page: 1,
                    category: this.currentCategory,
                    posts_per_page: this.postsPerPage
                },
                success: (response) => {
                    if (response.success && response.html) {
                        // Prikaži postove
                        this.$container.html(response.html);
                        
                        // Ažuriraj maksimalne stranice
                        this.maxPages = response.max_pages;
                        this.$loadMore.data('max-pages', this.maxPages);
                        
                        // Prikaži load more ako ima više stranica
                        this.updateLoadMoreVisibility();
                    } else {
                        this.$container.html('<div class="col-span-full text-center py-12"><p class="text-muted-foreground">Nema postova u ovoj kategoriji.</p></div>');
                    }
                },
                error: (xhr, status, error) => {
                    console.error('Filter error:', error);
                    this.$container.html('<div class="col-span-full text-center py-12"><p class="text-muted-foreground">Došlo je do greške prilikom učitavanja.</p></div>');
                },
                complete: () => {
                    this.isLoading = false;
                    this.$loadingIndicator.addClass('hidden');
                }
            });
        },
        
        /**
         * Ažuriraj vidljivost Load More dugmeta
         */
        updateLoadMoreVisibility: function() {
            if (this.currentPage < this.maxPages) {
                this.$loadMore.show();
            } else {
                this.$loadMore.hide();
            }
        }
    };
    
    // Pokreni blog funkcionalnosti
    Blog.init();
    
})(jQuery);