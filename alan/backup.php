<? include("./include/config.php");?>
<? include("./include/db.php");?>
<? include("./include_member/member_auth.php");?>
<? include("./include_member/member_secure.php");?>
<? include("./include/functions.php");?>
<?
	require_once("mysql_dump.inc.php");
	
	/**
	 * Create class object 
	 */
	$dbhost = "MYSQLHOST";
	$dbuser = "u70622296";
	$dbpwd = "399132";	
	

	$mysql_dump = new MYSQL_DUMP($dbhost,$dbuser,$dbpwd);
	
	// OR 
	/*
	$mysql_dump = new MYSQL_DUMP();
	$mysql_dump->setDBHost($dbhost,$dbuser,$dbpwd);
	*/
	

	/**
	@params : [$database name] You can give database name ,names seperated by coma or array of names
							   By default it will take all the database   
			: [$database name] You can give table name ,names seperated by coma or array of names
							   By default it will take all the tables into a database
			 [OPTIONS] :- 
				HAR_LOCK_TABLE  Put Lock table command into sql file 
				HAR_FULL_SYNTAX FULL Insert Syntax
				HAR_DROP_TABLE  Include Drop Table Statement
				HAR_NO_STRUCT   No Create Statement will include
				HAR_NO_DATA     No Insert Statement
				HAR_ALL_OPTIONS (HAR_LOCK_TABLE | HAR_FULL_SYNTAX | HAR_DROP_TABLE) Use All Options 
	*/

	//$sql = $mysql_dump->dumpDB(); //Takes all database backups
	
	//$sql = $mysql_dump->dumpDB("d60558781",HAR_ALL_TABLES, HAR_ALL_OPTIONS | HAR_NO_DATA );// It will take only back up of table structures only

	$sql = $mysql_dump->dumpDB("d60558781");  //Takes backup of particular database
	
	if($sql==false)
		echo $mysql_dump->error();
	
	// To save sql 
	/*@param : $sql sql commands comes from MYSQL_DUMP::dumpDB() function
			   [$sqlfilename]	Sql file name
	*/

	$mysql_dump->save_sql($sql);
	
	//To force sql to download
	// To save sql 
	/*@param : $sql sql commands comes from MYSQL_DUMP::dumpDB() function
			   [$sqlfilename]	Sql file name
	*/
	$date=date("Y-m-d");
	$mysql_dump->download_sql($sql,"$date-mewCS.sql");
	
	// Print SQL
	echo nl2br($sql);
	
	//To restore sqlfile
	/*if($mysql_dump->restoreDB("dump.sql")==false)
		echo $mysql_dump->error();*/

?>