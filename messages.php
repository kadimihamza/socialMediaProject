<?php
	include('connect_database.php');
	session_start();

	$id_user=$_SESSION['id_user'];
	$user_name=$_SESSION['user_name'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>Send Message</title>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  	<!-- <a class="navbar-brand" href="#">My Icons <i class="fas fa-heart"></i></a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    	<span class="navbar-toggler-icon"></span>
  	</button> -->

  	<div class="collapse navbar-collapse " id="collapsibleNavbar">
    	<ul class="navbar-nav">
    		<li class="nav-item">

<!-- lien vers acceuil de l'utilisateur -->
        		<a class='nav-link' href="acceuil.php">Acceuil</a>
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
	if ($_GET['user_receiver']!=$user_name) 
	{
		$sql="SELECT * FROM user WHERE user_name='".$_GET['user_receiver']."'";
		$result=mysqli_query($link,$sql);
		$data=mysqli_fetch_assoc($result);
		echo "Sending Message To : ".$data['F_Name'].' '.$data['L_Name'].'<hr>';
		echo "user_sender Full Name is : ".$_SESSION['F_Name'].' '.$_SESSION['L_Name'];
	?>

	<form method="post" action="" enctype="multipart/form-data">
		<textarea name="message" cols="100" rows="5" placeholder="Write Your Message"></textarea><br>
		<input type="file" class="photo" name="photo">
		<input type="submit" class="envoyer" name="envoyer" value="Send">
	</form>

	<?php	
		$user_sender=$_SESSION['id_user'];
		$user_receiver=$data['id_user'];
		$date=date("Y-m-d H:i:s");

		if (empty($_FILES['photo']['name']))
		{
            $photo=NULL;
		}
		else
		{
            $photo=$_FILES['photo']['name'];
            $upload="photomessages/".$photo;
            move_uploaded_file($_FILES['photo']['tmp_name'],$upload);
        }
		if (isset($_POST['envoyer']))
		{
			$message=$_POST['message'];
			$sql1="INSERT INTO `messages` VALUES (0,'$user_sender','$user_receiver','$message','$date','".$photo."')";
			$result1=mysqli_query($link,$sql1);
		}
		echo "<div id='messages'>";
		$sql3="SELECT * FROM messages INNER JOIN user as u1 ON u1.id_user=user_sender  WHERE (user_receiver='$user_receiver' AND user_sender='$user_sender') OR (user_receiver='$user_sender' AND user_sender='$user_receiver') ORDER BY heure ASC";
		$result3=mysqli_query($link,$sql3);
		while($data3=mysqli_fetch_assoc($result3))
		{
		   echo $data3['user_name'].' : '.$data3['contenu'].' -> '.' <span style="color:red;font-size:12px;">'.substr($data3['heure'],0,-3).'</span><br>';
		}		
		echo "</div>";	
		setcookie('userReceiver',$user_receiver,time()+1000);	
	?>
	<hr>
	<?php
	}
	else 
	{
		header("location: conversation.php");
	}
	?>
	<script>
		setInterval('load_messages()', 500);
		function load_messages(){
			$('#messages').load('load_messages.php');
		}
	</script>
</body>
</html>