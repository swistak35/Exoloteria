<?
$dbc = new PDO("mysql:dbname=rlasocha_exolot;host=localhost", "rlasocha_exolot", "exoloteria"); 

function check_session($what='') {
	switch ($what) {
		case 'id':
			return $_SESSION['id'];
			break;
		case 'name':
			return $_SESSION['name'];
			break;
		case 'rank':
			return $_SESSION['rank'];
			break;
		default:
			if ($_SESSION['logged']==true) return true; else return false;
	}
}

function redirect($page) {
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
	if ((substr($url, -1) == '/') OR (substr($url, -1) == '\\') ) { $url = substr ($url, 0, -1); }
	$url .= '/'.$page;
	header("Location: $url");
}
?>
