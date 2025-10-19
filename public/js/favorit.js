// Favorite functionality
document.addEventListener('DOMContentLoaded', function() {
    const favoriteBtn = document.getElementById('favoriteBtn');

    if (favoriteBtn) {
        const itemId = favoriteBtn.getAttribute('data-id');

        // Check if item is already favorited
        checkFavoriteStatus(itemId);

        // Handle favorite button click
        favoriteBtn.addEventListener('click', function() {
            toggleFavorite(itemId);
        });
    }
});

function checkFavoriteStatus(itemId) {
    const favorites = getFavorites();
    const favoriteBtn = document.getElementById('favoriteBtn');
    const icon = favoriteBtn.querySelector('i');

    if (favorites.includes(itemId)) {
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

function toggleFavorite(itemId) {
    let favorites = getFavorites();
    const favoriteBtn = document.getElementById('favoriteBtn');
    const icon = favoriteBtn.querySelector('i');

    if (favorites.includes(itemId)) {
        // Remove from favorites
        favorites = favorites.filter(id => id !== itemId);
        icon.classList.remove('fa-solid');
        icon.classList.add('fa-regular');
        favoriteBtn.classList.remove('btn-danger');
        favoriteBtn.classList.add('btn-outline-danger');

        // Show notification
        showNotification('Dihapus dari favorit', 'info');
    } else {
        // Add to favorites
        favorites.push(itemId);
        icon.classList.remove('fa-regular');
        icon.classList.add('fa-solid');
        favoriteBtn.classList.remove('btn-outline-danger');
        favoriteBtn.classList.add('btn-danger');

        // Show notification
        showNotification('Ditambahkan ke favorit', 'success');
    }

    // Save to localStorage
    saveFavorites(favorites);
}

function getFavorites() {
    const favorites = localStorage.getItem('museum_favorites');
    return favorites ? JSON.parse(favorites) : [];
}

function saveFavorites(favorites) {
    localStorage.setItem('museum_favorites', JSON.stringify(favorites));
}

function showNotification(message, type) {
    // Simple notification (you can replace with better UI library like toastr)
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} position-fixed top-0 start-50 translate-middle-x mt-3`;
    notification.style.zIndex = '9999';
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 2000);
}
