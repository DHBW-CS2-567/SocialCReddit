<<<<<<< HEAD
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <<link rel="stylesheet" href="assets/css/main.css">
  <title>SocialCReddit</title>
</head>
<body>
  <!-- Header -->
  <header style="display: flex; justify-content: space-between; align-items: center; padding: 1em; background-color: #1a1a1a; color: white;">
    <div>
      <h1 style="display: inline; color: white;"><span style="color: white;">SocialC</span><span style="color: #f15e15;">Reddit</span></h1>
      <span style="margin-left: 1em;">DAS FORUM FÜR ALLE OHNE SCHLECHTEN HINTERGEDANKEN</span>
    </div>
    <div>
      <span>SCR: 9999999</span>
      <span style="margin-left: 1em;">👤</span>
    </div>
  </header>
=======
<?php include "header.php"; ?>

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
>>>>>>> origin/devel

  <!-- Navigation Tabs -->
  <nav style="display: flex; justify-content: center; gap: 1em; margin: 1em;">
    <button>Popular</button>
    <button>Topic 1</button>
    <button>Topic 2</button>
    <button>Topic 3</button>
    <button>Topic 4</button>
    <button>More</button>
  </nav>

  <!-- Main Content -->
  <main style="width: 80%; margin: auto;">
    <!-- Repeat this block for each post -->
    <div style="display: flex; background-color: #ccc; padding: 1em; margin-bottom: 1em; border-radius: 8px;">
      <div style="width: 20%; text-align: center;">
        <div>👤</div>
        <div>User1</div>
        <div>Scr: 1234567</div>
      </div>
      <div style="width: 80%;">
        <p>
          Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla Bla
        </p>
        <div style="display: flex; justify-content: space-between; font-size: 0.8em; color: gray;">
          <span>Topic</span>
          <span>00:00, 01.01.2000</span>
        </div>
      </div>
    </div>

    <!-- More posts... -->
    <!-- Just copy and paste the above block -->
    
    <!-- Load More -->
    <div style="text-align: center; margin: 2em;">
      <button>▼</button>
    </div>
  </main>
</body>
</html>
