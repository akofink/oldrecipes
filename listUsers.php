<?php
    include("header.php");
    
    if($_SESSION['currentUser']->checkLoggedIn() && $_SESSION['currentUser']->userlevel==1){
        echo '
            <h1>User Listing</h1>
            <table><th></th>
            <th><a href="listUsers.php?sortby=lastname, firstname">Name</a></th>
            <th><a href="listUsers.php?sortby=username">Username</a></th>
            <th><a href="listUsers.php?sortby=email">Email</a></th>
            <th><a href="listUsers.php?sortby=no_of_recipes">Rec</a></th>
            <th><a href="listUsers.php?sortby=no_of_comments">Com</a></th>
            <th>Details</th>';
        if(isset($_GET['sortby'])) {
            if(isset($_SESSION['sortby']) && $_SESSION['sortby']==$_GET['sortby']) {
                if($_GET['sortby']=='lastname, firstname') {
                    $qry = 'select * from auth order by lastname desc, firstname desc';
                }else {
                    $qry = 'select * from auth order by '.$_GET['sortby'].' desc';
                }
                $_SESSION['sortby']=null;
            }else {
                $qry = 'select * from auth order by '.$_GET['sortby'];
                $_SESSION['sortby'] = $_GET['sortby'];
            }
        }else {
            $_SESSION['sortby'] = 'lastname, firstname';
            $qry = 'select * from auth order by '.$_SESSION['sortby'];
        }
        $result = mysql_query($qry);
        while($row = mysql_fetch_array($result)) {
            
            #Update the number of Recipes/Comments for this user
            $numberOfRecipes = mysql_fetch_array(mysql_query(
                                    'select count(*) from recipes
                                    where user="'.$row['username'].'"'));
            $numberOfRecipes = $numberOfRecipes[0];
            $numberOfComments = mysql_fetch_array(mysql_query(
                                    'select count(*) from comments
                                    where username="'.$row['username'].'"'));
            $numberOfComments = $numberOfComments[0];
            mysql_query('update auth set no_of_recipes='.$numberOfRecipes.',
                        no_of_comments='.$numberOfComments.' where
                        username="'.$row['username'].'"') or die(mysql_error());
            
            #Make the user's row in the table
            echo '<tr>
                    <td><a href="deleteAccount.php?username='.$row['username'].'">x</a></td>
                    <td>'.$row['lastname'].', '.$row['firstname'].'</td>
                    <td>'.$row['username'].'</td>
                    <td><a href="mailto:'.$row['email'].'">'.$row['email'].'</td>
                    <td>'.$row['no_of_recipes'].'</td>
                    <td>'.$row['no_of_comments'].'</td>
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