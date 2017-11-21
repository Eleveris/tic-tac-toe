<!DOCTYPE html>
<html>
	<head>
		<title>login tic-tac-toe</title>
	</head>

	<body>
    <?php 

    $err=$_GET;
    if ($err==true) echo "<div>user with this login already exist</div>";
    ?>
    
 <form action="reg.php">

  <div class="container">
    <label><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="login" required>

    <label><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="pass" required>

    <button type="submit">Registration</button>
  </div>

</form> 

	</body>
</html>