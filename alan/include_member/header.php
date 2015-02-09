<? !isset($userIsLogedIn)?$userIsLogedIn=false:""?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title><?=TITLE_DEFAULT?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="Mon, 01 Jan 2004 00:00:01 GMT" />
<link href="cssjs/menu.css" type="text/css" rel="stylesheet">
<link href="cssjs/cssmis.css" type="text/css" rel="stylesheet">
<script language="javascript" src="cssjs/getsub.js"></script>
</head>
<!--<body bottommargin="0" bgcolor="#2c3d47" leftmargin="0" topmargin="0">-->
<body bottommargin="0" bgcolor="" leftmargin="0" topmargin="0">
<br><br><br><br><br><br><br>
<table width="1100" align="center" bgcolor="#ffffff" border="0" valign="top" cellspacing="10" cellpadding="0">
<tr>
<td background="images/cploop.jpg" height="120" width="1100" colspan="2">
	<table width="1100" align="center" border="0" valign="top" cellspacing="0" cellpadding="0">
	<tr>
    	<td width="20" align="left" valign="top"></td>
     	<td align="left" width="103" valign="top"><img src="images/logo.png"> </td>
        <td width="841" align="right" valign="top" class="head3"><b><a href="include_member/member_logout.php" class="plink1">Logout</a></b> &nbsp; &nbsp;
            <p class="text3"><span class="text2"><?=ucfirst($_SESSION["apfname"]." ".$_SESSION["aplname"])?></span>&nbsp; &nbsp; &nbsp;<br />Welcome to Admin Panel. &nbsp; &nbsp; <br>
            Authorized Users Only. &nbsp; &nbsp; </td>
        </tr>
      </table>
</td>
</tr>
<tr>
	<td height="20"></td>
</tr>
