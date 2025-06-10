<?php
require_once "database_connector.php";
// To be used for creating posts and comments, and to get posts and comments from the database.
function get_posts($topic_id = null, $topic_name = null, $limit = 10, $sort_by = "created_at", $sort_order = "DESC")
{
    $conn = getDatabaseConnection();
    if ($topic_id) {
        // If topic_id is provided, fetch posts for that topic
        /* $sql = 'SELECT * FROM posts WHERE TopicID = "' . $topic_id . '" ORDER BY "' . $sort_by . '" "' . $sort_order . '"LIMIT ' . $limit; */
        $sql = ['SELECT * FROM posts WHERE TopicID = ? ORDER BY ? ' . (($sort_order == "ASC")? "ASC":"DESC")  . ' LIMIT ' . (int)$limit, [$topic_id, $sort_by]];
    } elseif ($topic_name) {
        // If topic_name is provided, fetch posts for that topic
        /* $sql = 'SELECT * FROM posts WHERE TopicID = (SELECT `ID` FROM topic WHERE topic.name = "' . $topic_name . '") ORDER BY "' . $sort_by . '" "' . $sort_order . '"LIMIT ' . $limit; */
        $sql = ['SELECT * FROM posts WHERE TopicID = (SELECT `ID` FROM topic WHERE topic.name = ?) ORDER BY ? '. (($sort_order == "ASC")? "ASC":"DESC") .' LIMIT ' . (int)$limit, [$topic_name, $sort_by]];
    } else {
        // If neither is provided, fetch all posts
        /* $sql = 'SELECT * FROM posts ORDER BY "' . $sort_by . '" "' . $sort_order . '"LIMIT ' . $limit; */
        $sql = ['SELECT * FROM posts ORDER BY ? ' . (($sort_order == "ASC")? "ASC":"DESC") . ' LIMIT ' . (int)$limit, [$sort_by]];
    }

    $result = $conn->execute_query($sql[0], $sql[1]);
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
// function get single post content for the post.php site
function get_post_content($post_id)
{
    $conn = getDatabaseConnection();
    $sql = 'SELECT post.Content, post.TopicID, post.Likes, post.Pinned, user.ID, user.username, user.DateCreated, user.SocialCredit, user.isadmin, user.email FROM posts AS post JOIN users AS user ON post.UserID = user.ID WHERE post.ID = ?';
    $result = $conn->execute_query($sql, [$post_id]);
    $conn->close();
    $result = $result->fetch_assoc();
    return $result;
}

// function to get comments from a post via post_id for post.php
function get_post_comments($post_id)
{
    $conn = getDatabaseConnection();
    $sql = 'SELECT kommentare.*, users.username, users.SocialCredit FROM kommentare 
            JOIN users ON kommentare.UserID = users.ID 
            WHERE kommentare.PostID = ' . $post_id . '
            ORDER BY kommentare.created_at ASC';
    $result = $conn->execute_query($sql, [$post_id]);
    $conn->close(); // Close the database connection
    if ($result->num_rows > 0) {
        $comments = array();
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    } else {
        return false; // No comments found
    }
}

function get_topics($limit = 10, $sort_by = "popular")
{
    $conn = getDatabaseConnection();
    // select topics with the most posts
    if ($limit == 0) {
        $sql = 'SELECT * FROM topic ORDER BY (SELECT COUNT(*) FROM posts WHERE posts.TopicID = topic.ID) DESC';
    } else {
        if ($sort_by == "popular") {
            $sql = 'SELECT * FROM topic ORDER BY (SELECT COUNT(*) FROM posts WHERE posts.TopicID = topic.ID) DESC LIMIT ' . (int)$limit;
        } else {
            // select topics with the most likes
            $sql = 'SELECT * FROM topic ORDER BY ID DESC LIMIT ' . (int)$limit;
        }
    }
    $result = $conn->execute_query($sql, []);
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


function get_homefeed($limit = 10, $sort_by = "created_at", $sort_order = "ASC")
{
    $conn = getDatabaseConnection();
    $limit = (int) $limit;
    $sql = 'SELECT * FROM posts ORDER BY ? ' . (($sort_order == "ASC")? "ASC":"DESC") . ' LIMIT ' . $limit;
    $result = $conn->execute_query($sql, [$sort_by]);
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

function create_topic($name)
{
    $conn = getDatabaseConnection();
    $sql = 'INSERT INTO topic (Name) VALUES (?)';
    $result = $conn->execute_query($sql, [$name]);
    if ($result) {
        $topic_id = $conn->insert_id; // Get the ID of the newly created topic
        $conn->close(); // Close the database connection
        return $topic_id; // Return the ID of the new topic
    }
}

function create_post($userid, $topic, $content)
{
    $conn = getDatabaseConnection();

    $check_topic = 'SELECT * FROM topic WHERE Name = ?';
    $check_result = $conn->execute_query($check_topic, [$topic]);
    if ($check_result->num_rows > 0) {
        $topicid = $check_result->fetch_assoc()['ID']; // Get the ID of the existing topic
    } else {
        $topicid = create_topic($topic); // Create the topic if it doesn't exist
    }
    /* $sql = 'INSERT INTO posts (TopicID, UserID, Content, Likes, Pinned) VALUES (' . $topicid . ', ' . $userid . ', "' . $content . '", 0, 0)'; */
    $sql = 'INSERT INTO posts (TopicID, UserID, Content, Likes, Pinned) VALUES ( ?, ?, ?, 0, 0)';
    $result = $conn->execute_query($sql, [$topicid, $userid, $content]);

    if ($result) {
        $post_id = $conn->insert_id; // Get the ID of the newly created post
        $conn->close(); // Close the database connection
        return $post_id; // Return the ID of the new post
    } else {
        $conn->close(); // Close the database connection
        return false; // Return false if the post creation failed
    }
}
