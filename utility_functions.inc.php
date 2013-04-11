<?
function newPDO(){
	$dsn = "mysql:host=localhost;dbname=CS430";
	$user = "root";
	$pass = "root";
	return new PDO($dsn, $user, $pass);
}

function loadOptions(){
	$db = newPDO();

	$sql = "SELECT * FROM Options WHERE autoload = 'yes'";

	$stmt = $db->prepare($sql);

	$stmt->execute();

	$result = $stmt->fetchAll();

	return $result;
}