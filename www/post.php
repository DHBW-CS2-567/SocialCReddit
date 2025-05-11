<!DOCTYPE html>
<html lang="en">

<head>
    <title>SocialCReddit</title>
    <meta charset="UTF-8">
    <?php include "header.php"; ?>
</head>

<body>
    <?php
    include "include/topicbar.php";
    $post_id = isset($_GET['id']) ? $_GET['id'] : null; // get post id from url or set it null if not there
    if ($post_id) {
        $post_content = get_post_content(post_id: $post_id); // TODO: soll content, erstelldatum und ersteller name und id zurückgeben
        //  $comments = get_comments(post_id: $post_id); TODO: soll commentar und ersteller likes und pinned zurückgeben
    } else {
        echo '<p>No Post under this ID found.</p>';
        exit();
    }


    ?>
</body>

</html>