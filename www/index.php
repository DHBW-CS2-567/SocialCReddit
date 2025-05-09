<!DOCTYPE html>
<html lang="en">
    <head>
    <title>SocialCReddit</title>
    <meta charset="UTF-8">
    <?php include "header.php"; ?>
    </head>
    <body>
    <?php
        // if user not logged in, redirect to login page check via session from login.php

        require_once "include/database/content_managment.php"; // Include the content management file

        // horizontel bar with the popular topics, from the database (content_managment.php) be clickable to open /topic.php?name=topicname
        $popular_topics = get_topics(); // Fetch topics using your existing function

        if ($popular_topics && !empty($popular_topics)) {
            echo '<div class="popular-topics-bar">';
            echo '<span>Popular Topics: </span>';
            foreach ($popular_topics as $topic) {
                // Assuming $topic is an array like ['ID' => 1, 'Name' => 'Essen']
                // Adjust 'Name' if your array key for the topic name is different
                echo '<a href="topic.php?name=' . urlencode($topic['Name']) . '">' . htmlspecialchars($topic['Name']) . '</a>';
            }
            echo '</div>';
        } else {
            echo '<div class="popular-topics-bar"><span>No popular topics found.</span></div>';
        }


                // Homefeed with the newest posts
        $home_feed_posts = get_homefeed(); // Fetches posts using your function

        if ($home_feed_posts && !empty($home_feed_posts)) {
            echo '<div class="home-feed">';
            echo '<h2>Latest Posts</h2>';
            foreach ($home_feed_posts as $post) {
                echo '<div class="post-preview">';
                // Assuming 'Name' contains the post title or content preview
                // and 'created_at' is the timestamp
                // You might want to fetch UserID and then get the username
                echo '<h3><a href="post.php?id=' . $post['ID'] . '">' . htmlspecialchars($post['Name']) . '</a></h3>'; // Link to full post
                // Format the date for better readability
                $date = date_create($post['created_at']);
                echo '<p class="post-meta">Posted on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
                // You could add a snippet of the post content here if 'Name' is just the title
                // echo '<p>' . htmlspecialchars(substr($post['Content'], 0, 150)) . '...</p>'; // Example for content snippet
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="home-feed"><p>No posts to display yet.</p></div>';
        }
       
        ?>
        

    </body>
</html>

