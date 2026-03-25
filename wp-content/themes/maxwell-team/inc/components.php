<?php

/**
 * Renders a link element with a specific class for styling purposes.
 *
 * This function is used to render a link element with a specific class. It is
 * designed to be used when you want to apply a specific styling class to the
 * link element. The class can be used to style the link element as per the
 * requirements of the theme.
 *
 * @param array  $link The link data.
 * @param string $class The class to be applied to the link element.
 */
function _link_1($link, $class = '')
{
?>
    <a href="<?php echo esc_url($link['url']); ?>" class="inline-flex items-center justify-center gap-2 rounded-lg bg-accent px-7 py-3.5 font-semibold text-accent-foreground hover:opacity-90 transition-opacity shadow-lg shadow-accent/20 no-underline <?php echo esc_attr($class); ?>">
        <?php echo esc_html($link['title']); ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5 transition-transform group-hover:translate-x-1">
            <path d="M5 12h14"></path>
            <path d="m12 5 7 7-7 7"></path>
        </svg>
    </a>
<?php
}


/**
 * Renders a link element with a "button-2" class for styling purposes.
 *
 * This function is used to render a link element with a "button-2" class. It is
 * designed to be used when you want to apply a styling class for a button-like
 * link element. The class is commonly used for styling buttons in the theme.
 *
 * @param array  $link The link data.
 * @param string $class The class to be applied to the link element.
 *
 * @since 1.0.0
 */
function _link_2($link, $class = '')
{
?>
    <a href="<?php echo esc_url($link['url']); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-border bg-transparent text-foreground hover:bg-secondary hover:border-accent/50 h-14 rounded-xl px-10 text-lg no-underline <?php echo esc_attr($class); ?>"><?php echo esc_html($link['title']); ?></a>
<?php
}


function _link_3($link, $class = '')
{
?>
    <a class="inline-flex items-center gap-2 text-primary font-medium hover:gap-3 transition-all group <?php echo esc_attr($class); ?>" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target']); ?>" title="<?php echo esc_attr($link['title']); ?>">
        <?php echo esc_html($link['title']); ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4 group-hover:translate-x-1 transition-transform">
            <path d="M5 12h14"></path>
            <path d="m12 5 7 7-7 7"></path>
        </svg>
    </a>
<?php
}
function _link_4($link, $class = '')
{
?>
    <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target']); ?>" title="<?php echo esc_attr($link['title']); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground font-semibold glow-primary hover:scale-105 h-14 rounded-xl px-10 text-lg group <?php echo esc_attr($class); ?>">
        <?php echo esc_html($link['title']); ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 transition-transform group-hover:translate-x-1">
            <path d="M5 12h14"></path>
            <path d="m12 5 7 7-7 7"></path>
        </svg>
    </a>
<?php
}


function link_5($link, $class = '')
{
?>
    <a href="<?php echo esc_url($link['url']); ?>" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-semibold ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border-2 border-primary bg-transparent hover:!text-white hover:bg-primary h-9 rounded-md px-4 <?php echo esc_attr($class); ?>">
        <?php echo esc_html($link['title']); ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
            class="w-3 h-3">
            <path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-105.4 105.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
        </svg>
    </a>
<?php
}

function link_inline_arrow($link, $class = '')
{
?>
    <a href="<?php echo esc_url($link['url']); ?>"
        title="<?php echo esc_attr($link['title']); ?>"
        class="inline-flex items-center text-button group hover:underline <?php echo esc_attr($class); ?> group">
        <?php echo esc_html($link['title']); ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
            class="w-4 h-3 ml-2 transition-transform duration-200 ease-in-out group-hover:translate-x-1">
            <path fill="currentColor" d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-105.4 105.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z" />
        </svg>
    </a>
<?php
}

function _link_6($link, $class = '')
{
?>
    <a href="<?php echo esc_url($link['url']); ?>">
        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap font-medium ring-offset-background transition-all duration-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border bg-transparent hover:border-primary/50 h-14 rounded-xl px-10 text-lg border-white/30 text-white hover:bg-white/10 <?php echo esc_attr($class); ?>">
            <?php echo esc_html($link['title']); ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-5 h-5">
                <path d="M5 12h14"></path>
                <path d="m12 5 7 7-7 7"></path>
            </svg>
        </button>
    </a>
<?php
}
