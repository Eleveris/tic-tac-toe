<?php

function randomString()
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < 32; $i++) {
        $randstring .=  $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}


$db = json_decode(file_get_contents("users.json"), true);

$login = $_GET["login"];
$pass = $_GET["pass"];


$id=1;
$found = false;
foreach ($db as $record) {
    
	if (($record["login"] == $login) && ($record["pass"] == $pass)){
		$found = true;
		break;
	}
    $id++;
}


if ($found == false) {
    header('Location: login.php?code_1=1');
    exit;
}


 if (isset($db[$id])){
 	$token = randomString();
 	setcookie("token", $token);

    $db[$id]["token"] = $token;
    file_put_contents("users.json", json_encode($db));
 	header('Location: index.php');
 	exit;
 }
 else {
 	header('Location: login.php?=err=$found');
 	exit;
 }


?>