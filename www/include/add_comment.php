<?php
session_start();
require_once "database/content_managment.php";
require_once "database/mysql_input_valid.php";

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['userID'])) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : null;
    $comment_content = isset($_POST['comment']) ? $_POST['comment'] : null;
    $user_id = $_SESSION['userID'];

    // Validate inputs
    if (!$post_id || !$comment_content || !sqlinjection_test($comment_content)) {
        header('Location: ../post.php?id=' . $post_id . '&error=invalid_input');
        exit();
    }

    // Add comment to database
    $conn = getDatabaseConnection();
    $sql = 'INSERT INTO kommentare (PostID, Content, UserID, Likes) VALUES (' . 
           intval($post_id) . ', "' . 
           $conn->real_escape_string($comment_content) . '", ' . 
           intval($user_id) . ', 0)';
    
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header('Location: ../post.php?id=' . $post_id . '&success=comment_added');
    } else {
        $conn->close();
        header('Location: ../post.php?id=' . $post_id . '&error=comment_failed');
    }
} else {
    header('Location: ../index.php');
}
exit();
?>