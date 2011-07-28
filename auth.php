<?php
session_start();
class User {
    //database access
    var $host = 'localhost';
    var $database = 'recipes';
    var $dbusername = 'anonymous';
    var $dbpassword = '';
    
    var $dbconnection = '';
    
    //table fields
    var $table = 'auth';
    var $usernameCol = 'username';
    var $firstnameCol = 'firstname';
    var $lastnameCol = 'lastname';
    var $emailCol = 'email';
    var $passwordCol = 'password';
    var $userlevelCol = 'userlevel';
    
    var $encrypt = false;
    var $loggedIn = false;
    
    var $username = '';
    var $firstname = '';
    var $lastname = '';
    var $email = '';
    var $password = '';
    
    function addUser($username, $firstname, $lastname, $email, $password) {
        $this->dbConnect();
        $qry = "
            insert into ".$this->table." (".$this->usernameCol.", ".
                    $this->firstnameCol.", ".
                    $this->lastnameCol.", ".
                    $this->emailCol.", ".
                    $this->passwordCol.") values('".
                    $username."', '".
                    $firstname."', '".
                    $lastname."', '".
                    $email."', SHA('".
                    $password."'));
            ";
        mysql_query($qry);
        if(preg_match("/Duplicate/", mysql_error())) {
            $_SESSION['currentUser']->displayCreateUserForm($_POST['username'], $_POST['firstname'],
                $_POST['lastname'], $_POST['email']);
            echo '<br /><span style="color:#f33;">That username already exists. Please try again.</span>';
            die();
        }
        echo $username.' added successfully.<br />
        You will be redirected <a href="login.php">here</a>.
        <meta http-equiv="refresh" content="1; url=login.php" />
        ';
    }
    
    function changePassword($newPassword){
        $this->dbConnect();
        $qry = "update ".$this->table." set "
                .$this->passwordCol."=SHA('".$newPassword."') 
                where ".$this->usernameCol."='".$this->username."';";
        mysql_query($qry) or die('Could not update user');
        $this->password = $newPassword;
        echo 'Password updated successfully for '.$this->username.'.<br />
        You will be redirected <a href="index.php">here</a>.
        <meta http-equiv="refresh" content="1; url=index.php" />
        ';
    }
    
    function checkLoggedIn() {
        return $this->loggedIn;
    }
    
    function dbConnect() {
        $this->dbconnection = mysql_connect($this->host,
                             $this->dbusername,
                             $this->dbpassword)
                or die ('Unable to connect to the database: '.mysql_error());
        mysql_select_db($this->database, $this->dbconnection)
                or die ('Unable to select database: '.mysql_error());
    }
    
    function deleteAccount() {
        $this->dbConnect();
        $qry = "delete from ".$this->table." 
                where ".$this->usernameCol."='".$this->username."';";
        mysql_query($qry) or die('Could not delete user');
        $this->logout();
        echo 'Account '.$this->username.' deleted successfully.<br />
        You will be redirected <a href=".">here</a>.
        <meta http-equiv="refresh" content="1; url=." />
        ';
    }
    
    function displayChangePasswordForm() {
        echo '
        <form action="changePassword.php" method="post">
            <table><tr><td>
            <label for="oldPassword">Old Password: </label></td><td>
            <input type="password" id="oldPassword" name="oldPassword" value="" /></td></tr><tr><td>
            <label for="newPassword1">New Password: </label></td><td>
            <input type="password" id="newPassword1" name="newPassword1" value="" /></td></tr><tr><td>
            <label for="newPassword2">Verify New Password: </label></td><td>
            <input type="password" id="newPassword2" name="newPassword2" value="" /></td></tr>
            </table><br />
            <input type="submit" value="update" />
            <a href="changePassword.php">Reset</a>
        </form>
        ';
    }
    
    function displayCreateUserForm($username="", $firstname="",
                                   $lastname="", $email="", $password1="", $password2="") {
        echo '
                <h1>New User Account</h1>
                <form action="addUser.php" method="post">
                    <table><tr><td>
                    <label for="username">Username: </label></td><td>
                    <input type="text" id="username" name="username" value="'.$username.'"/></td></tr><tr><td>
                    <label for="firstname">First Name: </label></td><td>
                    <input type="text" id="firstname" name="firstname" value="'.$firstname.'" /></td></tr><tr><td>
                    <label for="lastname">Last Name:</label></td><td>
                    <input type="text" id="lastname" name="lastname" value="'.$lastname.'" /></td></tr><tr><td>
                    <label for="email">Email: </label></td><td>
                    <input type="text" id="email" name="email" value="'.$email.'" /></td></tr><tr><td>
                    <label for="password1">Password</label></td><td>
                    <input type="password" id="password1" name="password1" value="'.$password1.'" /></td></tr><tr><td>
                    <label for="password2">Verify Password: </label></td><td>
                    <input type="password" id="password2" name="password2" value="'.$password2.'" /></td></tr>
                    </table><br />
                    <input type="submit" value="Submit" />
                    <a href="addUser.php">Reset</a>
                </form><br />
                ';
    }
    
    function displayEditUserForm($username, $firstname,
                                   $lastname, $email) {
        echo '
                <h1>Edit User Account</h1>
                <form action="editUser.php" method="post">
                    <table><tr><td>
                    Username:</td><td>'.
                    $this->username.'</td></tr><tr><td>
                    <label for="firstname">First Name: </label></td><td>
                    <input type="text" id="firstname" name="firstname" value="'.$this->firstname.'" /></td></tr><tr><td>
                    <label for="lastname">Last Name:</label></td><td>
                    <input type="text" id="lastname" name="lastname" value="'.$this->lastname.'" /></td></tr><tr><td>
                    <label for="email">Email: </label></td><td>
                    <input type="text" id="email" name="email" value="'.$this->email.'" /></td></tr><tr><td>
                    </table><br />
                    <input type="submit" value="Update" />
                    <a href="editUser.php">Reset</a>
                </form><br /><br />
                
                <a href="changePassword.php">Change Password</a><br /><br />
                
                <a href="deleteAccount.php" style="color:#f33;">Delete Account</a>
                ';
    }
    
    function displayLoginForm($invalid=false) {
        echo "
            <form action=\"login.php\" method=\"post\">
                <label for=\"username\">Username: </label>
                <input type=\"text\" id=\"username\" name=\"username\" /><br />
                <label for=\"password\">Password: </label>
                <input type=\"password\" id=\"password\" name=\"password\" /><br /><br />
                <input type=\"submit\" value=\"Login\" />
                <a href=\"login.php\">Reset</a>
            </form><br /><br />
                ";
            if($invalid) {
                echo '<span style="color:#f33;">Invalid username/password.</span><br /><br />';
            }
            echo "Don't have an account? <a href=\"addUser.php\">Make one.</a>";
    }
    
    function editUser($firstname, $lastname, $email) {
        $this->dbConnect();
        $qry = "update ".$this->table." set "
                .$this->firstnameCol."='".$firstname."', "
                .$this->lastnameCol."='".$lastname."', "
                .$this->emailCol."='".$email."' 
                where ".$this->usernameCol."='".$this->username."';";
        mysql_query($qry) or die('Could not update user');
        $this->firstname=$firstname;
        $this->lastname=$lastname;
        $this->email=$email;
        echo $username.' updated successfully.<br />
        You will be redirected <a href="index.php">here</a>.
        <meta http-equiv="refresh" content="1; url=index.php" />
        ';
    }
    
    function emailAllUsers($subject, $message) {
        $this->dbConnect();
        $qry = 'select email from auth';
        $result = mysql_query($qry) or die(mysql_error);
        $headers = 'From: Andrew_Kofink';
        while($row = mysql_fetch_array($result)) {
            mail($row['email'],$subject,$message,$headers);
        }
    }
    
    function login($username, $password) {
        $this->dbConnect();
        
        $result = mysql_query("SELECT * from ".
                              $this->table." where ".
                              $this->usernameCol."='".
                              $username."';");
        
        $row = mysql_fetch_array($result);
        if($row['username']!='') {
            $this->loggedIn = true;
            $this->username = $row['username'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            echo "Login successful.";
            echo "You will be redirected <a href=\".\">here</a>.";
            echo "<meta http-equiv=\"refresh\" content=\"1; url=.\" />";
        }else {
            echo "Invalid username/password.";
            echo "You will be redirected <a href=\".\">here</a>.";
            echo "<meta http-equiv=\"refresh\" content=\"1; url=.\" />";
        }
    }
    
    function logout() {
        $this->loggedIn = false;
        $this->username = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->password = '';
        session_destroy();
    }
}

class Recipe {
    var $host = 'localhost';
    var $database = 'recipes';
    var $dbusername = 'anonymous';
    var $dbpassword = '';
    
    var $dbconnection = '';
    
    function addComment($indx, $subject, $comment, $reply_id=0) {
        $this->dbConnect();
        $qry = 'insert into comments
                (username, indx, date, subject, comment, reply_id)
                values(
                "'.$_SESSION['currentUser']->username.'",
                "'.$indx.'",
                now(),
                "'.$subject.'",
                "'.$comment.'",
                "'.$reply_id.'"
                )';
        mysql_query($qry) or die(mysql_error());
    }
    
    function addRecipe($title, $user, $type, $imageLocation, $ingredients, $directions) {
        $this->dbConnect();
        
        $qry = "insert into recipes
                (title, user, type, imageLocation, ingredients, directions)
                values(\"".$title."\", \"".
                $user."\", \"".
                $type."\", \"".
                $imageLocation."\", \"".
                $ingredients."\", \"".
                $directions."\")";
        if (!mysql_query($qry)){
            die('Error: ' . mysql_error().'<hr />'.$qry);
        }
        
        echo "<h4>Recipe Added</h4><br />";
        echo "<meta http-equiv=\"refresh\" content=\"1; url=.\" />";
        echo "You will be redirected. If not, click <a href=\".\">here</a>.";
    }
    
    function dbConnect() {
        $_SESSION['currentUser']->dbConnect();
    }
    
    function deleteRecipe($indx) {
        $row = mysql_fetch_assoc(mysql_query('select imageLocation from recipes where indx='.$indx));
        if($row['imageLocation']!='') {
            unlink($row['imageLocation']) or die('Could not delete file '. $row['imageLocation']);
        }
        
        $qry = "delete from recipes where indx=".$indx;
        mysql_query($qry) or die('Error: ' . mysql_error().'<hr />'.$qry);
        
        echo "<h4>Recipe Deleted</h4><br />";
        echo "You will be redirected. If not, click <a href=\".\">here</a>.";
        echo '<meta http-equiv="refresh" content="1; url=." />';
    }
    
    function displayEditRecipeForm($indx="", $title="", $type="", $image="", $ingredients="", $directions="") {
        echo '
            <h1>Edit a Recipe</h1>
            <form enctype="multipart/form-data" action="editRecipe.php" method="post">
                <input type="hidden" name="indx" value='.$indx.' />
                
                <label for="title">Name: </label><input type="text" name="title" id="title" value="'.$title.'" /><br />
                <label for="type">Type: </label><input type="text" name="type" id="type" value="'.$type.'" /><br /><br />
                
                <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
                <label for="image">Choose an image for the recipe: </label>
                <input name="image" id="image" type="file" value="'.$image.'" /><br /><br />
                
                <label for="ingredients">Ingredients:</label><br />
                <textarea rows="15" cols="50" name="ingredients" id="ingredients">'.$ingredients.'</textarea><br />
                <label for="directions">Directions:</label><br />
                <textarea rows="15" cols="50" name="directions" id="directions">'.$directions.'</textarea><br /><br />
                <input type="submit" value="Update" />
                <a href="getNewInfo.php">Reset</a>
            </form>
            ';
    }
    
    function displayNewRecipeForm($title="", $type="", $image="", $ingredients="", $directions="") {
        echo '
            <h1>Add a Recipe</h1>
            <form enctype="multipart/form-data" action="addRecipe.php" method="post">
                <label for="title">Name: </label><input type="text" name="title" id="title" value="'.$title.'" /><br />
                <label for="typeOfFood">Type: </label><input type="text" name="typeOfFood" id="typeOfFood" value="'.$type.'" /><br /><br />
                
                <input type="hidden" name="MAX_FILE_SIZE" value="512000" />
                <label for="image">Choose an image for the recipe: </label>
                <input name="image" id="image" type="file" value="'.$image.'" /><br /><br />
                
                <label for="ingredients">Ingredients:</label><br />
                <textarea rows="15" cols="50" name="ingredients" id="ingredients">'.$ingredients.'</textarea><br />
                <label for="directions">Directions:</label><br />
                <textarea rows="15" cols="50" name="directions" id="directions">'.$directions.'</textarea><br /><br />
                <input type="submit" value="Submit" />
                <a href="getNewInfo.php">Reset</a>
            </form>
            ';
    }
    
    function editRecipe($indx="", $title="", $type="", $imageLocation="", $ingredients="", $directions="") {
        $this->dbConnect();
        
        $qry = '
                update recipes set
                title="'.$title.'", 
                type="'.$type.'", 
                imageLocation="'.$imageLocation.'", 
                ingredients="'.$ingredients.'", 
                directions="'.$directions.'" 
                where indx='.$indx.';
                ';
        if (!mysql_query($qry)){
            die('Error: ' . mysql_error().'<hr />'.$qry);
        }
        
        echo "<h4>Recipe Updated</h4><br />";
        echo "<meta http-equiv=\"refresh\" content=\"1; url=.\" />";
        echo "You will be redirected. If not, click <a href=\".\">here</a>.";
    }
}

?>