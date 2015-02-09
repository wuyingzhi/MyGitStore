<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>

<? $db= new db();$db->connect(); $valid = new validation();?>
<? if(isset($_GET["_task"]) && $_GET["_task"]=="D"){
	$tb = $_GET["t"];
	$id = $_GET["id"];
	$sid = $_GET["sid"];
	if($tb=="main"){	
		$db->execute("DELETE FROM ".TBL_SUBMENUS." WHERE menuid='".$id."'");
		$db->execute("DELETE FROM ".TBL_MENUS." WHERE id='".$id."'");
	}else{
		$db->execute("DELETE FROM ".TBL_SUBMENUS." WHERE menuid='".$id."' and id='".$sid."'");
	}
}
?>
<? include("include_member/header.php");?>
<tr>
<td align="center" coslpan="2">
	<table border="0" cellpadding="0" cellspacing="0" width="70%">
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
			<td align="center">
			<? 
				include("include_member/displayerror.php"); 
			?>
			</td>
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
					<? 
						$query = "SELECT * FROM posts ORDER BY 1 DESC";
						$result = $db->execute($query);
						include("navigationcall.php");
					?>
				</td>
				<td width="10"><? // Seperator --------?> </td>
				<td valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="btitle">Albums &amp; Pictures</td>
						</tr>
					</table><br />
					<table border="0" class="box1" width="100%" cellpadding="0" cellspacing="1" align="center">
						<tr class="th" height="22">
							<td align="center"  width="5%"></td>
							<td align="center"  width="5%">No</td>
							<td align="center"  width="10%">Created Date</td>
							<td align="center"  width="20%">Name</td>
							<td align="center"  width="20%">Album</td>
							<td align="center"  width="25%">Content</td>
							<td align="center"  width="5%">Add Picture</td>
							<td align="center"  width="5%">Edit</td>
							<td align="center"  width="5%">Delete</td>
						</tr>
						<?  $subcount=0;
							$treecount=0;
							$style="tr1";						
							$rs_menu=$db->execute("SELECT id, name, link FROM ".TBL_MENUS." ORDER BY id");
							$album_number=0;
							while($res = $db->row($result)){
								$album_number++;
								$row_menu=$db->row($rs_menu);
						?>
						<tr class="<?=$style?>">
							<td align="center" class="th"><img src=<?=IMGPLUS?> name="img<?=$treecount?>" onclick="DISPLAULISTING('<?=$treecount?>')"/></td>
							<td align="center"><?=$album_number?></td>
							<td align="center" ><label for="main_<?=$row_menu["id"]?>"><?=$res["post_date"]?></label></td>
							<td align="center" ><?=$res["post_title"]?></td>
							<td align="center" ><img src="photos/<?php echo $res["post_image"]; ?>" width="200" height="150"></td>
							<td align="center" ><?=$res["post_content"]?></td>
							<td align="center"><a href="picture_add.php?add=<?php echo $res["post_id"]; ?>"><img src="images/plus.jpg"/></a></td>
							<td align="center"><a href="edit_posts.php?edit=<?php echo $res["post_id"]; ?>"><img src="images/change.png"/></a></td>	
							<td align="center"><a href="delete.php?del=<?php echo $res["post_id"]; ?>"><img src<?=IPDELETE?></a></td>
						</tr>
						<tr>
							<td colspan="9">
							<div id="tree_<?=$treecount?>" style="visibility: hidden; display:none">
								<table border="0" cellspacing="1" cellpadding="1" width="100%" align="center" class="box2">
								<tr class="th" height="22">
									<th align="center"  class="th1" width="5%"></th>
									<th align="center"  class="th1" width="5%">no</th>
									<th align="center"  class="th1" width="15%">Album name</th>
									<th align="center"  class="th1" width="10%">Added Date</th>
									<th align="center"  class="th1" width="15%">picture name</th>
									<th align="center"  class="th1" width="15%">picture</th>
									<th align="center"  class="th1" width="25%">Content</th>
									<th align="center"  class="th1" width="5%">edit</th>
									<th align="center"  class="th1" width="5%">delete</th>
								</tr>
						<?	$style1="tr1";
							$rs_submenu=$db->execute("SELECT id, name ,link FROM ".TBL_SUBMENUS." WHERE menuid='".$row_menu["id"]."'ORDER BY id");
							$rs_submenu1=$db->execute("SELECT posts.post_title, picures.id, picures.photo_id,picures.name,picures.date, picures.url, picures.memo FROM posts LEFT JOIN picures ON posts.post_id=picures.photo_id WHERE picures.photo_id='".$res["post_id"]."'");
							// while($row_submenu=$db->row($rs_submenu)){
							$picture_number=0;		
							while($row1=$db->row($rs_submenu1)){			
								$picture_number++;
							?>
								 <tr class="<?=$style1?>">
									 <td  class="th"></td>
									 <td align="center"><?echo $picture_number?></td>
									 <td align="center" ><?echo $row1["post_title"]?></td>
									 <td align="center" ><?echo $row1["name"]?></td>
									 <td align="center" ><?echo $row1["date"]?></td>		
									 <td align="center"><img src="photos/<?php echo $row1["url"]; ?>" width="150" height="50"></td>	
									  <td align="center" ><?echo $row1["memo"]?></td>
									 <td align="center"><a href="picture_edit.php?edit=<?php echo $row1["id"]; ?>"><img src="images/change.png"></a></td>
									 <td align="center"><a href="picture_delete.php?del=<?php echo $row1["id"]; ?>"><img src<?=IPDELETE?></a></td>
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
</script>
<? include("./include_member/footer.php");?>