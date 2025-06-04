// Global toggleMenu function for topicbar
function toggleMenu() {
    const topicsList = document.querySelector(".popular-topics-bar .topics-list");
    if (topicsList) {
        topicsList.classList.toggle("show");
    }
}

// Feed loading functionality
function loadFeed() {
    fetch('homefeed.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('feed-container').innerHTML = html;
        });
}

// Initialize when DOM is loaded
window.addEventListener('DOMContentLoaded', function() {
    loadFeed();
    
    // Start auto-refresh if user is logged in
    if (typeof loggedIn !== 'undefined' && loggedIn === 'true') {
        setInterval(loadFeed, 1000);
    }
});