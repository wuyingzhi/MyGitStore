<?include("../include/config.php")?>
<?
session_destroy();
header("location:".ROOT."?info=5");
?>