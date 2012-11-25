<?php
    include("header.php");
    
    $qry = "select * from recipes where
            (title) like
            '%".$_GET['searchfield']."%'";
    $qry = $qry." or (user) like
            '%".$_GET['searchfield']."%'";
    $qry = $qry." or (type) like
            '%".$_GET['searchfield']."%'";
    $qry = $qry." or (ingredients) like
            '%".$_GET['searchfield']."%'";
    $qry = $qry." or (directions) like
            '%".$_GET['searchfield']."%'";
    $qry = $qry." or (indx) like
            '%".$_GET['searchfield']."%'";
    $qry = $qry." order by title";
     
    echo "<table><th></th><th>Title</th><th>Type</th>";     
    $result = mysql_query($qry) or die('invalid query: '.mysql_error());
    while($row = mysql_fetch_array($result)){
        echo "<tr><td>";
            
            if($_SESSION['currentUser']->username==$row['user']) {
                echo '<a href="deleteRecipe.php?indx='.$row['indx'].'">x</a>';
            }
            
            echo "</td>
                <td><a href=\"showForm.php?indx=".$row['indx']."\">".$row['title']."</a></td>
                <td>".$row['type']."</td>
                </tr>";
        }
        echo '</table>';
    
    include("footer.php");
?>