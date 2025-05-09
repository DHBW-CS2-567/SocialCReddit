<?php
require "database_connector.php";
// To be used for creating posts and comments, and to get posts and comments from the database. 
function get_posts($topic_id = null, $topic_name = null, $limit = 10, $sort_by = "created_at", $sort_order = "DESC")
{
    $conn = getDatabaseConnection();
    if ($topic_id) {
        // If topic_id is provided, fetch posts for that topic
        $sql = 'SELECT * FROM posts WHERE TopicID = "' . $topic_id . '" ORDER BY "' . $sort_by . '" "' . $sort_order . '"LIMIT ' . $limit;
    } elseif ($topic_name) {
        // If topic_name is provided, fetch posts for that topic
        $sql = 'SELECT * FROM posts WHERE TopicID = (SELECT `ID` FROM topic WHERE topic.name = "'. $topic_name .'") ORDER BY "' . $sort_by . '" "' . $sort_order . '"LIMIT ' . $limit;
    } else {
        // If neither is provided, fetch all posts
        $sql = 'SELECT * FROM posts ORDER BY "' . $sort_by . '" "' . $sort_order . '"LIMIT ' . $limit;
    }

    $result = $conn->query($sql);
    $conn->close(); // Close the database connection

    if ($result->num_rows > 0) {
        $posts = array();
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    } else {
        return false; // No posts found
    }
    // rückgabe der function sind die posts in einem array wie diesem: [0] => Array ( [ID] => 1 [TopicID] => 8 [Name] => #Willkommen im Forum der CCP. Schreibt rein worauf ihr bock habt aber bleibt im topic. Meinungsfreiheit wird hier *sehr* wertgeschätzt. [Likes] => 0 [Pinned] => 1 [UserID] => 3 )
    //um zum beispiel den name zu wollen muss mann nur $posts[0]['Name'] aufrufen fur den ersten post, alle einfach foreach schleife

}

function get_topics($limit = 10, $sort_by = "popular")
{
    $conn = getDatabaseConnection();
    // select topics with the most posts
    if ($sort_by == "popular") {
        $sql = 'SELECT * FROM topic ORDER BY (SELECT COUNT(*) FROM posts WHERE posts.TopicID = topic.ID) DESC LIMIT ' . $limit;
    } else {
        // select topics with the most likes
        $sql = 'SELECT * FROM topic ORDER BY ID DESC LIMIT ' . $limit;
    }
    $result = $conn->query($sql);
    $conn->close(); // Close the database connection

    if ($result->num_rows > 0) {
        $topics = array();
        while ($row = $result->fetch_assoc()) {
            $topics[] = $row;
        }
        return $topics;
    } else {
        return false; // No topics found
    }

    // rückgabe Array ( [0] => Array ( [ID] => 8 [Name] => Announcements ) [1] => Array ( [ID] => 9 [Name] => Katzen ) [2] => Array ( [ID] => 1 [Name] => Essen ) [3] => Array ( [ID] => 2 [Name] => Videospiele ) [4] => Array ( [ID] => 3 [Name] => Fischen ) [5] => Array ( [ID] => 4 [Name] => Security ) [6] => Array ( [ID] => 5 [Name] => Random ) [7] => Array ( [ID] => 6 [Name] => Politik ) [8] => Array ( [ID] => 7 [Name] => Programmieren ) [9] => Array ( [ID] => 10 [Name] => Lustige Bilder ) )
}


function get_homefeed($limit = 10, $sort_by = "created_at", $sort_order = "DESC")
{
    $conn = getDatabaseConnection();
    $sql = 'SELECT * FROM posts ORDER BY "' . $sort_by . '" "' . $sort_order . '"LIMIT ' . $limit;
    $result = $conn->query($sql);
    $conn->close(); // Close the database connection

    if ($result->num_rows > 0) {
        $posts = array();
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
        return $posts;
    } else {
        return false; // No posts found
    }
}
