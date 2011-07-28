<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn() && $_SESSION['currentUser']->username=='akofink'){
        echo '
            <ul style="list-style:none;">
                <li><a href="emailRecipeUsers.php">Email Recipe Users</a></li>
            </ul>
            ';
    }else {
        echo 'You do not have administrative privileges.
            <meta http-equiv="refresh" content="1; url=." />';
    }
    
    include("footer.php");
?>