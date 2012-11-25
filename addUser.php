<?php
    include("header.php");
    
    if(isset($_POST['username'], $_POST['firstname'],
             $_POST['lastname'], $_POST['email'], $_POST['password1'], $_POST['password2'])
       && $_POST['password1'] == $_POST['password2']
       && $_POST['username']!="" && $_POST['firstname']!="" && 
             $_POST['lastname']!="" && $_POST['email']!="" && $_POST['password1']!="" && $_POST['password2']!="") {
        $_SESSION['currentUser']->addUser($_POST['username'], $_POST['firstname'],
             $_POST['lastname'], $_POST['email'], $_POST['password1']);
    }else {
        $_SESSION['currentUser']->displayCreateUserForm($_POST['username'], $_POST['firstname'],
             $_POST['lastname'], $_POST['email'], $_POST['password1'], $_POST['password2']);
    }
    if($_POST['password1']!=$_POST['password2']) {
        echo "<br /><span style='color:#f33;'>Passwords do not match.</span>";
    }
    if(($_POST['username']=="" || $_POST['firstname']=="" || 
         $_POST['lastname']=="" || $_POST['email']=="" || $_POST['password1']=="" || $_POST['password2']=="") &&
       (isset($_POST['username']) || isset($_POST['firstname']) ||
        isset($_POST['lastname']) || isset($_POST['email']) ||
        isset($_POST['password1']) || isset($_POST['password2']))) {
        echo "<br /><span style='color:#f33;'>All fields are required.</span>";
    }
    
    include("footer.php");
?>