<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn()){
        if(isset($_POST['reply_id']) && $_POST['reply_id']!=0) {
            $_SESSION['currentRecipe']->addComment($_POST['indx'],
                                               $_POST['subject'],
                                               $_POST['comment'],
                                               $_POST['reply_id']);
            echo '
                Response added successfully.<br />
                You will be redirected <a href="showForm.php?indx='.$_POST['indx'].'">here</a> in five seconds.
                <meta http-equiv="refresh" content="5; url=showForm.php?indx='.$_POST['indx'].'" />
                ';
        }else {
            $_SESSION['currentRecipe']->addComment($_POST['indx'],
                                               $_POST['subject'],
                                               $_POST['comment']);
            echo '
                Comment added successfully.<br />
                You will be redirected <a href="showForm.php?indx='.$_POST['indx'].'">here</a> in five seconds.
                <meta http-equiv="refresh" content="5; url=showForm.php?indx='.$_POST['indx'].'" />
                ';
        }
    }else {
        echo '<meta http-equiv="refresh" content="0; url=login.php" />';
    }

    include("footer.php");
?>