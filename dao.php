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
	$query = "insert into stat (json) values (?)";
    $stmt = $dblink->prepare($query) or die("Prepare stmt die.");
    $stmt->bind_param("s", $jsonText);
    $stmt->execute();
    echo '{ "id":' . $stmt->insert_id . '}';
    $stmt->close();
}

function rest_post($req, $dblink) {
	$jsonText = file_get_contents('php://input');
  $idDash = $_GET['id'];
	$query = "update stat set json=? where id=?";
    $stmt = $dblink->prepare($query) or die("Prepare stmt die.");
    $stmt->bind_param("si", $jsonText, $idDash);
    $stmt->execute();
    echo '{ "id":' . $idDash . '}';
    $stmt->close();
}

function rest_get($req, $dblink) {
	$json = "{}";
	$id = $_GET['id'];
	$query = "select json from stat where id=?";
    $stmt = $dblink->prepare($query) or die("Prepare stmt die.");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($json);
    if ($stmt->fetch()) {
    	echo $json;
    }
    $stmt->close();
}

?>
