<?php 
	include("connect_database.php");
	session_start();

	if (!isset($_SESSION['L_Name']) and !isset($_SESSION['F_Name']) and !isset($_SESSION['user_name']))
	{
		header('Location: sign_in.php');		
	}
	else
	{
		$user_name=$_SESSION['user_name'];
		$id_user=$_SESSION['id_user'];
		$req2="UPDATE user SET is_active='status/online.jpg' WHERE id_user='$id_user'";
		mysqli_query($link,$req2);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Acceuil</title>
	<!-- <link rel="stylesheet" href="./css/acceuil.css"> -->
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="./js/main.js"></script>
</head>
<body>

<form action="cherche.php" method="post">
	<input onkeyup="chercher()" type="search" name="search" id="search">
</form>
<div id="result"></div>

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

//affichage des users 
	// $sql5="SELECT * from user where user_name!='$user_name'";
	// $result5=mysqli_query($link,$sql5);

	// while($data5=mysqli_fetch_assoc($result5))
	// {
	// 	$user=$data5['user_name'];
	// 	echo "<img width=20px; src='photodeprofil/".$data5['photo']."'><a href='profile.php?user=$user'>Profile $user</a><br>";
	// }
?>

<!-- formulaire pour publier -->

	<form method="post" action="publication.php?page=acceuil" enctype="multipart/form-data">
		<textarea name="publication" id="post" cols="30" rows="5" placeholder="vous voulez poster quelque chose ?"></textarea><br>
		<input type="file" class="photo" name="photo">
		<input type="submit" class="publier" name="publier" value="Publier">
	</form>
	
	<div class="publication">
		<?php

//recuperer tous les amis de l'utilisateur
				$sql6="SELECT * from follow where id_user_following='$id_user'";
				$result6=mysqli_query($link,$sql6);
				$friends_array=array();

//stocker les id des amie dans un tableau
				while($data6=mysqli_fetch_assoc($result6))
				{
					$friends_array[]=$data6['id_user_follower'];
				}
				$friends_array[]=$id_user;
				$friends_array=implode(",",$friends_array);

//affichage des post selon la date
				$sql2="SELECT * from publication where id_user in ($friends_array) order by date desc";
				$result2=mysqli_query($link,$sql2);
				while($data1=mysqli_fetch_assoc($result2))
				{

//afficher poste sans photo
					if($data1['photo']=='NULL')
					{
//id de post
						$id_publication = $data1['id_publication'];
						$share=0;
						echo "<div id='$id_publication'>";
                        $sql7="SELECT * from user where id_user='".$data1['id_user']."'"; 
                        $result7=mysqli_query($link,$sql7);
                        $data7=mysqli_fetch_assoc($result7);
						echo "<img width='40px;' src='photodeprofil/".$data7['photo']."'>";
						echo $data7['user_name'].": ".substr($data1['date'],0,-3)."<br><br>".$data1['contenue']."<br>".$data1['likes'].' LIKE'."<br>";
						
						

//afficher share publication
						if ($data1['id_user_share']!=0) 
						{
							$sql10="SELECT * from publication where id_user='".$data1['id_user_share']."' and id_publication='".$data1['id_publication_share']."' order by date desc"; 
                        	$result10=mysqli_query($link,$sql10);
							$data10=mysqli_fetch_assoc($result10);
							
							$sql11="SELECT * from user where id_user='".$data10['id_user']."'"; 
                        	$result11=mysqli_query($link,$sql11);
                        	$data11=mysqli_fetch_assoc($result11);
							echo "<img width='40px;' src='photodeprofil/".$data11['photo']."'>";
							echo $data11['user_name'].": ".substr($data10['date'],0,-3)."<br><br>".$data10['contenue']."<br>";
							$share=1;
						}

//button LIKE UNLIKE
$req1="SELECT * FROM publications_likes WHERE id_publication='$id_publication' and id_user='$id_user'";
$res1=mysqli_query($link,$req1);
$row1=mysqli_fetch_assoc($res1);		
if(!$row1){
	echo "<form action='like.php?id=$id_publication&page=acceuil' method='post'>
			<input type='submit' name='like' value='LIKE'>
		   </form><br>";
}else{								
	echo "<form action='unlike.php?id=$id_publication&page=acceuil' method='post'>
			<input type='submit' name='unlike' value='UNLIKE'>
		  </form><br>";
}


						if($data7['user_name']==$user_name)
						{	
							echo "<a href='delete_publication.php?id=$id_publication&page=acceuil'>Supprimer</a><br>";	
						}

						if ($share==0) 
						{
							echo "<a href='share_publication.php?id=$id_publication&page=acceuil'>Share</a>";
						}

//formulaire pour ajouter des commentaires
						echo "<form method='post' action='comment.php?id=$id_publication&page=acceuil'>
						<textarea name='comment' id='post' cols='30' rows='5' placeholder='vous voulez commenter quelque chose ?'></textarea><br>
						<input type='submit' class='commenter' name='commenter' value='commenter'>
						</form><hr>";

//afficher les commentaires
						$sql3="SELECT * from comments where id_publication='$id_publication' order by date asc";
						$result3=mysqli_query($link,$sql3);
						
						while($data2=mysqli_fetch_assoc($result3))
						{
							$id_user_comment=$data2['id_user'];
							$id_comment=$data2['id_comment'];
							
                            $sql5="SELECT * from user where id_user='$id_user_comment'"; 
                            $result5=mysqli_query($link,$sql5);
                            $data5=mysqli_fetch_assoc($result5);
							echo $data5['user_name'].": ".substr($data2['date'],0,-3)."<br><br>".$data2['contenue']."<br>";

//supprimer commentaire
							if($data5['user_name']==$user_name)
							{
								echo "<a href='delete_comment.php?id=$id_comment&page=acceuil'>supprimer</a><hr width=200px; align=left><br>";
							}
							else 
							{
								echo "<hr width=200px; align=left>";
							}
						}
						echo '</div><hr>';
					}

//afficher les publication avec photo
					else
					{
						$share=0;
//id de post pour le supprimer
						$id_publication=$data1['id_publication'];
						echo "<div id='$id_publication'>";
						$sql8="SELECT * from user where id_user='".$data1['id_user']."'"; 
                        $result8=mysqli_query($link,$sql8);
                        $data8=mysqli_fetch_assoc($result8);
						echo "<img width='40px;' src='photodeprofil/".$data8['photo']."'>";
						echo $data8['user_name'].": ".substr($data1['date'],0,-3)."<br><br>".$data1['contenue'].'<br>'.$data1['likes'].' LIKE'."<br> <img src='photo/".$data1['photo']."'><br>";

//afficher share publication
						if ($data1['id_user_share']!=0) 
						{
							$sql10="SELECT * from publication where id_user='".$data1['id_user_share']."' and id_publication='".$data1['id_publication_share']."' order by date desc"; 
                        	$result10=mysqli_query($link,$sql10);
							$data10=mysqli_fetch_assoc($result10);
							
							$sql11="SELECT * from user where id_user='".$data10['id_user']."'"; 
                        	$result11=mysqli_query($link,$sql11);
                        	$data11=mysqli_fetch_assoc($result11);
							echo "<img width='40px;' src='photodeprofil/".$data11['photo']."'>";
							echo $data11['user_name'].": ".substr($data10['date'],0,-3)."<br><br>".$data10['contenue']."<br><img width='80px;' src='photo/".$data10['photo']."'><br>";
							$share=1;
						}


//button LIKE UNLIKE
$req1="SELECT * FROM publications_likes WHERE id_publication='$id_publication' and id_user='$id_user'";
$res1=mysqli_query($link,$req1);
$row1=mysqli_fetch_assoc($res1);		
if(!$row1){
	echo "<form action='like.php?id=$id_publication&page=acceuil' method='post'>
			<input type='submit' name='like' value='LIKE'>
		   </form><br>";
}else{								
	echo "<form action='unlike.php?id=$id_publication&page=acceuil' method='post'>
			<input type='submit' name='unlike' value='UNLIKE'>
		  </form><br>";
}

						if($data8['user_name']==$user_name)
						{
							echo "<a href='delete_publication.php?id=$id_publication&page=acceuil'>supprimer</a><br>";
						}

						if ($share==0) 
						{
							echo "<a href='share_publication.php?id=$id_publication&page=acceuil'>Share</a>";
						}

//formulaire pour ajouter des commentaires						
						echo "<form method='post' action='comment.php?id=$id_publication&page=acceuil'>
						<textarea name='comment' id='post' cols='30' rows='5' placeholder='vous voulez commenter quelque chose ?'></textarea><br>
						<input type='submit' class='commenter' name='commenter' value='commenter'>
						</form><hr>";

//afficher les commentaires
						$sql4="SELECT * from comments where id_publication='$id_publication' order by date desc";
						$result4=mysqli_query($link,$sql4);
						while($data3=mysqli_fetch_assoc($result4))
						{
//id_user_comment => id de user qui va commente
							$id_user_comment=$data3['id_user'];
							$id_comment=$data2['id_comment'];

                            $sql5="SELECT * from user where id_user='$id_user_comment'";
                            $result5=mysqli_query($link,$sql5);
                            $data5=mysqli_fetch_assoc($result5);
							echo $data5['user_name'].": ".substr($data3['date'],0,-3)."<br><br>".$data3['contenue']."<br>";
//supprimer commentaire
							if($data5['user_name']==$user_name)
							{
								echo "<a href='delete_comment.php?id=$id_comment&page=acceuil'>supprimer</a><hr width=200px; align=left><br>";
							}
							else 
							{
								echo "<hr width=200px; align=left>";
							}
							
						}
						echo "</div>";
					}
				}
		?>
	</div>	
<?php 

	}
?>
		
</body>
</html>