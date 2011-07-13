<?php
    include("header.php");
    
    echo '<a href="printRecipe.php?indx='.$_GET['indx'].'" target="_blank">Print</a> this recipe.';
    $stmt = "select * from recipes where indx=".$_GET['indx'].";";
    $result = mysql_query($stmt) or die('invalid query');
    while($row = mysql_fetch_array($result)){
        echo '
            <h2>'.$row['title'].'</h2>
            <h3>Added by '.$row['user'].'</h3>
            <h4>'.$row['type'].'</h4>';
        if($row['imageLocation']!=''){
            echo '<img src="'.$row['imageLocation'].'" width="400px"></img>';
        }
        echo '
            <pre>'.$row['ingredients'].'</pre>
            <p>'.$row['directions'].'</p>
            ';
        
        if($_SESSION['currentUser']->username==$row['user']) {
            echo '
                <a href="deleteRecipe.php?indx='.$row['indx'].'" style="color:#f33;">Delete This Recipe</a> |
                <a href="editRecipe.php?indx='.$row['indx'].'">Edit This Recipe</a>
                ';
        }
    }

    include("footer.php");
?>