<?session_start(); session_regenerate_id();
require_once "includes/functions.php";
require_once "includes/header.php";?>

<table style='width: 100%;' border=0 cellspacing=0 cellpadding=0>
<?foreach ($dbc->query("SELECT `name`,`date`,`reward`,`fraction` FROM `winners` ORDER BY `date` DESC") as $winner) {
	$wyniknag = $dbc->query("SELECT `name`,`picture`,`wowhead` FROM `rewards` WHERE `id`='".$winner['reward']."'");
	$nagroda = $wyniknag->fetch();?>
	<tr class='<?=$winner['fraction']?>'>
		<td rowspan=2><a href='http://www.wowhead.com/item=<?=$nagroda['wowhead']?>' title='<?=$nagroda['name']?>'><img src='/rewards/<?=$nagroda['picture']?>' /></a></td>
		<td style='font-weight: bold;'><?=$winner['name']?></td>
	</tr>
	<tr class='<?=$winner['fraction']?>'>
		<td style='font-style: italic;'><?=$winner['date']?></td>
	</tr>
<?}?>
</table>

<?require_once "includes/footer.php";?>
