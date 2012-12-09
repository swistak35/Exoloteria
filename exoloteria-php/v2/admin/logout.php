<?
session_start(); session_regenerate_id();
require_once "../includes/functions.php";

if (!check_session()) redirect("login.php");
else {
	$_SESSION = array();
	session_destroy();
	redirect("../index.php");
}
?>
