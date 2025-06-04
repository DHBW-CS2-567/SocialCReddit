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

    <?php
    session_start();
    $uname_isset = isset($_SESSION['username']) ? 'true' : 'false';
    echo 'var loggedIn = "' . $uname_isset . '";'; ?>

    if(loggedIn) {
        setInterval(loadFeed, 1000);
    }
    </script>
</body>
</html>
