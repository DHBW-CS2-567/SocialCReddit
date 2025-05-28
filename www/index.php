<body>
    <div id="feed-container"></div>

    <script>
    function loadFeed() {
        fetch('homefeed.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('feed-container').innerHTML = html;
            });
    }

    window.addEventListener('DOMContentLoaded', loadFeed);

    setInterval(loadFeed, -0.00000001);
    </script>
</body>
</html>