<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('text_component');

$color_mode = $data['background'] ?? 'dark';
$layout = $data['layout'] ?? 'vertical';
$verical_alignment = $data['verical_alignment'] ?? 'center';
?>

<?php echo _spacing_full('text-component',$blocks_id,$data['margin'], $data['padding']); ?>
<section class="text-component-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']); ?> <?php echo esc_attr($blocks_class); ?>">
  <div class="container mx-auto px-6">
    <?php if ($layout === 'horizontal') : ?>
      <div class="grid grid-cols-1 md:grid-cols-6 gap-12 max-w-7xl mx-auto">
        <div class="md:col-span-2">
          <?php if ($data['top_title']): ?>
            <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
          <?php endif; ?>
          <?php echo _heading($data['title'], 'mb-10 '. esc_attr($color_mode == 'dark_mode' ? 'text-white' : '')); ?>
        </div>
        <div class="md:col-span-4">
          <?php if ($data['text']): ?>
            <div class="text-lg <?php echo esc_attr($color_mode == 'dark_mode' ? 'text-white/60' : 'text-muted-foreground'); ?> text-left maxwell-content">
              <?php echo apply_filters('the_content', $data['text']); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php else: ?>
      <div class="max-w-5xl mx-auto <?php echo $verical_alignment == 'center' ? " justify-center items-center text-center" : " text-left " ?>">
        <?php if ($data['top_title']): ?>
          <span class="maxwell-top-title mb-4 block"><?php echo $data['top_title']; ?></span>
        <?php endif; ?>
        <?php echo _heading($data['title'], 'mb-10 '. ($color_mode === 'dark_mode' ? 'text-white' : '')); ?>
        <?php if ($data['text']): ?>
          <div class="text-lg maxwell-content <?php echo $color_mode === 'dark_mode' ? 'text-white/60' : 'text-foreground'; ?>">
            <?php echo apply_filters('the_content', $data['text']); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</section>