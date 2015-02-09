<? if(isset($_GET["info"])){include("./include_member/info.php");$objinfo = new info();?>
	<div id="info">
	<table border="0" cellspacing="0" cellpadding="5" width="100%">
	<tr>
		<td width="50"><img src="./images/information.gif" /></td>
		<Td align="left" class="text3"><b><? $objinfo->show()?></b></Td>
	</tr>
	</table>
	</div>
<? $objinfo->free();}?>