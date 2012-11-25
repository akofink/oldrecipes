<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn()) {
        if(isset($_POST['title'], $_POST['type'], $_POST['ingredients'], $_POST['directions']) &&
        $_POST['title']!="" && $_POST['type']!="" &&
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
            
            $_SESSION['currentRecipe']->editRecipe($_POST['indx'],
                        $_POST['title'],
                      $_POST['type'], $image,
                      $_POST['ingredients'], $_POST['directions']);
        }else if(isset($_GET['indx']) && $_GET['indx']!=''){
            $qry = 'select * from recipes where indx='.$_GET['indx'].';';
            $result = mysql_query($qry);
            $row = mysql_fetch_assoc($result, 0);
            $_SESSION['currentRecipe']->displayEditRecipeForm($row['indx'], $row['title'], $row['type'],
                                  $row['imageLocation'], $row['ingredients'],
                                  $row['directions']);
        }else {
            echo "it's something else.";
        }
    }
    
    include("footer.php");
?>