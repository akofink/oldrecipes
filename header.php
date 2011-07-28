<?php 
    include("auth.php");
    
    if(!isset($_SESSION['currentUser'])){
        $_SESSION['currentUser'] = new User();
    }
    if(!isset($_SESSION['currentRecipe'])){
        $_SESSION['currentRecipe'] = new Recipe();
    }
    
    echo "
        <!DOCTYPE HTML>
            <head>
                <title>Recipes</title>
                <link rel=\"stylesheet\" type=\"text/css\" href=\"recipestyle.css\" />
            </head>
            <body>
        ";
    if(isset($_SESSION['currentUser']) && $_SESSION['currentUser']->checkLoggedIn()){
        $_SESSION['currentUser']->dbConnect();
        echo "
            
            <div style=\"float:right;\">
            <a href=\"addRecipe.php\">New Recipe</a> | 
            <a href=\"editUser.php\">Edit Account</a> | 
            <a href=\"logout.php\">Logout</a><br /><br />
            You are logged in as ".$_SESSION['currentUser']->username."
            </div>
            ";
    }else {
        $_SESSION['currentUser']->dbConnect();
        echo "
            
            <div style=\"float:right;\"> 
            <a href=\"login.php\">Login</a><br /><br />
            </div>
            "; 
    }
    echo "<a href=\".\">Recipes Home</a><br /><br />";
    
    echo "
        <form action=\"searchRecipes.php\" method=\"get\">
            <input type=\"text\" name=\"searchfield\" value=\"".$_GET['searchfield']."\"; ?>
        <input type=\"submit\" value=\"search\" />
        </form>
        ";
            
    echo "<h4>This site is still under construction</h4><hr />";
    
?>