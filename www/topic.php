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

        // Get the topic name from the URL
        $topic_name = isset($_GET['name']) ? $_GET['name'] : null;
        if ($topic_name) {
            // Fetch posts for the specific topic
            $topic_posts = get_posts(topic_name: $topic_name); // Adjust this function to accept topic name or ID
        } else {
            echo '<p>No topic specified.</p>';
            exit();
        }

        // Display the posts for the topic
        if ($topic_posts && !empty($topic_posts)) {
            echo '<div class="home-feed">';
            echo '<h1>' . htmlspecialchars($topic_name) . '</h1>';
            foreach ($topic_posts as $post) {
                echo '<div class="post-preview">';
                // Assuming 'Name' contains the post title or content preview
                // and 'created_at' is the timestamp
                // You might want to fetch UserID and then get the username
                echo '<h3><a href="post.php?id=' . $post['ID'] . '">' . htmlspecialchars($post['Content']) . '</a></h3>'; // Link to full post
                // Format the date for better readability
                $date = date_create($post['created_at']);
                echo '<p class="post-meta">Posted on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
                // You could add a snippet of the post content here if 'Name' is just the title
                // echo '<p>' . htmlspecialchars(substr($post['Content'], 0, 150)) . '...</p>'; // Example for content snippet
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="topic-posts"><p>No posts to display in this topic yet.</p></div>';
        }

        ?>
        

    </body>
</html>

