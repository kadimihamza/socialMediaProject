<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SignIn</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
	<style type="text/css">
		@font-face{
			font-family: FLOWER;
			src:url('FLOWER.ttf');
		}
		@font-face{
			font-family: Mali-Regular;
			src:url('CaviarDreams_Bold.ttf');
		}
		.container{
			background-color: rgb(15,15,15);
			border-radius: 10px;
  			box-shadow: 5px 5px 10px 3px black;
  			float: right;
  			width: 400px;
  			margin-right: 5%;
  			margin-top: 13.4%;margin-bottom: 11.4%;
		}
		body{
			background-image:linear-gradient(227deg, black, #343A40);
			background-repeat: no-repeat;
			font-family: Mali-Regular;
			color: white;
			background-attachment: fixed;
		}
		.logo{
			float: left;
			margin-left: 5%;
			margin-top: 11.4%;margin-bottom: 11.4%;
		}
		@media screen and (max-width:1180px) {
  			.logo{
  				width: 80%;
  				margin-left: 10%;
  				margin-right: 10%;
  			}
  			.container{
  				margin-top: 15px;
  				width:80% ;
  				margin-bottom:10%;
  				margin-left: 10%;
  				margin-right: 10%;
  			}
  		}
	</style>
		<div class="logo">
			<h1 style="font-family: 'FLOWER';text-align: center; margin-top: 25px;font-size: 80px;width: 100%"><span style="color: red;">Moroccan</span><span style="color: green;">Book</span><br><span style="font-size: 20px;font-family: Mali-Regular;font-variant: small-caps;">Avec MoroccanBook, partagez et restez en contact avec votre entourage.<hr class="hr">Créer une Page pour une célébrité, un groupe ou une entreprise.</span></h1>
		</div>
		<div class="container" style="min-width: 20%;max-width: 100%; padding: 15px;">
			<h2 style="text-align: center;margin-bottom: 10px;color: #218838;"><strong>LOGIN</strong></h2>
			<form action="check_sign_in.php" method="post">
				<div class="form-group">
					<input type="text" name="user_name" class="form-control input" placeholder="User Name" size="200">
				</div>
				<div class="form-group">
					<input type="password" name="password" class="form-control input" placeholder="Password" size="200">
				</div>
				<input type="submit" name="sign_in" value="Login" class="btn btn-success" style="width: 100%;"><hr>
			</form>
			<button class="btn btn-danger" style="width: 100%"><a href="sign_up.php" style="color: white;">SIGN UP</a></button>
		</div>	

	<?php 
		if (isset($_COOKIE['error_sign_in'])){
			echo "<p style='color:red; font-size:15px;text-align:center;'>&#9888".$_COOKIE['error_sign_in']."</p>";
		}
	?>
</body>
</html>