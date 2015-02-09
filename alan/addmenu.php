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
isset($_GET["mid"]) && $_GET["mid"]!="" ? $mid = $_GET["mid"] : $mid="";

if($mid!=""){
	$rs = $db->execute("SELECT name, link FROM ".TBL_MENUS." WHERE id='".$mid."'");
	$row = $db->row($rs);
	$menu = $row["name"];
	$link = $row["link"];
}
if(isset($_POST["_task"]) && $_POST["_task"]=="update"){
	$id = $_POST["id"];
	$menu = $_POST["menu"];
	$link = $_POST["link"];
	
	$db->update("UPDATE ".TBL_MENUS." SET name='".$menu."', link='".$link."' WHERE id='".$id."'");
	header("location:addmenu.php?info=8");
	exit();
}
if(isset($_POST["_task"]) && $_POST["_task"]=="addnew"){
	$menu = $_POST["menu"];
	$link = $_POST["link"];
	
	if($menu==""){
		$valid->adderror("Please Enter Menu Name");
	}
	if($link==""){
		$valid->adderror("Please Enter Page Link");
	}
	
	if($valid->errorcount==0){
		$id = $db->nextid(TBL_MENUS,"id");
		$db->update("INSERT INTO ".TBL_MENUS." VALUES('".$id."','".$menu."','".$link."')");
		header("location:addmenu.php?info=7");
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
							<td class="btitle">Add Main Menu</td>
						</tr>
					</table><br />
					<form name="addnew" acton="<?=$_SERVER['PHP_SELF']?>" method="post">
					<input type="hidden" name="_task" value="<?=$mid=="" ? "addnew" : "update"?>" />
					<input type="hidden" name="id" value="<?=$mid?>" />
					<table border="0" width="80%" cellpadding="5" cellspacing="1" align="left" class="box">
						<tr>
							<td height="22" align="right" colspan="2"><?=REQUIRED?>Required Fields</td>
						</tr>
						<tr>
							<td height="22" align="right" colspan="2"></td>
						</tr>
						<tr>
							<td height="22" align="left" class="text5">Main Menu Name:<?=REQUIRED?></td><td align="left"><input type="text" name="menu" size="40" value="<?=$menu?>" class="text5"/></td>
						</tr>
						<tr>
							<td height="22" align="left" class="text5">Menu Page Link:</td><td align="left"><input type="text" name="link" size="40" value="<?=$link?>" class="text5"/><span class="text2"> (index.php)</span></td>
						</tr>
						<tr>
							<td></td>
							<td height="22" align="left"><input type="submit" value="<?=$mid=="" ? "Add New Menu" : "Update Menu"?>" class="btn" /> <input type="button" value="Cancel" class="btn" onclick="location.href='menus.php'" /></td>
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