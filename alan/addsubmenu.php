<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
$menu="";
$link="";
isset($_GET["sid"]) && $_GET["sid"]!="" ? $sid = $_GET["sid"] : $sid="";
isset($_GET["cid"]) && $_GET["cid"]!="" ? $menuid = $_GET["cid"] : $menuid="";

if($sid!=""){
	$rs = $db->execute("SELECT menuid, name, link FROM ".TBL_SUBMENUS." WHERE id='".$sid."'");
	$row = $db->row($rs);
	$menuid = $row["menuid"];
	$menu = $row["name"];
	$link = $row["link"];
}
if(isset($_POST["_task"]) && $_POST["_task"]=="update"){
	$id = $_POST["id"];
	$menuid = $_POST["menuid"];
	$menu = $_POST["menu"];
	$link = $_POST["link"];
	
	$db->update("UPDATE ".TBL_SUBMENUS." SET menuid='".$menuid."', name='".$menu."', link='".$link."' WHERE id='".$id."'");
	header("location:addsubmenu.php?info=8");
	exit();
}
if(isset($_POST["_task"]) && $_POST["_task"]=="addnew"){
	$menuid = $_POST["menuid"];
	$menu = $_POST["menu"];
	$link = $_POST["link"];
	
	if($menuid==""){
		$valid->adderror("Please Select Main Menu");
	}
	if($menu==""){
		$valid->adderror("Please Enter Submenu Name");
	}
	if($link==""){
		$valid->adderror("Please Enter Page Link");
	}
	
	if($valid->errorcount==0){	
		$id = $db->nextid(TBL_SUBMENUS,"id");
		$db->update("INSERT INTO ".TBL_SUBMENUS." VALUES('".$id."','".$menuid."','".$menu."','".$link."')");
		header("location:addsubmenu.php?info=7");
		exit();
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
							<td class="btitle">Add SubMenu</td>
						</tr>
					</table><br />
					<form name="addnew" acton="<?=$_SERVER['PHP_SELF']?>" method="post">
					<input type="hidden" name="_task" value="<?=$sid=="" ? "addnew" : "update"?>" />
					<input type="hidden" name="id" value="<?=$sid?>" />
					<table border="0" width="80%" cellpadding="5" cellspacing="1" align="left" class="box">
						<tr>
							<td height="22" align="right" colspan="2"><?=REQUIRED?>Required Fields</td>
						</tr>
						<tr>
							<td height="22" align="right" colspan="2"></td>
						</tr>
						<tr>
							<td height="22" align="left" class="text5">Select Main Menu:<?=REQUIRED?></td>
							<td align="left">
								<select name="menuid" class="selectbox">
										<option value=""></option>
									<?	$rsM = $db->execute("SELECT id, name FROM ".TBL_MENUS);
										while($rowM = $db->row($rsM)){?>
										<option value="<?=$rowM["id"]?>" <?=$menuid==$rowM["id"]? "selected" : ""?>><?=$rowM["name"]?></option>
									<? }?>
								</select>
							</td>
						</tr>
						<tr>
							<td height="22" align="left" class="text5">Submenu Name:<?=REQUIRED?></td><td align="left"><input type="text" name="menu" size="40" value="<?=$menu?>" class="textfield"/></td>
						</tr>
						<tr>
							<td height="22" align="left" class="text5">Submenu Page Link:</td><td align="left"><input type="text" name="link" size="40" value="<?=$link?>" class="textfield"/><span class="text2"> (eg. index.php)</span></td>
						</tr>
						<tr>
							<td></td>
							<td height="22" align="left"><input type="submit" value="<?=$sid=="" ? "Add Submenu" : "Update Submenu"?>" class="btn" /> <input type="button" value="Cancel" class="btn" onclick="location.href='menus.php'"/></td>
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