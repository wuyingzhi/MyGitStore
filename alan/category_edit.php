<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
$category="";
$link="";
$status="";
isset($_GET["id"]) && $_GET["id"]!="" ? $id = $_GET["id"] : $id="";

if($id!=""){
	$rs = $db->execute("SELECT * FROM categories WHERE id='".$id."'");
	$row = $db->row($rs);
	$category = $row["name"];
	$status = $row["status"];
}
if(isset($_POST["_task"]) && $_POST["_task"]=="update"){
	$id = $_POST["id"];
	$category = $_POST["category"];
	$status = $_POST["status"];
	
	$db->update("UPDATE categories SET name='".$category."', status='".$status."' WHERE id='".$id."'");
	header("location:category_edit.php?info=8");
	exit();
}
if(isset($_POST["_task"]) && $_POST["_task"]=="addnew"){
	$category = $_POST["category"];
	$status = $_POST["status"];
	
	if($category==""){
		$valid->adderror("Please Enter Category Name");
	}
	if($status==""){
		$valid->adderror("Please Select Category Status");
	}
	
	if($valid->errorcount==0){
		$id = $db->nextid("categories","id");
		$db->update("INSERT INTO categories VALUES('".$id."','".$category."','".$status."')");
		header("location:category_edit.php?info=7");
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
							<td class="btitle">Add Job Offer Category</td>
						</tr>
					</table><br />
					<form name="addnew" acton="<?=$_SERVER['PHP_SELF']?>" method="post">
					<input type="hidden" name="_task" value="<?=$id=="" ? "addnew" : "update"?>" />
					<input type="hidden" name="id" value="<?=$id?>" />
					<table border="0" width="80%" cellpadding="5" cellspacing="1" align="left" class="box">
						<tr>
							<td height="22" align="right" colspan="2"><?=REQUIRED?>Required Fields</td>
						</tr>
						<tr>
							<td height="22" align="right" colspan="2"></td>
						</tr>
						<tr>
							<td height="22" align="left" class="text5">Category Name:<?=REQUIRED?></td><td align="left"><input type="text" name="category" size="40" value="<?=$category?>" class="text5"/></td>
						</tr>
						<tr>
							<td height="22" align="left" class="text5">Status:</td>
							<td align="left"><select name="status" class="text5"><option value="Yes" <?=$status=="Yes"?"selected":""?>>Yes</option><option value="No" <?=$status=="No"?"selected":""?>>No</option></select></td>
						</tr>
						<tr>
							<td></td>
							<td height="22" align="left"><input type="submit" value="<?=$id=="" ? "Add New Category" : "Update Category"?>" class="btn" /> <input type="button" value="Cancel" class="btn" onclick="location.href='category.php'" /></td>
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