<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn() && $_SESSION['currentUser']->userlevel==1){
        echo '
            <h1>User Listing</h1>
            <table>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Details</th>';
        
        $qry = 'select * from auth order by lastname';
        $result = mysql_query($qry);
        while($row = mysql_fetch_array($result)) {
            echo '<tr>
                    <td>'.$row['lastname'].', '.$row['firstname'].'</td>
                    <td><a href="searchRecipes.php?searchfield='.$row['username'].'">'.$row['username'].'</a></td>
                    <td><a href="mailto:'.$row['email'].'">'.$row['email'].'</td>
                    <td><a href="viewUserDetails.php?username='.$row['username'].'">View</a></td>
                    </tr>';
        }
        echo '</table>';
        
    }else {
        echo 'You do not have administrative privileges.
            <meta http-equiv="refresh" content="1; url=." />';
    }
    
    include("footer.php");
?>