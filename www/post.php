<?php include "header.php"; ?>

<body>
    <?php
    include "include/topicbar.php";
    $post_id = isset($_GET['id']) ? $_GET['id'] : null; // get post id from url or set it null if not there
    if ($post_id) {
        $post_content = get_post_content(post_id: $post_id); 
        $post_comments = get_post_comments(post_id: $post_id); 
        echo '<div class="post-content">';
        echo '<h2>' . htmlspecialchars($post_content['Content']) . '</h2>'; // Display post content
        $date = date_create($post_content['created_at']);
        echo '<p class="post-meta">Posted by ' . htmlspecialchars($post_content['username']) . ' on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
        echo '<p class="post-meta">Likes: ' . htmlspecialchars($post_content['Likes']) . '</p>';
        echo '<p class="post-meta">Date Created: ' . htmlspecialchars($post_content['DateCreated']) . '</p>';
        echo '<p class="post-meta">Social Credit: ' . htmlspecialchars($post_content['SocialCredit']) . '</p>';
        echo '<div class="post-comments">';
        if ($post_comments) {
            foreach ($post_comments as $comment) {
                echo '<div class="comment">';
                echo '<p>' . htmlspecialchars($comment['Content']) . '</p>';
                $date = date_create($comment['created_at']);
                echo '<p class="comment-meta">Commented by ' . htmlspecialchars($comment['username']) . ' on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No comments yet.</p>';
        }
    } else {
        echo '<p>No Post under this ID found.</p>';
        exit();
    }


    ?>
</body>

</html>