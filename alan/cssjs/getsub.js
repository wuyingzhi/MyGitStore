var xmlHttp
function getSUB(str,se){ 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null){
alert ("Your browser does not support AJAX!");
return;} 
var url="./include/getsub.php";
url=url+"?cid="+str+"&sid="+se;
url=url+"&sid="+Math.random();
//alert(url);
xmlHttp.onreadystatechange=stateChanged;
xmlHttp.open("GET",url,true);
xmlHttp.send(null);
}

function stateChanged(){ 
if (xmlHttp.readyState==4){ 
//alert(xmlHttp.responseText);
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