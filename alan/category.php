<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
if(isset($_GET["_task"]) && $_GET["_task"]=="C"){
$id = $_GET["id"];
$s = $_GET["s"];
$db->update("UPDATE categories SET status='".$s."' WHERE id='".$id."'");
header("location:category.php?info=8");
exit();
}
if(isset($_GET["_task"]) && $_GET["_task"]=="S"){
$id = $_GET["id"];
$s = $_GET["s"];
$db->update("UPDATE subcategories SET status='".$s."' WHERE id='".$id."'");
header("location:category.php?info=8");
exit();
}

if(isset($_GET["_task"]) && $_GET["_task"]=="D"){
$id = $_GET["id"];
$level = $_GET["level"];
if($level=="C"){
$db->update("DELETE FROM categories WHERE id='".$id."'");
}else{
$db->update("DELETE FROM subcategories WHERE id='".$id."'");
}
header("location:category.php?info=9");
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
							<td class="btitle">Categories &amp; Subcategories Listing</td>
						</tr>
					</table><br />
					<table border="0" class="box1" width="60%" cellpadding="0" cellspacing="1" align="center">
						<tr class="th" height="22">
							<td></td>
							<td width="10%">ID</td>
							<td>Categories</td>
							<td width="10%">Status</td>
							<td width="10%">Edit</td>
							<th width="10%">Delete</th>
						</tr>
						<?  $subcount=0;
							$treecount=0;
							$style="tr1";						
							$rs=$db->execute("SELECT id, name, status FROM categories ORDER BY id");
							while($row=$db->row($rs)){?>
						<tr class="<?=$style?>" height="25">
							<td align="center" class="th"><img src=<?=IMGPLUS?> name="img<?=$treecount?>" onclick="DISPLAULISTING('<?=$treecount?>')"/></td>
							<td align="center"><?=$row["id"]?></td>
							<td><label for="main_<?=$row["id"]?>"><?=$row["name"]?></label></td>
							<td align="center" valign="middle"><a href="category.php?_task=C&id=<?=$row["id"]?>&s=<?=$row["status"]=="Yes"?"No":"Yes"?>"><?=$row["status"]=="Yes"?IPVALID:IPINVALID?></a></td>
							<td align="center" valign="middle"><a href="category_edit.php?id=<?=$row["id"]?>"><?=IMGEDIT?></a></td>
							<td align="center" valign="middle"><a href="javascript:DE('<?=$row["id"]?>','C')"><?=IPDELETE?></a></td>
						</tr>
						<tr>
							<td colspan="6">
							<div id="tree_<?=$treecount?>" style="visibility: hidden; display:none">
								<table border="0" cellspacing="1" cellpadding="1" width="100%" align="center" class="box2">
								<tr class="th" height="22">
									<th width="14%">ID</th>
									<th>Subcategories</th>
									<th width="10%">Status</th>
									<th width="10%">Edit</th>
									<th width="10%">Delete</th>
								</tr>
						<?	$style1="tr1";
							$rss=$db->execute("SELECT id, cid, name ,status FROM subcategories WHERE cid='".$row["id"]."' ORDER BY id");
							while($rows=$db->row($rss)){	?>
								 <tr class="<?=$style1?>" height="25">
									 <td align="center"><?=$rows["id"]?></td>
									 <td><?=$rows["name"]?></td>
									 <td align="center" valign="middle"><a href="category.php?_task=S&id=<?=$rows["id"]?>&s=<?=$rows["status"]=="Yes"?"No":"Yes"?>"><?=$rows["status"]=="Yes"?IPVALID:IPINVALID?></a></td>
									<td align="center" valign="middle"><a href="category_edit.php?id=<?=$rows["id"]?>"><?=IMGEDIT?></a></td>
									<td align="center" valign="middle"><a href="javascript:DE('<?=$rows["id"]?>','S')"><?=IPDELETE?></a></td>
								</tr>
								<? $style1=="tr1" ? $style1="tr2" : $style1="tr1"; $subcount++;
								}?>
								</table>
							</div>
						<?
							$subcount=0;$treecount++;$style=="tr1" ? $style="tr2" : $style="tr1";
						}?>	
						</td>
						</tr>
						</table>
				</td>
				<td width="20" align="left" valign="top"></td>
			</tr>
		</table>
	</td>
</tr>
<script language="javascript">
	function DISPLAULISTING(tn){
			dv = document.getElementById("tree_"+tn);
				if(dv.style.visibility=="hidden"){
						dv.style.visibility="visible";
						dv.style.display="block";
						document.images['img'+tn].src="images/btn_mins.gif"; 
					}
				else{
						dv.style.visibility="hidden";
						dv.style.display="none";
						document.images['img'+tn].src="images/btn_plus.gif"; 
				}
					
		}
		
	function SELECTALL(st,en){
		aleret(st);
		for(x=st;x<=en;x++){
			document.frmedit.x.checked=true;
		}
	}
	
	function DE(id,level){
		if(confirm("Are you sure? You wants to delete selected Record")){
			location.href="category.php?_task=D&id="+id+"&level="+level;
		}
	}
</script>
<? include("./include_member/footer.php");?>