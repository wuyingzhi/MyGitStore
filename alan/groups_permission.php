<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include_member/member_secure.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>
<?
isset($_GET["gr"]) && $_GET["gr"]!="" ? $grid = $_GET["gr"] : $grid="";
if(isset($_POST["_task"]) && $_POST["_task"]=="per"){
$grid = $_POST["grid"];
$TM = $_POST["TM"];
$TS = $_POST["TS"];
$db->update("DELETE FROM ".TBL_GROUP_MENU_RIGHTS." WHERE groupid='".$grid."'");
for($loop=0;$loop<$TM;$loop++){
if(isset($_POST["menu_".$loop])){
$db->update("INSERT INTO ".TBL_GROUP_MENU_RIGHTS." 
									VALUES('".$grid."','".$_POST["menu_".$loop]."','".$_POST["MPO_".$loop]."')");
}
}
$db->update("DELETE FROM ".TBL_GROUP_SUBMENU_RIGHTS." WHERE groupid='".$grid."'");
for($loop=0;$loop<$TS;$loop++){
if(isset($_POST["submenu_".$loop])){
$db->update("INSERT INTO ".TBL_GROUP_SUBMENU_RIGHTS." 
		  VALUES('".$grid."','".$_POST["MU_".$loop]."','".$_POST["submenu_".$loop]."','".$_POST["SPO_".$loop]."')");
}
}
header("location:groups_permission.php?info=8");
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
							<td class="btitle">Set Group Permissionss</td>
						</tr>
					</table><br />
					<form name="addnew" acton="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return CON()">
					<input type="hidden" name="_task" value="per" />
					<table border="0" cellspacintg="0" cellpadding="0" width="100%" align="left">
					<tr>
						<td align="left" width="100" class="text5">Select Group:<?=REQUIRED?></td>
						<td align="left" width="80">
						<select name="grid" id="menuid" class="selectbox">
							<option value=""></option>
							<?
								$rsM = $db->execute("SELECT id, name FROM ".TBL_GROUPS." WHERE status='Yes'");
								while($rowM = $db->row($rsM)){
							?>
								<option value="<?=$rowM["id"]?>" <?=$grid==$rowM["id"]? "selected" : ""?>><?=$rowM["name"]?></option>
							<? }?>
						</select>
						</td>
						<td align="left"><input type="button" value="Load Permissions" class="btn" onclick="MENU()"/></td>
					</tr>
				</table><br />
				<table border="0" cellpadding="0" cellspacing="0" width="80%">
					<?		
					$stM="";
					$stS="";
					$M=0;
					$S=0;
					$rs_menu=$db->execute("SELECT id, name, link FROM ".TBL_MENUS." ORDER BY id");
					while($row_menu=$db->row($rs_menu)){
						$rsM = $db->execute("SELECT * FROM ".TBL_GROUP_MENU_RIGHTS." WHERE groupid='".$grid."' and menuid='".$row_menu["id"]."'");
						if($db->rowcount($rsM)){$rowM=$db->row($rsM); $stM="checked";}else{$stM="";}
					?>		
					<tr class="tr2" height="23">
						<td align="center" width="4%" class="th"><input type="checkbox" name="menu_<?=$M?>" value="<?=$row_menu["id"]?>" <?=$stM?>/></td>
						<td>&nbsp;<?=$row_menu["name"]?></td>
						 <td><input type="text" size="1" name="MPO_<?=$M?>" value="<?=isset($rowM["position"]) ? $rowM["position"] : ""?>" /></td>
					</tr>
					<tr>
						<td colspan="5">
							<table border="0" cellspacing="1" cellpadding="1" width="96%" align="right">
					<?	$style1="tr";
						$rs_submenu=$db->execute("SELECT id, name ,link FROM ".TBL_SUBMENUS." WHERE menuid='".$row_menu["id"]."'ORDER BY id");
						while($row_submenu=$db->row($rs_submenu)){
						$rsS = $db->execute("SELECT * FROM ".TBL_GROUP_SUBMENU_RIGHTS." 
									WHERE groupid='".$grid."' and menuid='".$row_menu["id"]."' and submenuid='".$row_submenu["id"]."'");
						if($db->rowcount($rsS)){$rowS=$db->row($rsS); $stS="checked";}else{$stS="";}
						?>
								 <tr class="<?=$style1?>">
									<td align="center" width="1" class="th"><input type="checkbox" name="submenu_<?=$S?>" value="<?=$row_submenu["id"]?>" <?=$stS?>/><input type="hidden" name="MU_<?=$S?>" value="<?=$row_menu["id"]?>" /></td>
									 <td width="450"><?=$row_submenu["name"]?></td>
									 <td><input type="text" size="1" name="SPO_<?=$S?>" value="<?=isset($rowS["position"])? $rowS["position"] :""?>"/></td>
								</tr>
								<? $S++;
								   $style1=="tr" ? $style1="tr2" : $style1="tr";			
								}?>
							</table>
						<? 	$M++;
						}?>	
						</td>
					</tr>
					<? if($grid!=""){?>
					<tr>
						<td height="10"></td>
					</tr>
					<tr>
						<td></td>
						<td align="left"><input type="submit" value="Update Permissions" class="btn" /></td>
					</tr>
					<? }?>
					</table>
					<input type="hidden" name="TM" value="<?=$M?>" /> <input type="hidden" name="TS" value="<?=$S?>" />
					</form>
				</td>
				<td width="20" align="left" valign="top"></td>
			</tr>
		</table>
	</td>
</tr>
<script language="javascript">
	function MENU(){
		gr = document.getElementById("menuid").value;
		location.href="groups_permission.php?gr="+gr;
	}
	
	function CON(){
		if(!confirm("Are You Sure? You wants to Update Group Permissions ?")){
			return false;
		}
	}
</script>

<? include("./include_member/footer.php");?>