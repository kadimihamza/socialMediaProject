<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="signup.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<title>SignUp</title>
</head>
<body>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script>
		$(document).ready(function(){
			$(".container").animate({
				height:'415px'
			},1000);
		});
	</script>

	<h1 style="font-family: 'FLOWER';text-align: center;font-size: 90px;"><span style="color: #C82333;">Moroccan</span><span style="color: #218838;">Book</span></h1>
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
   			background-color:  rgb(15,15,15);
   			border-radius: 10px;
   			box-shadow: 5px 5px 10px 1px black;
    		padding:15px;
    		height: 0;
    		margin-top: 2%;
		}
		.input{
   			margin: 5px;
		}
		#photo{
    		display: none;
		}
    	body{
			background-image:linear-gradient(227deg,  black, #343A40);
			background-attachment: fixed;
			font-family: Mali-Regular;
			margin-top: 2% ;
		}
		.right{
			margin-left: 3%;
		}
	</style>
	<div class="container" style="width: 60%;min-width: 700px; ">
		<h2 style="text-align: center; margin-bottom: 15px;color: #C82333;"><strong>SIGN UP</strong></h2>		
		<form action="check_sign_up.php" method="post" enctype="multipart/form-data">		
				<div class="form-inline">
					<input type="text" placeholder="First Name" name="first_name" class="input form-control" style=" width: 47.3%;" required value="<?php if(isset($_GET['first'])){echo $_GET['first'];}?>"> <!-- value = ... pour ne pas les retapés -->
		
					<input type="text" name="last_name" placeholder="Last Name" class="input form-control right" style=" width: 47.3%;" required value="<?php if(isset($_GET['last'])){echo $_GET['last'];}?>">
				</div>
		
				<div class="form-inline">
					<input type="text" name="user_name" placeholder="User Name" class="input form-control" style=" width: 47.3%;" required  value="<?php if(isset($_GET['user'])){echo $_GET['user'];}?>" >
		
					<input type="email" name="email" placeholder="Email" class="input form-control right" required style=" width: 47.3%;"  value="<?php if(isset($_GET['email'])){echo $_GET['email'];}?>" >
				</div>
		
				<div class="form-inline">
					<input type="date" name="birthday" class="input birthday form-control" required style=" width: 47.3%;">

					<select name="ville" class="input liste form-control right" required style=" width: 47.3%;">
					<?php 
						include("connect_database.php");
						$sql1="SELECT * FROM ville";
						$result1=mysqli_query($link,$sql1);
						while($data=mysqli_fetch_assoc($result1)){
							echo '<option value='.$data['Id_Ville'].'>';
							echo $data['Nom_Ville'];
							echo '</option>';
						}		
					?>

					</select><br>
				</div>

				<div class="form-inline">
					<input type="password" name="password" placeholder="Password" style=" width: 47.3%;" class="input form-control" required>

					<input type="password" name="confirmation_password" class="input form-control right" style=" width: 47.3%;" placeholder="Confirmation Password" required>
				</div>

				<span class="form-inline">
					<label for="photo" class="input photo form-control" style="text-align: center; width: 47.3%;height: 40px;font-size: 14px;">Insérer La Photo De Profil</label>
					<input type="file" id="photo" name="photo_de_profil" class="input form-control">
					<input type="text" name="telephone" class="input form-control right" placeholder="Numero De Telephone" style=" width: 47.3%;" required>
				</span>

				<input type="submit" name="sign_up" class="btn btn-danger" value="Confirm" style="margin-top: 10px;width: 100%;">		
		
			</form>
			<div style="text-align: center; margin-top: 10px;color:#218838;">Already have an acount ? <a href="sign_in.php" style="color: #218838;">Sign In</a></div>
	</div>
	<?php
		/* errors */
		if(!isset($_GET['signup'])){
			exit();
		}else{
			$signupcheck = $_GET['signup'];
			if ($signupcheck == 'password') {
				/* error password */
				echo "<p classe = 'error' style='color:#C82333; font-size:15px;text-align:center; margin-top:15px;'>&#9888 <strong>Vous n'avez pas taper le meme mot de passe</strong>";
				exit();	
			}elseif($signupcheck == 'email'){
				/* error email*/ 
				echo "<p classe = 'error' style='color:#C82333; font-size:15px;text-align:center;margin-top:15px;'>&#9888 <strong>votre email est deja utilisé dans un autre compte</strong></p> ";
				exit();
			}elseif ($signupcheck == 'username') {
				/* error Username */ 
				echo "<p classe = 'error' style='color:#C82333; font-size:15px; text-align:center;margin-top:15px;'>&#9888 <strong>votre Username est deja pris</strong></p>";
				exit();
			}
		}
	?>
</body>
</html>