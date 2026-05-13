<!-- Hero Sekcija -->
<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('image_text_column');
$color_mode = $data['background'] ?? 'dark';
?>

<style>
  .image-text-column-<?php echo esc_attr($blocks_id); ?> .maxwell-content p {
    margin-bottom: 0 !important;
  }
</style>
<?php echo _spacing_full('image-text-column', $blocks_id, $data['margin'], $data['padding']); ?>
<section class="image-text-column-<?php echo esc_attr($blocks_id); ?> <?php echo _background($data['background']) ?> <?php echo esc_attr($blocks_class); ?>">
  <div class="container">

    <!-- HEADER -->
    <div class="max-w-4xl mx-auto text-center">
      <?php if (!empty($data['top_title'])) : ?>
        <?php _top_title($data['top_title'], 'center'); ?>
      <?php endif; ?>

      <?php if (!empty($data['title'])) : ?>
        <?php echo _heading($data['title'], 'mb-6' . ($color_mode === 'dark_mode' ? ' text-white' : '')) ?>
        <div class="gold-divider mx-auto mb-4"></div>
      <?php endif; ?>

      <?php if (!empty($data['description'])) : ?>
        <div class="mx-auto mb-6 text-muted-foreground maxwell-content">
          <?php echo apply_filters('the_content', $data['description']); ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- ITEMS -->
    <?php if (!empty($data['items'])): ?>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <?php foreach ($data['items'] as $item): ?><div class="relative border border-border rounded-lg overflow-hidden">

            <!-- IMAGE -->
            <?php if (!empty($item['image'])): ?>
              <div class="absolute inset-0">
                <img
                  src="<?php echo esc_url($item['image']['url']); ?>"
                  alt="<?php echo esc_attr($item['image']['alt']); ?>"
                  class="w-full h-full object-cover">

                <!-- overlay -->
                <div class="absolute inset-0 bg-gradient-to-l from-transparent via-black/20 to-black/60"></div>

                <!-- frame -->
                <div class="absolute inset-6 border border-white/20 pointer-events-none"></div>
              </div>
            <?php endif; ?>
            <!-- CONTENT -->
            <div class="relative z-10 h-full flex flex-col justify-between max-w-[480px] p-8 lg:p-10">
              <!-- GRADIJENT: 100% bela do 80% širine, zatim providno -->
              <div class="absolute inset-0 bg-gradient-to-r from-white via-white to-transparent" style="--tw-gradient-stops: white 0%, white 80%, transparent 100%);"></div>
              <div class="relative max-w-[280px] z-20">

                <?php if (!empty($item['icon'])): ?>
                  <div class="w-12 h-12 rounded-full border border-accent flex items-center justify-center mb-6 bg-white/70 backdrop-blur-sm">
                    <?php echo maxwell_render_svg($item['icon']['url'], 'w-6 h-6 text-accent'); ?>
                  </div>
                <?php endif; ?>

                <!-- TITLE -->
                <?php if (!empty($item['title'])): ?>
                  <h3 class="h3-responsive mb-4">
                    <?php echo esc_html($item['title']); ?>
                  </h3>
                  <div class="gold-divider mb-5"></div>
                <?php endif; ?>

                <!-- TEXT -->
                <?php if (!empty($item['text'])): ?>
                  <div class="text-muted-foreground max-w-[320px] leading-8">
                    <?php echo apply_filters('the_content', $item['text']); ?>
                  </div>
                <?php endif; ?>

              </div>

              <!-- LINK -->
              <?php if (!empty($item['link'])): ?>
                <div class="relative z-20 mt-8">
                  <?php _link_outline($item['link'], 'bg-gradient-luxury'); ?>
                </div>
              <?php endif; ?>

            </div>

          </div>
        <?php endforeach; ?>

      </div>
    <?php endif; ?>

    <?php
    $cta = $data['cta'];

    $icon = $cta['icon'];
    $title = $cta['title'];
    $text = $cta['text'];
    $link = $cta['link'];
    $image = $cta['image'];
    if (!empty($icon) || !empty($title) || !empty($text) || !empty($link) || !empty($image)) :
    ?>

      <div class="mt-8 bg-gradient-luxury rounded-md p-4 sm:p-6 lg:p-2 lg:px-8 lg:py-6 flex flex-col lg:flex-row items-center justify-between gap-6 sm:gap-8 overflow-hidden">

        <!-- CONTENT - na mobilnom ide kolona, na desktopu red -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 sm:gap-6 text-white lg:w-4/5 flex-1 w-full">

          <?php if (!empty($icon)): ?>
            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border border-accent flex items-center justify-center shrink-0">
              <?php echo maxwell_render_svg($icon['url'], 'w-8 h-8 sm:w-10 sm:h-10 text-accent'); ?>
            </div>
          <?php endif; ?>

          <!-- TEKSTUALNI SADRŽAJ -->
          <div class="flex-1 text-center sm:text-left">
            <?php if (!empty($title)): ?>
              <h4 class="h4-responsive text-white mb-2">
                <?php echo $title; ?>
              </h4>
            <?php endif; ?>

            <?php if (!empty($text)): ?>
              <div class="text-white/70 maxwell-content max-w-[600px] mx-auto sm:mx-0">
                <?php echo apply_filters('the_content', $text); ?>
              </div>
            <?php endif; ?>
          </div>

          <!-- LINK - na mobilnom ispod teksta, na desktopu pored -->
          <?php if (!empty($link)): ?>
            <div class="relative z-20 mt-4 sm:mt-0 sm:ml-6 shrink-0">
              <?php _link_outline($link); ?>
            </div>
          <?php endif; ?>

        </div>

        <!-- DESNA STRANA - slike/logotipi -->
        <div class="flex flex-wrap items-center justify-center gap-4 sm:gap-6 shrink-0 w-full lg:w-auto">

          <?php if (!empty($image)): ?>
            <div class="px-4 py-3">
              <img
                src="<?php echo esc_url($image['url']); ?>"
                alt="<?php echo esc_attr($image['alt']); ?>"
                class="h-8 sm:h-10 lg:h-12 w-auto object-contain opacity-90">
            </div>
          <?php endif; ?>

        </div>

      </div>

    <?php endif; ?>

  </div>
</section>