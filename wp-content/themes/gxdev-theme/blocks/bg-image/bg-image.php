
<!-- Hero Sekcija -->
 <?php
$blocks_id = $block['id'];
$blocks_class = isset($block['class']) ? $block['class'] : '';
$anchor = isset($block['anchor']) ? $block['anchor'] : $blocks_id;
$data = get_field('bg_image');
?>

<section class="relative min-h-screen overflow-hidden">

    <!-- Wrapper za pozadinsku sliku -->
    <div class="absolute inset-0 overflow-hidden">
        <img
            class="sticky top-0 w-full h-full object-cover"
            src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80"
            srcset="
                https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80 400w,
                https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80 800w,
                https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80 1200w
            "
            sizes="100vw"
            alt="Pozadinska slika planine"
            loading="lazy"
            decoding="async"
            width="1200"
            height="800"
            style="clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);"
        />
    </div>

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black bg-opacity-50"></div>

    <!-- Sadržaj -->
    <div class="relative z-20 min-h-screen flex items-center justify-center">
        
        <div class="text-center text-white max-w-4xl mx-auto px-4">
            <h2 class="text-5xl font-bold mb-6">Naslov sekcije</h2>
            <p class="text-xl mb-8">
                Ovo je primjer sekcije s fiksnom pozadinom.
                Slika ostaje unutar ove sekcije dok se skroluje.
            </p>
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                Pozovite na akciju
            </button>
        </div>
    </div>

</section>
