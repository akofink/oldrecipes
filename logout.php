<?php
    include("header.php");
    
    $_SESSION['currentUser']->logout();
    echo "
            You have succesfully logged out.<br />
            You will be redirected <a href=\"index.php\">here</a> in 5 seconds.
            <meta http-equiv=\"refresh\" content=\"5; url=index.php\" />
            ";
    
    include("footer.php");
?>