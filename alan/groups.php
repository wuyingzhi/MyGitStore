<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
$action="addnew";
$grname="";
$id="";
if(isset($_POST["_task"]) && $_POST["_task"]=="cancel"){
header("location:groups.php");
exit();
}
if(isset($_POST["_task"]) && $_POST["_task"]=="update"){
$id=$_POST["id"];
$grname=$_POST["grname"];
$db->update("UPDATE ".TBL_GROUPS." SET name='".$grname."' WHERE id='".$id."'");
header("location:groups.php?info=8");
exit();
}
if(isset($_POST["_task"]) && $_POST["_task"]=="addnew"){
$grname=$_POST["grname"];
if($grname==""){
$valid->adderror("Please Enter Group Name");
}
if($valid->errorcount==0){
$id = $db->nextid(TBL_GROUPS,"id");
$db->update("INSERT INTO ".TBL_GROUPS." VALUES('".$id."','".$grname."','Yes')");
header("location:groups.php?info=7");
	exit();
}
}
if(isset($_GET["_task"]) && $_GET["_task"]=="edit"){
$id=$_GET["id"];
$action="update";
$rs = $db->execute("SELECT name FROM ".TBL_GROUPS." WHERE id='".$id."'");
$row = $db->row($rs);
$grname = $row["name"];
}
if(isset($_GET["_task"]) && $_GET["_task"]=="status"){
$v=$_GET["v"];
$id=$_GET["id"];
$db->update("UPDATE ".TBL_GROUPS." SET status='".$v."' WHERE id='".$id."'");
header("location:groups.php?info=8");
exit();
}
?>
<? include("./include_member/header.php");?>
<tr>
<td align="center" coslpan="2">
	<table border="0" cellpadding="0" cellspacing="0" width="50%">
		<tr>
			<td align="center"><? $valid->show();?></td>
		</tr>
	</table>
</td>
</tr>
<tr>
<td align="center" colspan="2">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td align="center"><? include("./include_member/displayerror.php"); ?></td>
		</tr>
	</table>
</td>
</tr>
<tr>
	<td colspan="2">
		<table border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			    <td width="20" align="left" valign="top"></td>
				<td width="200" valign="top">
					<? include("navigationcall.php");?>
				</td>
				<td width="10"><? // Seperator --------?> </td>
				<td valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="btitle">Group's Listing</td>
						</tr>
					</table><br />
					<table width="60%"  border="0" cellspacing="1" cellpadding="3" align="left" class="box2">
						<tr class="th" height="22">
							<td width="15%">Group ID</td>
							<td>Group Name</td>
							<td width="15%">Permission</td>
							<td width="18%">Group Status</td>
							<td width="15%">Edit Group</td>
						</tr>
						<?
						$style="tr";
						$rs = $db->execute("SELECT id, name, status FROM ".TBL_GROUPS);
						while($row = $db->row($rs)){
						?>
						<tr class="<?=$style?>">
							<td align="center"><?=$row["id"]?></td>
							<td align="left"><?=ucwords($row["name"])?></td>
							<td align="center"><a href="groups_permission.php?gr=<?=$row["id"]?>"><img src="images/btn_password.gif" border="0"/></a></td>
							<td align="center"><a href="?_task=status&v=<?=$row["status"]=="Yes" ? "No" : "Yes"?>&id=<?=$row["id"]?>"><?=$row["status"]=="Yes" ? IPVALID :IPINVALID?></a></td>
							<td align="center"><a href="group_edit.php?_task=edit&id=<?=$row["id"]?>"><?=IMGEDIT?></a></td>
						</tr>
						<?
						  $style=="tr" ? $style="tr2" : $style="tr";
						 }?>
					</table>
				</td>
				<td width="20" align="left" valign="top"></td>
			</tr>
		</table>
	</td>
</tr>
<? include("./include_member/footer.php");?>