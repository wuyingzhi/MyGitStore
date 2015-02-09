<? include("config.php");?>
<? include("db.php");?>
<? $db = new db(); $db->connect();?>
<?
isset($_GET["cid"]) && $_GET["cid"]!=""?$cid=$_GET["cid"]:$cid="";
isset($_GET["sid"]) && $_GET["sid"]!=""?$sid=$_GET["sid"]:$sid="";
$rs=$db->execute("SELECT * FROM subcategories WHERE cid='".$cid."' and status='Yes' order by name");?>
<SELECT name="sid" class="text4">
<option value="">--Select Subcategory--</option>
<? while($row=$db->row($rs)){?>
<option value="<?=$row["id"]?>" <?=$sid==$row["id"]?"selected":""?>><?=$row["name"]?></option>
<? }?></SELECT>

