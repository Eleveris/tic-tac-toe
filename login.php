<!DOCTYPE html>
<html>
	<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="mycss.css">
		<title>login tic-tac-toe</title>
	</head>
  

	<body style="background: #004d99 ">
    
   
<div class="row" style="margin: 10% 0">
<div class="col-3"></div>

 <div id="sign_in" class="col-6 main">  


  <form action="auth.php" class="sample" >


    <div class="col-12 container">
      <div class="welcome"><b>Welcome</b></div>

      <label><b>Username</b></label>
      <br>
      <input type="text" placeholder="Enter Username" name="login" class="login"  required>
      <br>
      <label><b>Password</b></label>
      <br>
      <input type="password" placeholder="Enter Password" name="pass" class="login" required>
      <br>
      <div class="row">
        <div class="col-6">
        <button type="submit" class="col-12">Sign In</button>
        </div>
        <div class="col-6">
        <button type="reset" class="col-12 reset">Reset form</button>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <button type="button" class="col-12" onclick="form_switch(0)" >Sign Up</button>
        </div>
        <div class="col-6">
          <div id="log_alert" class="col-12 alert alert-danger warning">Wrong username of password</div>
        </div>
      </div>
      
    </div>

  </form>

</div>

<div id="sign_up" class="col-6 modal"> 


  <form action="reg.php" class="sample">

    <div class="col-12 container">
      <div class="welcome"><b>Welcome</b></div>

      <label><b>Username</b></label>
      <br>
      <input type="text" placeholder="Enter Username" name="login" class="login"  required>
      <br>
      <label><b>Password</b></label>
      <br>
      <input type="password" placeholder="Enter Password" name="pass" class="login" required>
      <br>
      <label><b>Repeate password</b></label>
      <br>
      <input type="password" placeholder="Repeate Password" name="rep_pass" class="login" required>
      <div class="row">
        <div class="col-6">
        <button type="submit" class="col-12">Sign Up</button>
        </div>
        <div class="col-6">
        <button type="reset" class="col-12 reset">Reset form</button>
        </div>
      </div>
      <div class="row">
        <div class="col-6">
          <button type="button" class="col-12 close_button" onclick="form_switch(1)" >Cancel</button>
        </div>
        <div class="col-6">
          <div id="name_alert" class="col-12 alert alert-danger warning">User name already in use</div>
        </div>
        <div class="col-6">
          <div id="pass_alert" class="col-12 alert alert-danger warning">Passwords is not equal</div>
        </div>
      </div>
      
    </div>

  </form>

</div>

<div class="col-3"></div>
</div>
 

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<script type="text/javascript">
  function form_switch(condition){
    if(condition){
    document.getElementById('sign_up').style.display='none'
    document.getElementById('sign_in').style.display='block'
  }
    else{
      document.getElementById('sign_up').style.display='block'
      document.getElementById('sign_in').style.display='none'
    }
  }

  if (<?php if (isset($_GET["code_1"])) {print $_GET["code_1"];} else print 0;?>){
    document.getElementById('log_alert').style.display='block'
  }
  if (<?php if (isset($_GET["form"])) {print $_GET["form"];} else print 0;?>) form_switch(0);

  if (<?php if (isset($_GET["code_2"])) {print $_GET["code_2"];} else print 0;?>){
    document.getElementById('pass_alert').style.display='block'
  }
  if (<?php if (isset($_GET["code_3"])) {print $_GET["code_3"];} else print 0;?>){
    document.getElementById('name_alert').style.display='block'
  }

  
</script>

</body>
</html>