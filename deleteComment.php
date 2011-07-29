<?php
    include("header.php");
    
    $result = mysql_fetch_assoc(mysql_query("select username
                                            from comments where
                                            comment_id=".$_GET['comment_id']))
                                    or die('Invalid query: '.mysql_error());
    $user = $result['username'];
    
    if($_SESSION['currentUser']->username!=$user && $_SESSION['currentUser']->userlevel!=1){
        header('Location: .');
    }else if($_GET['verified']) {
        $_SESSION['currentRecipe']->deleteComment($_GET['comment_id']);
        
        #Update Number of Comments for User
        $numberOfComments = mysql_fetch_array(mysql_query(
                                    'select count(*) from comments
                                    where username="'.$user.'"'));
        $numberOfComments = $numberOfComments[0];
        mysql_query('update auth set no_of_comments='.$numberOfComments.' where
                        username="'.$user.'"') or die(mysql_error());
        
        echo "<h4>Comment Deleted</h4><br />";
        echo "You will be redirected. If not, click <a href=\".\">here</a>.";
        echo '<meta http-equiv="refresh" content="1; url=." />';
    }else {
        echo "<form action=\"deleteComment.php\" action=\"get\">
                Are you sure you want to delete this comment? <input type=\"submit\" value=\"Yes\" />
                <input type=\"hidden\" name=\"verified\" value=\"true\"/>
                <input type=\"hidden\" name=\"comment_id\" value=\"".$_GET['comment_id']."\"/>
            </form>";
    }
    
    include("footer.php");
?>