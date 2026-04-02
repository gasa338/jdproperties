<?php
// Ovo će kasnije biti zamenjeno sa stvarnim podacima iz CPT i taksonomija
// Za sada koristimo mock podatke
$property_types = [
    '' => 'Tip nekretnine',
    'stan' => 'Stan',
    'kuca' => 'Kuća',
    'poslovni-prostor' => 'Poslovni prostor',
    'garaza' => 'Garaža',
    'kancelarija' => 'Kancelarija',
    'magacin' => 'Magacin'
];

// Lokacije - inicijalno 10 lokacija, kasnije će se učitavati iz taksonomije
$locations = [
    'novi-beograd' => 'Novi Beograd',
    'zemun' => 'Zemun',
    'centar' => 'Centar',
    'vracar' => 'Vračar',
    'palilula' => 'Palilula',
    'cukarica' => 'Čukarica',
    'novi-sad' => 'Novi Sad',
    'nis' => 'Niš',
    'kragujevac' => 'Kragujevac',
    'subotica' => 'Subotica'
];
?>

<section class="relative z-20 -mt-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-card rounded-lg shadow-xl border border-border">
            <div class="flex border-b border-border">
                <button class="flex-1 py-3.5 text-sm font-body tracking-wide transition-colors bg-accent text-accent-foreground font-medium" data-type="all">Sve</button>
                <button class="flex-1 py-3.5 text-sm font-body tracking-wide transition-colors text-muted-foreground hover:text-foreground hover:bg-secondary/50" data-type="sale">Prodaja</button>
                <button class="flex-1 py-3.5 text-sm font-body tracking-wide transition-colors text-muted-foreground hover:text-foreground hover:bg-secondary/50" data-type="rent">Izdavanje</button>
            </div>
            <div class="p-5">
                <form id="search-form" method="GET" action="">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Tip nekretnine dropdown -->
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-house absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-accent">
                                <path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"></path>
                                <path d="M3 10a2 2 0 0 1 .709-1.528l7-5.999a2 2 0 0 1 2.582 0l7 5.999A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            </svg>
                            <select name="property_type" id="property-type" class="h-12 w-full px-4 bg-background border-0 border-b border-border/50 text-sm font-body text-foreground focus:outline-none focus:border-accent transition-colors appearance-none cursor-pointer pl-10">
                                <?php foreach ($property_types as $value => $label): ?>
                                    <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Lokacija input sa autocomplete -->
                        <div class="relative" id="location-container" style="overflow: visible;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-accent">
                                <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <input type="text" 
                                   id="location-input" 
                                   name="location" 
                                   placeholder="Lokacija..." 
                                   class="h-12 w-full px-4 bg-background border-0 border-b border-border/50 text-sm font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-accent transition-colors pl-10" 
                                   autocomplete="off"
                                   value="<?php echo isset($_GET['location']) ? esc_attr($_GET['location']) : ''; ?>">
                            <div id="location-suggestions" class="hidden absolute z-50 w-full mt-1 bg-card border border-border rounded-md shadow-lg max-h-60 overflow-auto" style="min-width: 200px;"></div>
                        </div>

                        <!-- Min m² -->
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-maximize absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-accent">
                                <path d="M8 3H5a2 2 0 0 0-2 2v3"></path>
                                <path d="M21 8V5a2 2 0 0 0-2-2h-3"></path>
                                <path d="M3 16v3a2 2 0 0 0 2 2h3"></path>
                                <path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>
                            </svg>
                            <input type="number" 
                                   name="min_area" 
                                   placeholder="Min m²" 
                                   class="h-12 w-full px-4 bg-background border-0 border-b border-border/50 text-sm font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-accent transition-colors pl-10" 
                                   value="<?php echo isset($_GET['min_area']) ? esc_attr($_GET['min_area']) : ''; ?>">
                        </div>

                        <!-- Max m² -->
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-maximize absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-accent">
                                <path d="M8 3H5a2 2 0 0 0-2 2v3"></path>
                                <path d="M21 8V5a2 2 0 0 0-2-2h-3"></path>
                                <path d="M3 16v3a2 2 0 0 0 2 2h3"></path>
                                <path d="M16 21h3a2 2 0 0 0 2-2v-3"></path>
                            </svg>
                            <input type="number" 
                                   name="max_area" 
                                   placeholder="Max m²" 
                                   class="h-12 w-full px-4 bg-background border-0 border-b border-border/50 text-sm font-body text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-accent transition-colors pl-10" 
                                   value="<?php echo isset($_GET['max_area']) ? esc_attr($_GET['max_area']) : ''; ?>">
                        </div>

                        <!-- Submit dugme -->
                        <button type="submit" class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 px-4 py-2 h-12 bg-accent text-accent-foreground hover:bg-accent/90 rounded-sm font-body text-sm tracking-wide">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-4 h-4 mr-2">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                            Pretraži
                        </button>
                    </div>
                    
                    <!-- Hidden input za tip pretrage (prodaja/izdavanje) -->
                    <input type="hidden" name="search_type" id="search-type" value="all">
                </form>
            </div>
            <div class="px-5 pb-4 flex justify-end">
                <a class="inline-flex items-center gap-2 text-sm font-body text-accent hover:text-accent/80 transition-colors" href="/nekretnine">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sliders-horizontal w-3.5 h-3.5">
                        <line x1="21" x2="14" y1="4" y2="4"></line>
                        <line x1="10" x2="3" y1="4" y2="4"></line>
                        <line x1="21" x2="12" y1="12" y2="12"></line>
                        <line x1="8" x2="3" y1="12" y2="12"></line>
                        <line x1="21" x2="16" y1="20" y2="20"></line>
                        <line x1="12" x2="3" y1="20" y2="20"></line>
                        <line x1="14" x2="14" y1="2" y2="6"></line>
                        <line x1="8" x2="8" y1="10" y2="14"></line>
                        <line x1="16" x2="16" y1="18" y2="22"></line>
                    </svg>
                    Napredna pretraga
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// Lokacije iz PHP niza (kasnije će se učitavati iz taksonomije)
const locationsData = <?php echo json_encode(array_values($locations)); ?>;

// Funkcija za filter lokacija
function filterLocations(searchTerm) {
    if (!searchTerm) return locationsData.slice(0, 10);
    
    const term = searchTerm.toLowerCase();
    return locationsData
        .filter(location => location.toLowerCase().includes(term))
        .slice(0, 10);
}

// Prikazivanje predloga za lokacije
function showSuggestions(suggestions) {
    const suggestionsDiv = document.getElementById('location-suggestions');
    
    if (suggestions.length === 0) {
        suggestionsDiv.classList.add('hidden');
        return;
    }
    
    suggestionsDiv.innerHTML = suggestions
        .map(location => `
            <div class="px-4 py-2 hover:bg-accent/10 cursor-pointer text-sm text-foreground transition-colors" data-location="${location}">
                ${escapeHtml(location)}
            </div>
        `)
        .join('');
    
    suggestionsDiv.classList.remove('hidden');
}

// HTML escape funkcija
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Sakrivanje predloga
function hideSuggestions() {
    setTimeout(() => {
        const suggestionsDiv = document.getElementById('location-suggestions');
        if (suggestionsDiv) {
            suggestionsDiv.classList.add('hidden');
        }
    }, 200);
}

// Inicijalizacija autocomplete-a za lokacije
function initLocationAutocomplete() {
    const locationInput = document.getElementById('location-input');
    const suggestionsDiv = document.getElementById('location-suggestions');
    
    if (!locationInput) return;
    
    // Event za unos teksta
    locationInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value;
        const suggestions = filterLocations(searchTerm);
        showSuggestions(suggestions);
    });
    
    // Event za klik na predlog
    suggestionsDiv.addEventListener('click', function(e) {
        const target = e.target.closest('[data-location]');
        if (target) {
            locationInput.value = target.getAttribute('data-location');
            hideSuggestions();
            
            // Opciono: trigger input event da bi se pokrenula pretraga
            const event = new Event('input', { bubbles: true });
            locationInput.dispatchEvent(event);
        }
    });
    
    // Event za fokusiranje - prikaži inicijalne predloge
    locationInput.addEventListener('focus', function() {
        const suggestions = filterLocations('');
        showSuggestions(suggestions);
    });
    
    // Event za izlazak iz polja
    locationInput.addEventListener('blur', function() {
        hideSuggestions();
    });
    
    // Event za Enter
    locationInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.getElementById('search-form').submit();
        }
    });
    
    // Event za Escape - sakrivanje predloga
    locationInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSuggestions();
        }
    });
}

// Inicijalizacija tabova (prodaja/izdavanje)
function initTabs() {
    const tabs = document.querySelectorAll('[data-type]');
    const searchTypeInput = document.getElementById('search-type');
    
    tabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Ukloni active klasu sa svih tabova
            tabs.forEach(t => {
                t.classList.remove('bg-accent', 'text-accent-foreground', 'font-medium');
                t.classList.add('text-muted-foreground');
            });
            
            // Dodaj active klasu na kliknuti tab
            this.classList.add('bg-accent', 'text-accent-foreground', 'font-medium');
            this.classList.remove('text-muted-foreground');
            
            // Postavi vrednost za search type
            const searchType = this.getAttribute('data-type');
            searchTypeInput.value = searchType;
            
            // Opciono: automatski submit forme
            // document.getElementById('search-form').submit();
        });
    });
}

// Inicijalizacija na load
document.addEventListener('DOMContentLoaded', function() {
    initLocationAutocomplete();
    initTabs();
});
</script>

<style>
/* Stilovi za autocomplete - osiguravamo da dropdown bude iznad svih elemenata */
#location-suggestions {
    background-color: var(--card, #ffffff);
    border-color: var(--border, #e5e7eb);
    max-height: 240px;
    overflow-y: auto;
    z-index: 9999;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

#location-suggestions div:hover {
    background-color: var(--accent, #f59e0b);
    color: var(--accent-foreground, #ffffff);
}

/* Dark mode podrška */
@media (prefers-color-scheme: dark) {
    #location-suggestions {
        background-color: var(--card, #1f2937);
        border-color: var(--border, #374151);
    }
}

/* Osiguravamo da roditeljski kontejner ne ograničava prikaz dropdowna */
#location-container {
    overflow: visible !important;
}

/* Grid kontejner takođe ne sme da ograničava overflow */
.grid {
    overflow: visible !important;
}

/* Celi form kontejner mora da dozvoli overflow */
form {
    overflow: visible !important;
}

/* Relativni pozicionirani elementi ne smeju da imaju overflow hidden */
.relative {
    overflow: visible !important;
}
</style>