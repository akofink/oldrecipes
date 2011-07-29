<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn() && $_SESSION['currentUser']->userlevel==1){
        echo '<a href="listUsers.php">Back to all users.</a>';
        
        #User Info
        $qry = 'select * from auth where username="'.$_GET['username'].'"';
        $result = mysql_query($qry);
        while($row = mysql_fetch_array($result)) {
            echo '<h1>User Details</h1>
                    <h2>Name: '.$row['firstname'].' '.$row['lastname'].'</h2>
                    <h3>Username: <a href="searchRecipes.php?searchfield='.$row['username'].'">'.$row['username'].'</a></h3>
                    Email: <a href="mailto:'.$row['email'].'">'.$row['email'].'</a><br />';
        }
        
        #User Recipes
        $result = mysql_query('select * from recipes where user="'.$_GET['username'].'" order by title');
        echo '<h1>User Recipes</h1><table>';
        echo "<th></th><th>Title</th><th>Type</th>";
        while($row = mysql_fetch_array($result)){
            echo "<tr><td>";
            
            echo '<a href="deleteRecipe.php?indx='.$row['indx'].'">x</a>';
            
            echo "</td>
                <td><a href=\"showForm.php?indx=".$row['indx']."\">".$row['title']."</a></td>
                <td>".$row['type']."</td>
                </tr>";
        }
        echo '</table>';
        
        #User Comments
        $result = mysql_query('select * from comments where username="'.$_GET['username'].'" order by date');
        echo '<h1>User Comments</h1><table>';
        echo "<th>Date</th><th>Subject</th><th>Comment</th>";
        while($row = mysql_fetch_array($result)){
            $formattedDateArr = mysql_fetch_array(mysql_query('
                    select date_format("'.$row['date'].'","%M %D, %Y at %l:%i%p");'));
            $formattedDate = $formattedDateArr[0];
            echo '<tr>
                <td>'.$formattedDate.'</td>
                <td>'.$row['subject'].'</td>
                <td>'.$row['comment'].'</td>
                </tr>';
        }
        echo '</table>';
    }else {
        echo 'You do not have administrative privileges.
            <meta http-equiv="refresh" content="1; url=." />';
    }
    
    include("footer.php");
?>