<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
if(isset($_GET["_task"]) && $_GET["_task"]=="S"){
$id = $_GET["id"];
$s = $_GET["s"];
$db->update("UPDATE items SET status='".$s."' WHERE id='".$id."'");
header("location:items.php?info=8");
exit();
}
if(isset($_GET["_task"]) && $_GET["_task"]=="D"){
$id = $_GET["id"];
$db->update("DELETE FROM items WHERE id='".$id."'");
header("location:items.php?info=9");
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
							<td class="btitle">List of Members</td>
						</tr>
					</table><br />
					<table border="0" class="box1" width="100%" cellpadding="0" cellspacing="1" align="center">
						<tr class="th" height="22">
							<td width="6%">User ID</td>
							<!--<td width="7%">Group</td>-->
							<td width="16%">LoginID</td>
							<td>Name</td>
							<td>Email</td>
							<td width="16%">Last Login</td>
                            <? if($_SESSION["grname"]=="91"){?>
							<td width="5%">Status</td>
							<td width="5%">Edit</td>
                            <? }?>
						</tr>
						<?
						$style="tr";
						$rs = $db->execute("SELECT userid, groupid, loginid, firstname, lastname, email, lastlogin, status FROM ".TBL_USERS);
						while($row = $db->row($rs)){
							$rsG = $db->execute("SELECT name FROM ".TBL_GROUPS." WHERE id='".$row["groupid"]."'");
							$rowG= $db->row($rsG); ?>
						<tr class="<?=$style?>" height="30">
							<td align="center" class="text5"><?=$row["userid"]?></td>
							<!--<td align="center" class="text5"><?=$rowG["name"]?></td>-->
							<td align="center" class="text5"><?=$row["loginid"]?></td>
							<td align="left" class="text5"><?=ucwords($row["firstname"])?> <?=ucwords($row["lastname"])?></td>
							<td align="center" class="text5"><?=$row["email"]?></td>
							<td align="center" class="text5"><?=$db->formatdate(substr($row["lastlogin"],0,10))?></td>
                            <? if($_SESSION["grname"]=="91"){?>
							<td align="center" class="text5"><a href="?_task=status&v=<?=$row["status"]=="Yes" ? "No" : "Yes"?>&id=<?=$row["userid"]?>"><?=$row["status"]=="Yes" ? IPVALID :IPINVALID?></a></td>
							<td align="center" class="text5"><a href="users.php?_task=edit&id=<?=$row["userid"]?>"><?=IMGEDIT?></a></td>
                            <? }?>
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
<script language="javascript">
cc	function DE(id){
		if(confirm("Are you sure? You wants to delete selected Record")){
			location.href="items.php?_task=D&id="+id;
		}
	}
</script>
<? include("./include_member/footer.php");?>