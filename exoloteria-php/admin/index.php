<?session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");
require_once "../includes/header.php";?>

<h3>Witaj, <?=$_SESSION['name']?>! : )</h3>

<table class='special'>
	<tr>
		<th colspan='2'>10 ostatnich logowań</th>
	</tr>
<?
$dzientyg=array("Niedziela","Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota");
$wynik = $dbc->query("SELECT `addr` FROM `users` WHERE `id`='".$_SESSION['id']."'");
$addrdb=$wynik->fetch();
$addr = explode(',',$addrdb['addr']);
$ilosc = count($addr)-1;
for ($i=0;$i<=$ilosc;$i++) {
	$wpis = explode('/',$addr[$i]);?>
	<tr>
		<td><?=$wpis[0]?></td>
		<td><?=$dzientyg[date("w",$wpis[1])]?>, <?=date("d.m.Y, G:i:s",$wpis[1])?></td>
	</tr>
<?}?>
</table>

<?require_once "../includes/footer.php";?>
