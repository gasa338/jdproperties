<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('link_list');
$color_mode = $data['background'] ?? 'dark';
$layout = $data['layout'] ?? 'four';


// Dohvati sve termine (parente i childeve)
$all_terms = get_terms(array(
  'taxonomy'   => 'location',
  'hide_empty' => false,
));

$all_links = array();

if (!empty($all_terms) && !is_wp_error($all_terms)) {
  foreach ($all_terms as $term) {
    $all_links[] = ['url' => get_term_link($term), 'name' => $term->name];
  }
}

$links_per_column = 6; // uvek 14 po koloni
$number_of_columns = ($layout === 'four') ? 4 : 5; // 4 ili 5 kolona

// Podeli linkove u grupe (kolone)
$columns = array_chunk($all_links, $links_per_column);
?>

<?php echo _spacing_full('link-list', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="overflow-hidden link-list-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
  <div class="container-fluid mx-auto px-12">
    <!-- Intro -->
    <div class="max-w-3xl mb-8 <?php echo ($data['title']['align'] === 'center' ? 'mx-auto text-center justify-center items-center' : 'text-left'); ?>">
      <?php if (!empty($data['top_title'])): ?>
        <p class="maxwell-top-title mb-3"><?php echo esc_html($data['top_title']); ?></p>
      <?php endif; ?>
      <?php echo _heading($data['title'], 'mb-8 ' . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
      <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-4"></div>
      <?php if (!empty($data['description'])): ?>
        <div class="text-xl <?php echo ($color_mode === 'dark_mode' ? ' text-white/60' : 'text-muted-foreground'); ?> maxwell-content">
          <?php echo apply_filters('the_content', $data['description']); ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Framework -->
    <div class="grid md:grid-cols-1 lg:grid-cols-5 gap-x-2 gap-y-4">

      <?php foreach ($columns as $column_index => $column_links): ?>
        <div class="group relative p-6 rounded-2xl <?php echo $color_mode === 'dark_mode' ? ' bg-white/5' : 'bg-card'; ?> border border-border hover:border-accent/50 hover:shadow-xl transition-all duration-500">
          <!-- Linkovi u koloni -->
          <div class=" space-y-2">
          <?php foreach ($column_links as $link): ?>
            <div>
              <a href="<?php echo esc_url($link['url']); ?>"
                class="<?php echo ($color_mode === 'dark_mode' ? 'text-white/80 hover:text-white' : 'text-gray-700 hover:text-accent'); ?> transition-colors">
                <?php echo __('Nekretnine u: ', 'gxdev') . esc_html($link['name']); ?>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
    </div>
  <?php endforeach; ?>

  <!-- Popuni preostale kolone praznim ako fali linkova -->
  <?php for ($i = count($columns); $i < $number_of_columns; $i++): ?>
    <div></div>
  <?php endfor; ?>

  </div>

  <!-- Closing statement -->
  <?php if (!empty($data['bottom_text'])): ?>
    <div class="mt-8 pt-8 border-t border-border maxwell-content <?php echo ($color_mode === 'dark_mode' ? 'text-white/60' : ''); ?>">
      <?php echo apply_filters('the_content', $data['bottom_text']); ?>
    </div>
  <?php endif; ?>

  </div>
</section>