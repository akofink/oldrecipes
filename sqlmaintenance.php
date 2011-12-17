<?php
	
	$displayTop = <<<DISPTOP
		<!DOCTYPE html>
			<head>
				<title>SQL Maintenance</title>
				<link rel="stylesheet" type="text/css" href="recipestyle.css" />
			</head>
			<body>
				<h1>SQL Maintenance</h1>
DISPTOP;

	$displayBottom = <<<DISPBOTTOM
			</body>
		</html>
DISPBOTTOM;

	$content = <<<CONTENT
				<a href="?do=backup">Backup</a>
CONTENT;

	$login = <<<LOGIN
				<div id="SqlMaintenanceLoginForm">
					<form method="post" action="sqlmaintenance.php">
						<label for="username">MySQL Username:</label>
						<input type="text" id="username" name="username" /><br />
						<label for="password">MySQL Password:</label>
						<input type="password" id="password" name="password" /><br />
						<input type="submit" />
						<input type="reset" />
					</form>
				</div>
LOGIN;

	$logout = <<<LOGOUT
				<a href="?logout">Logout</a><br /><br />
LOGOUT;

	printf($displayTop);
	
	if (isset($_POST['username']) && isset($_POST['password'])) {
		$_SESSION['loggedIn'] = true;
		$_SESSION['mysqluser'] = $_POST['username'];
		$_SESSION['mysqlpassword'] = $_POST['password'];
	}
	if ($_SESSION['loggedIn'] == true) {
		printf($logout);
		if (isset($_GET['do'])) {
			switch ($_GET['do']) {
			case 'backup':
				
				break;
			
			default:
				
				break;
			}
		} else if (isset($_GET['logout'])) {
			session_destroy();
			echo '<META HTTP-EQUIV="refresh" CONTENT="0">';
		} else {
			printf($content);
		}
	} else {
		printf($login);
	}
	
	printf($displayBottom);
	
	function createUser() {
		$qry = <<<QUERY
		create user 
		anonymous@localhost
QUERY;
		mysql_query($qry);
		
		$qry = <<<QUERY
		grant all on 
		recipes.* to 
		anonymous@localhost
QUERY;
		mysql_query($qry);
	}
	
	function backupDatabase() {
		$command = <<<COM
		mysqldump --add-drop-table -u $user recipes > sqlbackups/latest.sql
COM;
		exec($command);
	}
	
	function restoreFromBackup() {
		$pass = $_SESSION['mysqlpassword'];
		$user = $_SESSION['mysqluser'];
		$command = <<<COM
		mysql -u $user -p $pass < sqlbackups/lastest.sql
COM;
	}
?>
