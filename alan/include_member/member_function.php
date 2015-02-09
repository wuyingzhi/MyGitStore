<?
function cleanstockid($stockid){
	return preg_replace("/[\/ \\\ \s .]/","_",$stockid);
}
?>
<?
function createdir($dirname){
	if(mkdir(AB_PATH_CLIENT.$dirname)){
		chmod(AB_PATH_CLIENT.$dirname,0777);
		if(mkdir(AB_PATH_CLIENT.$dirname."/".IMGFOLDER)){
			chmod(AB_PATH_CLIENT.$dirname."/".IMGFOLDER,0777);
				if(file_exists(AB_PATH_CLIENT."include_client/_index.php_")){
					copy(AB_PATH_CLIENT."include_client/_index.php_",AB_PATH_CLIENT.$dirname."/index.php");
					//copy(AB_PATH_MEMBER."/path.php",AB_PATH_CLIENT.$dirname."/path.php");
					chmod(AB_PATH_CLIENT.$dirname."/index.php",0777);
				}
				/*
				if(file_exists(AB_PATH_CLIENT."include_client/_".IMGNO."_")){
					copy(AB_PATH_CLIENT."include_client/_".IMGNO."_",AB_PATH_CLIENT.$dirname."/".IMGFOLDER.IMGNO);
				}
				if(file_exists(AB_PATH_CLIENT."include_client/_".TNNO."_")){
					copy(AB_PATH_CLIENT."include_client/_".TNNO."_",AB_PATH_CLIENT.$dirname."/".IMGFOLDER.TNNO);
				}*/
			return true;
		}else{
			return false;
		}
	}else{
		return false;
	}
}
?>
<?
	function replacetags($strString)
	{
		$strString = str_replace("\r\n",chr(92)."n",trim(stripslashes($strString)));
		$strString = str_replace("[shop]","\"+shopname+\"",$strString);
		$strString = str_replace("[name]","\"+name+\"",$strString);
		$strString = str_replace("[date]","\"+date+\"",$strString);
		$strString = str_replace("[total]","\"+total+\"",$strString);
		$strString = str_replace("[curency]","\"+curname+\"",$strString);
		return $strString;
	}
?>
<?
	function registrationemail($memberid,$db){
		$rs = $db->execute("SELECT M.*,S.* FROM ".PFIX.TBL_MEMBER." M, ".PFIX.TBL_SHOP." S WHERE M.MEMBER_ID = S.MEMBER_ID AND M.MEMBER_ID ='".$memberid."'");
		//$rs2 = $db->execute("SELECT * FROM ".PFIX.TBL_SHOP." WHERE MEMBER_ID ='".$memberid."'");
		if($row = $db->row($rs) ){
			$strbody = "";
			
			//$ab_pass = preg_replace('/(.*?){3}?/', "$1*****", $row["PWD"]);
			$ab_pass = substr($row["PWD"], 0, 3);
			
			$strbody = "Thank you for registering at www.101shops.co.uk,\r\n";
			$strbody.= "Your shop at ".ROOT_CLIENT.$row["DIR_NAME"]."/"." by name ".$row["SHOP_NAME"]." is ready for building.\r\n";
			$strbody.= "Your username is: ".$row["LOGIN"]." and password starts with: ".$ab_pass."*****\r\nRegards,\r\n";
			$strbody.= "For any query contact us at ".INFO_EMAIL." \r\n";
			@mail($row["EMAIL"],"Thank you for registering at www.101shops.co.uk",$strbody,"From: ".INFO_EMAIL."\r\nBCC: ".INFO_EMAIL."\r\n");
		}
		
	}
?>