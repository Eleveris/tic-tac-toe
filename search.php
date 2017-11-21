<?php

function get_id($game_id){
	$id=0;
	for ($i=4; $i<strlen($game_id); $i++){
	$id=$id*10+$game_id[$i];
}
	return $id;
}

$db = json_decode(file_get_contents("games.json"), true);
$userdb = json_decode(file_get_contents("users.json"), true);

$found=false;
$user_id=0;
foreach ($userdb as $user) {
	$user_id++;
	if ($user["login"]==$_GET["user"]){
		$found=true;
		break;
	}
}
if ($found==false) {
	$result["result"]="fail";
	print json_encode($result);
	exit;
}

if($_GET["game_id"]=="none"){//если игры для пользователя ещё нет, то нужно найти подходящую и вернуть её id с результатом готовности игры(found), если подходящей нет, то создать новую и вернуть что игра создана(created) и её id
	$id=0;
	$found=false;
	foreach($db as $game){
		$id++;
		
		if ($game["status"]=="finding"){
			$db["game".$id]["players"]["O"]=$_GET["user"];
			$db["game".$id]["status"]="online";
			$db["game".$id]["time"]=time();
			$userdb[$user_id]["games"][]=$id;
			file_put_contents("users.json", json_encode($userdb));
			
			$result["result"]="found";
			$result["game_id"]=$id;
			$result["token"]=1;
			
			file_put_contents("games.json", json_encode($db));
			$found=true;
			print json_encode($result);
			exit;
		}
	}
if ($found==false){
	$id++;
	$db["game".$id]["moves"]=[];
	$db["game".$id]["players"]["X"]=$_GET["user"];
	$db["game".$id]["turn"]="X";
	$db["game".$id]["status"]="finding";
	
	$result["result"]="created";
	$result["game_id"]=$id;
	$result["token"]=2;
	file_put_contents("games.json", json_encode($db));
	print json_encode($result);
	exit;
}


}

elseif (isset($db["game".$_GET["game_id"]])){//если игра уже существует то нужно проверить наличие второго игрока
	if (isset($db["game".$_GET["game_id"]]["players"]["O"])){

		$result["result"]="found";
		$result["game_id"]=$_GET["game_id"];
		$result["token"]=3;
		$userdb[$user_id]["games"][]=$_GET["game_id"];
		file_put_contents("users.json", json_encode($userdb));
		file_put_contents("games.json", json_encode($db));
		print json_encode($result);
		exit;
	}
	else{
		$result["result"]="created";
		$result["game_id"]=$_GET["game_id"];
		$result["token"]=4;
		file_put_contents("games.json", json_encode($db));
		print json_encode($result);
		exit;
	}
}

?>