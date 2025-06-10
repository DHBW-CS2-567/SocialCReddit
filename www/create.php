<!DOCTYPE html>
<html lang="en">

<head>
    <title>SocialCReddit - Create Post</title>
    <meta charset="UTF-8">
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="assets/css/create.css">
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
    <div class="create">
        <h2>Create a New Post</h2>
        <form id="createForm" action="create.php" method="post">
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
                <input id="export" type="button" value="Export" onclick="download();" />
                <input id="import" type="button" value="Import" onclick="document.getElementById('importFile').click();" />
                <input type="file" id="importFile" accept=".json" style="display: none;" onchange="importPost();" />
            </div>
        </form>
    </div>

    <script>
        // jQuery UI Autocomplete for topic input
        // This will provide suggestions as the user types
        $(function() {
            var availableTopics = <?php echo json_encode($topic_names); ?>;
            $("#topic_input").autocomplete({
                source: availableTopics
            });
        });

        function download() {
            // Erstelle strukturierte JSON-Ausgabe
            var postData = {
                topic: $("#topic_input").val(),
                content: $("textarea[name='content']").val(),
                timestamp: new Date().toISOString()
            };
            
            var formData = JSON.stringify(postData, null, 2);
            var a = document.createElement("a");
            var file = new Blob([formData], {type: 'application/json'});
            a.href = URL.createObjectURL(file);
            a.download = "post.json";
            a.click();
        }

        function importPost() {
            const fileInput = document.getElementById('importFile');
            const file = fileInput.files[0];
            
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                try {
                    const postData = JSON.parse(e.target.result);
                    
                    // Fülle die Form-Felder mit den importierten Daten
                    if (postData.topic) {
                        $("#topic_input").val(postData.topic);
                    }
                    if (postData.content) {
                        $("textarea[name='content']").val(postData.content);
                    }
                } catch (error) {
                    alert('Error parsing JSON file: ' + error.message);
                }
            };
            
            reader.readAsText(file);
        }
        
    </script>

</body>

</html>