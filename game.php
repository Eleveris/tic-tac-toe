<?php
 include 'authorize.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>tic-tac-toe</title>

		

		<script type="text/javascript" src="jquery-3.2.1.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    	<link rel="stylesheet" type="text/css" href="mycss.css">
	</head>

	<body onload="initialization();">
		<script>

			var timestamp;
			//var in_time_id = setTimeout(poll, 1000);
			//var time_id = setTimeout(poll, 1000);
			var sign = 'X';

			setTimeout(poll, 1);

			function poll(){
				$.ajax({
				url : "state.php?game_id=<?php print $_GET['game_id'] ?>",
				type : "GET",
				dataType: "json",
				success : function(data){
					timestamp=Date()/1000;
					if (data.status=="online"){

					//$("#turn").html(data.players[data.turn] + "'s turn " + "\"" + data.turn + "\" "  + (60-((Math.floor(+new Date()/1000))-data.time))+" second's last"+" "+data.status);
					$("#turn_name").html(data.players[data.turn] + "'s turn");
					$("#turn_time").html((60-((Math.floor(+new Date()/1000))-data.time))+" second's last")
					}
					else if ((data.status=="X win") || (data.status=="O win")) {
						$("#turn").remove();
					}
					for (move in data.moves){
						$("#"+move).html(data.moves[move]);
						$("#"+move).css("cursor", "default");

					}
					if ((data.status=="X win") || (data.status=="O win")) {
					win_request(data.players[data.turn]);
					//return;
					}
					else setTimeout(poll, 1000);
				}
			})		
				
				
			}

			

			function win_request(winner){
				$("#win").html("Congratulation "+winner+"'s Win");
				


			}

			function initialization(){
				init_field();
				init_user();
			}

			function init_user(){
				
				$.ajax({
					url : "state.php?game_id=<?php print $_GET['game_id'] ?>",
					type : "GET",
					dataType: "json",
					success : function(data){
						$("#hi").html("Hi, "+"<?php print $user_record["login"] ?>");
						//"<br>"+"game "+<?php print $_GET["game_id"]?>+": "+data.players["X"]+" vs "+data.players["O"];
						$("#game_id").html("Game "+<?php print $_GET["game_id"] ?>);
						$("#members").html(data.players["X"]+" vs "+data.players["O"]);
						//$("#game").html("game "+<?php print $_GET["game_id"]?>+": "+data.players["X"]+" vs "+data.players["O"]);
					}
				})
				console.log('user end');
			}

			function init_field(){
				for (let r = 0; r < 50; r++){
					let row = "";
					for (let c = 0; c < 50; c++){
						row += "<td id='r"+r+"c"+c+"' class=\"game_td\" onclick = \"onCellClick(this)\">&nbsp</td>"
					}
					$("#board").append("<tr>" + row + "</tr>");
				}
				//console.log('field created');
			}

			

			function onCellClick(el){
				$.ajax({
					url : "move.php?cell="+el.id+"&game_id=<?php print $_GET['game_id'] ?>"+"&player=<?php print $user_record['login'] ?>",
					type : "GET",
					dataType: "json",
					success : function(data){
							
							
							}
					
					
				})				
			}



		</script>
	</body>
	<nav class="col-12 navbar navbar-light nav_bg">
		<a id="hi" class="navbar-brand col-5" style="color: white">
		</a>
		<div class="col-2">
		<?php 
		if (!in_array($_GET["game_id"], $user_record["games"])) print "
			<button class=\"col-12 btn btn-primary\" type=\"button\" onclick=search(".$user_record["login"].",\"none\")>Play</button>";?>
		</div>
		
		<div class="col-2"></div>
		<div class="col-1">
			<button class="col-12 btn btn-secondary" type="button" onclick=location="index.php">Leave</button>
		</div>
		<div class="col-1">
			<button class="col-12 btn btn-secondary" type="button" onclick=location="<?php print 'logout.php?user='.$user_record["login"]?>">Logout</button>
		</div>
	</nav>

	<div class="row" style="width: 100%">
		<div class="col-4" style="align-content: center"></div>
		<div  class="col-1 game_bar game_id"><b id="game_id"></b>
		</div>
		<div id="members" class="col-3 game_bar game_members">
		</div>
	</div>
	
	<div class="row" style="width: 100%">
		<div class="col-4"></div>
		<div id="win" class="col-4 win"></div>
	</div>
	<div id="player"></div>


	<div id="turn" class="row" style="width: 100%">
		<div class="col-4"></div>
		<div  class="col-2 turn turn_name">
			<b id="turn_name"></b>
		</div>
		<div class="col-2 turn turn_time">
			<b id="turn_time"></b>
		</div>
	</div>


	<div class="row" style="width: 100%">
		<div class="col-1"></div>
		<div class="col-10 board_div">
		<table id="board" class="col-12 game_board"  border="1">
		</table>
		</div>
		
	</div>
</html>