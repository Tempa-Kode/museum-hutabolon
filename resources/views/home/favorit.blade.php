@php
    use Illuminate\Support\Str;
@endphp
@extends("home.template")
@section("title", "Galery Favorit")
@section("body")
    <!--======= HOME MAIN SLIDER =========-->
    <section class="sub-bnr sub-gallery" data-stellar-background-ratio="0.3">
        <div class="overlay-gr">
            <div class="container">
                <h2>Gallery Favorit</h2>
            </div>
        </div>
    </section>
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li><a href="{{ route("home") }}">Home</a></li>
        <li class="active">Gallery Favorit</li>
    </ol>

    <div class="content">
        <!--======= Gallery =========-->
        <section class="sec-100px gallery bg-white">
            <div class="container">
                <!-- Filter Type -->
                <div class="row mb-4">
                    <div class="col-12">
                        <button class="btn btn-outline-danger float-end" id="clearAllFavorites">
                            <i class="fa-solid fa-trash"></i> HAPUS SEMUA FAVORIT
                        </button>
                    </div>
                </div>

                <!-- Favorites Container -->
                <ul class="row" id="favoritesContainer" style="margin-top: 20px;">
                    <!-- Items will be dynamically loaded here -->
                </ul>

                <!-- Empty State -->
                <div class="row" id="emptyState" style="display: none; margin-top: 20px;">
                    <div class="col-12 text-center py-5">
                        <i class="fa-regular fa-heart" style="font-size: 48px; color: #ccc;"></i>
                        <p class="mt-3">Belum ada item favorit.</p>
                        <a href="{{ route('gallery') }}" class="btn btn-primary mt-2">Jelajahi Gallery</a>
                    </div>
                </div>
            </div>
        </section>
    </div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentFilter = 'all';

    // Load favorites on page load
    loadFavorites();

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active', 'btn-primary');
                b.classList.add('btn-outline-primary');
            });
            this.classList.remove('btn-outline-primary');
            this.classList.add('active', 'btn-primary');

            currentFilter = this.getAttribute('data-filter');
            loadFavorites(currentFilter);
        });
    });

    // Clear all favorites
    document.getElementById('clearAllFavorites').addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin menghapus semua favorit?')) {
            localStorage.removeItem('museum_favorites');
            loadFavorites();
            showNotification('Semua favorit telah dihapus', 'warning');
        }
    });
});

function loadFavorites(filter = 'all') {
    const favorites = getFavorites();
    const container = document.getElementById('favoritesContainer');
    const emptyState = document.getElementById('emptyState');

    // Filter favorites
    const filteredFavorites = filter === 'all'
        ? favorites
        : favorites.filter(item => item.type === filter);

    if (filteredFavorites.length === 0) {
        container.innerHTML = '';
        emptyState.style.display = 'block';
        return;
    }

    emptyState.style.display = 'none';
    container.innerHTML = '';

    filteredFavorites.forEach(item => {
        const li = document.createElement('li');
        li.className = 'col-sm-4';

        // Get route based on type
        const detailRoute = item.type === 'gallery'
            ? `{{ url('gallery') }}/${item.slug}`
            : `{{ url('situs-sejarah') }}/${item.slug}`;

        li.innerHTML = `
            <div class="inn-sec position-relative">
                <span class="tag">${truncate(item.kategori, 30)}</span>
                <img class="img-responsive"
                     src="${item.gambar || 'https://upload.wikimedia.org/wikipedia/commons/1/14/No_Image_Available.jpg'}"
                     alt="${item.nama}">
                <div class="detail">
                    <a href="${detailRoute}">${item.nama}</a>
                    <p><span>KATEGORI</span>: ${item.kategori}</p>
                    <p class="text-muted small mb-0">
                        <i class="fa-regular fa-clock"></i>
                        Difavoritkan: ${formatDate(item.favoritedAt)}
                    </p>
                </div>
            </div>
        `;

        container.appendChild(li);
    });
}

function removeFavorite(itemId, event) {
    event.preventDefault();
    event.stopPropagation();

    if (confirm('Hapus item ini dari favorit?')) {
        let favorites = getFavorites();
        favorites = favorites.filter(item => item.id !== itemId);
        saveFavorites(favorites);
        loadFavorites(document.querySelector('.filter-btn.active').getAttribute('data-filter'));
        showNotification('Item telah dihapus dari favorit', 'info');
    }
}

function getFavorites() {
    const favorites = localStorage.getItem('museum_favorites');
    return favorites ? JSON.parse(favorites) : [];
}

function saveFavorites(favorites) {
    localStorage.setItem('museum_favorites', JSON.stringify(favorites));
}

function truncate(str, length) {
    if (!str) return '';
    return str.length > length ? str.substring(0, length) + '...' : str;
}

function formatDate(dateString) {
    if (!dateString) return 'Tidak diketahui';
    const date = new Date(dateString);
    const now = new Date();
    const diff = now - date;

    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) return `${days} hari yang lalu`;
    if (hours > 0) return `${hours} jam yang lalu`;
    if (minutes > 0) return `${minutes} menit yang lalu`;
    return 'Baru saja';
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed top-0 start-50 translate-middle-x mt-3`;
    notification.style.zIndex = '9999';
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 2000);
}
</script>
@endpush
@endsection
