<?
require_once "../includes/functions.php";

if (isset($_POST['submit'])) {
	$login = $_POST['login'];
	$pass = $_POST['pass'];
	$error="";
	
	if (empty($login)) $error.="Nie podałeś loginu.<br />";
	elseif (!preg_match('/^([A-Za-z0-9]){8,32}$/i',$login)) $error.="Login zawiera nieprawidłowe znaki.<br />";
	if (empty($pass)) $error.="Nie podałeś hasła.<br />";
	elseif (!preg_match('/^([A-Za-z0-9]){8,32}$/i',$pass)) $error.="Hasło zawiera nieprawidłowe znaki.<br />";
	
	if ($error=="") {
		$wynik = $dbc->query("SELECT `id`,`name`,`rank`,`addr` FROM `users` WHERE `login`='".$login."' AND `passwd`='".md5(md5($pass))."'");
		$ilosc = $wynik->rowCount();
		switch ($ilosc) {
			case 0:
				require_once "../includes/header.php";
				echo "<h2 class='loginform_zledane'>Podałeś nieprawidłowe dane. : (</h2>";
				break;
			case 1:
				$user = $wynik->fetch();
				session_start();
				$_SESSION['logged']=true;
				$_SESSION['userid']=$user['id'];
				$_SESSION['rank']=$user['rank'];
				$_SESSION['name']=$user['name'];
				
				//Dodaj ip/time do addr
				$addr = explode(',',$user['addr']);
				$wpis=$_SERVER['REMOTE_ADDR'].'/'.time();
				array_unshift($addr,$wpis);
				array_splice($addr,10);
				$addrdb=implode(',',$addr);
				$dbc->exec("UPDATE `users` SET `addr`='".$addrdb."' WHERE `id`='".$user['id']."'");
				
				redirect("index.php");
				break;
			default:
				require_once "../includes/header.php";
				echo "Błąd, spróbuj ponownie";
		}
	} else {
		require_once "../includes/header.php";
		echo "<span class='loginform_errors'>".$error."</span>";
	}
} else { require_once"../includes/header.php";?>

<h1>Logowanie</h1>
<form action='<?=$_SERVER['PHP_SELF']?>' method='post'>
<table>
<tr><td>Login:</td><td><input type='text' name='login' maxlength='32' style='width:200px' /></td></tr>
<tr><td>Hasło:</td><td><input type='password' name='pass' maxlength='32' style='width:200px' /></td></tr>
<tr><td></td><td><input type='submit' name='submit' value='Zaloguj się' /></td></tr>
</table>
</form>

<?}require_once "../includes/footer.php";?>
