var xmlHttp
function getSUB(str,se){ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null){
alert ("Your browser does not support AJAX!");
return;} 
var url="cms/include/getsub.php";
url=url+"?id="+str+"&sca="+se;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged(){ 
if (xmlHttp.readyState==4){ 
document.getElementById("subitems").innerHTML=xmlHttp.responseText;
}
}

function GetXmlHttpObject(){
var xmlHttp=null;
try{
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }catch (e){
  // Internet Explorer
  try{
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }catch (e){
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}