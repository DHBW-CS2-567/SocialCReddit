<?php include "header.php"; ?>

<body>
    <?php
    require_once "include/topicbar.php";
    $post_id = isset($_GET['id']) ? $_GET['id'] : null; // get post id from url or set it null if not there
    if ($post_id) {
        $post_content = get_post_content(post_id: $post_id);
        $post_comments = get_post_comments(post_id: $post_id);
        echo '<div class="post-content">';
        echo '<h2>' . htmlspecialchars($post_content['Content']) . '</h2>'; // Display post content
        $date = date_create($post_content['DateCreated']);
        echo '<p class="post-meta">Posted by ' . htmlspecialchars($post_content['username']) . ' on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
        echo '<p class="post-meta">Likes: ' . htmlspecialchars($post_content['Likes']) . '</p>';
        echo '<p class="post-meta">Date Created: ' . htmlspecialchars($post_content['DateCreated']) . '</p>';
        echo '<p class="post-meta">Social Credit: ' . htmlspecialchars($post_content['SocialCredit']) . '</p>';
        echo '<div class="post-comments">';
        if ($post_comments) {
            foreach ($post_comments as $comment) {
                echo '<div class="comment">';
                echo '<p>' . htmlspecialchars($comment['Content']) . '</p>';
                $date = date_create($comment['created_at']);
                echo '<p class="comment-meta">Commented by ' . htmlspecialchars($comment['username']) . ' on ' . date_format($date, 'F j, Y, g:i a') . '</p>';
                echo '</div>';
            }

        } else {
            echo '<p>No comments yet.</p>';

        }
        echo '</div>';
        echo '<div class="comment">';
        echo '<form action="include/add_comment.php" method="POST" id="commentForm">';
        echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post_id) . '">';
        echo '<textarea name="comment" placeholder="Add a comment..." required id="commentTextarea"></textarea>';
        echo '<button type="button" id="submitCommentBtn">Submit</button>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<p>No Post under this ID found.</p>';
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
