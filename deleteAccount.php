<?php
    include("header.php");
    
    if($_GET['username']==$_SESSION['currentUser']->username ||
       $_SESSION['currentUser']->userlevel==1) {
        if($_GET['verified']) {
            $_SESSION['currentUser']->deleteAccount($_GET['username']);
        }else {
            echo '<form action="deleteAccount.php" action="get">
                    Are you sure you want to delete account
                    '.$_GET['username'].'? <input type="submit" value="Yes" />
                    <input type="hidden" name="verified" value="true"/>
                    <input type="hidden" name="username" value="'.$_GET['username'].'"/>
                </form>';
        }
    }else {
        echo 'You do not have sufficient privileges.
            <meta http-equiv="refresh" content="1; url=." />';
    }
    
    
    include("footer.php");
?>