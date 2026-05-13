<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$data = get_field('home_search');
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$color_mode = $data['background'] ?? 'dark';



/**
 * QUICK SEARCH
 */

$defaults = [
  'cat'      => '',
  'jd_type'  => '',
  'location' => '',
];

$args = wp_parse_args($args ?? [], $defaults);

$selected_cat      = sanitize_text_field($args['cat']);
$selected_jd_type  = sanitize_text_field($args['jd_type']);
$selected_location = sanitize_text_field($args['location']);

$cats = get_terms([
  'taxonomy'   => 'cat',
  'hide_empty' => false,
]);

$types = get_terms([
  'taxonomy'   => 'jd-type',
  'hide_empty' => false,
]);

$locations = get_terms([
  'taxonomy'   => 'location',
  'hide_empty' => false,
]);
?>

<style>
  /* Ovo već verovatno imaš, ali dodaj ako fali */
  input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
  }
</style>

<?php echo _spacing_full('home-search', $blocks_id, $data['margin'], $data['padding']); ?>
<section class="home-search-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
  <form
    action="<?php echo esc_url(get_post_type_archive_link('properties')); ?>"
    method="GET"
    class="bg-white border border-border p-6 lg:p-10">

    <input type="hidden" name="post_type" value="properties">

    <!-- PRIMARY SEARCH -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-[1fr_1fr_1.4fr_220px_80px] gap-6 items-end">

      <!-- TRANSACTION -->
      <div>
        <label class="block text-base text-muted-foreground mb-4">
          <?php echo __('Prodaja / Izdavanje', 'gxdev'); ?>
        </label>

        <select
          name="cat"
          class="w-full h-[58px] bg-transparent border-0 border-b border-accent px-0 text-muted-foreground focus:outline-none focus:border-[#a48d69] transition-colors">
          <option value="" class="text-muted-foreground"><?php echo __('Sve', 'gxdev'); ?></option>

          <?php foreach ($cats as $term): ?>
            <option
              class="text-muted-foreground"
              value="<?php echo esc_attr($term->slug); ?>"
              <?php selected($selected_cat, $term->slug); ?>>
              <?php echo esc_html($term->name); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- TYPE -->
      <div>
        <label class="block text-base text-muted-foreground mb-4">
          <?php echo __('Vrsta objekta', 'gxdev'); ?>
        </label>

        <select
          name="jd_type"
          class="w-full h-[58px] bg-transparent border-0 border-b border-accent px-0 text-foreground focus:outline-none focus:border-[#a48d69] transition-colors">
          <option value="" class="text-muted-foreground"><?php echo __('Sve', 'gxdev'); ?></option>

          <?php foreach ($types as $term): ?>
            <option
              class="text-muted-foreground"
              value="<?php echo esc_attr($term->slug); ?>"
              <?php selected($selected_jd_type, $term->slug); ?>>
              <?php echo esc_html($term->name); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- LOCATION -->
      <div>
        <label class="block text-base text-muted-foreground mb-4">
          <?php echo __('Lokacija', 'gxdev'); ?>
        </label>

        <select
          name="location"
          class="w-full h-[58px] bg-transparent border-0 border-b border-accent px-0 text-foreground focus:outline-none focus:border-[#a48d69] transition-colors">
          <option value="" class="text-muted-foreground"><?php echo __('Sve lokacije', 'gxdev'); ?></option>

          <?php foreach ($locations as $term): ?>
            <option
              class="text-muted-foreground"
              value="<?php echo esc_attr($term->slug); ?>"
              <?php selected($selected_location, $term->slug); ?>>
              <?php echo esc_html($term->name); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- BUTTON -->
      <button
        type="submit"
        class="inline-flex items-center justify-center gap-3 bg-accent text-background hover:bg-accent/60 transition-colors duration-500 font-body uppercase px-8 py-4">
        <?php echo __('Traži', 'gxdev'); ?>

        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M11 6C13.7614 6 16 8.23858 16 11M16.6588 16.6549L21 21M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>

      <!-- TOGGLE -->
      <button
        type="button"
        data-search-toggle
        class="w-full h-[58px] inline-flex items-center justify-center border border-accent/30 hover:border-accent/80 hover:bg-white transition-all duration-300 group"
        aria-label="Dodatna pretraga">

        <!-- Ikona filtera (levak) - NAJBOLJA -->
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2 2 0 0 1-.65 1.483l-5.284 4.757a2 2 0 0 0-.7 1.514V19a1 1 0 0 1-.4.8l-2 1.5A1 1 0 0 1 10 20.5v-7.928a2 2 0 0 0-.7-1.514L4.016 6.3A2 2 0 0 1 3.366 4.82V3.774c0-.54.384-1.006.917-1.096A41.43 41.43 0 0 1 12 3z" />
        </svg>
      </button>

    </div>

    <!-- ADVANCED SEARCH -->
    <div data-search-advanced class="hidden mt-10 pt-10">

      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-6">

        <!-- PRICE MIN -->
        <div>
          <label class="block text-base text-muted-foreground mb-4">
            <?php echo __('Cena od', 'gxdev'); ?>
          </label>

          <input
            type="number"
            name="price_min"
            placeholder="Min"
            value="<?php echo esc_attr($_GET['price_min'] ?? ''); ?>"
            class="w-full h-[58px] bg-transparent border-0 border-b border-accent text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-[#a48d69]">
        </div>

        <!-- PRICE MAX -->
        <div>
          <label class="block text-base text-muted-foreground mb-4">
            <?php echo __('Cena do', 'gxdev'); ?>
          </label>

          <input
            type="number"
            name="price_max"
            placeholder="Max"
            value="<?php echo esc_attr($_GET['price_max'] ?? ''); ?>"
            class="w-full h-[58px] bg-transparent border-0 border-b border-accent text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-[#a48d69]">
        </div>

        <!-- AREA MIN -->
        <div>
          <label class="block text-base text-muted-foreground mb-4">
            <?php echo __('Kvadratura od', 'gxdev'); ?>
          </label>

          <input
            type="number"
            name="area_min"
            placeholder="Min"
            value="<?php echo esc_attr($_GET['area_min'] ?? ''); ?>"
            class="w-full h-[58px] bg-transparent border-0 border-b border-accent text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-[#a48d69]">
        </div>

        <!-- AREA MAX -->
        <div>
          <label class="block text-base text-foreground mb-4">
            <?php echo __('Kvadratura do', 'gxdev'); ?>
          </label>

          <input
            type="number"
            name="area_max"
            placeholder="Max"
            value="<?php echo esc_attr($_GET['area_max'] ?? ''); ?>"
            class="w-full h-[58px] bg-transparent border-0 border-b border-accent text-foreground placeholder:text-muted-foreground focus:outline-none focus:border-[#a48d69]">
        </div>

        <!-- NEW BUILD -->
        <div class="flex items-end">

          <label class="flex items-center gap-3 h-[58px] cursor-pointer select-none group">

            <div class="relative flex items-center justify-center">
              <input
                type="checkbox"
                name="novogradnja"
                value="1"
                <?php checked(!empty($_GET['novogradnja'])); ?>
                class="peer w-4 h-4 appearance-none border-2 border-[#b8a27b] rounded-sm bg-white 
               checked:bg-[#b8a27b] checked:border-[#b8a27b]
               hover:border-[#9b8764] 
               focus:outline-none focus:ring-2 focus:ring-[#b8a27b] focus:ring-offset-1
               transition-all duration-200 cursor-pointer">

              <!-- Custom checkmark (samo za checked stanje) -->
              <svg
                class="absolute w-3 h-3 text-white pointer-events-none peer-checked:block hidden"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
            </div>

            <span class="text-foreground group-hover:text-[#b8a27b] transition-colors duration-200">
              <?php echo __('Novogradnja', 'gxdev'); ?>
            </span>

          </label>

        </div>

      </div>

    </div>

  </form>
</section>

<script>
  document.addEventListener('DOMContentLoaded', function() {

    const toggle = document.querySelector('[data-search-toggle]');
    const advanced = document.querySelector('[data-search-advanced]');


    if (!toggle || !advanced) return;

    toggle.addEventListener('click', function() {
      advanced.classList.toggle('hidden');
    });

  });
</script>