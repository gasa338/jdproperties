<?php
/**
 * Template Name: Demo Palete Boja
 * Template Post Type: page
 */
?>

<?php get_header(); ?>

<div class="demo-container">
  <!-- Switcher panel -->
  <aside class="demo-sidebar">
    <h2>Demo Palete Boja</h2>
    <p>Izaberite paletu da vidite kako izgleda:</p>
    
    <div class="palette-switcher">
      <?php 
      $palettes = [
        'default' => ['#0F1729', '#CC9933', 'Podrazumevano'],
        'sport' => ['#1E40AF', '#DC2626', 'Sportska'],
        'elegant' => ['#374151', '#A78BFA', 'Elegantna'],
        'corporate' => ['#1E3A8A', '#047857', 'Korporativna'],
        'creative' => ['#7C3AED', '#F59E0B', 'Kreativna']
      ];
      
      foreach ($palettes as $key => $colors): 
      ?>
        <button 
          class="palette-option" 
          data-palette="<?php echo $key; ?>"
          onclick="window.switchTheme('<?php echo $key; ?>')"
        >
          <div class="color-strip">
            <span style="background: <?php echo $colors[0]; ?>"></span>
            <span style="background: <?php echo $colors[1]; ?>"></span>
          </div>
          <span><?php echo $colors[2]; ?></span>
        </button>
      <?php endforeach; ?>
    </div>
    
    <div class="color-picker">
      <h4>Custom boje:</h4>
      <input type="color" id="custom-primary" value="#0F1729">
      <input type="color" id="custom-secondary" value="#CC9933">
      <button onclick="applyCustomColors()">Primeni</button>
    </div>
    
    <div class="share-section">
      <h4>Podeli paletu:</h4>
      <input type="text" id="share-url" readonly>
      <button onclick="copyShareUrl()">Kopiraj link</button>
    </div>
  </aside>
  
  <!-- Live preview -->
  <main class="demo-preview">
    <header class="demo-header">
      <h1 class="demo-site-title">Demo Sajt</h1>
      <nav class="demo-nav">
        <a href="#">Početna</a>
        <a href="#">Usluge</a>
        <a href="#">O nama</a>
        <a href="#">Kontakt</a>
      </nav>
    </header>
    
    <section class="demo-hero">
      <h2>Dobrodošli na naš demo</h2>
      <p>Ova paleta boja se može promeniti u real-time</p>
      <button class="demo-btn-primary">Primarno dugme</button>
      <button class="demo-btn-secondary">Sekundarno dugme</button>
    </section>
    
    <section class="demo-cards">
      <div class="demo-card">
        <h3>Kartica 1</h3>
        <p>Ovo je primer kartice sa primarnom bojom.</p>
      </div>
      <div class="demo-card">
        <h3>Kartica 2</h3>
        <p>Ovo je primer kartice sa sekundarnom bojom.</p>
      </div>
    </section>
  </main>
</div>

<script>
// Theme switching logic
window.switchTheme = function(palette) {
  const palettes = {
    default: { primary: '#0F1729', secondary: '#CC9933' },
    sport: { primary: '#1E40AF', secondary: '#DC2626' },
    elegant: { primary: '#374151', secondary: '#A78BFA' },
    corporate: { primary: '#1E3A8A', secondary: '#047857' },
    creative: { primary: '#7C3AED', secondary: '#F59E0B' }
  };
  
  const colors = palettes[palette] || palettes.default;
  
  // Ažuriraj CSS varijable
  document.documentElement.style.setProperty('--theme-primary', colors.primary);
  document.documentElement.style.setProperty('--theme-secondary', colors.secondary);
  
  // Ažuriraj URL za deljenje
  const url = new URL(window.location);
  url.searchParams.set('theme', palette);
  document.getElementById('share-url').value = url.toString();
  
  // Sačuvaj u localStorage
  localStorage.setItem('demo-theme', palette);
};

// Custom colors function
function applyCustomColors() {
  const primary = document.getElementById('custom-primary').value;
  const secondary = document.getElementById('custom-secondary').value;
  
  document.documentElement.style.setProperty('--theme-primary', primary);
  document.documentElement.style.setProperty('--theme-secondary', secondary);
  
  // Ažuriraj URL za deljenje
  const url = new URL(window.location);
  url.searchParams.set('custom', `${primary},${secondary}`);
  document.getElementById('share-url').value = url.toString();
}

// Copy share URL
function copyShareUrl() {
  const input = document.getElementById('share-url');
  input.select();
  document.execCommand('copy');
  alert('Link kopiran u clipboard!');
}

// Učitaj teme iz URL-a ili localStorage
document.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  const themeFromUrl = urlParams.get('theme');
  const themeFromStorage = localStorage.getItem('demo-theme');
  const theme = themeFromUrl || themeFromStorage || 'default';
  
  window.switchTheme(theme);
  
  // Custom colors from URL
  const customColors = urlParams.get('custom');
  if (customColors) {
    const [primary, secondary] = customColors.split(',');
    document.documentElement.style.setProperty('--theme-primary', primary);
    document.documentElement.style.setProperty('--theme-secondary', secondary);
    document.getElementById('custom-primary').value = primary;
    document.getElementById('custom-secondary').value = secondary;
  }
});
</script>

<style>
:root {
  --theme-primary: #0F1729;
  --theme-secondary: #CC9933;
}

.demo-container {
  display: flex;
  min-height: 100vh;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.demo-sidebar {
  width: 300px;
  background: #f5f7fa;
  padding: 2rem;
  border-right: 1px solid #e1e8ed;
}

.demo-preview {
  flex: 1;
  padding: 2rem;
  background: white;
}

.palette-switcher {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin: 2rem 0;
}

.palette-option {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 0.75rem;
  background: white;
  border: 1px solid #e1e8ed;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.palette-option:hover {
  border-color: var(--theme-primary);
}

.color-strip {
  display: flex;
  width: 40px;
  height: 40px;
  border-radius: 6px;
  overflow: hidden;
  border: 1px solid #ddd;
}

.color-strip span {
  flex: 1;
}

.demo-header {
  border-bottom: 3px solid var(--theme-primary);
  padding-bottom: 1rem;
  margin-bottom: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.demo-nav a {
  margin-left: 1.5rem;
  text-decoration: none;
  color: var(--theme-primary);
  font-weight: 500;
}

.demo-hero {
  background: linear-gradient(135deg, var(--theme-primary) 0%, #1a365d 100%);
  color: white;
  padding: 4rem 2rem;
  border-radius: 12px;
  text-align: center;
  margin-bottom: 2rem;
}

.demo-hero h2 {
  font-size: 2.5rem;
  margin-bottom: 1rem;
}

.demo-btn-primary,
.demo-btn-secondary {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  margin: 0.5rem;
  transition: opacity 0.2s;
}

.demo-btn-primary:hover,
.demo-btn-secondary:hover {
  opacity: 0.9;
}

.demo-btn-primary {
  background: var(--theme-primary);
  color: white;
}

.demo-btn-secondary {
  background: var(--theme-secondary);
  color: white;
}

.demo-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.demo-card {
  border: 1px solid #e1e8ed;
  border-radius: 12px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.demo-card:nth-child(1) {
  border-top: 4px solid var(--theme-primary);
}

.demo-card:nth-child(2) {
  border-top: 4px solid var(--theme-secondary);
}

.color-picker,
.share-section {
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid #e1e8ed;
}

.color-picker input[type="color"] {
  width: 50px;
  height: 50px;
  margin-right: 1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.color-picker button,
.share-section button {
  padding: 0.5rem 1rem;
  background: var(--theme-primary);
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

#share-url {
  width: 100%;
  padding: 0.5rem;
  margin: 0.5rem 0;
  border: 1px solid #ddd;
  border-radius: 4px;
}
</style>

<?php get_footer(); ?>