<?
session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");
require_once "../includes/header.php";

if ((isset($_POST['submit'])) && ($_POST['fraction']!='') && ($_POST['nick']!='nick')) {
	$nagrody = array();
	foreach ($dbc->query("SELECT `id`,`rate`,`quantity` FROM `rewards` WHERE `quantity`>0 AND `fraction`='".$_POST['fraction']."'") as $reward) { 
		$rate = $reward['rate'] * $reward['quantity'];
		for ($i=1;$i<=$rate;$i++) array_push($nagrody,$reward['id']);
	}
	
	$wygrana = array_rand($nagrody);
	$id = $nagrody[$wygrana];	
	$result = $dbc->query("SELECT `name` FROM `rewards` WHERE `id`='".$id."'");
	$item = $result->fetch();
	$dbc->exec("UPDATE `rewards` SET `quantity`=quantity-1 WHERE `id`='".$id."'");
	$dbc->exec("INSERT INTO `winners` (`name`,`reward`,`user`,`fraction`) VALUES ('".$_POST['nick']."','".$id."','".$_SESSION['userid']."','".$_POST['fraction']."')");
	?>
<h2><?=$_POST['nick']?> wygrał <?=$item['name']?>! : )</h2>
<?}?>

<form action='<?=$_SERVER['PHP_SELF']?>' method='POST' enctype='multipart/form-data'>
Podaj 
<input type='text' maxlength='12' name='nick' value='nick' style='width:200px;' />
 gracza, jego 
<select name='fraction'><option value='' selected='selected'>frakcję</option><option value='ally'>Ally</option><option value='horda'>Horda</option></select>
 i 
<input type='submit' name='submit' value='wylosuj' />
 nagrodę!<br />
</form>
<?require_once "../includes/footer.php";?>
