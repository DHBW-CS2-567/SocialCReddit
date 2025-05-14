<!DOCTYPE html>
<html lang="en">
    <head>
    <title>SocialCReddit</title>
    <meta charset="UTF-8">
    <?php include "header.php"; ?>
    </head>
    <body>
    <?php
        include "include/topicbar.php"; // Include the topic bar

        // Homefeed with the newest posts
        $home_feed_posts = get_homefeed(sort_order: 'ASC'); // Fetches posts using your function

        if ($home_feed_posts && !empty($home_feed_posts)) {
            echo '<div class="home-feed">';
            echo '<h2>Latest Posts</h2>';
            foreach ($home_feed_posts as $post) {
                echo '<a href="post.php?id=' . $post['ID'] . '" class="post-preview-link">';
                echo '<div class="post-preview">';
                    echo '<h3>' . htmlspecialchars($post['Content']) . '</h3>'; // Display post content
                    $date = date_create($post['created_at']);
                    echo '<p class="post-meta">Posted on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
                echo '</div>';
                echo '</a>'; // Close the link
              
            }
            echo '</div>';
        } else {
            echo '<div class="home-feed"><p>No posts to display yet.</p></div>';
        }
       
        ?>

    </body>
</html>

