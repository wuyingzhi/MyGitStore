<? include("include/config.php");?>
<? include("include/db.php")?>
<? include("include_member/member_secure.php");?>
<? include("./include/validation.php");?>
<?
	$db=new db();
	$db->connect();
	$valid = new validation();
?>
<?
$emailpass="";
//$status="No";
$status="Yes";
	if( isset($_POST["_task"]) && $_POST["_task"] == "Register" ){
		//$grname=$_POST["grname"];
		$loginid=$_POST["loginid"];
		$pass = $_POST["pass"];
		$cpass = $_POST["cpass"];
		$fname = $_POST["fname"];
		$lname = $_POST["lname"];
		$email = $_POST["email"];
		if($fname==""){
			$valid->adderror("Please Enter First Name");
		}	
		if($fname==""){
			$valid->adderror("Please Enter Last Name");
		}
		if($loginid==""){
			$valid->adderror("Please Enter Username");
		}
		if($pass==""){
			$valid->adderror("Please Enter Password");
		}
		if($pass!=$cpass){
			$valid->adderror("Confirm Password Not Matched! Please Try Again");
		}
		
		if($email==""){
			$valid->adderror("Please Enter Email Address");
		}
		// if($grname==""){
			// $valid->adderror("Please Enter Group Name");
		// }	
		
		if($valid->errorcount==0){	
			$id = $db->nextid(TBL_USERS,"userid");
			$db->update("INSERT INTO ".TBL_USERS." VALUES('".$id."','','".$loginid."','".$fname."','".$lname."',
		'".$pass."','".$email."','".$emailpass."',NOW(),'".$status."','No')");
			header("location:register.php?info=21");
			exit();
		}
	}
?>
<?
	$strPageHeading = TITLE_DEFAULT;
	$strPageTitle = $strPageHeading;
?>
<? !isset($userIsLogedIn)?$userIsLogedIn=false:""?>	
<html>
<head>
<title><?=isset($strPageTitle)?$strPageTitle:"Member Area"?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="Mon, 01 Jan 2004 00:00:01 GMT" />
<link href="cssjs/cssmis.css" type="text/css" rel="stylesheet">
</head>
</head>
<body bottommargin="0" bgcolor="#2c3d47" leftmargin="0" topmargin="0">
<form method="post" action="register.php" name="frmlogin">
<input type="hidden" name="_task" value="Register" />
<table width="1100" align="center" bgcolor="#ffffff" border="0" valign="top" cellspacing="10" cellpadding="0">
  <tr>
    <td background="images/cploop.jpg" height="180" width="984" colspan="2"><table width="1090" align="center" border="0" valign="top" cellspacing="0" cellpadding="0">
        <tr>
          <td width="381" align="left" valign="middle"><img src="images/logo.png"></td>      
        </tr>
      </table></td>
  </tr>
  <tr>
       <td colspan="2" align="center">
	 		<table border="0" cellpadding="0" cellspacing="0" width="50%">
		<tr>
			<td align="center"><? $valid->show();?></td>
		</tr>
	</table>
	 </td>
   </tr>  
   <tr>
       <td colspan="2">
	 	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
			<tr>
				<td align="center"><? include("./include_member/displayerror.php");?></td>
			</tr>
		</table>
	 </td>
   </tr>
  <tr>
    <td class="text4" valign="top">
    	<table border=0 cellspacing=0 cellpadding=10 width="55%" align="center" class="box">         
<tr>
<Td width="30%">
	<table border=0 cellspacing=0 cellpadding=10 width="100%" align="center"> 
	<Tr>
		<td width="150" align="center"><img src="images/sign-up.png" /></td>
	<tr>
		<td width="150" class="te" align="left">			
		</td>
	</tr>
	</Table>

</Td>
<td width="">
	<table cellpadding="2" cellspacing="0" border="0" width="100%" align="center">
	<tr>
		<td width="222" align="left"><img src="images/signup.gif" /></td>
	</tr>
	</table>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center" class="box1">
	<tr>
		<td class="errtext" align="right">All fields are required.</td>
	</tr>
    <tr>
		<td class="text5" align="left"><b>First Name</b><br /><input type="text" name="fname" value="" class="ip" /><?=REQUIRED?></td>
	</tr>
    <tr>
		<td class="text5" align="left"><b>Last Name</b><br /><input type="text" name="lname" value="" class="ip" /><?=REQUIRED?></td>
	</tr>
	<tr>
		<td class="text5" align="left"><b>User Name</b><br /><input type="text" name="loginid" value="" class="ip" /><?=REQUIRED?></td>
	</tr>
	<tr>
		<td class="text5" align="left"><b>Password</b><br><input type="password" name="pass" class="ip" /><?=REQUIRED?></td>
	</tr>
    <tr>
		<td class="text5" align="left"><b>Confirm Password</b><br><input type="password" name="cpass" class="ip" /><?=REQUIRED?></td>
	</tr>
    <tr>
		<td class="text5" align="left"><b>Email</b><br><input type="text" name="email" class="ip" /><?=REQUIRED?></td>
	</tr><!--
    <tr>
		<td class="text5" align="left"><b>Group</b><br><input type="text" name="grname" class="ip" /></td>
	</tr>-->
	<tr>
		<td align="left"><input type="submit" value=" Sign Up " class="ip" /></td>
	</tr>
    <tr>
          <td height="20" class="text5">Are You Already Member <a href="index.php" class="ilink">Click Here!</a></td>
    </tr>
	</table>	
</td>
</Tr>
</table>
		<br><br><br><br>
	</td>
  </tr>
  <? include("in-footer.php");?>
</table>
</form>
</body>
</html>