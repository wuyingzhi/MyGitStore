<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
if(isset($_POST["_task"]) && $_POST["_task"] == "User"){
if($_POST["_action"]==="ChangePassword"){
	$stroldpw = $_POST["oldpwd"];
	$strnewpw = $_POST["newpwd"];
	$strconpw = $_POST["retypepwd"];
	$rs = $db->execute("SELECT pwd FROM ".TBL_USERS." WHERE userid='".$_SESSION["apid"]."'");
	if($row = $db->row($rs)){
	$db->free($rs);
		if($row["pwd"]!=$stroldpw){
			$valid->adderror("Old Password is not correct.");
		}
		if(!$valid->ispassword($strnewpw)){
			$valid->adderror("New Password is not a valid Password.");
		}
		if($strconpw != $strnewpw){
			$valid->adderror("New Password and Retype Password must be same.");
		}
		if($valid->errorcount == 0){
			$db->update("UPDATE ".TBL_USERS." SET pwd ='".$strnewpw."' WHERE userid='".$_SESSION["apid"]."'");
			header("location:member_pwd.php?info=6");
			exit();
		}
		}else{
			header("location:member_pwd.php?info=13");
			exit();
		}
	}
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
							<td class="btitle">Change Login Password</td>
						</tr>
					</table><br />
					<form method="post" action="member_pwd.php" name="frmchangepwd">
					<input type="hidden" name="_task" value="User" />
					<input type="hidden" name="_action" value="ChangePassword" /> 
					<table border="0" cellpadding="5" cellspacing="0" width="50%" class="box">
					   	<tr>	
							<td width="35%" class="td">Old Password</td>
							<td class="td"><input type="password" name="oldpwd" class="ip" /><?=REQUIRED?></td>
						</tr>
						 <tr>
							<td class="td">New Password</td>
							<td class="td"><input type="password" name="newpwd" class="ip" /><?=REQUIRED?></td>
						</tr>
					 	<tr>
					  		<td class="td" width="45%">Re-type New Password</td>
					  		<td class="td"><input type="password" name="retypepwd" class="ip" /><?=REQUIRED?></td>
				  		</tr>
				 		<tr>
					  		<td colspan="2" align="center"><input type="submit" value="Change Password" class="ip2" /></td>
						</tr>
					</table>
					</form>
				</td>
				<td width="20" align="left" valign="top"></td>
			</tr>
		</table>
	</td>
</tr>
<? include("./include_member/footer.php");?>