<?
class menu{
	function menu(){
		$this->db = new db();
		$this->db->connect();
			}
	// add main menu	
	function addmainmenu($menu,$menulink){
	$mintid = $this->db->nextid(TBL_MAIN_MENU,"menuid");
$this->db->update("INSERT INTO ".TBL_MAIN_MENU." (menuid,menu,link) VALUES ('".$mintid."','".$menu."','".$menulink."')");
	}

	// add sub menu
	function addsubmenu($mainid,$submenu,$menulink){
		$intid = $this->db->nextid(TBL_SUB_MENU,"submenuid");
		$this->db->update("INSERT INTO ".TBL_SUB_MENU."(submenuid,mainmenuid,submenu,link) VALUES ('".$intid."','". $mainid."','".$submenu."','".$menulink."')");
	}

	// for update main menu
	function updatemenu($menuid,$menu,$link,$type){
	if($type=="d"){
		$this->db->update("UPDATE ".TBL_MAIN_MENU." SET menu='".$menu."', link='".$link."' WHERE menuid='".$menuid."'");
		}
	elseif($type=="u"){
		$this->db->update("UPDATE ".TBL_MENU." SET menu='".$menu."', link='".$link."' WHERE menuid='".$menuid."'");
		}
	}

	//for update submenu
	function updatesubmenu($submenuid,$submenu,$link,$type){
	if($type=="d"){
		$this->db->update("UPDATE ".TBL_SUB_MENU." SET submenu='".$submenu."', link='".$link."' WHERE submenuid='".$submenuid."'");
		}
	elseif($type=="u"){
		$this->db->update("UPDATE ".TBL_SUBMENU." SET submenu='".$submenu."', link='".$link."' WHERE submenuid='".$submenuid."'");
		}
	}

	// for move submenu item
	function movemenu($submenuid,$menuid,$type){
	if($type=="d"){
		$this->db->update("UPDATE ".TBL_SUB_MENU." SET mainmenuid='".$menuid."' WHERE submenuid='".$submenuid."'");
		}
	elseif($type=="u"){
		$this->db->update("UPDATE ".TBL_SUBMENU." SET mainmenuid='".$menuid."' WHERE submenuid='".$submenuid."'");
		}
	}

	// for delete main menu
	function deletemenu($menuid){
		$this->db->update("DELETE FROM ".TBL_MAIN_MENU." WHERE menuid='".$menuid."'");
	}

	// for delete submenu
	function deletesubmenu($submenuid){
		$this->db->update("DELETE FROM ".TBL_SUB_MENU." WHERE submenuid='".$submenuid."'");
	}


}// end of class           
?>