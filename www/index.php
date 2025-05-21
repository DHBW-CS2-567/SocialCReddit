<?php include "header.php"; ?>

<body>
    <?php include "include/topicbar.php"; ?>

    <div id="feed-container"></div>

    <script>
    function loadFeed() {
        fetch('homefeed.php')
            .then(response => response.text())
            .then(html => {
                document.getElementById('feed-container').innerHTML = html;
            });
    }

    // Load feed on page load
    window.addEventListener('DOMContentLoaded', loadFeed);

    // Reload feed every 10 seconds
    setInterval(loadFeed, 10000);
    </script>
</body>
</html>