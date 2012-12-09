<?session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");

if (isset($_POST['submit'])) {
	if ($_POST['m']==add)
		$dbc->exec("INSERT INTO `rewards` (`picture`,`name`,`rate`,`wowhead`,`fraction`) VALUES ('".$_POST['picture']."','".$_POST['name']."','".$_POST['rate']."','".$_POST['wowhead']."','".$_POST['fraction']."')");
	else
		$dbc->exec("UPDATE `rewards` SET `name`='".$_POST['name']."',`rate`='".$_POST['rate']."',`wowhead`='".$_POST['wowhead']."',`picture`='".$_POST['picture']."',`fraction`='".$_POST['fraction']."' WHERE `id`='".$_POST['m']."'");
	redirect("rewards.php");
} else {
if (is_numeric($_GET['m'])) {
	$result = $dbc->query("SELECT * FROM `rewards` WHERE `id`='".$_GET['m']."'");
	$reward = $result->fetch();
}
require_once "../includes/header.php";	
?>

<form style='' action='<?=$_SERVER["PHP_SELF"]?>' method='POST' enctype='multipart/form-data'>
<table style='margin-top:20px;'>
	<tr>
		<td><img src='/rewards/<?=$reward['picture']?>' id='podglad' /></td>
		<td><select name='picture' onchange='document.getElementById("podglad").src = "/rewards/"+this.value;this.blur();this.focus();'>
			<?if ($handle = opendir('../rewards/')) {
				while (false !== ($file = readdir($handle))) {
					if ($file==$reward['picture']) echo "<option value='".$file."' selected='selected'>".$file."</option>\n";
					if (($file!=".") && ($file!="..") && ($file!=$reward['picture'])) echo "<option value='".$file."'>".$file."</option>\n";
				}
			closedir($handle); 
			}?>
			
		</select></td>
	</tr>
	<tr>
		<td>Nazwa:</td>
		<td><input type='text' maxlength='64' name='name' value='<?=$reward["name"]?>' style='width:200px;' /></td>
	</tr>
	<tr>
		<td>Wartość</td>
		<td><input type='text' maxlength='32' name='rate' value='<?=$reward["rate"]?>' style='width:200px;' /></td>
	</tr>
	<tr>
		<td>Frakcja</td>
		<td><select name='fraction'>
		<? if ($reward['fraction']=='ally') $ally="selected='selected'"; elseif ($reward['fraction']=='horda') $horda="selected='selected'"; elseif ($_GET['add']=='m') $none="selected='selected'";?>
		<option value='' <?=$none?>></option><option value='ally' <?=$ally?>>Ally</option><option value='horda' <?=$horda?>>Horda</option></select></td>
	</tr>
	<tr>
		<td>Wowhead:</td>
		<td><input type='text' maxlength='32' name='wowhead' value='<?=$reward["wowhead"]?>' style='width:200px;' /></td>
	</tr>
	<tr>
		<td><input type='hidden' name='m' value='<?=$_GET["m"]?>' /></td>
		<td><input type='submit' name='submit' value='Utwórz' /></td>
	</tr>
</table>
</form>

<script type="text/javascript">
<!--
function oblicz() {
	var cena = document.forms['obliczanieceny'].cena.value;
	var x=0;
	if ((cena <=9000) && (cena>=0)) {
		if (cena > 1000) x=1;
		else if ((cena <= 1000) && (cena>100)) {x = Match.ceil(cena/-100)+11;}
		else if ((cena <= 100) && (cena>10)) {x = Match.ceil(cena/-10)+11;}
		else if ((cena <=10) && (cena>=0)) {x = Match.ceil(cena/-1)+11;}
		alert("Doradzam ustawienie szansy "+x+".");
	} else alert("Doradzam puknięcie się w łeb i wpisanie innej ceny");
	return false;
}
//-->
</script>
<form id="obliczanieceny" action="">
Wpisz cenę przedmiotu: <input type="text" maxlength="7" name="cena" style="width:125px;" /> - i <button onclick="return oblicz()">oblicz</button> jego szansę!
</form>

<?}require_once "../includes/footer.php";?>
