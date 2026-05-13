<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('link_list');
$color_mode = $data['background'] ?? 'dark';
$list_style = $data['inline_list'] ?? 'no';
?>

<?php echo _spacing_full('link-list', $blocks_id, $data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="overflow-hidden link-list-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
  <div class="<?php echo ($data['full_width'] === 'yes' ? '' : 'container') ?> mx-auto px-12">
    <!-- Intro -->
    <div class="max-w-3xl mb-8 <?php echo ($data['title']['align'] === 'center' ? 'mx-auto text-center justify-center items-center' : 'text-left'); ?>">
      <?php if (!empty($data['top_title'])): ?>
        <?php _top_title($data['top_title'], 'center'); ?>
      <?php endif; ?>
      <?php if (!empty($data['title'])): ?>
        <?php echo _heading($data['title'], 'mb-8 ' . ($color_mode === 'dark_mode' ? ' text-white' : '')); ?>
        <div class="gold-divider <?php echo ($data['title']['align'] === 'center' ? 'mx-auto' : '') ?> mb-4"></div>
      <?php endif; ?>

      <?php if (!empty($data['text'])): ?>
        <div class="text-xl <?php echo ($color_mode === 'dark_mode' ? ' text-white/60' : 'text-muted-foreground'); ?> maxwell-content">
          <?php echo apply_filters('the_content', $data['text']); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (!empty($data['links_group'])): ?>
      <?php if ($list_style == 'no'): ?>
        <div class="flex flex-wrap justify-center gap-8">
          <?php foreach ($data['links_group'] as $group): ?>
            <div class="flex flex-col min-w-[200px]">
              <!-- Naslov grupe -->
              <?php if (!empty($group['title'])): ?>
                <div class="inline-flex items-center justify-center gap-2 px-5 py-2.5 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin w-6 h-6 text-accent">
                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                  </svg>
                  <h3 class="text-2xl font-heading"><?php echo $group['title']; ?></h3>
                </div>
              <?php endif; ?>

              <!-- Linkovi ispod naslova -->
              <?php if (!empty($group['link'])): ?>
                <div class="flex flex-col gap-2">
                  <?php foreach ($group['link'] as $link): ?>
                    <div class="px-5 py-1">
                      <a href="<?php echo get_the_permalink($link); ?>"
                        title="<?php echo get_the_title($link); ?>"
                        class="text-accent hover:underline transition-colors">
                        <?php echo get_the_title($link); ?>
                      </a>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="flex flex-col items-center justify-center gap-4">
          <?php foreach ($data['links_group'] as $group): ?>
            <div class="flex flex-row items-center gap-3">
              <!-- Naslov grupe -->
              <?php if (!empty($group['title'])): ?>
                <h3 class="text-2xl font-heading"><?php echo $group['title']; ?>:</h3>
              <?php endif; ?>

              <!-- Linkovi inline horizontalno -->
              <?php if (!empty($group['link'])): ?>
                <div class="flex flex-row flex-wrap gap-3">
                  <?php foreach ($group['link'] as $link): ?>
                    <div class="px-3 py-1">
                      <a href="<?php echo get_the_permalink($link); ?>"
                        title="<?php echo get_the_title($link); ?>"
                        class="text-accent hover:underline transition-colors whitespace-nowrap">
                        <?php echo get_the_title($link); ?>
                      </a>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($data['additional_text'])) : ?>
      <div class="<?php echo ($color_mode === 'dark_mode' ? ' text-white/60' : ' text-muted-foreground'); ?> mt-10">
        <?php echo apply_filters('the_content', $data['additional_text']); ?>
      </div>
    <?php endif; ?>
  </div>
</section>