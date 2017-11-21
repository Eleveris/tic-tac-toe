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
$rep_pass = $_GET["rep_pass"];
if ($pass != $rep_pass) {
    header('location: login.php?code_2=1&form=1');
    exit;
}


$id=0;
$found = false;
foreach ($db as $record) {
    $id++;
	if ($record["login"] == $login){
		$found = true;
		break;
	}
}
if ($found == true){
	header('Location: login.php?code_3=1&form=1');
    exit;
}


$id++;
$db[$id]["login"]=$login;
$db[$id]["pass"]=$pass;
$db[$id]["rating"]=1000;
$db[$id]["games"]=[];
if(isset($db[$id])){
	$token = randomString();
 	setcookie("token", $token);
    $db[$id]["token"] = $token;
    file_put_contents("users.json", json_encode($db));
 	header('Location: index.php');
 	exit;
 }

?>