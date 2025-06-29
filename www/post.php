<?php include "header.php"; ?>
<link rel="stylesheet" href="assets/css/post.css">

<body>
    <?php
    require_once "include/topicbar.php";
    $post_id = isset($_GET['id']) ? $_GET['id'] : null;
    
    if ($post_id) {
        $post_content = get_post_content(post_id: $post_id);
        $post_comments = get_post_comments(post_id: $post_id);
        
        echo '<div class="post-content">';
        echo '<h2>' . htmlspecialchars($post_content['Content']) . '</h2>';
        
        $date = date_create($post_content['DateCreated']);
        echo '<div class="post-meta">';
        echo '<p>Posted by <strong>' . htmlspecialchars($post_content['username']) . '</strong> on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
        echo '<p>Likes: ' . htmlspecialchars($post_content['Likes']) . ' | Social Credit: ' . htmlspecialchars($post_content['SocialCredit']) . '</p>';
        echo '</div>';
        
        // Comments section
        echo '<div class="post-comments">';
        echo '<h3>Comments (' . (is_array($post_comments) ? count($post_comments) : 0) . ')</h3>';
        
        if ($post_comments && is_array($post_comments)) {
            foreach ($post_comments as $comment) {
                echo '<div class="comment">';
                echo '<div class="comment-header">';
                echo '<div class="comment-user-icon">';
                echo strtoupper(substr($comment['username'], 0, 1));
                echo '</div>';
                echo '<div class="comment-user-info">';
                echo '<div class="comment-username">' . htmlspecialchars($comment['username']) . '</div>';
                $comment_date = date_create($comment['created_at']);
                echo '<div class="comment-meta">Posted on ' . date_format($comment_date, 'F j, Y, g:i a') . '</div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="comment-content">' . htmlspecialchars($comment['Content']) . '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="no-comments">No comments yet. Be the first to comment!</div>';
        }
        
        // Comment form
        echo '<div class="comment-form">';
        echo '<h4>Add a Comment</h4>';
        echo '<form action="include/add_comment.php" method="POST" id="commentForm">';
        echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post_id) . '">';
        echo '<textarea name="comment" placeholder="Share your thoughts..." required id="commentTextarea"></textarea>';
        echo '<button type="button" id="submitCommentBtn">Post Comment</button>';
        echo '</form>';
        echo '</div>';
        
        echo '</div>'; // Close post-comments
        echo '</div>'; // Close post-content
    } else {
        echo '<div class="post-content">';
        echo '<p class="no-comments">No post found with this ID.</p>';
        echo '</div>';
        exit();
    }
    ?>

    <!-- Confirmation Dialog for Comments -->
    <div id="confirmCommentDialog" title="Confirm Comment" style="display: none;">
        <p>Are you sure you want to post this comment?</p>
        <div style="margin-top: 15px;">
            <strong>Your comment:</strong><br>
            <span id="confirmCommentContent" style="font-style: italic;"></span>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

    <script>
        $(function() {
            // Initialize confirmation dialog
            $("#confirmCommentDialog").dialog({
                autoOpen: false,
                modal: true,
                width: 400,
                height: 250,
                resizable: false,
                buttons: {
                    "Yes, Post Comment": function() {
                        $(this).dialog("close");
                        $("#commentForm").submit();
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });

            // Handle submit comment button click
            $("#submitCommentBtn").click(function() {
                var commentText = $("#commentTextarea").val();

                if (commentText.trim() === "") {
                    alert("Please enter a comment before submitting.");
                    return;
                }

                // Update confirmation dialog with current comment
                $("#confirmCommentContent").text(commentText.length > 150 ? commentText.substring(0, 150) + "..." : commentText);

                // Show confirmation dialog
                $("#confirmCommentDialog").dialog("open");
            });
        });
    </script>

</body>
</html>
