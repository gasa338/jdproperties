document.addEventListener('DOMContentLoaded', function () {
    // DOM elementi
    const modal = document.getElementById('gallery-modal');
    const modalImage = document.getElementById('modal-image');
    const modalCaption = document.getElementById('modal-caption');
    const currentIndexSpan = document.getElementById('current-index');
    const closeBtn = document.querySelector('.close-modal');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const galleryGrid = document.querySelector('.gallery-grid');

    let currentImageIndex = 0;
    let images = [];

    // Učitaj podatke iz data-gallery atributa
    if (galleryGrid && galleryGrid.dataset.gallery) {
        try {
            images = JSON.parse(galleryGrid.dataset.gallery);

            // Ažuriraj total broj slika
            const totalSpan = document.getElementById('total-images');
            if (totalSpan) {
                totalSpan.textContent = images.length;
            }
        } catch (e) {
            console.error('Greška pri parsiranju galerije:', e);
        }
    }

    // Dodaj klik event na sve gallery-item elemente
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            const index = parseInt(this.getAttribute('data-index'));
            if (!isNaN(index) && images[index]) {
                openGallery(index);
            }
        });
    });

    // Otvori galeriju
    function openGallery(index) {
        if (!images.length) return;

        currentImageIndex = index;
        updateModalImage();
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Dodaj event listener za tastaturu
        document.addEventListener('keydown', handleKeyPress);
    }

    // Zatvori galeriju
    function closeGallery() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', handleKeyPress);
    }

    // Ažuriraj sliku u modalu
    function updateModalImage() {
        const container = document.querySelector('.modal-image-container');
        if (!images[currentImageIndex]) return;

        container.classList.add('loading');

        const image = images[currentImageIndex];
        modalImage.src = image.full;
        modalImage.alt = image.alt;
        modalCaption.textContent = image.caption || '';
        currentIndexSpan.textContent = currentImageIndex + 1;

        modalImage.onload = function () {
            container.classList.remove('loading');
        };

        // Ako slika nije u kešu, prikaži loading dok se učitava
        if (!modalImage.complete) {
            modalImage.style.opacity = '0';
            modalImage.onload = function () {
                modalImage.style.opacity = '1';
                container.classList.remove('loading');
            };
        } else {
            modalImage.style.opacity = '1';
            container.classList.remove('loading');
        }
    }

    // Sledeća slika
    function nextImage() {
        if (!images.length) return;
        currentImageIndex = (currentImageIndex + 1) % images.length;
        updateModalImage();
    }

    // Prethodna slika
    function prevImage() {
        if (!images.length) return;
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        updateModalImage();
    }

    // Tastatura
    function handleKeyPress(e) {
        switch (e.key) {
            case 'ArrowLeft':
                prevImage();
                break;
            case 'ArrowRight':
                nextImage();
                break;
            case 'Escape':
                closeGallery();
                break;
        }
    }

    // Event listeneri
    if (closeBtn) closeBtn.addEventListener('click', closeGallery);
    if (prevBtn) prevBtn.addEventListener('click', prevImage);
    if (nextBtn) nextBtn.addEventListener('click', nextImage);

    // Zatvori klikom na pozadinu
    if (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                closeGallery();
            }
        });
    }

    // Touch/swipe podrška za mobilne uređaje
    let touchStartX = 0;
    let touchEndX = 0;

    if (modal) {
        modal.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        });

        modal.addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            const swipeThreshold = 50;
            const diff = touchEndX - touchStartX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    prevImage();
                } else {
                    nextImage();
                }
            }
        });
    }
});