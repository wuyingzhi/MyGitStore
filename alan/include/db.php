<?php error_reporting(E_ALL);?>
<?php 
/****************** TABLE NAMES ********************/
	define("TBL_GROUPS", PFIX."groups");//
	define("TBL_USERS", PFIX."users");//
	define("TBL_GROUP_MENU_RIGHTS", PFIX."groupmenurights");//
	define("TBL_GROUP_SUBMENU_RIGHTS", PFIX."groupsubmenurights");//
	define("TBL_MENUS", PFIX."menus");//	
	define("TBL_SUBMENUS", PFIX."submenus");//	
	define("TBL_SENDMAIL", PFIX."sendmail");//	
	define("TBL_READMAIL", PFIX."receivedmail");//	
	define("TBL_PARTIES", PFIX."parties");//	
	define("TBL_WORK", PFIX."working");//	
	define("TBL_PG", PFIX."uploaddocument");		
	
	
class db
{
	var $connected = false;
	var $dbname = DATABASE;
	var $dbuser = USERNAME;
	var $dbpassword = PASSWORD;
	var $dbhost = HOST;
	var $pagesize = 100;
	function configure($user,$password,$database,$host="localhost",$pagesize = 10)
	{
		$this->dbuser = $user;
		$this->dbpassword = $password;
		$this->dbname = $database;
		$this->dbhost = $host;
		$this->pagesize = $pagesize;
	}
	
	function connect()
	{
		$this->connected = false;
		unset($this->link);
		if($this->link = @mysql_connect($this->dbhost,$this->dbuser,$this->dbpassword))
		{
			if(@mysql_select_db($this->dbname,$this->link))
			{
				$this->connected = true;
				return true;
			}
			else
			{
				$this->seterror(mysql_errno($this->link),mysql_error($this->link));
				return false;
			}
		}
		else // could not connect server
		{
			$this->seterror("","Could not connect to server.");
			return false;
		}
	}
 
	function execute($query)
	{
		if($this->connected)
		{
			if($result = mysql_query( $query, $this->link ))
			{
				return $result;
			}
			else
			{
				$this->seterror(mysql_errno($this->link),"".$query."<br />".mysql_error($this->link));
				return false;
			}
		}
		else
		{
			$this->seterror("No database connection open.");
			return false;
		}
	}
	
	function update($query)
	{
		if($this->connected)
		{
			if(mysql_query( $query, $this->link ))
			{
				return mysql_affected_rows($this->link);
			}
			else
			{
				$this->seterror(mysql_errno($this->link),"".$query."<br />".mysql_error($this->link));
				return false;
			}
		}
		else
		{
			$this->seterror("No database connection open.");
			return false;
		}
	}

	function delete($query)
	{
		if($this->connected)
		{
			if(mysql_query( $query, $this->link ))
			{
				return mysql_affected_rows($this->link);
			}
			else
			{
				$this->seterror(mysql_errno($this->link),"".$query."<br />".mysql_error($this->link));
				return false;
			}
		}
		else
		{
			$this->seterror("No database connection open.");
			return false;
		}
	}
	
	
	function boxlength(&$result){		
		$e=mysql_num_rows($result);
		if($e>99)
			return 3;
		else
			return 2;
	}

	function exists($table,$column,$value,$cond="")
	{
	$rs = $this->execute("SELECT COUNT(".$column.") AS TOTAL FROM ".$table." WHERE ".$column."='".$value."' ".$cond);
		$row = $this->row($rs);
		return $row["TOTAL"];
	}
	function rowcount(&$result)
	{
		return mysql_num_rows( $result);
	}
	function row(&$result)
	{
		if ( $row = mysql_fetch_assoc( $result ) )
				return $row;
			else
				return 0;
	}


function nextid1($table,$column="ID",$start=100000)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM uploaddocument");
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}


	function nextid($table,$column="ID",$start=100000)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}

// ids for stock----------------------------
	function categoryid($table,$column="ID",$start=110000)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 5000;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}


	function subcategoryid($table,$categoryid,$column="id")
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS id FROM ".$table." WHERE cid='".$categoryid."'" );
			$row = $this->row( $result );
			if ( !isset( $row["id"] ))
				return $categoryid + 200;
			else
				return $row["id"] + 200;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}


	function itemid($table,$categoryid,$subcategoryid,$column="ID")
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table." WHERE cid='".$categoryid."' and sid='".$subcategoryid."'" );
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $subcategoryid + 1;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}

//-------------- end ids code here--------------------------------
	function nextcrmaid($table,$column="ID",$start=100000)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}
	

	function nextbatchid($table,$column="ID",$start=1001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}



	function nextaccid($table,$column="ID",$start=10001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}
	
		function nextcustmerid($table,$column="ID",$start=100001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}
	
	function nextnoteid($table,$column="ID",$start=200001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}

	function nextinvoiceid($table,$column="ID",$start=200001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) || $row["ID"]==0 || $row["ID"]=="0")
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}

		function nextorderid($table,$column="ID",$start=100001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}

	function taccid($table,$column="ID",$start=1000001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}
	
	function stockcodeid($table,$column="ID",$start=1)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}

	function stockcode($table,$column="ID",$start=11)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}

	function getstockcodeid($table,$column="ID",$start=1000)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}


	function nextpcreditid($table,$column="ID",$start=4000001)
	{
		if($this->connected)
		{
			$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
			$row = $this->row( $result );
			if ( !isset( $row["ID"] ) )
				return $start;
			else
				return $row["ID"] + 1;
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
	}


	function lastid()
	{
		if($this->connected){
			$result = mysql_insert_id($this->link);
		}
		else{
			$this->seterror("No database connection open.");
			return 0;
		}
	}
	
	function getlastid($table,$column="ID",$start=1){
		if($this->connected){
				if($this->connected)
				{
					$result = $this->execute( "SELECT MAX(".$column.") AS ID FROM ".$table);
					$row = $this->row( $result );
					if ( !isset( $row["ID"] ) )
						return $start;
					else
					return $row["ID"] + 1;
				}
				else
				{
				$this->seterror("No database connection open.");
				return 0;
			}
		}
	}

	function seterror($number, $message, $fatal = true) 
	{
		$this->errornumber = $number;
		$this->errormessage = $message;
		if ($fatal) {
		  $this->showerror();
		  die();
		} 
	 }
	 function showerror()
	{
		echo "<BR><font face = vardana color='#ff0000'>".$this->errornumber.": ".$this->errormessage."</font>";
	}
	function free(&$result){
		@mysql_free_result($result);
	}
function breakpage($query)
{
	isset( $_GET["x"] )? $this->x = $_GET["x"] : $this->x = 1;
	if ( isset( $_GET["t"] ) )
	{ 
		$this->t = $_GET["t"] ;
	} 
	elseif( !isset($_GET["t"]) )
	{
		$this->t = $this->update($query);
	}
	$query = $query." LIMIT ".($this->x-1) * $this->pagesize.",".$this->pagesize;
	return $this->execute($query);
}
function writepage($page)
{
	if ( ( $totalpages = ceil( $this->t / $this->pagesize ) ) == 0 )
		$this->x = 0;

	$output = "<CENTER><font face='verdana' size='1'><b>Page ".($this->x)." of ".$totalpages."</b> Total ".$this->t." Record(s)<br>";

	if( $this->x == 0 || $this->x == 1 )
		$output.= "Prev ";
	else
		$output.= "<a href='".$page."t=".$this->t."&x=".($this->x-1)."'>Prev</a>";
	
	for( $k = 1 ; $k <= $totalpages ; $k++ )
	{
		if ( $k != $this->x )
			$output.=" | <a href='".$page."t=".$this->t."&x=".($k)."'>".($k)."</a>";
		else
			$output.=" | ".$k ;
	}
	
	if( $this->x == $totalpages )
		$output.= " | Next";
	else
		$output.= " | <a href='".$page."t=".$this->t."&x=".($this->x+1)."'>Next</a>";
	
	$output.="</CENTER>";
	return $output;
}
	
	function close()
	{
		@mysql_close($this->link);
		$this->connected = false;
	}
	
	function clean($string)
	{
		return str_replace('"',"&#34;",str_replace("'","&#39;",stripslashes(trim($string))));
	}

	function formatamount($numamount){
		//return $numamount;
		return number_format($numamount,2);
	}
	function formatdate($mysql_stamp,$type=1)
	{
		//$type = 1 date + time
		//$type = 2 date
		//$type = 3 time
		// split mysql DATETIME stamp into date and time
		if($mysql_stamp==""){
			return "";
		}
		@list($date, $time) = split ('[ ]', $mysql_stamp);
		@list($year, $month, $day) = split ('[-]', $date);
		if( isset($time) && $time != "" )
		{
			list($hour, $minute, $second) = split ('[:]', $time);
			if($hour>=12)
			{
				$ext = "PM";
				$hour = $hour - 12;
			}
			else
			{
				$ext = "AM";
			}
			$time =  " ".$hour.":".$minute." ".$ext;
		}
		else
		{
			$hour="";
			$minute= "" ;
			$ext = "";
			$time = "";
		}
		
		if($type == 1)
			$formatted_stamp = "$day/$month/$year".$time;
		elseif($type==2)
		{
			$formatted_stamp = "$day/$month/$year";
		}
		elseif($type==3)
			$formatted_stamp = $time;

		return $formatted_stamp;
	}
	
	function nltobr($strstring){
		return str_replace("\r\n","<br />",$strstring);
	}
	function brtonl($strstring){
		return str_replace("<br />","\r\n",$strstring);
	}

	function writetrack($strdata){
		if($fh = fopen(TRACK_FILE,'a')){
			chmod(TRACK_FILE,0777);
			fwrite($fh,date("Ymd")."\t".date("H:i:s")."\t".$_SERVER["REMOTE_ADDR"]."\t".$strdata."\r\n");
			fclose($fh);
			return true;
		}else{
			return false;
		}
	}

	function tosqldate($strdata){
		$strdata = trim($strdata);
		if($strdata==""){
			return "";
		}
		$arrdate = explode("/",$strdata);
		if(count($arrdate) < 3){
			return "";
		}else{
			return $arrdate[2]."-".$arrdate[1]."-".$arrdate[0];
		}
	}

	function cut($str,$length=30){
		if(strlen($str)<$length){
			return $str;
		}else{
			$str = substr($str,0,$length-3);
			$str.="...";
		}
		return $str;
	}

	function nextcharid($table,$numcol,$charcol,$chr='S',$maxnum=999999){
		$arr = array(0=>$chr,1=>100000);
		if($this->connected)
		{
			$result = $this->execute("SELECT ".$numcol." AS ID,".$charcol." CHR FROM ".$table." where ".$charcol."='".$chr."' order by ".$charcol." desc, ".$numcol." desc limit 0,1");
			if($row = $this->row( $result )){
				$row["CHR"] = strtoupper($row["CHR"]);
				if($row["ID"]<$maxnum){
					$arr[0] = trim($row["CHR"]) == "" ? $chr : $row["CHR"];
					$arr[1] = $row["ID"] == 0 ? 100000 : $row["ID"]+1;
				}else{
					$arr[1] = 100000;
					$arr[0] = chr((ord($row["CHR"])+1));
				}
			}
			else{
				return $arr;
			}
		}
		else
		{
			$this->seterror("No database connection open.");
			return 0;
		}
		return $arr;
	}
	
	function adddays($date,$days){
		$rs = $this->execute("select DATE_FORMAT(DATE_ADD('$date',INTERVAL $days DAY),'%Y-%m-%d') as newdate");
		if($row = $this->row($rs)){
			return $row["newdate"];
		}else{
			return "0000-00-00";
		}
	}
	
	function getconfig($key){
		$rs = $this->execute("select configvalue from ".TBL_CONFIG." where configname='".$key."'");
		if($row = $this->row($rs)){
			return $row["configvalue"];
		}else{
			return "";
		}
	}
	
	function setconfig($key,$value){
		$this->update("update ".TBL_CONFIG." set configvalue='".$value."' where configname='".$key."'");

	}
	
	
	function datediff($sdate,$edate){
		$rs = $this->execute("select to_days('$edate') - to_days('$sdate') as diff");
		if($row = $this->row($rs)){
			return $row["diff"];
		}else{
			return "0";
		}
	}

	function generate_passwd($length = 8,$password="") {
	  static $chars = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ23456789';
	  $chars_len = strlen($chars);
	  for ($i = 0; $i < $length; $i++)
    	$password .= $chars[mt_rand(0, $chars_len - 1)];
	  return $password;
	}
}
?>
<?
// new defines-----------------------
define("FOOTER",'<tr>
    <td width="984" height="50" align="center" bgcolor="#121c24" class="text1" colspan="2">&nbsp; &nbsp; &nbsp; Copyright &copy; 2015 <a href="http://amazon.com">alan</a>. All Rights Reserved. </td>
  </tr>');
define("FOOTAR",'  <tr>
    <td width="984" height="50" align="center" bgcolor="#121c24" class="text1" colspan="2">&nbsp; &nbsp; &nbsp; Copyright &copy; 2015 <a href="http://amazon.com">alan</a>. All Rights Reserved </td>
  </tr>
</table>
</body>
</html>
');
?>
