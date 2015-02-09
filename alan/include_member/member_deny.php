<?
$confirm=0;
	if($_SESSION["usermenuid"] != 0)
	{
//		$pgname=substr($_SERVER['PHP_SELF'],8,strlen($_SERVER['PHP_SELF']));
		$pgname=substr($_SERVER['PHP_SELF'],9,strlen($_SERVER['PHP_SELF']));
//		echo $pgname;
		$db = new db();
		$db->connect();
		
		$rs=$db->execute("SELECT usermenuid, groupid FROM ".TBL_USER." WHERE userid='".$_SESSION["smid"]."'");
		while($row=$db->row($rs))
		{
			$rs_permission=$db->execute("SELECT menuid, submenuid FROM ".TBL_GROUP_PERMISSIONS." 
														WHERE groupid='".$row["groupid"]."'");
			if($row_permission=$db->row($rs_permission))
			{
				$confirm=1;
			}
		}

//		$rs=$db->execute("SELECT permission,link FROM ".TBL_SUBMENU." WHERE usermenuid='".$_SESSION["smid"]."'");
//		while($row=$db->row($rs)){
//			if($row["link"] == $pgname){
//					if($row["permission"]=="Yes"){
//						$confirm=1;
//					}
//			}
//		}

		if($confirm	== 0)
		{	
			header("location:welcome.php?info=18");
			die;
		}
	}
?>