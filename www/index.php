<?php include "header.php"; ?>
<body>
    <?php require_once "include/topicbar.php" ?>
    <div id="feed-container"></div>

    <script>
    <?php
    session_start();
    $uname_isset = isset($_SESSION['username']) ? 'true' : 'false';
    echo 'var loggedIn = "' . $uname_isset . '";'; ?>

    window.addEventListener('DOMContentLoaded', function() {
        loadFeed();
    });

    if(loggedIn) {
        setInterval(loadFeed, 1000);
    }
    //Merge conflict
    window.addEventListener('DOMContentLoaded', loadFeed);

    setInterval(loadFeed, 10000);

    </script>

    <script src="assets/js/main.js"></script>
</body>
</html>
