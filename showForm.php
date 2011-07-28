<?php
    include("header.php");
    
    echo '<a href="printRecipe.php?indx='.$_GET['indx'].'" target="_blank">Print</a> this recipe.';
    
    #Recipe
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
                <a href="editRecipe.php?indx='.$row['indx'].'">Edit This Recipe</a><br />
                ';
        }
    }
    
    #Comments
    
    function getReplies($comment_id) {
        $_SESSION['level'] += 1;
        $stmt = 'select * from comments where indx='.$_GET['indx'].' and reply_id='.$comment_id.'
            order by date;';
            $result = mysql_query($stmt) or die('invalid query: '.mysql_error());
            
        while($row = mysql_fetch_array($result)) {
            $formattedDateArr = mysql_fetch_array(mysql_query('
                    select date_format("'.$row['date'].'","%M %D, %Y at %l:%i%p");'));
            $formattedDate = $formattedDateArr[0];
            echo '
                <div class="comment" style="margin-left:'.($_SESSION['level']*50).'px;">
                    <h3 style="font-style:italic">'.$row['subject'].'</h3>
                    <h5>'.$row['username'].' on
                    '.$formattedDate.'</h5>
                    <p>'.$row['comment'].'</p>';
            if($_SESSION['currentUser']->checkLoggedIn()) {
                if(isset($_GET['reply_id']) && $_GET['reply_id']==$row['comment_id']) {
                    echo '
                        <form action="addComment.php" method="post">
                            <label for="subject">Subject: </label>
                            <input type="text" name="subject" id="subject" size="40"/><br /><br />
                            <textarea name="comment" style="width:400px; height:100px"></textarea><br />
                            <input type="hidden" name="indx" value="'.$_GET['indx'].'" /><br />
                            <input type="hidden" name="reply_id" value="'.$_GET['reply_id'].'" />
                            <input type="submit" value="Reply" />
                            <input type="reset" value="Reset" />
                        </form>
                        ';
                }else {
                    echo '<a href="showForm.php?indx='.$_GET['indx'].'&reply_id='.$row['comment_id'].'" id="reply_id">Reply</a>';
                }
            }else {
                echo '<a href="login.php" id="login_to_reply">Login to Reply</a>';
            }
            echo '</div><br />';
            getReplies($row['comment_id']);
            $_SESSION['level']-=1;
        }
    }
    
    echo '
        <hr />
        <h2>Comments</h2>
        ';
    
    $stmt = 'select * from comments where indx='.$_GET['indx'].' and reply_id=0
            order by date;';
    $result = mysql_query($stmt) or die('invalid query: '.mysql_error());
    while($row = mysql_fetch_array($result)) {
        $_SESSION['level'] = 0;
        $formattedDateArr = mysql_fetch_array(mysql_query('
                select date_format("'.$row['date'].'","%M %D, %Y at %l:%i%p");'));
        $formattedDate = $formattedDateArr[0];
        echo '
            <div class="comment">
                <h3 style="font-style:italic">'.$row['subject'].'</h3>
                <h5>'.$row['username'].' on
                '.$formattedDate.'</h5>
                <p>'.$row['comment'].'</p>';
        if($_SESSION['currentUser']->checkLoggedIn()) {
            if(isset($_GET['reply_id']) && $_GET['reply_id']==$row['comment_id']) {
                echo '
                    <form action="addComment.php" method="post">
                        <label for="subject">Subject: </label>
                        <input type="text" name="subject" id="subject" size="40"/><br /><br />
                        <textarea name="comment" style="width:400px; height:100px"></textarea><br />
                        <input type="hidden" name="indx" value="'.$_GET['indx'].'" /><br />
                        <input type="hidden" name="reply_id" value="'.$_GET['reply_id'].'" />
                        <input type="submit" value="Reply" />
                        <input type="reset" value="Reset" />
                    </form>
                    ';
            }else {
                echo '<a href="showForm.php?indx='.$_GET['indx'].'&reply_id='.$row['comment_id'].'" id="reply_id">Reply</a>';
            }
        }else {
            echo '<a href="login.php" id="login_to_reply">Login to Reply</a>';
        }
        echo '</div><br />';
        getReplies($row['comment_id']);
    }
    
    if($_SESSION['currentUser']->checkLoggedIn()) {
        echo '
            <h2>Leave a Comment</h2>
            <form action="addComment.php" method="post">
                <label for="subject">Subject: </label>
                <input type="text" name="subject" id="subject" size="40"/><br /><br />
                <textarea name="comment" style="width:400px; height:100px"></textarea><br />
                <input type="hidden" name="indx" value="'.$_GET['indx'].'" /><br />
                <input type="submit" value="Submit" />
                <input type="reset" value="Reset" />
            </form>
            ';
    }else {
        echo '
            To add a comment, <a href="login.php">login</a>.
            ';
    }
    
    include("footer.php");
?>