<?php 
	include("include/config.php");
	include("include/db.php");
	
if(isset($_GET['del'])){

	$delete_id = $_GET['del'];
	$db = new db();
	$db->connect();
	$delete_query = "delete from posts where post_id='$delete_id' ";
	
	if(mysql_query($delete_query)){
		echo "<script>alert('Album Has been Deleted')</script>";
		echo "<script>window.open('menus.php','_self')</script>";
	}
}
?>