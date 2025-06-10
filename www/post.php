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
/* <<<<<<< HEAD */

        // Display post similar to comment layout
        echo '<div class="post-main">';

        // Left side: User info, date, and likes (similar to comment layout)
        echo '<div class="post-left">';
        echo '<div class="post-user-icon">';
        echo strtoupper(substr($post_content['username'], 0, 1));
        echo '</div>';
        echo '<div class="post-user-info">';
        echo '<div class="post-username">' . htmlspecialchars($post_content['username']) . '</div>';
        echo '<div class="post-social-credit">SCr: ' . htmlspecialchars($post_content['SocialCredit']) . '</div>';
        echo '</div>';
        $date = date_create($post_content['DateCreated']);
        echo '<div class="post-date">' . date_format($date, 'M j, Y<br>g:i a') . '</div>';

        // Likes section with buttons for post
        echo '<div class="post-likes-section">';
        echo '<div class="post-likes" id="post-likes-' . $post_id . '">♥ ' . htmlspecialchars($post_content['Likes']) . '</div>';
        echo '<div class="post-like-buttons">';
        echo '<button class="post-like-btn" onclick="likePost(' . $post_id . ', \'like\')">👍</button>';
        echo '<button class="post-dislike-btn" onclick="likePost(' . $post_id . ', \'dislike\')">👎</button>';
        echo '</div>';
        echo '</div>';

        echo '</div>'; // Close post-left

        // Right side: Post content
        echo '<div class="post-main-content">';
        echo '<h2>' . htmlspecialchars($post_content['Content']) . '</h2>';
        echo '</div>'; // Close post-main-content

        echo '</div>'; // Close post-main

/* ======= */
/*         echo '<h2>' . htmlspecialchars($post_content['Content']) . '</h2>'; */
/**/
/*         $date = date_create($post_content['DateCreated']); */
/*         echo '<div class="post-meta">'; */
/*         echo '<p>Posted by <strong>' . htmlspecialchars($post_content['username']) . '</strong> on ' . date_format($date, 'F j, Y, g:i a') . '</p>'; */
/*         echo '<p>Likes: ' . htmlspecialchars($post_content['Likes']) . ' | Social Credit: ' . htmlspecialchars($post_content['SocialCredit']) . '</p>'; */
/*         echo '</div>'; */
/**/
/* >>>>>>> devel_IO */
        // Comments section
        echo '<div class="post-comments">';
        echo '<h3>Comments (' . (is_array($post_comments) ? count($post_comments) : 0) . ')</h3>';

        if ($post_comments && is_array($post_comments)) {
            foreach ($post_comments as $comment) {
                echo '<div class="comment">';

                // Left side: User info, date, and likes
                echo '<div class="comment-left">';
                echo '<div class="comment-user-icon">';
                echo strtoupper(substr($comment['username'], 0, 1));
                echo '</div>';
                echo '<div class="comment-user-info">';
                echo '<div class="comment-username">' . htmlspecialchars($comment['username']) . '</div>';
                echo '<div class="comment-social-credit">SCr: ' . htmlspecialchars($comment['SocialCredit']) . '</div>';
                echo '</div>';
                $comment_date = date_create($comment['created_at']);
                echo '<div class="comment-date">' . date_format($comment_date, 'M j, Y<br>g:i a') . '</div>';

                // Likes section with buttons
                echo '<div class="comment-likes-section">';
                echo '<div class="comment-likes" id="likes-' . $comment['ID'] . '">♥ ' . htmlspecialchars($comment['Likes']) . '</div>';
                echo '<div class="like-buttons">';
                echo '<button class="like-btn" onclick="likeComment(' . $comment['ID'] . ', \'like\', ' . $post_id . ')">👍</button>';
                echo '<button class="dislike-btn" onclick="likeComment(' . $comment['ID'] . ', \'dislike\', ' . $post_id . ')">👎</button>';
                echo '</div>';
                echo '</div>';

                echo '</div>';

                // Middle: Comment content
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
        // Like/Dislike functionality for posts
        function likePost(postId, action) {
            fetch('include/like_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'post_id=' + postId + '&action=' + action
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the likes display
                    document.getElementById('post-likes-' + postId).innerHTML = '♥ ' + data.new_likes;
                } else {
                    alert('Error: ' + (data.error || 'Unknown error occurred'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the like count.');
            });
        }

        // Like/Dislike functionality for comments
        function likeComment(commentId, action, postId) {
// <<<<<<< HEAD
// =======
//             // Disable buttons temporarily to prevent double-clicking
//             var likeBtn = document.querySelector('.comment .like-buttons .like-btn');
//             var dislikeBtn = document.querySelector('.comment .like-buttons .dislike-btn');
//
// >>>>>>> devel_IO
            fetch('include/like_comment.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'comment_id=' + commentId + '&action=' + action + '&post_id=' + postId
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the likes display
                    document.getElementById('likes-' + commentId).innerHTML = '♥ ' + data.new_likes;
                } else {
                    alert('Error: ' + (data.error || 'Unknown error occurred'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the like count.');
            });
        }

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
