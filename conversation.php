<!DOCTYPE html>
<html>
<head>
	<title>Conversation</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"> -->
</head>
<body>
  <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
	<?php 
		session_start();
		if (!isset($_SESSION['L_Name']) and !isset($_SESSION['F_Name']) and !isset($_SESSION['user_name'])){
			header('Location: sign_in.php');		
		}
		else
		{
			$user_name=$_SESSION['user_name'];
			$id_user=$_SESSION['id_user'];
	?>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  	<!-- <a class="navbar-brand" href="#">My Icons <i class="fas fa-heart"></i></a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    	<span class="navbar-toggler-icon"></span>
  	</button> -->

  		<div class="collapse navbar-collapse " id="collapsibleNavbar">
    		<ul class="navbar-nav">
    			<li class="nav-item">

<!-- lien vers acceuil de l'utilisateur -->
        			<?php echo "<a class='nav-link' href='acceuil.php?user=$user_name'>Acceuil</a>";?>
      			</li>
      			<li class="nav-item">

<!-- lien vers conversation de l'utilisateur -->
        			<a class="nav-link" href="conversation.php">Messages</a>
      			</li>
      			<li class="nav-item">

<!-- lien vers profile de l'utilisateur -->
			  		<?php echo "<a class='nav-link' href='profile.php?user=$user_name'>Profil</a>";?>
      			</li>
      			<li class="nav-item">
        			<a class="nav-link" href="deconnexion.php">Deconnexion</a>
      			</li>        
    		</ul>
  		</div>  
</nav><br>

	<?php  
		include('connect_database.php');
		
		$req="SELECT * FROM follow WHERE id_user_following='$id_user'";
		$res=mysqli_query($link,$req);
		$friends=array();
		while($row=mysqli_fetch_assoc($res)){
			$friends[]=$row['id_user_follower'];
		}
		$friends=implode(",",$friends);
		echo "La Liste De Vos Amis <br><hr>";
		if(empty($friends)){	
			echo "pas d amis";
		}else{
			$sql="SELECT * FROM user where id_user IN ($friends)";
			$result=mysqli_query($link,$sql);
			while($data=mysqli_fetch_assoc($result)){
				$id_user=$data['id_user'];
				$user=$data['user_name'];
          		$F_Name=$data['F_Name'];
          		$L_Name=$data['L_Name'];
          		$usn=$data['user_name'];
          		$status=$data['is_active'];
          		$pdp=$data['photo'];
          		echo "<img width='30px;' src='photodeprofil/$pdp'</a> <a href='messages.php?user_receiver=$user'>$F_Name $L_Name ($usn) <img width='10px;' src='$status'</a><hr>";
			}
		}
	?>
	<?php 
		} 
	?>
	
</body>
</html>