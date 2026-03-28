<?php
$blocks_id = $block['id'];
$blocks_class = $block['class'] ?? '';
$anchor = $block['anchor'] ?? $blocks_id;
$data = get_field('hero_slider');
$slides = $data['slides'] ?? [];
?>

<?php echo _spacing_full('hero-slider',$blocks_id,$data['margin'], $data['padding']); ?>

<section id="<?php echo esc_attr($anchor); ?>" class="relative overflow-hidden hero-slider-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>">

    <!-- SLIDER -->
    <div class="relative overflow-hidden">

        <!-- TRACK -->
        <div 
            class="flex transition-transform duration-700 ease-out will-change-transform"
            id="heroTrack-<?php echo esc_attr($blocks_id); ?>"
        >

            <?php foreach ($slides as $index => $slide): 
                $bg = get_image($slide['image']);
            ?>

            <div class="w-full flex-shrink-0 relative">

                <!-- BG IMAGE -->
                <?php if ($bg): ?>
                    <img 
                        src="<?php echo esc_url($bg['url']); ?>"
                        srcset="<?php echo esc_attr($bg['srcset']); ?>"
                        alt="<?php echo esc_attr($bg['alt']); ?>"
                        class="absolute inset-0 w-full h-full object-cover"

                        <?php if ($index === 0): ?>
                            fetchpriority="high" loading="eager"
                        <?php else: ?>
                            loading="lazy"
                        <?php endif; ?>

                        decoding="async"
                    >
                <?php endif; ?>

                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-gradient-to-r from-background/95 via-background/80 to-background/40 z-10"></div>

                <!-- CONTENT -->
                <div class="relative z-20">
                    <div class="container-luxury section-padding min-h-[80vh] flex items-center">

                        <div class="max-w-xl">

                            <?php echo _heading($slide['title'], 'mb-6'); ?>

                            <?php if ($slide['text']): ?>
                                <div class="maxwell-content text-muted-foreground mb-6">
                                    <?php echo apply_filters('the_content', $slide['text']); ?>
                                </div>
                            <?php endif; ?>

                            <div class="flex flex-wrap gap-4">
                                <?php if ($slide['link_1']) _link_1($slide['link_1']); ?>
                                <?php if ($slide['link_2']) _link_2($slide['link_2']); ?>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            <?php endforeach; ?>

        </div>
    </div>

    <!-- DOTS -->
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-30">
        <?php foreach ($slides as $i => $slide): ?>
            <button class="hero-dot w-3 h-3 rounded-full <?php echo $i === 0 ? 'bg-accent' : 'bg-accent/60 w-6 h-3'; ?>"></button>
        <?php endforeach; ?>
    </div>

</section>

<script>
(function () {
  const track = document.querySelector('[id^="heroTrack-"]');
  if (!track) return;

  const slides = track.children;
  const dots = track.closest('section').querySelectorAll('.hero-dot');

  let index = 0;
  const total = slides.length;

  function update() {
    track.style.transform = `translate3d(-${index * 100}%, 0, 0)`;

    dots.forEach((dot, i) => {
      dot.classList.toggle('bg-accent', i === index);
      dot.classList.toggle('bg-accent/60 w-6 h-3', i !== index);
    });
  }

  function goTo(i) {
    index = i;
    update();
  }

  function next() {
    index = (index + 1) % total;
    update();
  }

  // DOTS
  dots.forEach((dot, i) => {
    dot.addEventListener('click', () => goTo(i));
  });

  // AUTOPLAY
  let interval = setInterval(next, 5000);

  // PAUSE ON HOVER
  track.addEventListener('mouseenter', () => clearInterval(interval));
  track.addEventListener('mouseleave', () => {
    interval = setInterval(next, 5000);
  });

})();
</script>