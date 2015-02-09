<? 
class validation
{
	var $error = false;
	var $errormessage = "";
	var $errorcount = 0;
	var $width = "50%";
	var $cellpadding = "1";
	var $cellspacing = "1";
	var $title = "Errors:";
	var $image = "../images/btn_error.gif";
	var $messages = array();

	function isemail($email)
	{
		$sChars = "^[A-Za-z0-9\._-]+@([A-Za-z0-9-]{1,62})(\.[A-Za-z][A-Za-z0-9-]{1,62})+$";
		$bIsValid = true;
		if(!ereg("$sChars",$email))
		{
			$bIsValid = false;
		}
		return $bIsValid;
	}
	function ispassword($string,$minlength=4,$maxlength=100)
	{
		if(ereg("^[A-Za-z0-9._@-]{".$minlength.",".$maxlength."}$",$string))
			return true;
		else
			return false;
	}
	function isalphanum($string,$minlength=4,$maxlength=100)
	{
		if(ereg("^[A-Za-z0-9_-]{".$minlength.",".$maxlength."}$",$string))
			return true;
		else
			return false;
	}
	function islogin($string,$minlength=4,$maxlength=100)
	{
		if(ereg("^[A-Za-z0-9._@-]{".$minlength.",".$maxlength."}$",$string))
			return true;
		else
			//echo "returning false";
			return false;
	}
	function isnum($string,$minlength=1)
	{
		$string = trim($string);
		if( ereg( "^[-]{0,1}[0-9.]{".$minlength.",}$",$string ) )
			return true;
		else
			return false;
	}
	function isint($string,$minlength=1)
	{
		$string = trim($string);
		if( ereg( "^[-]{0,1}[0-9]{".$minlength.",}$",$string ) )
			return true;
		else
			return false;
	}
	function adderror($message)
	{
		$message = trim($message);
		if( $message !="" )
		{
			$this->messages[$this->errorcount]= $message;
			$this->errorcount++;
		}
	}
	function clear()
	{
		$this->errorcount = 0;
		$this->messages = array();
	}
	function show()
	{
		$table = "";
		if( $this->errorcount > 0)
		{
			echo  "<table width=\"100%\" cellpadding=\"".$this->cellpadding."\" cellspacing=\"".$this->cellspacing."\" class=\"errtable\" border=0>\r\n";
			echo  "<tr class=\"errhd\">\r\n";
			echo  "<td><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td width=\"99%\"  class=\"errhd\" align=\"left\">".$this->title."</td>\r\n</tr>\r\n</table></td>\r\n";
			echo  "</tr>\r\n";
			echo  "<tr>\r\n<td valign=\"top\" align=\"left\" class=\"errtext\">";
			echo  "";
			foreach( $this->messages as $msg )
			{
				echo  "» ".$msg."<br><br />\r\n";
			}
			//echo  "";
			echo  "</td>\r\n</tr>\r\n";
			echo  "</table>\r\n";
		}
		return $table;
	}
	function showerror(){
		if( $this->errorcount > 0)
		{
			echo "<div id=\"validation\"><div id=\"valid_heading\">".$this->title."</div><div id=\"valid_text\">";
			foreach( $this->messages as $msg )
			{
				echo "&raquo; ".$msg."<br />\r\n";
			}
			echo "</div></div>";
		}
	}
}
?>