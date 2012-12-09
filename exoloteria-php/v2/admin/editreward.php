<?session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");

if (isset($_POST['submit'])) {
	if ($_POST['m']==add)
		$dbc->exec("INSERT INTO `rewards` (`picture`,`name`,`rate`,`wowhead`) VALUES ('".$_POST['picture']."','".$_POST['name']."','".$_POST['rate']."','".$_POST['wowhead']."')");
	else
		$dbc->exec("UPDATE `rewards` SET `name`='".$_POST['name']."',`rate`='".$_POST['rate']."',`wowhead`='".$_POST['wowhead']."',`picture`='".$_POST['picture']."' WHERE `id`='".$_POST['m']."'");
	redirect("index.php");
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
		<td><input type='text' maxlength='32' name='name' value='<?=$reward["name"]?>' style='width:200px;' /></td>
	</tr>
	<tr>
		<td>Wartość:</td>
		<td><input type='text' maxlength='32' name='rate' value='<?=$reward["rate"]?>' style='width:200px;' /></td>
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

<?}require_once "../includes/footer.php";?>
