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
$fname="";
$lname="";
$email="";
$status="";
$loginid="";
$dess="";
$emailpass="";
if(isset($_POST["_task"]) && $_POST["_task"]=="cancel"){
	header("location:users.php");
	exit();
}
if(isset($_POST["_task"]) && $_POST["_task"]=="update"){
	$id=$_POST["id"];
	//$grname=$_POST["grname"];
	$loginid=$_POST["loginid"];
	$pass = $_POST["pass"]!="" ? $_POST["pass"] : "";
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$status = $_POST["status"];
	
	// if($grname==""){
		// $valid->adderror("Please Select Group");
	// }	
	if($loginid==""){
		$valid->adderror("Please Enter Login Id");
	}
	if($fname==""){
		$valid->adderrror("Please Enter User First Name");
	}

	if($valid->errorcount==0){
		$db->update("UPDATE ".TBL_USERS." SET groupid='', loginid='".$loginid."', firstname='".$fname."',
					lastname='".$lname."', email='".$email."', status='".$status."' 
					WHERE userid='".$id."'");
					
			if($pass!=""){
				$db->update("UPDATE ".TBL_USERS." SET pwd='".$pass."' WHERE userid='".$id."'");
			}

			if($emailpass!=""){
				$db->update("UPDATE ".TBL_USERS." SET emailpass='".$emailpass."' WHERE userid='".$id."'");
			}
		header("location:users.php?info=28");
		exit();
	}
}
if(isset($_POST["_task"]) && $_POST["_task"]=="addnew"){
	//$grname=$_POST["grname"];
	$loginid=$_POST["loginid"];
	$pass = $_POST["pass"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$status = isset($_POST["status"]) ? $_POST["status"] : "";
	// if($grname==""){
		// $valid->adderror("Please Select Group");
	// }	
	if($loginid==""){
		$valid->adderror("Please Enter Login Id");
	}
	if($pass==""){
		$valid->adderror("Please Enter Login Password");
	}
	if($fname==""){
		$valid->adderror("Please Enter User First Name");
	}
	if($valid->errorcount==0){	
		$id = $db->nextid(TBL_USERS,"userid");
		$db->update("INSERT INTO ".TBL_USERS." VALUES('".$id."','','".$loginid."','".$fname."','".$lname."',
		'".$pass."','".$email."','".$emailpass."',NOW(),'".$status."','No')");
		header("location:users.php?info=7");
		exit();
	}
}
if(isset($_GET["_task"]) && $_GET["_task"]=="edit"){
	$id=$_GET["id"];
	$action="update";
	$rs = $db->execute("SELECT * FROM ".TBL_USERS." WHERE userid='".$id."'");
	$row = $db->row($rs);
	$id = $row["userid"];
	//$grname = $row["groupid"];
	$loginid = $row["loginid"];
	$fname = $row["firstname"];
	$lname = $row["lastname"];
	$email = $row["email"];
	$status = $row["status"];
}
if(isset($_GET["_task"]) && $_GET["_task"]=="status"){
	$v=$_GET["v"];
	$id=$_GET["id"];
	$db->update("UPDATE ".TBL_USERS." SET status='".$v."' WHERE userid='".$id."'");
	header("location:users.php?info=31");
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
							<td class="btitle"><?=$action=="update" ? "Update Users" : "Add New User"?></td>
						</tr>
					</table><br />					
					<form name="addnew" action="users.php" method="post">
					<input type="hidden" name="_task" value="<?=$action?>" />
					<input type="hidden" name="id" value="<?=$id?>" />
					<table border="0" cellpadding="5" cellspacing="0" align="left" width="80%" class="box">
						<tr>
							<td colspan="2" align="right"><?=REQUIRED?> Required Fields</td>
						</tr>
						<!--
						<tr>
							<td align="left" class="text5" width="22%">Select Group: <?=REQUIRED?></td>
							<td align="left"><select name="grname" class="selectbox">
							    <option vlaue=""></option>
								<?
									$rsG = $db->execute("SELECT id,name FROM ".TBL_GROUPS." WHERE status='Yes'");
									while($rowG = $db->row($rsG)){
								?>
									<option value="<?=$rowG["id"]?>" <?=$grname==$rowG["id"] ? "selected" : ""?>><?=$rowG["name"]?></option>
								<? }?>
								</select>
							</td>
						</tr>-->
						<tr>
							<td align="left" class="text5">Login ID: <?=REQUIRED?></td><td align="left"><input type="text" name="loginid"  class="textfield" size="40" value="<?=$loginid?>"/></td>
						</tr>
						<tr>
							<td align="left" class="text5">Password: <?=REQUIRED?></td><td align="left"><input type="password" name="pass" class="textfield" size="40"/> <? if($id!=""){?><span class="text2">Leave Empty If u don't want to change Password</span><? }?></td>
						</tr>
						<tr>
							<td align="left" class="text5">First Name: <?=REQUIRED?></td><td align="left"><input type="text" name="fname" class="textfield" size="40" value="<?=$fname?>"/></td>
						</tr>
						<tr>
							<td align="left" class="text5">Last Name:</td><td align="left"><input type="text" name="lname"  class="textfield" size="40" value="<?=$lname?>"/></td>
						</tr>						
						<tr>
							<td align="left" class="text5">Email Address:</td><td align="left"><input type="text" name="email" size="40" class="textfield" value="<?=$email?>"/></td>
						</tr>						
						<tr>
							<td  align="left" class="text5">Status:</td>
							<td align="left"><input type="radio" name="status" value="Yes" <?=$status=="Yes" ? "checked" : ""?>/>Yes &nbsp; &nbsp; <input type="radio" name="status" value="No" <?=$status=="No" ? "checked" : ""?>/>No 
							</td>
						</tr>
						<tr>
							<td></td><td align="left" class="text5"><input type="submit" value="<?=$action=="addnew" ? "Add User" : "Update User"?>"  class="btn"/> <input type="button" value="Cancel" class="btn" onclick="location.href='?_task=cancel'"/></td>
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