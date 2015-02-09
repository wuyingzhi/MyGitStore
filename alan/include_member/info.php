<?
class info{
	var $arrinfo = array();
	var $width = "50%";
	var $msg = "";
	var $infocode = 0;

	function show(){
		if(isset($_GET["info"])){
			$this->infocode = $_GET["info"];
		}
		else{
			return false;
		}
		$this->arrinfo[0] = "";
		$this->arrinfo[1] = "Login Id was not found";
		$this->arrinfo[2] = "Password was not correct";
		$this->arrinfo[3] = "Your login has been disabled";
		$this->arrinfo[4] = "Session expired , you need to Login";
		$this->arrinfo[5] = "Logout was successfull.";
		$this->arrinfo[6] = "Password was changed successfully.";

		$this->arrinfo[7] = "New record was inserted.";
		$this->arrinfo[8] = "Record updated successfully.";
		$this->arrinfo[9] = "Record deleted successfully.";

		$this->arrinfo[10] = "Unable to insert new record.";
		$this->arrinfo[11] = "Unable to update the record.";
		$this->arrinfo[12] = "Unable to delete record.";

		$this->arrinfo[13] = "Record was not found.";
	
		$this->arrinfo[14] = "Payment has been approved and order was updated.";
		$this->arrinfo[15] = "Registration completed, Login to countinue.";
		$this->arrinfo[16] = "Style was updated.";
		$this->arrinfo[17] = "Style was restored.";
		$this->arrinfo[18] = "You were not allowed to the page.";
		$this->arrinfo[19] = "Nothing was transfered";
		$this->arrinfo[20] = "Record transfered successfully";		
		$this->arrinfo[20] = "Record transfered successfully";	
		$this->arrinfo[21] = "Thank you for Signup.";				
		$this->arrinfo[22] = "Document has been Updated Successfully";						
		$this->arrinfo[23] = "You have already enter your IN timing";
		$this->arrinfo[24] = "No Such entries found";
		$this->arrinfo[25] = "Attached File has been Deleted Successfully";
		$this->arrinfo[26] = "Your group has been disabled";
		$this->arrinfo[27] = "Your are already out!";
		$this->arrinfo[28] = "User Information has been Updated Successfully";
		$this->arrinfo[29] = "Email sent successfully";
		$this->arrinfo[30] = "Record Already exists!";
		//------------- new info------------------------
		$this->arrinfo[31] = "User Status has been Changed";
		$this->arrinfo[32] = "Order Product Details Updated Successfully.";		
		$this->arrinfo[33] = "Order Payment Details Updated Successfully.";		
		$this->arrinfo[33] = "Order Note Updated Successfully.";		
		$this->arrinfo[34] = "Order Qty Updated Successfully.";				
		$this->arrinfo[35] = "Parts Successfully Add in your Order.";				
		$this->arrinfo[36] = "Order Products Update Successfully.";								
		$this->arrinfo[37] = "Order PCS can't be Decrease! Use Delete PC.";										
		$this->arrinfo[38] = "PC was Deleted Successfully.";												
		$this->arrinfo[39] = "Payment Entry was Deleted Successfully.";														
		$this->arrinfo[40] = "Secure e-Payments Card Process Successfully.";
		$this->arrinfo[41] = "Order Reviewed Successfully.";
		$this->arrinfo[42] = "Order Note Deleted Successfully.";
		$this->arrinfo[43] = "Mail has been Successfully Save as Draft.";
		$this->arrinfo[44] = "Document(s) has been Uploaded Successfully.";
			
		//------------- end new info------------------------								
		
		if( isset($this->arrinfo[$this->infocode]) ){
			$this->msg = $this->arrinfo[$this->infocode];
		}else{
			$this->msg = "UNKNOWN";
		}

		echo "";
		echo $this->msg."";
		echo "";
	}

	function free(){
		$this->arrinfo = array();
	}
}
?>