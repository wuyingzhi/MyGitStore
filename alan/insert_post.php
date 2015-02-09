
<?include("./include/config.php");?>
<?include("./include/db.php");?>
<?include("./include_member/member_auth.php");?>
<?include("./include/functions.php");?>
<?include("./include/validation.php");?>
<?include("./include/listing.php");?>
<? $db= new db();$db->connect(); $valid = new validation();?>

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
							<td class="btitle">Add Album</td>
						</tr>
					</table><br />
					<form method="post" action="insert_post.php" enctype="multipart/form-data">
					<table border="0" cellpadding="5" cellspacing="0" width="55%" class="box">
					   	<tr>	
							<td width="35%" class="td">Name</td>
							<td class="td"><input type="text" name="name" class="ip" /><?=REQUIRED?></td>
						</tr>
						<tr>
					  		<td class="td" width="">Select</td>
					  		<td class="td"><input type="file" name="image"><?=REQUIRED?></td>
				  		</tr>		
					  		<td class="td" width="">Image</td>
					  		<td class="td">
							<img src="photos/<?php if(isset($post_image)) echo $post_image;?>" width="100" height="100" id="im">
							</td>
				  		</tr>							
					 	<tr>
					  		<td class="td" width="">Album Scription</td>
					  		<td class="td"><textarea name="content" cols="30" rows="5" class="ip"></textarea><?=REQUIRED?></td>
				  		</tr>

				 		<tr>
					  		<td colspan="2" align="center">
							<input type="submit" name="submit" value="Add" class="ip2" />
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
if(isset($_POST['submit'])){			
	  $post_name = $_POST['name'];
	  $post_date = date('m-d-y');
	  $post_content = $_POST['content'];
	  $post_image= $_FILES['image']['name'];
	  $image_tmp= $_FILES['image']['tmp_name'];
	
	if($post_name=='' or $post_content=='' or $post_image==''){	
		echo "<script>alert('Any of the fields is empty');</script>";
		exit();
	}else {
		move_uploaded_file($image_tmp,"photos/$post_image");
		$db = new db();
		$db->connect();
		$insert_query = "insert into posts (post_title,post_date,post_author,post_image,post_keywords,post_content) values ('$post_name','$post_date','','$post_image','','$post_content')";
		
		if(mysql_query($insert_query)){
			
			echo "<script>alert('post published successfuly')</script>";
			echo "<script>location.href='menus.php';</script>";
		}
	}
}

?>

