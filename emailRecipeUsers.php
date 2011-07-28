<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn() && $_SESSION['currentUser']->username=='akofink'){
        echo '<h1>Email All Users</h1>';
        if(isset($_POST['subject']) && $_POST['message'] && $_POST['verified']=="true") {
            $_SESSION['currentUser']->emailAllUsers($_POST['subject'], $_POST['message']);
            echo 'Email sent successfully.';
        }else if(isset($_POST['subject']) && isset($_POST['message']) && isset($_POST['verified'])) {
            echo '
                <h3>'.$_POST['subject'].'</h3>
                <p>'.$_POST['message'].'</p><br />
                <form action="emailRecipeUsers.php" method="post">
                    <input type="hidden" name="subject" value="'.$_POST['subject'].'" />
                    <input type="hidden" name="message" value="'.$_POST['message'].'" />
                    <input type="hidden" name="verified" value="true" />
                    <input type="submit" value="Send" />
                </form>
                <form action="emailRecipeUsers.php" method="post">
                    <input type="hidden" name="subject" value="'.$_POST['subject'].'" />
                    <input type="hidden" name="message" value="'.$_POST['message'].'" />
                    <input type="submit" value="Edit" />
                </form>
                ';
        }else {
            echo '
                <form action="emailRecipeUsers.php" method="post">
                <label for="subject">Subject: </label>
                <input type="text" id="subject" name="subject" value="'.$_POST['subject'].'" /><br /><br />
                <label for="message">Message:</label><br />
                <textarea name="message" style="width:500px; height:200px;">'.$_POST['message'].'</textarea><br />
                <input type="hidden" name="verified" value="false" />
                <input type="submit" value="Send" />
                <input type="reset" value="Reset" />
                </form>
                ';
        }
    }else {
        echo 'You do not have administrative privileges.
            <meta http-equiv="refresh" content="1; url=." />';
    }
    
    include("footer.php");
?>