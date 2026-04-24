<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('text_column');
$color_mode = $data['background'] ?? 'dark';
?>

<?php echo _spacing_full('text-column',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="overflow-hidden text-column-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
  <div class="container mx-auto px-6 max-w-6xl">
    <!-- Intro -->
    <div class="max-w-3xl mb-8">
      <?php echo _heading($data['title'], 'mb-8' . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
      <?php if (!empty($data['text'])): ?>
        <div class="text-xl text-muted-foreground leading-relaxed <?php echo ($color_mode === 'dark_mode' ? 'text-white/60' : ''); ?>" >
          <?php echo apply_filters('the_content', $data['text']); ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- Framework -->
    <div class="grid lg:grid-cols-2 gap-x-20 gap-y-16">

      <!-- Criteria -->
      <div>
        <div class="flex items-center gap-4 mb-6">
          <?php if (!empty($data['left_icon'])): ?>
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent">
              <?php echo maxwell_render_icon($data['left_icon'], 'h-5 w-5 text-white'); ?>
            </div>
          <?php endif; ?>
          <?php if (!empty($data['left_title'])): ?>
            <h3 class="text-2xl font-bold <?php echo ($color_mode === 'dark_mode' ? 'text-white' : ''); ?>">
              <?php echo $data['left_title']; ?>
            </h3>
          <?php endif; ?>
        </div>

        <div class="space-y-6 <?php echo empty($data['left_icon']) ? "" : "pl-14"; ?> maxwell-content <?php echo ($color_mode === 'dark_mode' ? 'text-white/60 [&_li]:!text-white' : ''); ?>">
          <?php echo apply_filters('the_content', $data['left_text']); ?>
        </div>
      </div>

      <!-- Implications -->
      <div class="pt-1">
        <div class="flex items-center gap-4 mb-6">
          <?php if (!empty($data['right_icon'])): ?>
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent">
              <!-- Decision / constraint icon -->
                <?php echo maxwell_render_icon($data['right_icon'], 'h-5 w-5 text-white'); ?>
            </div>
          <?php endif; ?>

          <?php if (!empty($data['right_title'])): ?>
            <h3 class="text-2xl font-bold <?php echo ($color_mode === 'dark_mode' ? 'text-white' : ''); ?>">
              <?php echo $data['right_title']; ?>
            </h3>
          <?php endif; ?>
        </div>

        <div class="space-y-6 <?php echo empty($data['right_icon']) ? "" : "pl-14"; ?> maxwell-content <?php echo ($color_mode === 'dark_mode' ? 'text-white/60 [&_li]:!text-white' : ''); ?>">
          <?php echo apply_filters('the_content', $data['right_text']); ?>
        </div>
      </div>

    </div>

    <!-- Closing statement -->
    <?php if (!empty($data['bottom_text'])): ?>
      <div class="mt-8 pt-8 border-t border-border maxwell-content <?php echo ($color_mode === 'dark_mode' ? 'text-white/60' : ''); ?>">
        <?php echo apply_filters('the_content', $data['bottom_text']); ?>
      </div>
    <?php endif; ?>

  </div>
</section>