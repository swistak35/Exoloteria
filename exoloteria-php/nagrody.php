<?session_start(); session_regenerate_id();
require_once "includes/functions.php";
if (($_GET['f']!='ally') && ($_GET['f']!='horda')) redirect("index.php");
require_once "includes/header.php";?>

<table class='special'>
<?foreach ($dbc->query("SELECT * FROM `rewards` WHERE quantity>0 AND fraction='".$_GET['f']."' ORDER BY `name`") as $reward) {?>
	<tr>
		<td rowspan=2><a href='http://www.wowhead.com/item=<?=$reward['wowhead']?>' title='<?=$reward['name']?>'><img src='/rewards/<?=$reward['picture']?>' /></a></td>
		<td><b><?=$reward['name']?></b></td>
	</tr>
	<tr>
		<td><i>Szanse: <?=$reward['rate']?></i></td>
	</tr>
<?}?>
</table>

<?require_once "includes/footer.php";?>
