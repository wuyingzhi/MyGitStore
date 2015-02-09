<? include("./include/config.php");?>
<? include("./include/db.php");?>
<? include("./include/menu.php");?>
<?
if( isset( $_SESSION["grid"] ) && $_SESSION["grid"] == "1" ) // for administrators
{
		 $menus = new menu(); 
		 $menus->menutype(1,"No");
		 for($loop=2;$loop<=12;$loop++){
			 $menus->menutype($loop,"Yes");
			}
}
elseif( isset( $_SESSION["grid"] ) && $_SESSION["grid"] == "0" ) // for normal users
{
		 $menus = new menu(); 
		 $menus->menutype(1,"No");
		 for($loop=2;$loop<=12;$loop++){
			 $menus->menutype($loop,"Yes");
			}
}
?>