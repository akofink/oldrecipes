<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn() && $_SESSION['currentUser']->userlevel==1){
        echo '
            <ul style="list-style:none;">
                <li><a href="emailRecipeUsers.php">Email All Users</a></li>
                <li><a href="listUsers.php">List Users</a></li>
                <li><a href="sqlmaintenance.php">MySQL Maintenance</a></li>
            </ul>
            ';
    }else {
        echo 'You do not have administrative privileges.
            <meta http-equiv="refresh" content="1; url=." />';
    }
    
    include("footer.php");
?>