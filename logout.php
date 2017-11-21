<?php

if (isset($_COOKIE["token"])){
	$token=$_COOKIE["token"];
	$db = json_decode (file_get_contents("users.json"), true);

	$id=1;
	foreach ($db as $record) {
		if ($record["login"]==$_GET["user"] && $record["token"]==$token){
			setcookie("token", $token, time()-1);
			$record["token"]="";
			$db[$id]=$record;
			file_put_contents("users.json", json_encode($db));

			header('Location: index.php');
		}
		$id++;
	}


}
else header('Location: index.php');

?>