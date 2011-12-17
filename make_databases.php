<?php
	createUser();
	restoreFromBackup();
	
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
		$command = <<<COM
		mysql -u $user < sqlbackups/lastest.sql
COM;
	}
?>