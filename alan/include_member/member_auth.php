<?
@session_start();
if( isset($_SESSION['apid']) && $_SESSION['apid'] != "" ) // this going to authenticate member
{$userIsLogedIn = true;}// process if any thing
else{
$lastPageVisit = $_SERVER['SCRIPT_NAME'];
$pageQueryString = $_SERVER['QUERY_STRING'];
$_SESSION["RESUME_SESSION_AGAIN"] = $lastPageVisit."?".$pageQueryString;
header("location:index.php?info=4");exit();} // admin
?>