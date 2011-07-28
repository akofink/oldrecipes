<?php
    include("auth.php");
    
    if(!isset($_SESSION['currentUser'])){
        $_SESSION['currentUser'] = new User();
    }
    $_SESSION['currentUser']->dbConnect();
    
    $stmt = "select * from recipes where indx=".$_GET['indx'].";";
    $result = mysql_query($stmt) or die(mysql_error);
    while($row = mysql_fetch_array($result)){
        echo '
            <h2>'.$row['title'].'</h2>
            <h3>Added by '.$row['user'].'</h3>
            <h4>'.$row['type'].'</h4>
            <pre>'.$row['ingredients'].'</pre>
            <p>'.$row['directions'].'</p>
            ';
    }
    echo '<script type="text/javascript">window.print();</script>';
?>