<? $timestart = time();  error_reporting(E_ALL); ?>
<?
define("ROOT","http://localhost/alan/index.php"); // root
define("TITLE_DEFAULT","Admin Panel - expRealty.info"); // default title
define("HOST", "localhost"); // database host 
define("DATABASE", "photo"); // name of database
define("USERNAME", "root"); // database user name
define("PASSWORD", ""); // database password
define("ADMIN_EMAIL","admin@almubdi.com"); // order email
define("MAXFILESIZE" , 5242880); // 5 MB maximum file size to be uploaded
define("PFIX" , ""); // 5 MB maximum file size to be uploaded
define("REQUIRED","<font size='2' color='red'>*</font>");
?>
<?
session_start();
?>