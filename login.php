<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn()){
        echo "You are logged in as ".$_SESSION['currentUser']->username.".<br />";
        echo "You will be redirected <a href=\".\">here</a>.";
        echo "<meta http-equiv=\"refresh\" content=\"1; url=index.php\" />";
    }else if($_POST['username']!="" && $_POST['password']!="") {
        $_SESSION['currentUser']->login($_POST['username'], $_POST['password']);
    }else if(isset($_POST['username']) || isset($_POST['password'])){
        $_SESSION['currentUser']->displayLoginForm(true);
    }else {
        $_SESSION['currentUser']->displayLoginForm();
    }
    
    include("footer.php");
?>