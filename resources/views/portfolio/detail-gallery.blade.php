<!-- Galerie vlevo -->
<div class="col-md-4 mb-4 mb-md-0" id="gallery" data-gallery='{{ json_encode($project->gallery) }}'>
    <div>
        @if (!empty($project->gallery))
            <!-- Hlavní obrázek (kliknutím na něj otevřeš modal) -->
            <img id="mainImage" src="portfolio/gallery/{{ $mainImage }}" class="img-fluid rounded mb-3 detail-mainimg"
                loading="lazy" alt="Hlavní obrázek" data-bs-toggle="modal" data-bs-target="#imageModal"
                style="max-width: 100%; max-height: 400px; object-fit: contain; margin: 0">
            <div class="row g-2">
                @foreach ($project->gallery as $index => $image)
                    <div class="col-4 col-md-2 thumb-wrapper">
                        <!-- 3 sloupce na xs, 6 sloupců na md -->
                        <img src="portfolio/gallery/{{ $image }}" class="img-thumbnail w-100"
                            style="height: 60px; cursor: pointer; object-fit: cover;" onclick="changeMainImage(this)"
                            loading="lazy" data-index="{{ $index }}" alt="Náhled {{ $index }}">
                    </div>
                @endforeach
            </div>

        @else
            <p class="text-muted">Galerie není k dispozici.</p>
        @endif
    </div>

    <!-- Modal pro zobrazení zvětšeného obrázku -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title" id="imageModalLabel">Galerie projektu</h5>
                    <button type="button" class="btn-close gallery-btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <!-- odstraněny paddingy, aby obrázek zabral maximum -->
                    <img id="modalImage"
                        src="portfolio/gallery/{{ $project->gallery[0] ?? 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKAAAAA5CAYAAABxNnTaAAAAFElEQVR4nO3BMQEAAAgDoJvcf+FAAFY7gW8FAAAAAAAAAAAAAPA3A9MNAAEKCcAAAAASUVORK5CYII=' }}"
                        class="img-fluid w-100" loading="lazy" alt="Detail obrázku"
                        style="max-width:100%; max-height: 90vh; object-fit: contain; margin: 0px">
                    <!-- omezení výšky na 90% viewportu -->
                    <button type="button"
                        class="btn btn-dark btn-gallery position-absolute top-50 start-0 translate-middle-y"
                        id="prevImageBtn">&lt;&nbsp;</button>
                    <button type="button"
                        class="btn btn-dark btn-gallery position-absolute top-50 end-0 translate-middle-y"
                        id="nextImageBtn">&nbsp;&gt;</button>
                </div>
            </div>
        </div>
    </div>
</div>