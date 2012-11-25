<?php
    include("header.php");
    
    if(isset($_POST['firstname'],
             $_POST['lastname'], $_POST['email'])
            && $_POST['firstname']!="" && 
             $_POST['lastname']!="" && $_POST['email']!="") {
        $_SESSION['currentUser']->editUser($_POST['firstname'],
             $_POST['lastname'], $_POST['email']);
    }else {
        $_SESSION['currentUser']->displayEditUserForm($_POST['username'], $_POST['firstname'],
             $_POST['lastname'], $_POST['email']);
    }
    if(($_POST['firstname']=="" || $_POST['lastname']==""
        || $_POST['email']=="") &&
       (isset($_POST['firstname']) || isset($_POST['lastname']) || isset($_POST['email']))) {
        echo '<script type="text/javascript">alert("All fields are required.");</script>';
    }
    
    include("footer.php");
?>