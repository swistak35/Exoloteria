<?
session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");
require_once "../includes/header.php";

if (isset($_POST['submit'])) {
	$newpasswd = $_POST['newpasswd'];
	$newpasswd2 = $_POST['newpasswd2'];
	$oldpasswd = $_POST['oldpasswd'];
	$error="";
	
	if (empty($oldpasswd)) $error.="Nie podałeś starego hasła.<br />";
	elseif (!preg_match('/^([A-Za-z0-9]){8,32}$/i',$oldpasswd)) $error.="Stare hasło zawiera nieprawidłowe znaki.<br />";
	if (empty($newpasswd)) $error.="Nie podałeś nowego hasła.<br />";
	elseif (!preg_match('/^([A-Za-z0-9]){8,32}$/i',$newpasswd)) $error.="Nowe hasło zawiera nieprawidłowe znaki.<br />";
	if (empty($newpasswd2)) $error.="Nie powtórzyłeś nowego hasła.<br />";
	elseif (!preg_match('/^([A-Za-z0-9]){8,32}$/i',$newpasswd2)) $error.="Powtórzone nowe hasło zawiera nieprawidłowe znaki.<br />";
	if ($newpasswd != $newpasswd2) $error.="Nowe hasła nie są identyczne.<br />";
	
	$bledy = $error;
	if ($bledy=="") {
		$wynik = $dbc->query("SELECT `id` FROM `users` WHERE `id`='".$_SESSION['id']."' AND `passwd`='".md5(md5($oldpasswd))."'");
		$ilosc = $wynik->rowCount();
		switch ($ilosc) {
			case 0:
				$error .="Stare hasło jest nieprawidłowe.<br />";
				break;
			case 1:
				$dbc->exec("UPDATE `users` SET `passwd`='".md5(md5($newpasswd))."' WHERE `id`='".$_SESSION['id']."'");
				$error.="Hasło zmieniono pomyślnie.<br />";
				break;
			default:
				$error.="Błąd, spróbuj ponownie.<br />";
		}
	}
	echo $error;
} else {?>

<form style='' action='<?=$_SERVER['PHP_SELF']?>' method='POST' enctype='multipart/form-data'>
<table>
<tr><td>Stare hasło: </td><td><input type='password' maxlength='32' name='oldpasswd' style='width:200px;' /></td></tr>
<tr><td>Nowe hasło: </td><td><input type='password' maxlength='32' name='newpasswd' style='width:200px;' /></td></tr>
<tr><td>Powtórz nowe hasło: </td><td><input type='password' maxlength='32' name='newpasswd2' style='width:200px;' /></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Uaktualnij' /></td></tr>
</table>
</form>

<?}require_once "../includes/footer.php";?>
