<?
	function getDay($da){
		$year = substr($da, 6,4); 
		$month = substr($da, 3,2); 
		$day = substr($da, 0,2); 
		
		return date("D d/m/Y", mktime(0, 0, 0, $month, $day, $year)); 
	}
//------------- end getDay function-------------------

	function gettotalminutes($usertime){
			$hours1=substr($usertime,0,2);
			$minutes1=substr($usertime,3,2);
			
			$hours2=($hours1 * 60);	// get total minutes
			return $hours2 + $minutes1;
		}

  //----------- end gettotalminutes funcitons------------------
  
  function pageimage($img,$txt){
   echo "<img src='./images/icons/".$img.".jpg' style='padding-left:10px' height='30'><td class=he align='left'>".$txt;
  }
  //------------ end page image function----------------------
  
  function displayimages($img,&$db){
   	$imgname = $img;
	if($img=="buildlist"){
		$img="build list";
		}
	elseif($img == "pcconfig"){
		$img = "pc config";	
		}
	elseif($img == "emailtext"){
		$img = "email text";	
		}
		
	
  	$rs=$db->execute("SELECT * FROM ".TBL_MENU." WHERE usermenuid='".$_SESSION["usermenuid"]."' and permission='Yes' and menu='".strtoupper($img)."'");
		if($db->rowcount($rs)){
			$row=$db->row($rs);
			echo "<a href='".$row["link"]."'><img src='./images/".$imgname.".gif' border='0'></a>";
		}
		else{
			echo "<img src='./images/".$imgname."_g.gif'>";
		}
	}  
	
	// --------------------------end of function displayimages----------------
	
  function displayimagessub($img,&$db){
   	$imgname = $img;
	if($img=="buildlist"){
		$img="build list";
		}
	elseif($img == "pcconfig"){
		$img = "pc config";	
		}
	elseif($img == "emailtext"){
		$img = "email text";	
		}
		
	
  	$rs=$db->execute("SELECT * FROM ".TBL_SUBMENU." WHERE usermenuid='".$_SESSION["usermenuid"]."' and permission='Yes' and submenu='".strtoupper($img)."'");
		if($db->rowcount($rs)){
			$row=$db->row($rs);
			echo "<a href='".$row["link"]."'><img src='./images/".$imgname.".gif' border='0'></a>";
		}
		else{
			echo "<img src='./images/".$imgname."_g.gif'>";
		}
	}  
	
	// --------------------------end of function displayimages sub----------------

function check_if_exists($tbl,$fld1,$fld2)
{
	$rs_n1 = mysql_query("select $fld1 as t from $tbl where $fld1='$fld2'");
	$name = mysql_fetch_object($rs_n1);
	return $name->t;	
}
function item_name($typeid1)
{
	$rs_n1 = mysql_query("select itemname from mis_item where itemid='$typeid1'");
	$name = mysql_result($rs_n1,0,"itemname");
	return $name;
}
function location_name($typeid1)
{
	$rs_n1 = mysql_query("select locnamelong from mis_location where locationid='$typeid1'");
	$name = mysql_result($rs_n1,0,"locnamelong");
	return $name;
}


	function getspec($id,&$db){
		$str = "";
		$rs = $db->execute("select * from ".TBL_ORDER." where  id = '".$id."'");
		
		while($row=$db->row($rs)){
			$str.= $row["order_qty"] > 1 ? $row["order_qty"]."x " : "";
			$str.= $row["item_title"].", ";
		}
		return $str;
	}

	function getspeccost($id,&$db){
		$str = "";
		$rs = $db->execute("select sum(d.qty*i.price) as total from ".TBL_SPEC_D." d,".TBL_ITEM." i where d.itemid = i.itemid and d.specid = '".$id."' and d.isvalid=1");
		if($row=$db->row($rs)){
			return $row["total"];
		}
		return 0;
	}
	
	function get_field($table,$fieldtofetch,$givenfield,&$db){
		$str = "";
		$rs = $db->execute("select $fieldtofetch as ff from $table where $givenfield");
		if($row=$db->row($rs)){
			return $row["ff"];
		}
		return 0;
	}	

	function getusername($userid){
		$rs = mysql_query("select firstname,lastname from mis_admin where userid='$userid'");
		$rs55 = mysql_fetch_object($rs);
		if($rs55->firstname!="" or $rs55->lastname!=""){
			$username = $rs55->firstname." ".$rs55->lastname;
		}else{
			$username = "Unknown";		
		}
		return $username;
	}


	function getinvoicetotal($id,&$db)
	{
		$numconst = 40/47;
		$res["sell_price"]= 0;
		$res["shipping"] = 0;
		$res["vat"] = 0;
		$res["surcharge"] = 0;
		$res["total"] = 0;
		$res["amountex"]= 0;
		$rs = $db->execute("select sell_price, shipping, upgrades, surcharge from ".TBL_ORDER." o where o.id = '".$id."'");
		if(!$row = $db->row($rs)){
			return $res;
	}
			
		$res["sellprice"]=$row["sell_price"] * 1.175;
		$res["shipping"]=$row["shipping"] * 1.175;
		$res["upgrades"]=$row["upgrades"] * 1.175;

		// get surcharge--------------
		
		$rs_sur = $db->execute("SELECT SUM(csurcharge) AS st FROM ".TBL_ORDER_PAYMENT." WHERE orderid='".$id."'");
		if($db->rowcount($rs_sur)){
				$row_sur = $db->row($rs_sur);
				$res["surcharge"]=$row_sur["st"];
			}else{
				$res["surcharge"]=0;
			}
			
		
		$res["total"] = $res["sellprice"] + $res["shipping"] + $res["upgrades"] + $res["surcharge"];
		return $res;

	/*	OLD CALCULATION
		$res["total"] = ($row["amount"]+$row["upgrades"]+$row["shipping"]+(($row["amount"]+$row["upgrades"]+$row["shipping"])* ($row["surcharge"]/100)));
		$res["total_ws"] = $row["amount"]+$row["upgrades"]+$row["shipping"];

		$row["amount"] = ($row["amount"]+$row["upgrades"]) * $numconst; // get net
		$row["upgrades"] = $row["upgrades"] * $numconst; // get the net
		$row["shipping"] = $row["shipping"] * $numconst;// get the net

		$unitprice = $db->formatamount($row["amount"]);
		
		$amountex = ($unitprice * $row["order_pcs"]);
		$vat = ($amountex + $row["shipping"]) * (VAT/100);
		$gtotal=$amountex + $row["shipping"]+$vat;
		$vat = $gtotal * (7/47);
		$surcharge = $gtotal * ($row["surcharge"]/100);
		$gtotal+=$surcharge;
		$res["sell_price"]= $unitprice;
		$res["shipping"] =  $row["shipping"];
		$res["vat"] = $vat;
		$res["surcharge"] = $surcharge;
		$res["total"] = $gtotal;
		$res["amountex"]= $amountex;
		$res["surchargepc"] = $row["surcharge"];
		return $res;
	*/		
	
	}

function type_name($typeid1)
{
	$rs_n1 = mysql_query("select name from mis_item_type where typeid='$typeid1'");
	$name = mysql_result($rs_n1,0,"name");
	return $name;
}
function physical_stock($itemid)
{
	global $db;
	$rs_n2 = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC." p, ".TBL_PURC_D." d where d.itemid='$itemid' and p.purchaseid = d.purchaseid and d.isvalid='1' and p.isvalid='1' and purtype in (1,2)");
	$row = $db->row($rs_n2);
	return $row["t"];

}
function to_be_shipped($itemid1)
{
	$rs_n2 = mysql_query("select moi.orderid,moi.qty,mo.qty as order_qty,mo.statusid,mo.paymentcon from mis_order_item moi inner join mis_order mo on moi.orderid=mo.orderid where moi.itemid='$itemid1' and moi.isvalid='1' and mo.isvalid='1' and mo.statusid<>'5' and mo.statusid<>'6' and mo.statusid<>'7' and mo.paymentcon='1'");
	$s_qty = 0;
	while($rs_n3 = mysql_fetch_object($rs_n2))
	{
		$s_qty = $s_qty+(($rs_n3->qty)*$rs_n3->order_qty);
	}	
	return $s_qty;
}
function to_be_shipped_before($itemid1,$date)
{
	$rs_n2 = mysql_query("select moi.orderid,moi.qty,mo.qty as order_qty,mo.statusid,mo.paymentcon from mis_order_item moi inner join mis_order mo on moi.orderid=mo.orderid where moi.itemid='$itemid1' and moi.isvalid='1' and mo.isvalid='1' and mo.statusid<>'5' and mo.statusid<>'6' and mo.statusid<>'7' and mo.paymentcon='1' and shipmentdate < '$date'");
	$s_qty = 0;
	while($rs_n3 = mysql_fetch_object($rs_n2))
	{
		$s_qty = $s_qty+(($rs_n3->qty)*$rs_n3->order_qty);
	}	
	return $s_qty;
}
function to_be_shipped_bet($itemid1,$date,$edate)
{
	$rs_n2 = mysql_query("select moi.orderid,moi.qty,mo.qty as order_qty,mo.statusid,mo.paymentcon from mis_order_item moi inner join mis_order mo on moi.orderid=mo.orderid where moi.itemid='$itemid1' and moi.isvalid='1' and mo.isvalid='1' and mo.statusid<>'5' and mo.statusid<>'6' and mo.statusid<>'7' and mo.paymentcon='1' and shipmentdate >= '$date' and shipmentdate <= '$edate'");
	$s_qty = 0;
	while($rs_n3 = mysql_fetch_object($rs_n2))
	{
		$s_qty = $s_qty+(($rs_n3->qty)*$rs_n3->order_qty);
	}	
	return $s_qty;
}

	function shipped_before($itemid1,$date)
	{
		$rs_n5 = mysql_query("select moi.orderid,moi.qty,mo.qty as order_qty,mo.statusid,mo.paymentcon from mis_order_item moi inner join mis_order mo on moi.orderid=mo.orderid where moi.itemid='$itemid1' and moi.isvalid='1' and mo.isvalid='1' and mo.statusid='5' and mo.paymentcon='1' and mo.shipmentdate < '$date'");
		$ss_qty = 0;
		while($rs_n6 = mysql_fetch_object($rs_n5))
		{
				$ss_qty = $ss_qty+(($rs_n6->qty)*$rs_n6->order_qty);
		}	
		return $ss_qty;
	}

	function shipped_bet($itemid1,$date,$edate)
	{
		$rs_n5 = mysql_query("select moi.orderid,moi.qty,mo.qty as order_qty,mo.statusid,mo.paymentcon from mis_order_item moi inner join mis_order mo on moi.orderid=mo.orderid where moi.itemid='$itemid1' and moi.isvalid='1' and mo.isvalid='1' and mo.statusid='5' and mo.paymentcon='1' and mo.shipmentdate >= '$date' and mo.shipmentdate <= '$edate'");
		$ss_qty = 0;
		while($rs_n6 = mysql_fetch_object($rs_n5))
		{
				$ss_qty = $ss_qty+(($rs_n6->qty)*$rs_n6->order_qty);
		}	
		return $ss_qty;
	}

	function shipped($itemid1)
	{
		$rs_n5 = mysql_query("select moi.orderid,moi.qty,mo.qty as order_qty,mo.statusid,mo.paymentcon from mis_order_item moi inner join mis_order mo on moi.orderid=mo.orderid where moi.itemid='$itemid1' and moi.isvalid='1' and mo.isvalid='1' and mo.statusid='5' and mo.paymentcon='1'");
		$ss_qty = 0;
		while($rs_n6 = mysql_fetch_object($rs_n5))
		{
				$ss_qty = $ss_qty+(($rs_n6->qty)*$rs_n6->order_qty);
		}	
		return $ss_qty;
	}	
	
	function itemreturned($itemid)
	{
		global $db;
		$rs = $db->execute("select ifnull(sum(d.qty),0) as total from ".TBL_PURC_R." r,".TBL_PURC_R_D." d where r.purchaseid = d.purchaseid and r.isvalid=1 and d.itemid = '".$itemid."'");
		$row = $db->row($rs);
		return $row["total"];
	}	
	
	function itemreturnedbetween($itemid,$sdate,$edate)
	{
		global $db;
		$rs = $db->execute("select ifnull(sum(d.qty),0) as total from ".TBL_PURC_R." r,".TBL_PURC_R_D." d where r.purchaseid = d.purchaseid and r.isvalid=1 and purchasedate between '$sdate' and '$edate' and d.itemid = '".$itemid."'");
		$row = $db->row($rs);
		return $row["total"];
	}	
	
		function physical_stock_by_location($itemid1,$locid)
		{
			$qt = 0;
				$rs_n2 = mysql_query("select sum(qty) as t from mis_purchase_detail where itemid='$itemid1' and isvalid='1' and locationid='$locid'");
				$qty = mysql_result($rs_n2,0,"t");	
					if($qty=="")
					{
						$qt = $qt+0;
					}
					else
					{
						$qt = $qt+$qty;
					}	
			return $qt;	
		}	
			function item_transfered($itemid55,$loc)
			{
				$tmp_trans_qty = 0;
					$tmp_trans3 = mysql_query("select $loc as qt from mis_trans_detail where  itemid='$itemid55'");
					while($tmp_trans4=mysql_fetch_object($tmp_trans3)){
						$tmp_trans_qty = $tmp_trans_qty + $tmp_trans4->qt;
					}
				return $tmp_trans_qty;
			}
function purchased_before($itemid1,$item_date)
	{
		
		global $db;
		
		$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC." p,".TBL_PURC_D." d  where purchasedate < '$item_date' and p.isvalid='1' and p.purtype in (1,2) and d.isvalid=1 and d.itemid = '".$itemid1."' and d.purchaseid = p.purchaseid");
		$row = $db->row($rs_pd);
		return $row["t"];		
		
	}

function purchased_bet($itemid1,$item_date,$edate)
{
	global $db;	
	$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC." p,".TBL_PURC_D." d  where purchasedate >= '$item_date' and  purchasedate <= '$edate' and p.isvalid='1' and p.purtype in (1,2) and d.isvalid=1 and d.itemid = '".$itemid1."' and d.purchaseid = p.purchaseid");
	//echo "select ifnull(sum(qty),0) as t from ".TBL_PURC." p,".TBL_PURC_D." d  where purchasedate >= '$item_date' and  purchasedate <= '$edate' and p.isvalid='1' and p.purtype in (1,2) and d.isvalid=1 and d.itemid = '".$itemid1."' and d.purchaseid = p.purchaseid";
	$row = $db->row($rs_pd);
	return $row["t"];		
	
}

function returned_before($itemid1,$item_date)
	{
		
		global $db;
		$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC_R." p,".TBL_PURC_R_D." d  where purchasedate < '$item_date' and p.isvalid='1' and d.isvalid=1 and d.itemid = '".$itemid1."' and d.purchaseid = p.purchaseid");
		$row2 = $db->row($rs_pd);
		return $row2["t"];		
		
	}

function returned_bet($itemid1,$item_date,$edate)
{
		
		global $db;
		$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC_R." p,".TBL_PURC_R_D." d  where purchasedate >= '$item_date' and  purchasedate <= '$edate' and p.isvalid='1' and d.isvalid=1 and d.itemid = '".$itemid1."' and d.purchaseid = p.purchaseid");
		$row2 = $db->row($rs_pd);
		return $row2["t"];		
		
	}



function opening_stock2($itemid1,$s_date,$e_date)
{		
	global $db;
	$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC_R." p,".TBL_PURC_R_D." d  where purchasedate between '$s_date' and '$e_date' and p.isvalid='1' and d.isvalid=1 and d.itemid = '".$itemid1."' and d.purchaseid = p.purchaseid");
	$row2 = $db->row($rs_pd);
	return $row2["t"];
}	
	
function shipped2($itemid1,$s_date,$e_date)
{
	$rs_n5 = mysql_query("select moi.orderid,moi.qty,mo.qty as order_qty,mo.statusid,mo.paymentcon from mis_order_item moi inner join mis_order mo on moi.orderid=mo.orderid where moi.itemid='$itemid1' and moi.isvalid='1' and mo.isvalid='1' and (mo.shipmentdate between '$s_date' and '$e_date')  and mo.statusid='5' and mo.paymentcon='1'");
	$ss_qty = 0;
	while($rs_n6 = mysql_fetch_object($rs_n5))
	{
			$ss_qty = $ss_qty+(($rs_n6->qty)*$rs_n6->order_qty);
	}	
	return $ss_qty;
}

function adjustment($itemid)
{
		global $db;
		$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC." p,".TBL_PURC_D." d  where p.purchaseid = d.purchaseid and p.supplierid = 1 and purtype=3 and p.isvalid='1' and d.isvalid=1 and d.itemid = '".$itemid."'");
		$row = $db->row($rs_pd);
		
		return $row["t"];		
		
}

function adjustmentbefore($itemid,$date)
{
		global $db;
		$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC." p,".TBL_PURC_D." d  where p.purchaseid = d.purchaseid and p.supplierid = 1 and purtype=3 and purchasedate < '$date' and p.isvalid='1' and d.isvalid=1 and d.itemid = '".$itemid."'");
		$row = $db->row($rs_pd);
		return $row["t"];
}

function adjustmentbet($itemid,$date,$edate)
{
		global $db;
		$rs_pd = $db->execute("select ifnull(sum(qty),0) as t from ".TBL_PURC." p,".TBL_PURC_D." d  where p.purchaseid = d.purchaseid and p.supplierid = 1 and purtype=3 and purchasedate >= '$date' and purchasedate <= '$edate' and p.isvalid='1' and d.isvalid=1 and d.itemid = '".$itemid."'");
		$row = $db->row($rs_pd);
		return $row["t"];
}

function ordercost($orderid){
	$arr=array("laborcost"=>0,);
	
}


function ago($date){
	$date = trim($date);
	if($date=="" || $date=="0000-00-00" || $date=="0000-00-00 00:00:00"){
		return "";
	}
	$arr = split(" ",$date);
	$date = split("-",$arr[0]);
	$time = split(":",$arr[1]);
	
	$thetime = mktime($time[0],$time[1],$time[2],$date[1],$date[2],$date[0]);
	$diff = time() - $thetime;
	if($diff <= 60){
		$ret = $diff . " sec";
	}elseif($diff <= 3600){
		$ret = floor($diff/60) . " min";
	}elseif($diff<=86400){
		$rem = ($diff%3600);
		$ret = floor($diff/3600) . " hour";
	}else{
		$rem = ($diff%86400);
		$ret = floor($diff/86400) . " days";
	}
	return $ret." ago";
}

function formatpc($pc){
	$pc = str_replace(" ","",trim($pc));
	$str =  substr($pc,0,strlen($pc)-3);
	$str2 = substr($pc,-3,3);
	return strtoupper($str." ".$str2);	
}

function phlink($id){
	global $db;
	$rs = $db->execute("select ifnull(count(paymentid),0) as id from ".TBL_PAY." where orderid='$id'");
	$row = $db->row($rs);
	if($row["id"]>0){
		$result = '<a href="order_payment_history.php?oid='.$id.'">PH</a>';
	}else{
		$result = "";
	}
	return $result;
}

function displaytime($se){
          $cloop=9; 
		  $tb=array(1=>"00",2=>"15",3=>"30",4=>"45");
		  for($ti=1;$ti<=24;$ti++){ 
		  	if($cloop==24)
					$cloop=0;
    	  if($cloop<10){
		  	for($innerloop=1;$innerloop<=4;$innerloop++){
				if($se=="0".$cloop.":".$tb[$innerloop].":00")
					echo "<option selected value='0".$cloop.":".$tb[$innerloop].":00'>0".$cloop.":".$tb[$innerloop].":00</option>";
				else
					echo "<option value='0".$cloop.":".$tb[$innerloop].":00'>0".$cloop.":".$tb[$innerloop].":00</option>";
				}
		   }
		   else{
			for($innerloop=1;$innerloop<=4;$innerloop++){
  				if($se==$cloop.":".$tb[$innerloop].":00")
					echo "<option selected value='".$cloop.":".$tb[$innerloop].":00'>".$cloop.":".$tb[$innerloop].":00</option>";					
				else
					echo "<option value='".$cloop.":".$tb[$innerloop].":00'>".$cloop.":".$tb[$innerloop].":00</option>";
				}
		    }
   		  $cloop++;
		  }
}



function gettiming($lasttime){	
$timearray=array(1=>"09:00:00",2=>"09:15:00",3=>"09:30:00",4=>"09:45:00",5=>"10:00:00",6=>"10:15:00",7=>"10:30:00",8=>"10:45:00",9=>"11:00:00",10=>"11:15:00",11=>"11:30:00",12=>"11:45:00",13=>"12:00:00",14=>"12:15:00",15=>"12:30:00",16=>"12:45:00",17=>"13:00:00",18=>"13:15:00",19=>"13:30:00",20=>"13:45:00",21=>"14:00:00",22=>"14:15:00",23=>"14:30:00",24=>"14:45:00",25=>"15:00:00",26=>"15:15:00",27=>"15:30:00",28=>"15:45:00",29=>"16:00:00",30=>"16:15:00",31=>"16:30:00",32=>"16:45:00",33=>"17:00:00",34=>"17:15:00",35=>"17:30:00",36=>"17:45:00",37=>"18:00:00",38=>"18:15:00",39=>"18:30:00",40=>"18:45:00",41=>"19:00:00",42=>"19:15:00",43=>"19:30:00",44=>"19:45:00",45=>"20:00:00",46=>"20:15:00",47=>"20:30:00",48=>"20:45:00",49=>"21:00:00",50=>"21:15:00",51=>"21:30:00",52=>"21:45:00",53=>"22:00:00",54=>"22:15:00",55=>"22:30:00",56=>"22:45:00",57=>"23:00:00",58=>"23:15:00",59=>"23:30:00",60=>"23:45:00",61=>"00:00:00",62=>"00:15:00",63=>"00:30:00",64=>"00:45:00",65=>"01:00:00",66=>"01:15:00",67=>"01:30:00",68=>"01:45:00",69=>"02:00:00",70=>"02:15:00",71=>"02:30:00",72=>"02:45:00",73=>"03:00:00",74=>"03:15:00",75=>"03:30:00",76=>"03:45:00",77=>"04:00:00",78=>"04:15:00",79=>"04:30:00",80=>"04:45:00",81=>"05:00:00",82=>"05:15:00",83=>"05:30:00",84=>"05:45:00",85=>"06:00:00",86=>"06:15:00",87=>"06:30:00",88=>"06:45:00",89=>"07:00:00",90=>"07:15:00",91=>"07:30:00",92=>"07:45:00",93=>"08:00:00",94=>"08:15:00",95=>"08:30:00",96=>"08:45:00",97=>"09:00:00",98=>"09:15:00",99=>"09:30:00",100=>"09:45:00",101=>"10:00:00",102=>"10:15:00",103=>"10:30:00",104=>"10:45:00",105=>"11:00:00",106=>"11:15:00",107=>"11:30:00",108=>"11:45:00",109=>"12:00:00",110=>"12:15:00",111=>"12:30:00",112=>"12:45:00",113=>"13:00:00",114=>"13:15:00",115=>"13:30:00",116=>"13:45:00",117=>"14:00:00",118=>"14:15:00",119=>"14:30:00",120=>"14:45:00",121=>"15:00:00",122=>"15:15:00",123=>"15:30:00",124=>"15:45:00",125=>"16:00:00",126=>"16:15:00",127=>"16:30:00",128=>"16:45:00",129=>"17:00:00",130=>"17:15:00",131=>"17:30:00",132=>"17:45:00",133=>"18:00:00",134=>"18:15:00",135=>"18:30:00",136=>"18:45:00",137=>"19:00:00",138=>"19:15:00",139=>"19:30:00",140=>"19:45:00",141=>"20:00:00",142=>"20:15:00",143=>"20:30:00",144=>"20:45:00",145=>"21:00:00",146=>"21:15:00",147=>"21:30:00",148=>"21:45:00",149=>"22:00:00",150=>"22:15:00",151=>"22:30:00",152=>"22:45:00",153=>"23:00:00",154=>"23:15:00",155=>"23:30:00",156=>"23:45:00",157=>"00:00:00",158=>"00:15:00",159=>"00:30:00",160=>"00:45:00",161=>"01:00:00",162=>"01:15:00",163=>"01:30:00",164=>"01:45:00",165=>"02:00:00",166=>"02:15:00",167=>"02:30:00",168=>"02:45:00",169=>"03:00:00",170=>"03:15:00",171=>"03:30:00",172=>"03:45:00",173=>"04:00:00",174=>"04:15:00",175=>"04:30:00",176=>"04:45:00",177=>"05:00:00",178=>"05:15:00",179=>"05:30:00",180=>"05:45:00",181=>"06:00:00",182=>"06:15:00",183=>"06:30:00",184=>"06:45:00",185=>"07:00:00",186=>"07:15:00",187=>"07:30:00",188=>"07:45:00",189=>"08:00:00",190=>"08:15:00",191=>"08:30:00",192=>"08:45:00",193=>"09:00:00",194=>"09:15:00",195=>"09:30:00",196=>"09:45:00",197=>"10:00:00",198=>"10:15:00",199=>"10:30:00",200=>"10:45:00",201=>"11:00:00",202=>"11:15:00",203=>"11:30:00",204=>"11:45:00",205=>"12:00:00",206=>"12:15:00",207=>"12:30:00",208=>"12:45:00",209=>"13:00:00",210=>"13:15:00",211=>"13:30:00",212=>"13:45:00",213=>"14:00:00",214=>"14:15:00",215=>"14:30:00",216=>"14:45:00",217=>"15:00:00",218=>"15:15:00",219=>"15:30:00",220=>"15:45:00",221=>"16:00:00",222=>"16:15:00",223=>"16:30:00",224=>"16:45:00",225=>"17:00:00",226=>"17:15:00",227=>"17:30:00",228=>"17:45:00",229=>"18:00:00",230=>"18:15:00",231=>"18:30:00",232=>"18:45:00",233=>"19:00:00",234=>"19:15:00",235=>"19:30:00",236=>"19:45:00",237=>"20:00:00",238=>"20:15:00",239=>"20:30:00",240=>"20:45:00",241=>"21:00:00",242=>"21:15:00",243=>"21:30:00",244=>"21:45:00",245=>"22:00:00",246=>"22:15:00",247=>"22:30:00",248=>"22:45:00",249=>"23:00:00",250=>"23:15:00",251=>"23:30:00",252=>"23:45:00",253=>"00:00:00",254=>"00:15:00",255=>"00:30:00",256=>"00:45:00",257=>"01:00:00",258=>"01:15:00",259=>"01:30:00",260=>"01:45:00",261=>"02:00:00",262=>"02:15:00",263=>"02:30:00",264=>"02:45:00",265=>"03:00:00",266=>"03:15:00",267=>"03:30:00",268=>"03:45:00",269=>"04:00:00",270=>"04:15:00",271=>"04:30:00",272=>"04:45:00",273=>"05:00:00",274=>"05:15:00",275=>"05:30:00",276=>"05:45:00",277=>"06:00:00",278=>"06:15:00",279=>"06:30:00",280=>"06:45:00",281=>"07:00:00",282=>"07:15:00",283=>"07:30:00",284=>"07:45:00",285=>"08:00:00",286=>"08:15:00",287=>"08:30:00",288=>"08:45:00");
	
	$etiming="";
	for($xloop=1;$xloop<=288;$xloop++){
			if($lasttime==$timearray[$xloop]){
					return $timearray[$xloop+1];
					break;
						}
		}

}



function totalhours($newintime,$newouttime){
				$h=substr($newintime,0,2);
				$h1=substr($newouttime,0,2);

				$m=substr($newintime,3,2);
				$m1=substr($newouttime,3,2);
				
							
$time1 = (($h+12)*60*60) + ($m*60) + 00 ;
$time2 = (($h1+12)*60*60) + ($m1*60) + 00 ;


$v1=$time1-$time2;


$rmin=$v1 / 60;
$sec=$v1 % 60 ;


$hours=$rmin / 60; 
$min=$rmin%60;

if($hours<0){
		$hours=$hours* -1;
	}

if($min<0){
		$min=$min* -1;

	}
	
$hours=floor($hours);
$min=floor($min);


if($hours<9){
	$hours="0".$hours;
}

if($min<9){
	$min="0".$min;
}


//echo floor($hours)."<br>";
//echo floor($min)."<br>";
//echo $sec."<br>";
				
				$totalhours=$hours.":".$min.":00";
				return $totalhours;

}




?>