<?
//$rs=$db->execute("SELECT groupid FROM ".TBL_USERS." WHERE userid='".$_SESSION["apid"]."'");
//$row=$db->row($rs);
//$rs_grp=$db->execute("SELECT name FROM ".TBL_GROUPS." WHERE id='".$row["groupid"]."'");
//$row_grp=$db->row($rs_grp);
//$rs_perm=$db->execute("SELECT DISTINCT(menuid) FROM ".TBL_GROUP_MENU_RIGHTS." 
//WHERE groupid='".$row["groupid"]."' ORDER BY position");

//while($row_perm=$db->row($rs_perm)){
//	$rs_menu=$db->execute("SELECT name, link FROM ".TBL_MENUS." WHERE id='".$row_perm["menuid"]."'");
//	$row_menu=$db->row($rs_menu);
?>
	
	<br><b><a href="insert_post.php" class="plink1">Add Album</a></b></td><br><br>
	<br><b><a href="menus.php"  class="plink1">Main</a></b><br><br><br><br>
	<br><b><a href="member_pwd.php"  class="plink1">Change Password</a></b><br><br><br>
	<br><b><a href="members.php" class="plink1">Show Members</a></b><br><br><br>
	<br><b><a href="user_listing.php" class="plink1">User Manage</a></b><br><br><br>
	
<? 
	//$rs_subperm = $db->execute("SELECT DISTINCT(submenuid) FROM ".TBL_GROUP_SUBMENU_RIGHTS."
	//WHERE groupid='".$row["groupid"]."' and menuid='".$row_perm["menuid"]."' ORDER BY position");
	//if($db->rowcount($rs_subperm)){
	//	while($row_subperm = $db->row($rs_subperm)){
	//		$rs_submenu=$db->execute("SELECT name,link FROM ".TBL_SUBMENUS." 
	//		WHERE id='".$row_subperm["submenuid"]."'");
	//		$row_submenu=$db->row($rs_submenu);
			
			//echo $row_submenu["link"];
?>
		
<? 
		//}
	//}
//}?>