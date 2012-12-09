<?
session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");
if ($_SESSION['rank'] != 1) redirect("index.php");
require_once "../includes/header.php";

if ((is_numeric($_GET['delete'])) && ($_GET['delete'] != $_SESSION['id'])) $dbc->exec("DELETE FROM `users` WHERE `id`='".$_GET['delete']."'");

if (isset($_POST['submit'])) {
	$login = $_POST['login'];
	$name = $_POST['name'];
	$pass = $_POST['pass'];
	$error="";
	if ($_POST['rank']==1) $rank=1; else $rank=0;
	if (empty($login)) $error.="Nie podałeś loginu.<br />";
	elseif (!preg_match('/^([A-Za-z0-9_@.]){8,32}$/i',$login)) $error.="Login zawiera nieprawidłowe znaki.<br />";
	if (empty($pass)) $error.="Nie podałeś hasła.<br />";
	elseif (!preg_match('/^([A-Za-z0-9]){8,32}$/i',$pass)) $error.="Hasło zawiera nieprawidłowe znaki.<br />";
	if (empty($name)) $error.="Nie podałeś nazwy.<br />";
	elseif (!preg_match('/^([A-Za-z0-9 ]){8,32}$/i',$name)) $error.="Nazwa zawiera nieprawidłowe znaki.<br />";
	if ($error=="") 
	$wynik = $dbc->exec("INSERT INTO `users` (`name`,`login`,`passwd`,`rank`) VALUES ('".$name."','".$login."','".md5(md5($pass))."','".$rank."')");
	else echo $error;
}?>

<table class='special'>
	<tr>
		<th>Nazwa</th>
		<th>Login</th>
		<th>Ranga</th>
		<th>Usuń</th>
	</tr>
<?foreach ($dbc->query("SELECT `id`,`login`,`name`,`rank` FROM `users`") as $user) { 
	$ranga = ($user['rank'] ==  1 ? "Administrator" : "Moderator");?>
	<tr>
		<td><?=$user['name']?></td>
		<td><?=$user['login']?></td>
		<td><?=$ranga?></td>
		<td><a href='adminusers.php?delete=<?=$user['id']?></a>'>Usuń</a></td>
	</tr>
<?}?>
</table>

<form action='<?=$_SERVER['PHP_SELF']?>' method='POST' enctype='multipart/form-data'>
<table style='margin-top:20px;'>
<tr><td>Nazwa:</td><td><input type='text' maxlength='32' name='name' style='width:200px;' /></td></tr>
<tr><td>Login:</td><td><input type='text' maxlength='32' name='login' style='width:200px;' /></td></tr>
<tr><td>Hasło:</td><td><input type='password' maxlength='32' name='pass' style='width:200px;' /></td></tr>
<tr><td><input type='submit' name='submit' value='Utwórz' /></td><td>
<select name='rank' class='textbox' style='width:200px;'>
<option value='0' selected='selected'>Moderator</option>";
<option value='1'>Administrator</option>";
</select></td></tr>
</table>
</form>

<?require_once "../includes/footer.php";?>
