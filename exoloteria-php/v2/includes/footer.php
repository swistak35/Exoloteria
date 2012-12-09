</div>
<div id='right'>

<?if (check_session()) {?>
<div id='adminpanel'>
<a href='/admin/index.php'>Panel Admina</a>
<a href='/admin/adminlosuj.php'>Losuj nagrodę</a>
<a href='/admin/editreward.php?m=add'>Dodaj nagrodę</a><br />
<a href='/admin/adminrewards.php'>Zarządzaj nagrodami</a><br />
<a href='/admin/adminusers.php'>Zarządzaj użytkownikami</a><br />
<a href='/admin/changepass.php'>Zmień hasło</a><br />
<a href='/admin/logout.php'>Wyloguj się</a><br />
</div>
<?}?>


<div id='ostatni'>
<table style='width: 100%;'>
<?
foreach ($dbc->query("SELECT `name`,`date`,`reward` FROM `winners` ORDER BY `date` DESC LIMIT 10") as $winner) {
	$wyniknag = $dbc->query("SELECT `name`,`picture`,`wowhead` FROM `rewards` WHERE `id`='".$winner['reward']."'");
	$nagroda = $wyniknag->fetch();?>
	<tr>
		<td rowspan=2><a href='http://www.wowhead.com/item=<?=$nagroda['wowhead']?>' title='<?=$nagroda['name']?>'><img src='/rewards/<?=$nagroda['picture']?>' /></a></td>
		<td style='font-weight: bold;'><?=$winner['name']?></td></tr>
		<tr><td class='date'><?=$winner['date']?></td></tr>
	</tr>
<?}?>
</table>
</div>

</div>
</div>
<div id='footer'>
Copyright by Świstak35
</div>
</div>
</body>
</html>
