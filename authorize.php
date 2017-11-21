<?php

if (isset($_COOKIE["token"]))
{
	$token = $_COOKIE["token"];
	$db = json_decode(file_get_contents("users.json"), true);
	$dbg = json_decode(file_get_contents("games.json"), true);



	$found = false;

	$game_id=0;
	foreach ($db as $record) {
		
		if ($record["token"] == $token){
			$found = true;
			$user_record = $record;
			$user_game=[];
			foreach ($dbg as $record) {
				$game_id++;
				if ($record["status"]!="finding"){
				if ($user_record["login"]==$record["players"]["X"] || $user_record["login"]==$record["players"]["O"]){
					$user_game["game".$game_id]=$record;
				}
			}

			}
			$game_id=0;
			$active_game=[];
			foreach ($dbg as $record){
				$game_id++;
				if ($record["status"]=="online"){
					$active_game[$game_id]=$record;
				}
			}

			break;
			}
}	
}


else
{
	header('Location: login.php');
}

if ($found==false){
		header('Location: login.php');
	}

?>