let currentIndex = 0;
const galleryImages = JSON.parse(document.getElementById('gallery').dataset.gallery);

function changeMainImage(imgElement) {
    const src = imgElement.src;
    currentIndex = parseInt(imgElement.getAttribute('data-index'));
    if (currentIndex === -1) currentIndex = 0; // záložní hodnota
    // Nastav hlavní obrázek na stránce
    document.getElementById('mainImage').src = src;
    // Nastav obrázek v modalu
    document.getElementById('modalImage').src = src;
}

document.getElementById('prevImageBtn').addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
    document.getElementById('modalImage').src = galleryImages[currentIndex];
});

document.getElementById('nextImageBtn').addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % galleryImages.length;
    document.getElementById('modalImage').src = galleryImages[currentIndex];
});
