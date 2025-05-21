<!DOCTYPE html>
<html lang="en">

<head>
    <title>SocialCReddit - Admin Panel</title>
    <meta charset="UTF-8">
    <?php include_once "header.php"; ?>
    <link rel="stylesheet" href="assets/css/create.css">
</head>

<body>
    <?php
    // Include the database connection and user management functions
    require_once "include/database/user_managment.php";
    require_once "include/database/content_managment.php";

    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] != 1) {
        header('Location: index.php');
        exit();
    }

    // Handle user creation
    $create_message = "";
    if (isset($_POST['create_user'])) {
        $username = $_POST['new_username'];
        $password = $_POST['new_password'];
        $email = $_POST['new_email'];
        if (register_user($username, $password, $email)) {
            $create_message = "User created successfully!";
        } else {
            $create_message = "Failed to create user.";
        }
    }

    // Handle make admin
    $admin_message = "";
    if (isset($_POST['make_admin'])) {
        $username = $_POST['admin_username'];
        $conn = getDatabaseConnection();
        $sql = 'UPDATE users SET isadmin = 1 WHERE username = "' . $conn->real_escape_string($username) . '"';
        if ($conn->query($sql) === TRUE) {
            $admin_message = "User '$username' is now an admin.";
        } else {
            $admin_message = "Failed to make user admin.";
        }
        $conn->close();
    }

    // Handle revoke admin
    $revoke_message = "";
    if (isset($_POST['revoke_admin'])) {
        $username = $_POST['revoke_admin_username'];
        $conn = getDatabaseConnection();
        $sql = 'UPDATE users SET isadmin = 0 WHERE username = "' . $conn->real_escape_string($username) . '"';
        if ($conn->query($sql) === TRUE) {
            $revoke_message = "User '$username' is no longer an admin.";
        } else {
            $revoke_message = "Failed to revoke admin status.";
        }
        $conn->close();
    }

    // Fetch all users for the table
    $users = [];
    $conn = getDatabaseConnection();
    $result = $conn->query("SELECT ID, username, email, isadmin FROM users");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    $conn->close();
    ?>

    <h2>Admin Control Panel</h2>

    <h3>Create User</h3>
    <form method="post">
        <input type="text" name="new_username" placeholder="Username" required>
        <input type="password" name="new_password" placeholder="Password" required>
        <input type="email" name="new_email" placeholder="Email" required>
        <button type="submit" name="create_user">Create User</button>
    </form>
    <p><?php echo $create_message; ?></p>

    

    <h3>All Users</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo $user['isadmin'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <?php if ($user['isadmin']): ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="revoke_admin_username" value="<?php echo htmlspecialchars($user['username']); ?>">
                            <button type="submit" name="revoke_admin">Revoke Admin</button>
                        </form>
                    <?php else: ?>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="admin_username" value="<?php echo htmlspecialchars($user['username']); ?>">
                            <button type="submit" name="make_admin">Make Admin</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
