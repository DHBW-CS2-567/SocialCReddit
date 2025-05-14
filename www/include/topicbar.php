<?php

// horizontel bar with the popular topics, from the database (content_managment.php) be clickable to open /topic.php?name=topicname
        $popular_topics = get_topics(); // Fetch topics using your existing function

        if ($popular_topics && !empty($popular_topics)) {
            echo '<div class="popular-topics-bar">';
            echo '<button class="burger-menu" onclick="toggleMenu()">☰</button>';
            echo '<div class="topics-list">';
            echo '<span>Popular Topics: </span>';
            foreach ($popular_topics as $topic) {
                echo '<a href="topic.php?name=' . urlencode($topic['Name']) . '">' . htmlspecialchars($topic['Name']) . '</a>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="popular-topics-bar"><span>No popular topics found.</span></div>';
        }
?>