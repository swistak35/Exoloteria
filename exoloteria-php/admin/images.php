<?session_start(); session_regenerate_id(); require_once "../includes/functions.php";
if (!check_session()) redirect("login.php");

if (isset($_POST['submit'])) {
	$target_path = "../rewards/";
	$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
		$info="Plik ".  basename( $_FILES['uploadedfile']['name'])." został wgrany";
	} else {
		$info="Wystapil blad, sprobuj ponownie";
	}
}
require_once "../includes/header.php";	
echo $info."<br />";
?>

<form style='' action='<?=$_SERVER["PHP_SELF"]?>' method='POST' enctype='multipart/form-data'>
<input type="hidden" name="MAX_FILE_SIZE" value="100000" />
Wybierz plik: <input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" />
</form>

<?require_once "../includes/footer.php";?>
