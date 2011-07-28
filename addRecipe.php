<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn()) {
        if(isset($_POST['title'], $_POST['typeOfFood'], $_POST['ingredients'], $_POST['directions']) &&
            $_POST['title']!="" && $_POST['typeOfFood']!="" &&
            $_POST['ingredients']!="" && $_POST['directions']!="") {
             $filename = '';
             if(isset($_FILES['image']) && $_FILES['image']['name']!='') {
                 if ((($_FILES["image"]["type"] == "image/gif")
                         || ($_FILES["image"]["type"] == "image/jpeg")
                         || ($_FILES["image"]["type"] == "image/pjpeg"))
                         && ($_FILES["image"]["size"] < $_POST['MAX_FILE_SIZE'])){
                     if ($_FILES["image"]["error"] > 0){
                         echo "Error: " . $_FILES["image"]["error"] . "<br />";
                     }else {
                         echo "Upload: " . $_FILES["image"]["name"] . "<br />";
                         echo "Type: " . $_FILES["image"]["type"] . "<br />";
                         echo "Size: " . ($_FILES["image"]["size"] / 1024) . " Kb<br />";
                         
                         $filename = $_FILES["image"]["name"];
                         $i=1;
                         while (file_exists("uploads/" . $filename)){
                             $filename = $i.$_FILES["image"]["name"];
                             $i+=1;
                         }
                         if(!move_uploaded_file($_FILES["image"]["tmp_name"],
                                             "uploads/" . $filename)){
                             die('There was an error uploading the file. Please try again.');
                         }
                     }
                 }else {
                     die('Wrong file type or file too large. Must be JPEG or GIF under 500kb.');
                 }
             }
             if($filename!='') {
                 $image = 'uploads/'.$filename;
             }else {
                 $image = '';
             }
             $_SESSION['currentRecipe']->addRecipe($_POST['title'], $_SESSION['currentUser']->username,
                       $_POST['typeOfFood'], $image,
                       $_POST['ingredients'], $_POST['directions']);
             
         }else {
             if((isset($_POST['title']) || isset($_POST['typeOfFood']) ||
                      isset($_POST['ingredients']) || isset($_POST['directions'])) && 
                ($_POST['title']=="" || $_POST['typeOfFood']=="" ||
            $_POST['ingredients']=="" || $_POST['directions']=="")){
                 echo '<script type="text/javascript">alert("There are empty feilds.")</script>';
             }
             $_SESSION['currentRecipe']->displayNewRecipeForm($_POST['title'], $_POST['typeOfFood'],
                                  $_POST['image'], $_POST['ingredients'],
                                  $_POST['directions']);
        }
    }else {
        echo '<meta http-equiv="refresh" content="0; url=index.php" />';
    }
    
    include("footer.php");
?>