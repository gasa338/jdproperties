<?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$block_name = $block['name'];
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('case_studies_list');
?>
<?php echo _spacing_full('case-studies-list',$blocks_id,$data['margin'], $data['padding']); ?>
<section id="<?php echo esc_attr($anchor); ?>" class="case-studies-list-<?php echo esc_attr($blocks_id); ?> <?php echo esc_attr($blocks_class); ?>" >
    <div class="container mx-auto px-6">
        <div class="py-4 md:py-18">
            <?php if (!empty($data['top_title'])) : ?>
                <span class="maxwell-top-title mb-4 block "><?php echo $data['top_title']; ?></span>
            <?php endif; ?>
            <?php if (!empty($data['title'])) : ?>
                <?php echo _heading($data['title'], 'mb-16'); ?>
            <?php endif; ?>
            <?php if (!empty($data['items'])) : ?>
                <div class="space-y-6">
                    <?php foreach ($data['items'] as $item) : ?>
                        <div class="group rounded-2xl bg-card border border-border hover:border-accent/30 hover:shadow-xl transition-all duration-500 overflow-hidden">
                            <div class="p-8 md:p-10">
                                <div class="flex flex-col lg:flex-row lg:items-start gap-8">
                                    <div class="flex-1">
                                        <?php if (!empty($item['tag'])) : ?>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                <span class="px-3 py-1 rounded-full bg-accent/10 text-accent text-xs font-medium "><?php echo $item['tag']; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($item['title'])) : ?>
                                            <h3 class="h3-reposponsive mb-4 group-hover:text-primary transition-colors"><?php echo $item['title']; ?></h3>
                                        <?php endif; ?>
                                        <?php if (!empty($item['name'])) : ?>
                                            <p class="text-xl text-primary font-semibold mb-4"><?php echo $item['name']; ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($item['text'])) : ?>
                                            <div class="mb-4 maxwell-content"><?php echo apply_filters('the_content', $item['text']); ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (!empty($item['outcomes'])) : ?>
                                        <div class=" lg:w-[380px] shrink-0 p-6 rounded-xl bg-accent/10 border border-accent/30">
                                            <p class="font-heading text-xl mb-4 font-medium">Outcomes</p>
                                            <ul class="space-y-3">
                                                <?php foreach ($item['outcomes'] as $outcome) : ?>
                                                    <li class="flex items-start gap-3  ">
                                                        <svg class="text-accent" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-big w-4 h-4 text-primary mt-0.5 shrink-0">
                                                            <path d="M21.801 10A10 10 0 1 1 17 3.335"></path>
                                                            <path d="m9 11 3 3L22 4"></path>
                                                        </svg><span><?php echo $outcome['text']; ?></span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <?php if (!empty($item['link'])) : ?>
                                                <div class="mt-6 pt-4 border-t border-border">
                                                    <a class="no-underline inline-flex items-center gap-2 text-accent font-medium hover:gap-3 hover:text-accent transition-all " href="<?php echo $item['link']['url']; ?>"><?php echo $item['link']['title']; ?>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4">
                                                            <path d="M5 12h14"></path>
                                                            <path d="m12 5 7 7-7 7"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>