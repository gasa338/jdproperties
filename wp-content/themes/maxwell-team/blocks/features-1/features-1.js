// Tour Blocks - Dynamic Load More
(function() {
    'use strict';
    
    class TourLoader {
        constructor() {
            this.blocks = [];
            this.initialized = false;
            this.init();
        }
        
        init() {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.setupBlocks());
            } else {
                this.setupBlocks();
            }
        }
        
        setupBlocks() {
            const containers = document.querySelectorAll('.tour-packages-container');
            
            if (!containers.length) return;
            
            containers.forEach((container, index) => {
                const loadMoreBtn = container.querySelector('.tour-load-more');
                const items = container.querySelectorAll('.tour-item');
                
                if (loadMoreBtn && items.length > 0) {
                    // Kreiraj state objekat za svaki blok
                    const state = {
                        container,
                        button: loadMoreBtn,
                        items,
                        currentlyVisible: parseInt(loadMoreBtn.dataset.itemsPerLoad) || 6,
                        totalItems: parseInt(loadMoreBtn.dataset.totalItems) || items.length,
                        itemsPerLoad: parseInt(loadMoreBtn.dataset.itemsPerLoad) || 6
                    };
                    
                    // Proveri koliko je trenutno vidljivih
                    const visibleCount = Array.from(items).filter(item => 
                        item.style.display !== 'none' && window.getComputedStyle(item).display !== 'none'
                    ).length;
                    
                    state.currentlyVisible = Math.max(visibleCount, state.itemsPerLoad);
                    
                    // Ažuriraj dugme
                    this.updateButtonVisibility(state);
                    
                    // Dodaj event listener sa bindovanim state-om
                    loadMoreBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        this.handleLoadMore(state);
                    });
                    
                    // Čuvaj state za debug
                    loadMoreBtn._tourState = state;
                }
            });
            
            this.initialized = true;
        }
        
        handleLoadMore(state) {
            const { container, button, items, currentlyVisible, totalItems, itemsPerLoad } = state;
            
            // Pokaži sledeću grupu stavki
            const nextIndex = currentlyVisible;
            const endIndex = Math.min(currentlyVisible + itemsPerLoad, totalItems);
            
            for (let i = nextIndex; i < endIndex; i++) {
                if (items[i]) {
                    items[i].style.display = 'block';
                    
                    // Dodaj fade-in efekat
                    setTimeout(() => {
                        items[i].style.opacity = '1';
                        items[i].style.transform = 'translateY(0)';
                    }, (i - nextIndex) * 50); // Stagger efekat
                }
            }
            
            // Ažuriraj state
            state.currentlyVisible = endIndex;
            
            // Ažuriraj dugme
            this.updateButtonVisibility(state);
            
            // Scroll do novih stavki (opcionalno)
            if (items[nextIndex]) {
                setTimeout(() => {
                    const itemTop = items[nextIndex].offsetTop;
                    window.scrollTo({
                        top: itemTop - 100,
                        behavior: 'smooth'
                    });
                }, 300);
            }
        }
        
        updateButtonVisibility(state) {
            const { button, currentlyVisible, totalItems } = state;
            
            if (currentlyVisible >= totalItems) {
                button.style.display = 'none';
                button.disabled = true;
            } else {
                button.style.display = 'inline-flex';
                button.disabled = false;
                button.textContent = `Load more`;
                // button.textContent = `Load more (${totalItems - currentlyVisible} remaining)`; With count element
                
                // Dodaj loading state (opcionalno)
                const originalText = button.innerHTML;
                button.addEventListener('click', function tempHandler(e) {
                    const btn = e.target;
                    button.innerHTML = '<span class="loading">Loading...</span>';
                    btn.disabled = true;
                    
                    // Vrati originalni tekst nakon 500ms
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }, 500);
                    console.log(originalText)
                
                    // Ukloni privremeni handler
                    btn.removeEventListener('click', tempHandler);
                }, { once: true });
            }
        }
        
        scrollToNewItems(container, items, startIndex) {
            if (items[startIndex]) {
                const itemTop = items[startIndex].offsetTop;
                const offset = 100;
                
                window.scrollTo({
                    top: itemTop - offset,
                    behavior: 'smooth'
                });
            }
        }
    }
    
    // Inicijalizuj loader
    let tourLoader;
    
    function initializeTourLoader() {
        if (!tourLoader) {
            tourLoader = new TourLoader();
        }
    }
    
    // Pokreni odmah ako je dokument spreman
    if (document.readyState !== 'loading') {
        initializeTourLoader();
    } else {
        document.addEventListener('DOMContentLoaded', initializeTourLoader);
    }
    
    // Za AJAX/Dynamic Content
    if (typeof MutationObserver !== 'undefined') {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.addedNodes.length) {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === 1 && 
                            (node.classList && node.classList.contains('tour-packages-container') || 
                             node.querySelector('.tour-packages-container'))) {
                            if (tourLoader) {
                                tourLoader.setupBlocks();
                            }
                        }
                    });
                }
            });
        });
        
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
    
    // Export za debug
    window.TourLoader = TourLoader;
})();