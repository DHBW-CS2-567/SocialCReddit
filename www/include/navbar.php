<?php


    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
    $social_credit = isset($_SESSION['socialcredit']) ? htmlspecialchars($_SESSION['socialcredit']) : '-';
    ?>
    <link rel="stylesheet" href="assets/css/navbar.css">  
    <nav class="navbar">
        <div class="navbar-brand">
            <a href="index.php" class="navbar-logo">Social<span>CReddit</span></a>
            <span class="navbar-tagline">DAS FORUM FÜR ALLE OHNE SCHLECHTE HINTERGEDANKEN</span>
        </div>
        
        <div class="navbar-user-info">
        <?php if (isset($_SESSION['isadmin']) && $_SESSION['isadmin'] == 1) : ?>
                <a href="controlpanel.php" class="control-panel-button">Control Panel</a>
        <?php endif; ?>
            <a href="create.php" class="user-icon-link">
                <div class="user-icon">
                        <span class="user-icon-letter"><b>+</b></span>
                </div>
            </a>

            
            <span class="user-social-credit">SCr: <?php echo $social_credit; ?></span>
            <a href="profile.php" class="user-icon-link">
                <div class="user-icon">
                    <?php if ($username != 'Guest') : ?>
                        <span class="user-icon-letter"><?php echo strtoupper(substr($username, 0, 1)); ?></span>
                    <?php else : ?>
                        <span class="user-icon-letter">-</span>
                    <?php endif; ?>
                </div>
            </a>


            <a href="include/logout.php" class="logout-button">Logout</a>
        </div>
    </nav>


