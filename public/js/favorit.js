// Favorite functionality
document.addEventListener('DOMContentLoaded', function() {
    const favoriteBtn = document.getElementById('favoriteBtn');

    if (favoriteBtn) {
        const itemId = favoriteBtn.getAttribute('data-id');
        const itemData = {
            id: itemId,
            nama: favoriteBtn.getAttribute('data-nama'),
            gambar: favoriteBtn.getAttribute('data-gambar'),
            kategori: favoriteBtn.getAttribute('data-kategori'),
            slug: favoriteBtn.getAttribute('data-slug'),
            type: favoriteBtn.getAttribute('data-type') || 'gallery' // gallery, situs-sejarah, dll
        };

        // Check if item is already favorited
        checkFavoriteStatus(itemId);

        // Handle favorite button click
        favoriteBtn.addEventListener('click', function() {
            toggleFavorite(itemData);
        });
    }
});

function checkFavoriteStatus(itemId) {
    const favorites = getFavorites();
    const favoriteBtn = document.getElementById('favoriteBtn');
    const icon = favoriteBtn.querySelector('i');

    const isFavorited = favorites.some(item => item.id === itemId);

    if (isFavorited) {
        // Item is favorited
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');
        favoriteBtn.classList.remove('btn-outline-danger');
        favoriteBtn.classList.add('btn-danger');
    } else {
        // Item is not favorited
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
        favoriteBtn.classList.remove('btn-danger');
        favoriteBtn.classList.add('btn-outline-danger');
    }
}

function toggleFavorite(itemData) {
    let favorites = getFavorites();
    const favoriteBtn = document.getElementById('favoriteBtn');
    const icon = favoriteBtn.querySelector('i');

    const existingIndex = favorites.findIndex(item => item.id === itemData.id);

    if (existingIndex !== -1) {
        // Remove from favorites
        favorites.splice(existingIndex, 1);
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
        favoriteBtn.classList.remove('btn-danger');
        favoriteBtn.classList.add('btn-outline-danger');

        // Show notification
        showNotification('Dihapus dari favorit', 'info');
    } else {
        // Add to favorites with timestamp
        itemData.favoritedAt = new Date().toISOString();
        favorites.push(itemData);
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');
        favoriteBtn.classList.remove('btn-outline-danger');
        favoriteBtn.classList.add('btn-danger');

        // Show notification
        showNotification('Ditambahkan ke favorit', 'success');
    }

    // Save to localStorage
    saveFavorites(favorites);
    console.log('Total favorit saat ini:', favorites);
}

function getFavorites() {
    const favorites = localStorage.getItem('museum_favorites');
    return favorites ? JSON.parse(favorites) : [];
}

function saveFavorites(favorites) {
    localStorage.setItem('museum_favorites', JSON.stringify(favorites));
}

function showNotification(message, type) {
    // Simple notification
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed top-0 start-50 translate-middle-x mt-3`;
    notification.style.zIndex = '9999';
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 2000);
}

// Function to get favorites count (bonus)
function getFavoritesCount() {
    return getFavorites().length;
}

// Function to clear all favorites (bonus)
function clearAllFavorites() {
    localStorage.removeItem('museum_favorites');
    showNotification('Semua favorit telah dihapus', 'warning');
}
