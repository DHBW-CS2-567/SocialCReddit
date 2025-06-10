<?php
session_start();
require_once "database/content_managment.php";

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['userID'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment_id = isset($_POST['comment_id']) ? intval($_POST['comment_id']) : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : null;

    if (!$comment_id || !$action || !$post_id || !in_array($action, ['like', 'dislike'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
        exit();
    }

    $conn = getDatabaseConnection();
    
    // Get current likes count
    $sql = "SELECT Likes FROM kommentare WHERE ID = " . $comment_id;
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_likes = intval($row['Likes']);
        
        // Update likes based on action
        if ($action === 'like') {
            $new_likes = $current_likes + 1;
        } else { // dislike
            $new_likes = $current_likes - 1;
        }
        
        // Update the database
        $update_sql = "UPDATE kommentare SET Likes = " . $new_likes . " WHERE ID = " . $comment_id;
        
        if ($conn->query($update_sql) === TRUE) {
            $conn->close();
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'new_likes' => $new_likes]);
        } else {
            $conn->close();
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Database error: ' . $conn->error]);
        }
    } else {
        $conn->close();
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Comment not found']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}
exit();
?>