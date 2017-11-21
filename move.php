<?php
// Входные данные: маркер доступа, ID игры, ход
// проверить может ли игрок с данным маркером сделать ход на данной доске в данный момент
// если да - добавить ход в игру, поменять очередность и вернуть OK
//	print('{"result":"OK"}');


	$db = json_decode(file_get_contents("games.json"), true);
	$userdb = json_decode(file_get_contents("users.json"), true);

	function parsing($string){
		$coord=explode("c",$string);
		$c=$coord[1];
		$coord=explode("r",$coord[0]);
		$r=$coord[1];
		$result=["r"=>$r,"c"=>$c];
		return $result;
	}

	function checkForWin($cell){
		global $db;
		$main_coord=parsing($cell);
		$counter=0;
		$vectors=[[0,-1],[1,-1],[1,0],[1,1],[0,1],[-1,1],[-1,0],[-1,-1]];
		$sum_vectors=[1,1,1,1,1,1,1,1];
		$vector_streak=[0,0,0,0];

		for ($i=1; $i<5; $i++){
			for ($j=0; $j<8; $j++){
				$r=$main_coord["r"]+$vectors[$j][1]*$i;
				$c=$main_coord["c"]+$vectors[$j][0]*$i;
				
				if (!(isset($db["game".$_GET["game_id"]]["moves"]["r".$r."c".$c]))){
					if ($sum_vectors[$j]>0) {$sum_vectors[$j]=-$sum_vectors[$j];}
				}

				elseif (isset($db["game".$_GET["game_id"]]["moves"]["r".$r."c".$c])){
					if ($db["game".$_GET["game_id"]]["moves"]["r".$r."c".$c]==$db["game".$_GET["game_id"]]["turn"]){

						if ($sum_vectors[$j]>0) {$sum_vectors[$j]++;}
					}
					else {
						if ($sum_vectors[$j]>0) {$sum_vectors[$j]=-$sum_vectors[$j];}
					}
				}

			}
		}
		

		for ($i=0; $i<4; $i++){
			$vector_streak[$i]=abs($sum_vectors[$i])+abs($sum_vectors[$i+4])-1;
			if ($vector_streak[$i]>=5){ return "win";
			exit;
		}
		}
		return "fail";
		exit;
	}



	if ($db["game".$_GET["game_id"]]["status"]=="online"){
		if ($db["game".$_GET["game_id"]]["players"][$db["game".$_GET["game_id"]]["turn"]]==$_GET["player"]){
			if (!(isset($db["game".$_GET["game_id"]]["moves"][$_GET["cell"]]))){
				$db["game".$_GET["game_id"]]["moves"][$_GET["cell"]]=$db["game".$_GET["game_id"]]["turn"];
				if (checkForWin($_GET["cell"])=="win"){
					$db["game".$_GET["game_id"]]["status"]=$db["game".$_GET["game_id"]]["turn"]." win";
					$win=$db["game".$_GET["game_id"]]["turn"];
					if ($win=="X"){
						$lose="O";
					}
					if ($win=="O"){
						$lose="X";
					}
					$winner=0;
					$loser=0;
					foreach ($userdb as $user) {
						$winner++;
						$loser++;
						if ($user["login"]==$db["game".$_GET["game_id"]]["players"][$win]){
							$record["winner"]=$winner;
						}
						elseif ($user["login"]==$db["game".$_GET["game_id"]]["players"][$lose]){
							$record["loser"]=$loser;
						}
					}
					if ($userdb[$record["loser"]]["rating"]>=10){
						$userdb[$record["winner"]]["rating"]+=10;
						$userdb[$record["loser"]]["rating"]-=10;
					}
					file_put_contents("users.json", json_encode($userdb));
					$db["game".$_GET["game_id"]]["time"]=time();
					file_put_contents("games.json", json_encode($db));
					print('{"result":"win"}');
					exit;
				}

			
		
			if($db["game".$_GET["game_id"]]["turn"]=='X'){

			$db["game".$_GET["game_id"]]["turn"]='O';
			$db["game".$_GET["game_id"]]["time"]=time();
			file_put_contents("games.json", json_encode($db));
			print('{"result":"success"}');
			exit;
			}
			elseif($db["game".$_GET["game_id"]]["turn"]=='O'){

			$db["game".$_GET["game_id"]]["turn"]='X';
			$db["game".$_GET["game_id"]]["time"]=time();
			file_put_contents("games.json", json_encode($db));
			print('{"result":"success"}');
			exit;
			}
		}

	}
}

	file_put_contents("games.json", json_encode($db));
	print('{"result":"fail"}');
?>