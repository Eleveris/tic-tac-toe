<?php

$db = json_decode(file_get_contents("games.json"), true);
$userdb = json_decode(file_get_contents("users.json"),true);

if (isset($db["game".$_GET["game_id"]])){
	if ($db["game".$_GET["game_id"]]["status"]=="online"){
	//print json_encode($db["game".$_GET["game_id"]]["moves"]);

	if (time()-$db["game".$_GET["game_id"]]["time"]>=60){
		$db["game".$_GET["game_id"]]["time"]=time();
		
		if($db["game".$_GET["game_id"]]["turn"]=="X"){
			$db["game".$_GET["game_id"]]["turn"]="O";
			$db["game".$_GET["game_id"]]["status"]="O win";
			$winner=0;
			$loser=0;
			foreach ($userdb as $user) {
				$winner++;
				$loser++;
				if ($user["login"]==$db["game".$_GET["game_id"]]["players"]["O"]){
					$record["winner"]=$winner;
				}
				elseif ($user["login"]==$db["game".$_GET["game_id"]]["players"]["X"]){
					$record["loser"]=$loser;
				}
				if (isset($record["winner"]) && isset($record["loser"])) {break;}
			}
			if ($userdb[$record["loser"]]["rating"]>=10){
			$userdb[$record["winner"]]["rating"]+=10;
			$userdb[$record["loser"]]["rating"]-=10;
		}
		file_put_contents("users.json", json_encode($userdb));
		}
		elseif($db["game".$_GET["game_id"]]["turn"]=="O"){
			$db["game".$_GET["game_id"]]["turn"]="X";
			$db["game".$_GET["game_id"]]["status"]="X win";
			$winner=0;
			$loser=0;
			foreach ($userdb as $user) {
				$winner++;
				$loser++;
				if ($user["login"]==$db["game".$_GET["game_id"]]["players"]["X"]){
					$record["winner"]=$winner;
				}
				elseif ($user["login"]==$db["game".$_GET["game_id"]]["players"]["O"]){
					$record["loser"]=$loser;
				}
				if (isset($record["winner"]) && isset($record["loser"])) {break;}
			}
			if ($userdb[$record["loser"]]["rating"]>=10){
			$userdb[$record["winner"]]["rating"]+=10;
			$userdb[$record["loser"]]["rating"]-=10;
		}
		file_put_contents("users.json", json_encode($userdb));
		}
	}

	file_put_contents("games.json", json_encode($db));

	
}
print json_encode($db["game".$_GET["game_id"]]);
}


?>