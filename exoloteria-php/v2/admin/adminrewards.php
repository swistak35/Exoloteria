<?
session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");
require_once "../includes/header.php";

if (((is_numeric($_POST['quantity'])) || ($_POST['quantity']=='d') || ($_POST['quantity']=='D')) && (is_numeric($_POST['id'])) && (isset($_POST['submit']))) {
	if (($_POST['quantity']=='d') || ($_POST['quantity']=='D')) $dbc->exec("DELETE FROM `rewards` WHERE `id`='".$_POST['id']."'");
	else $dbc->exec("UPDATE `rewards` SET `quantity`='".$_POST['quantity']."' WHERE `id`='".$_POST['id']."'");
}
?>

<table class='special'>
	<tr>
		<th></th>
		<th>Nazwa</th>
		<th>Wartość</th>
		<th>Ilość</th>
		<th>Uaktualnij</th>
	</tr>

<?foreach ($dbc->query("SELECT * FROM `rewards`") as $reward) {?>
	<form action='<?=$_SERVER['PHP_SELF']?>' method='POST' enctype='multipart/form-data'>
	<input type='hidden' name='id' value='<?=$reward['id']?>' />
	<tr>
		<td><img src='/rewards/<?=$reward['picture']?>' /></td>
		<td><a href='editreward.php?m=<?=$reward['id']?>'><?=$reward['name']?></a></td>
		<td><?=$reward['rate']?></td>
		<td><input type='text' maxlength='2' name='quantity' value='<?=$reward['quantity']?>' style='width:40px;' /></td>
		<td><input type='submit' name='submit' value='Uaktualnij' /></td>
	</tr>
	</form>
<?}?>

</table>

<?require_once "../includes/footer.php";?>
