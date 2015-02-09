<? include("include/config.php");?>
<? include("include/db.php")?>
<? include("include_member/member_secure.php");?>
<?
	$db=new db();
	$db->connect();
?>
<?
	if( isset($_GET["_em"]) && $_GET["_em"]!="" ){
		$em = $_GET["_em"];
		$rs = $db->execute("SELECT email FROM ".TBL_USERS." WHERE loginid ='".$em."'");
		if($db->rowcount($rs)){
			$row=$db->row($rs);
			$email_text = "<html><head>";
			$email_text = $email_text.'
			<body>
				<table border="0" cellspacing="0" cellpadding"0" width="50%" align="center">
					<tr>
						<td><font face="arial" size="2"><b>Password:</b></font></td><td><b>'.$em.'</b></td>
					</tr>
				</table>	
			</body>
			</html>';		
			
			$xheaders = ""; 
			$xheaders .= 'MIME-Version: 1.0' . "\r\n";
			$xheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$xheaders .= 'X-Priority: 1'."\r\n";
			$xheaders .= "From: support@yourdomainname.com\r\n"; 
			$subject = "Reset Password";
			$to = $row["email"];
			$mail=@mail($to, $subject, $email_text, $xheaders);	
			header("location:index.php?info=29");
			exit();
		}else{
			header("location:index.php?info=1");
			exit();
		}
	}

	isset($_GET["uid"]) ? $aplogin = $_GET["uid"] : $aplogin="";
	if( isset($_POST["_task"]) && $_POST["_task"] == "Login" ){
		$aplogin = trim($_POST["userid"]); 
		$strpassword = $_POST["pwd"];
		
		$rs = $db->execute("SELECT userid,groupid,loginid,pwd,firstname,lastname,lastlogin,email,master FROM ".TBL_USERS."
								 WHERE loginid ='".$aplogin."'");		//$row = $db->row($rs);	 print_r($strpassword);echo ":";print_r($row["pwd"]);exit;
		if($row = $db->row($rs)){ 
			$urid = $row["userid"];		 
			if($strpassword == $row["pwd"]){	
				// $rsG = $db->execute("SELECT * FROM ".TBL_GROUPS." WHERE id='".$row["groupid"]."' and status='Yes'");
				// if($db->rowcount($rsG)<=0){
					// header("location:index.php?info=26");
					// exit();
				// }
				$rsU = $db->execute("SELECT * FROM ".TBL_USERS." WHERE userid='".$urid."' and status='Yes'");
				if($db->rowcount($rsU)<=0){
					header("location:index.php?info=3");
					exit();
				}
				$apid = $row["userid"];
				$aplogin = $row["loginid"];
				$apfname = $row["firstname"];
				$aplname = $row["lastname"];
				$aplastlogin = $row["lastlogin"];	
				$apemail = $row["email"];
				//$grname= $row["groupid"];
				$master = $row["master"];
						  
					session_register("apid");
					session_register("aplogin");
					session_register("apfname");
					session_register("aplname");
					session_register("aplastlogin");
					session_register("apemail");
					session_register("RESUME_SESSION_AGAIN");
					session_register("ground");
					session_register("ismaster");
				
					$_SESSION['apid'] = $apid;
					$_SESSION['alogin'] = $aplogin;
					$_SESSION['apfname'] = $apfname;
					$_SESSION['aplname'] = $aplname;
					$_SESSION['grname'] = $grname;
					$_SESSION['apemail'] = $apemail;
					$_SESSION['aplastlogin'] = $aplastlogin;
					$_SESSION["ismaster"]=$master;
					$_SESSION["ground"]="No";
					if(isset($_POST["ground"])){
						$_SESSION["ground"]="Yes";
					}
																	
				if(isset($_SESSION["RESUME_SESSION_AGAIN"]) && $_SESSION["RESUME_SESSION_AGAIN"]!=""){
						header("location:".$_SESSION["RESUME_SESSION_AGAIN"]);
						exit();
					}else{
						//header("location:welcome.php");
						header("location:menus.php");
						exit();
				}

				$db->update("UPDATE ".TBL_USER." SET lastlogin = NOW() WHERE userid='".$smid."'");
			}else{
				header("location:index.php?info=2");
				exit();
				}
  		 }else{
			header("location:index.php?info=1");
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
<form method="post" action="index.php" name="frmlogin">
<input type="hidden" name="_task" value="Login" />
<input type="hidden" name="_action" value="Login" />
<table width="1100" align="center" bgcolor="#ffffff" border="0" valign="top" cellspacing="10" cellpadding="0">
  <tr>
    <td background="images/cploop.jpg" height="130" width="984" colspan="2"><table width="1090" align="center" border="0" valign="top" cellspacing="0" cellpadding="0">
        <tr>
          <td width="381" align="left" valign="middle"><img src="images/logo.png"></td>      
        </tr>
      </table></td>
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
		<td width="150" align="center"><img src="images/lock.gif" /></td>
	<tr>
		<td width="150" class="te" align="left">
		Welcome to the (YourApplicationName) Admin Panel.
<br><br>Please enter a valid Login ID and Password to access the Console.<br><br><br> <b>Don't have a ID?</b><br>Signing up is easy.<br><br><a href="register.php" class="dlink">Sign up NOW!</a>	
		</td>
	</tr>
	</Table>

</Td>
<td width="">
	<table cellpadding="2" cellspacing="0" border="0" width="100%" align="center">
	<tr>
		<td width="222" align="left"><img src="images/logotext.gif" /></td>
	</tr>
	</table>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center" class="box1">
	<tr>
		<td></td>
	</tr>
	<tr>
		<td class="text5" align="left"><b>Login</b><br /><input type="text" name="userid" value="" class="ip" /><?=REQUIRED?></td>
	</tr>
	<tr>

		<td class="text5" align="left"><b>Password</b><br><input type="password" name="pwd" class="ip" /><?=REQUIRED?></td>
	</tr>
	<tr>
		<td align="left"><input type="submit" value=" Login " class="ip" /></td>
	</tr>
    <tr>
          <td height="20"></td>
    </tr>

	</table>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center" class="">
	<tr height="10"><td></td></tr>
	</table>
	<table cellpadding="4" cellspacing="0" border="0" width="100%" align="center" class="box1">
    <tr>
          <td class="text5" align="left">&nbsp;<b>Forgot your password?</b><br>
            <br>&nbsp;Enter your Login ID and your &nbsp;Password will be E-mailed to<br> &nbsp;you from amazon.com</td>

        </tr>
        <tr>
          <td align="left">&nbsp;<input type="text" size="35" id="domain" name="domain" style="font-size:10px; font-family:verdana">
          </td>
        </tr>
        <tr>
          <td align="left">&nbsp;<input type="button" value="Email" name="email" onClick="RESETPASS()" class="ip"> </td>

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
<script language="javascript">
	function RESETPASS(){
		em = document.getElementById("domain").value;
		location.href="index.php?_em="+em;
	}
</script>
</body>
</html>