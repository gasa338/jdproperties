<?php
/**
 * Super optimized floating buttons - minimal code
 */
function add_super_optimized_buttons()
{

	$contact_data = get_field('contact_options', 'options');

	$wa = $contact_data['whatsapp'];
	$vb = $contact_data['viber'];
	$phone = $contact_data['phone'];
?>
	<div class="fixed right-6 top-3/4 -translate-y-1/2 z-[9999] !flex-col !gap-3">

		<!-- WhatsApp -->
		<a href="https://wa.me/<?php echo $wa; ?>"
			target="_blank"
			rel="noopener noreferrer"
			aria-label="WhatsApp"
			class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#25D366] shadow-lg transition hover:scale-105 hover:shadow-xl m-1.5">

			<?php echo maxwell_render_svg($contact_data['whatsapp_icon']['url'], 'w-6 h-6 text-white'); ?>
		</a>

		<!-- Viber -->
		<a href="viber://add?number=<?php echo $vb; ?>"
			aria-label="Viber"
			class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#7360F2] shadow-lg transition hover:scale-105 hover:shadow-xl m-1.5">

			<?php echo maxwell_render_svg($contact_data['viber_icon']['url'], 'w-6 h-6 text-white'); ?>
		</a>

		<!-- Phone -->
		<a href="tel:<?php echo $phone; ?>"
			aria-label="Phone"
			class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-lg transition hover:scale-105 hover:shadow-xl mx-1.5">

			<?php echo maxwell_render_svg($contact_data['phone_icon']['url'], 'w-6 h-6 text-black'); ?>
		</a>

	</div>

<?php
}

add_action('wp_footer', 'add_super_optimized_buttons');