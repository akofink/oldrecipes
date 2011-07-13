<?php
    include("header.php");
    
    if($_GET['verified']) {
        $_SESSION['currentUser']->deleteAccount();
    }else {
        echo "<form action=\"deleteAccount.php\" action=\"get\">
                Are you sure you want to delete account ".$_SESSION['currentUser']->username."? <input type=\"submit\" value=\"Yes\" />
                <input type=\"hidden\" name=\"verified\" value=\"true\"/>
            </form>";
    }
    include("footer.php");
?>