<!DOCTYPE html>
<html lang="en">

<head>
    <title>SocialCReddit - Create Post</title>
    <meta charset="UTF-8">
    <?php include "header.php"; ?>
</head>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic_from_form = $_POST['topic'];
    $content = $_POST['content'];
    $userID = $_SESSION['userID']; // Stellen Sie sicher, dass 'userID' in der Session korrekt gesetzt ist
    $new_post_id = create_post($userID, $topic_from_form, $content);
    if ($new_post_id) {
        // create_post gibt jetzt die neue Beitrags-ID oder false zurück
        header('Location: post.php?id=' . $new_post_id);
        exit(); 
    } else {

        echo "<p>Error creating post. Please try again.</p>";
    }
        exit(); // Redirect to the create page with an error
    }
?>

<body>
    <?php
    // Side to create new posts, topics can only created by an admin, after an request
    // Fetch all topics for the autocomplete
    $all_topics_data = get_topics(0);
    $topic_names = [];
    if ($all_topics_data) {
        foreach ($all_topics_data as $topic_item) {
            $topic_names[] = htmlspecialchars($topic_item['Name']); // htmlspecialchars to prevent XSS
        }
    }
    ?>

    <h2>Create a New Post</h2>
    <form action="create.php" method="post">
        <div id="create_form">
            <div>
                <label for="topic"><b>Topic</b></label><br>
                <input type="text" placeholder="Start typing a topic..." name="topic" id="topic_input" required>
            </div>
            <br>
            <div>
                <label for="content"><b>Content</b></label><br>
                <textarea placeholder="I have something to tell" name="content" rows="5" cols="50" required></textarea>
            </div>
            <br>
            <button type="submit">Create Post</button>
        </div>
    </form>

    <script>
        // jQuery UI Autocomplete for topic input
        // This will provide suggestions as the user types
        $(function() {
            var availableTopics = <?php echo json_encode($topic_names); ?>;
            $("#topic_input").autocomplete({
                source: availableTopics
            });
        });
    </script>

</body>

</html>