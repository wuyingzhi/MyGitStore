// JavaScript Document
var xmlHttp

function GETTEXT()
{ 
te = document.getElementById("scrollingtext").innerHTML;
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
var url="../gettext.php";
url=url+"?te="+te;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
//alert("calling");
setTimeout("GETTEXT()",5000);
}
GETTEXT();
function stateChanged() 
{ 
	if (xmlHttp.readyState==4){ 
			if(xmlHttp.responseText!=""){
				document.getElementById("scrollingtext").innerHTML=xmlHttp.responseText;		
			}
		}
}


function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}