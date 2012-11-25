<?php
    include("header.php");
    
    $user = '';
    $result=mysql_query("select user from recipes where indx=".$_GET['indx']) or die('Invalid query: '.mysql_error());
    while($row = mysql_fetch_array($result)){
        $user = $row['user'];
    }
    
    if($_SESSION['currentUser']->username!=$user && $_SESSION['currentUser']->userlevel!=1){
        header('Location: .');
    }else if($_GET['verified']) {
        $_SESSION['currentRecipe']->deleteRecipe($_GET['indx']);
    }else {
        echo "<form action=\"deleteRecipe.php\" action=\"get\">
                Are you sure you want to delete this recipe? <input type=\"submit\" value=\"Yes\" />
                <input type=\"hidden\" name=\"verified\" value=\"true\"/>
                <input type=\"hidden\" name=\"indx\" value=\"".$_GET['indx']."\"/>
            </form>";
    }
    
    include("footer.php");
?>