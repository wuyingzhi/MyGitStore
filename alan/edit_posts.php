

<html>
	<head>
		<title>Admin Panel</title>
	
	<!--  <link rel="stylesheet" href="admin_style.css" />-->
	<script>
		function setImage() {
			//var img = document.getElementById("imageid").src="sdfsf";
			//document.write("DSFSDFAFDSAFAFDSAFSAFSDFSAFSDFS");
			//alert(document.getElementById("imageid").src);
			//document.getElementByName("title").value="xxx";
		}
	</script>
	</head>
	
<body>
<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>

<?
if(isset($_GET['edit'])){ 

	$edit_id = $_GET['edit'];
	$db = new db();
	$db->connect();
	$edit_query = "select *from posts where post_id='$edit_id'";
	$run_edit = mysql_query($edit_query); 
	
	while ($edit_row=mysql_fetch_array($run_edit)){
		$post_id = $edit_row['post_id'];
		$post_title = $edit_row['post_title'];
		//$post_author = $edit_row['post_author'];
		//$post_keywords = $edit_row['post_keywords'];
		$post_image = $edit_row['post_image'];
		$post_content = $edit_row['post_content'];
	}
}
?>

<? include("./include_member/header.php");?>
<tr>
<td align="center" coslpan="">
	<table border="0" cellpadding="0" cellspacing="0" width="60%">
		<tr>
			<td align="center"><? $valid->show();?></td>
			
		</tr>
	</table>
</td>
</tr>
<tr>
<td with="" align="center" colspan="2">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td width="" align="center">&nbsp;<? include("./include_member/displayerror.php"); ?></td>
			
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
				<td width="100"><? // Seperator --------?> </td>
				<td valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="btitle">Edit Album</td>
						</tr>
					</table><br />
					<form method="post" action="edit_posts.php?edit_form=<?php if(isset($edit_id)) echo $edit_id; ?>" enctype="multipart/form-data">
					<table border="0" cellpadding="5" cellspacing="0" width="55%" class="box">
					   	<tr>	
							<td width="35%" class="td">Name</td>
							<td class="td"><input type="text" name="title"  value="<?php if(isset($post_title)) echo $post_title; ?>" class="ip" /><?=REQUIRED?></td>
						</tr><!--
						<tr>
					  		<td class="td" width="">Select</td>
					  		<td class="td"><input type="file" name="image" value="photos/<?php if(isset($post_image)) echo $post_image;?>"><?=REQUIRED?></td>
				  		</tr>	-->	
						<tr>
					  		<td class="td" width="">Image</td>
					  		<td class="td"><img src="photos/<?php if(isset($post_image)) echo $post_image;?>" width="100" height="100"></td>
				  		</tr>						
					 	<tr>
					  		<td class="td" width="">Album Scription</td>
					  		<td class="td"><textarea name="content" cols="30" rows="5" class="ip"><?php if(isset($post_content)) echo $post_content; ?></textarea><?=REQUIRED?></td>
				  		</tr>
				 		<tr>
					  		<td colspan="2" align="center">
							<input type="submit" name="update" value="Update Now" class="ip2" />
							</td>
						</tr>
					</table>
					</form>
				</td>
				<td width="15%" align="left" valign="top"></td>
			</tr>
		</table>
	</td>
</tr>

<? include("./include_member/footer.php");?>
<?php	
	if(isset($_POST['update'])){	
	  $update_id = $_GET['edit_form'];
	  $post_title1 = $_POST['title'];
	  $post_date1 = date('m-d-y');
	 // $post_author1 = "invalid";
	 // $post_keywords1 = $_POST['invalid'];
	  $post_content1 = $_POST['content'];
	  //$post_image1= $_FILES['image']['name'];	print_r($_FILES);exit;
	  //$image_tmp= $_FILES['image']['tmp_name'];
	
	?>
	<script>
		//document.getElementById("imageid").src="photos/download.jpg";
	</script>
	<?
		//if($post_title1=='' or $post_content1=='' or $post_image1==''){
		if($post_title1=='' or $post_content1==''){
			echo "<script>alert('Any of the fields is empty')</script>";
			exit();
		}else { 
			//move_uploaded_file($image_tmp, "photos/$post_image1");
			//$update_query = "update posts set post_title='$post_title1',post_date='$post_date1',post_author='',post_image='$post_image1',post_keywords='',post_content='$post_content1' where post_id='$update_id'";
			$update_query = "update posts set post_title='$post_title1',post_content='$post_content1' where post_id='$update_id'";
			if(mysql_query($update_query)){           
				//echo "<script>alert('success');</script>";
				echo "<script>window.open('menus.php','_self')</script>";
			}
	
		}
	}



?>