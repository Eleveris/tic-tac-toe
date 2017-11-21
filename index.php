<?php

 include 'authorize.php';

?>

<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="jquery-3.2.1.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    	<link rel="stylesheet" type="text/css" href="mycss.css">
		<title>tic-tac-toe</title>

		

	</head>

	<body>

		
	<nav class="col-12 navbar navbar-light nav_bg">
		<a class="navbar-brand" style="color: white">
			Hello, <?php
			print $user_record["login"]."<br>";
			print "Your rating is: ".$user_record["rating"];
			?>
		</a>
		<div class="col-2">
			<button class="col-12 btn btn-primary" type="button" onclick=search("<?php print $user_record["login"] ?>","none")>Play</button>
		</div>
		
		<div class="col-2"></div>

		<div class="col-1">
			<button class="col-12 btn btn-secondary" type="button" onclick=location="<?php print 'logout.php?user='.$user_record["login"]?>">Logout</button>
		</div>

		
		
    	


	</nav>
	<div class="col-12" style="height: 70px" >&nbsp;</div>
	<div class="row">
		<div class="col-1"></div>
		<div class="col-3" >
		<table border="1" class="col-12 index_table">
			<tr><td colspan="3">Match history</td></tr>
			<tbody>
			<?php
				$game_num=0;
				foreach ($user_record["games"] as $game_id) {
					print "<tr><td>".$user_game["game".$game_id]["players"]["X"]." vs ".$user_game["game".$game_id]["players"]["O"]."</td>
					<td>".$user_game["game".$game_id]["players"][$user_game["game".$game_id]["turn"]]." win</td>
					<td class=\"td_link\" onclick=location=\"game.php?game_id=".$game_id."\">Watch</td>
					</tr>";
				}
			?>
			</tbody>
		</table>
		</div>
		<div class="col-1"></div>
		<div class="col-3">
		<table border="1" class="col-12 index_table">
			<tr><td colspan="3">Match online</td></tr>
			<tbody>
			<?php
				foreach ($active_game as $game) {
					print "<tr><td>".$game["players"]["X"]." vs ".$game["players"]["O"]."</td><td class=\"td_link\" onclick=location=\"game.php?game_id=".key($active_game)."\">Watch</td></tr>";
				}
			?>
			</tbody>
		</table>
		</div>
	</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

<script type="text/javascript">
	function search(name,id){
		$.ajax({
			url: "search.php?user="+name+"&game_id="+id,
			type: "GET",
			dataType: "json",
			success: function(data){//data.result={"status":"created"|"found","id":id} //передавать game_id только как none или ___
				//if (data.result == game created) poll search.php?user=name&game_id=data.game_id //for another player
				//if (data.result == game found) location="game.php?game_id=data.game_id"
				if (data.result=="found"){
					location="game.php?game_id="+data.game_id
				}
				else if (data.result=="created"){
					setTimeout(search,1000,name,data.game_id)
				}
				
			}
			})
		
	}

	function switch_play(condition){

	}
</script>

	</body>
</html>