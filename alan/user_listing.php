<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
if(isset($_POST["_task"]) && $_POST["_task"]=="cancel"){
	header("location:users.php");
	exit();
}



if(isset($_GET["_task"]) && $_GET["_task"]=="status"){
	$v=$_GET["v"];
	$id=$_GET["id"];
	$db->update("UPDATE ".TBL_USERS." SET status='".$v."' WHERE userid='".$id."'");
	header("location:user_listing.php?info=31");
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
							<td class="btitle"><?="User's Listing"?></td>
						</tr>
					</table><br />					
					<table width="100%" border="0" cellspacing="1" cellpadding="3" align="left" class="box2">
						<tr class="th" height="22">
							<td width="7%">User ID</td>
							<!--<td width="7%">Group</td>-->
							<td width="7%">LoginID</td>
							<td>Name</td>
							<td>Email</td>
							<td width="15%">Last Login</td>
							<td width="5%">Status</td>
							<td width="5%">Edit</td>
						</tr>
						<?
						$style="tr";
						$rs = $db->execute("SELECT userid, groupid, loginid, firstname, lastname, email, lastlogin, status FROM ".TBL_USERS);
						while($row = $db->row($rs)){
							$rsG = $db->execute("SELECT name FROM ".TBL_GROUPS." WHERE id='".$row["groupid"]."'");
							$rowG= $db->row($rsG); ?>
						<tr class="<?=$style?>">
							<td align="center" class="text5"><?=$row["userid"]?></td>
							<!--<td align="center" class="text5"><?=$rowG["name"]?></td>-->
							<td align="center" class="text5"><?=$row["loginid"]?></td>
							<td align="center" class="text5"><?=ucwords($row["firstname"])?> <?=ucwords($row["lastname"])?></td>
							<td align="center" class="text5"><?=$row["email"]?></td>
							<td align="center" class="text5"><?=$db->formatdate(substr($row["lastlogin"],0,10))?></td>
							<td align="center" class="text5"><a href="?_task=status&v=<?=$row["status"]=="Yes" ? "No" : "Yes"?>&id=<?=$row["userid"]?>"><?=$row["status"]=="Yes" ? IPVALID :IPINVALID?></a></td>
							<td align="center" class="text5"><a href="users.php?_task=edit&id=<?=$row["userid"]?>"><?=IMGEDIT?></a></td>
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