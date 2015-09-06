<?php
$method = $_SERVER['REQUEST_METHOD'];
$request = explode("/", substr(@$_SERVER['PATH_INFO'], 1));

include "db.php";

switch ($method) {
  case 'PUT':
    rest_put($request, $dblink);
    break;
  case 'POST':
    rest_post($request, $dblink);
    break;
  case 'GET':
    rest_get($request, $dblink);
    break;
  case 'DELETE':
    rest_delete($request);
    break;
  default:
    rest_error($request);
    break;
}

function rest_put($req, $dblink) {
	$jsonText = file_get_contents('php://input');
  $idDash = generateRandomString();
	$query = "insert into stat (json, id_dash) values (?, ?)";
    $stmt = $dblink->prepare($query) or die("Prepare stmt die.");
    $stmt->bind_param("ss", $jsonText, $idDash);
    $stmt->execute();
    echo '{ "id":"' . $idDash . '"}';
    $stmt->close();
}

function rest_post($req, $dblink) {
	$jsonText = file_get_contents('php://input');
  $idDash = filterDashId();
	$query = "update stat set json=? where id_dash=?";
    $stmt = $dblink->prepare($query) or die("Prepare stmt die.");
    $stmt->bind_param("ss", $jsonText, $idDash);
    $stmt->execute();
    echo '{ "id":"' . $idDash . '"}';
    $stmt->close();
}

function rest_get($req, $dblink) {
	$json = "{}";
	$idDash = filterDashId();
	$query = "select json from stat where id_dash=?";
    $stmt = $dblink->prepare($query) or die("Prepare stmt die.");
    $stmt->bind_param("s", $idDash);
    $stmt->execute();
    $stmt->bind_result($json);
    if ($stmt->fetch()) {
    	echo $json;
    }
    $stmt->close();
}

function filterDashId() {
  return preg_replace("/[^a-zA-Z0-9]+/", "", substr($_GET["id"], 0, 5));
}

function generateRandomString($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>
