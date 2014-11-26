<?php session_start(); ?>
<html>
<head>
  <link rel="stylesheet" href="styles/bootstrap.min.css">
  <link rel="stylesheet" href="styles/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>
		GriffChat Community Messageboard Registration
	</title>

</head>
<body>
  <div class="jumbotron">
    <img src="https://i.imgur.com/kfvPsvT.png" style="max-width:50%;">
<h1>GriffChat Registration</h1>
</div>

<div class="col-md-4 col-md-offset-4" style="text-align:center; color:white;">
  <h3>Register with your ASL email for a GriffChat Account</h3>
  
<form action="registerConfirm.php" method="post">
<br>
<input type="text" name="email" style="color:black" class="form-control" placeholder="Email Address">
<br>
<input type="password" name="password" style="color:black" class="form-control" placeholder="Password">
<br>
<input type="password" name="confirmPassword" style="color:black" class="form-control" placeholder="Confirm Password">
<br>
<input type="text" name="firstName" style="color:black" class="form-control" placeholder="First Name">
<br>
<input type="text" name="lastName" style="color:black" class="form-control" placeholder="Last Name">
<br>
<input type="text" name="dob" style="color:black" class="form-control" placeholder="Date of Birth (YYYY-MM-DD)">
<br><br>
<input type="submit" value="Register" style="color:black" class="btn btn-default">

</form>
</div>

</body>
</html>