<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('link_list');
$color_mode = $data['background'] ?? 'dark';


?>

<?php echo _spacing_full('link-list', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="overflow-hidden link-list-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
  <div class="container mx-auto px-12">
    <!-- Intro -->
    <div class="max-w-3xl mb-8 <?php echo ($data['title']['align'] === 'center' ? 'mx-auto text-center justify-center items-center' : 'text-left'); ?>">
      <?php if (!empty($data['top_title'])): ?>
        <p class="maxwell-top-title mb-3"><?php echo esc_html($data['top_title']); ?></p>
        <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-4"></div>
      <?php endif; ?>
      <?php echo _heading($data['title'], 'mb-8 ' . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
      <?php if (!empty($data['text'])): ?>
        <div class="text-xl <?php echo ($color_mode === 'dark_mode' ? ' text-white/60' : 'text-muted-foreground'); ?> maxwell-content">
          <?php echo apply_filters('the_content', $data['text']); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($data['links'])): ?>
      <div class="flex flex-wrap justify-center gap-3">
        <?php foreach ($data['links'] as $link): ?>
          <?php if (!empty($link['link'])): ?>
            <div>
              <a class="inline-flex items-center gap-2 bg-card border border-border hover:border-accent hover:text-accent rounded-full px-5 py-2.5 font-body text-sm text-foreground transition-colors" href="<?php echo $link['link']['url']; ?>" title="<?php echo $link['link']['title']; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-3.5 h-3.5 text-accent">
                  <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                  <circle cx="12" cy="10" r="3"></circle>
                </svg><?php echo $link['link']['title']; ?></a>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>


    <?php if (!empty($data['additional_text'])) : ?>
      <div class="<?php echo ($color_mode === 'dark_mode' ? ' text-white/60' : ' text-muted-foreground'); ?> mt-10">
        <?php echo apply_filters('the_content', $data['additional_text']); ?>
      </div>
    <?php endif; ?>
  </div>
</section>