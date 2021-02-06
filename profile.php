<?php 
	include("connect_database.php");
	session_start();
	if (!isset($_SESSION['L_Name']) and !isset($_SESSION['F_Name']) and !isset($_SESSION['user_name']))
	{
		header('Location: sign_in.php');		
	}
	else
	{
        $user=$_GET['user'];
		$user_name=$_SESSION['user_name'];
		$id_user_following=$_SESSION['id_user'];

//recuperer id du profil rechercher
		$sql="SELECT * from user where user_name='$user'";
		$result=mysqli_query($link,$sql);
		$data=mysqli_fetch_assoc($result);
		$id_user=$data['id_user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="./js/main.js"></script>
    <title>Profile</title>
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
</nav>

<br>

<?php
	echo "<img width='40px;' src='photodeprofil/".$data['photo']."'><br>".$data['F_Name'].' '.$data['L_Name'].' ( '.$user.' )'." "."<img width='15px;' src=".$data['is_active'].">";
	// echo "<img width='40px;' src='photodeprofil/".$data['photo']."'><br>".$user;

if ($user==$user_name) 
{
?>
    <form method="post" action="publication.php?page=profile" enctype="multipart/form-data">
		<textarea name="publication" id="post" cols="30" rows="5" placeholder="vous voulez poster quelque chose ?"></textarea><br>
		<input type="file" class="photo" name="photo">
		<input type="submit" class="publier" name="publier" value="Publier">
    </form><hr>
<?php
}
    $sql9="SELECT * from follow where id_user_following='$id_user_following' and id_user_follower='$id_user'";
	$result9=mysqli_query($link,$sql9);
	$data9=mysqli_fetch_assoc($result9);
	 
?>
<?php 
if ($user!=$user_name && !$data9) 
{
    echo"<form action='follow.php?user=$user' method='post'>
    <input type='submit' name='follow' value='Follow'>
    </form>";

}
if ($user!=$user_name && $data9) 
{
	echo"<form action='unfollow.php?user=$user' method='post'>
	
    <input type='submit' name='unfollow' value='Unfollow'>
    </form>";
}
?>

<div class="publication">
	<?php
				
		$sql2="SELECT * from publication where id_user='$id_user' order by date desc";
			$result2=mysqli_query($link,$sql2);

			while($data1=mysqli_fetch_assoc($result2))
			{
				if($data1['photo']=='NULL')
				{
					$share=0;
                    $sql7="SELECT * from user where id_user='".$data1['id_user']."'"; 
					$result7=mysqli_query($link,$sql7);
					$id_publication=$data1['id_publication'];
					echo "<div id='$id_publication'>";
                    $data7=mysqli_fetch_assoc($result7);
					echo "<img width='40px;' src='photodeprofil/".$data7['photo']."'>";
					echo $data7['user_name'].": ".substr($data1['date'],0,-3)."<br><br>".$data1['contenue']."<br>".$data1['likes'].' LIKE'.'<br>';


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
$req1="SELECT * FROM publications_likes WHERE id_publication='$id_publication' and id_user='$id_user_following'";
$res1=mysqli_query($link,$req1);
$row1=mysqli_fetch_assoc($res1);		
if(!$row1){
	echo "<form action='like.php?id=$id_publication&page=profile&user=$user' method='post'>
			<input type='submit' name='like' value='LIKE'>
		   </form><br>";
}else{								
	echo "<form action='unlike.php?id=$id_publication&page=profile&user=$user' method='post'>
			<input type='submit' name='unlike' value='UNLIKE'>
		  </form><br>";
}



					if($data7['user_name']==$user_name)
					{
						echo "<a href='delete_publication.php?id=$id_publication&page=profile'>supprimer</a><br>";
					}
					if ($share==0) 
					{
						echo "<a href='share_publication.php?id=$id_publication&page=profile'>Share</a><hr>";
					}

					echo "<form method='post' action='comment.php?id=$id_publication&user=$user&page=profile'>
					<textarea name='comment' id='post' cols='30' rows='5' placeholder='vous voulez commenter quelque chose ?'></textarea><br>
					<input type='submit' class='commenter' name='commenter' value='commenter'>
					</form>";

					$sql3="SELECT * from comments where id_publication='$id_publication' order by date desc";
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
							echo "<a href='delete_comment.php?id=$id_comment&page=profile'>supprimer</a><hr width=200px; align=left><br>";
						}
						else 
						{
							echo "<hr width=200px; align=left>";
						}
					}
					echo '</div><hr>';
				}
				else
				{
					$share=0;
					$sql8="SELECT * from user where id_user='".$data1['id_user']."'"; 
					$result8=mysqli_query($link,$sql8);
					$id_publication=$data1['id_publication'];
                    echo "<div id='$id_publication'>";
                    $data8=mysqli_fetch_assoc($result8);
					echo "<img width='40px;' src='photodeprofil/".$data8['photo']."'>";
					echo $data8['user_name'].": ".substr($data1['date'],0,-3)."<br><br>".$data1['contenue']."<br> <img src='photo/".$data1['photo']."'><br>";

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
					$req1="SELECT * FROM publications_likes WHERE id_publication='$id_publication' and id_user='$id_user_following'";
					$res1=mysqli_query($link,$req1);
					$row1=mysqli_fetch_assoc($res1);		
					if(!$row1){
						echo "<form action='like.php?id=$id_publication&page=profile&user=$user' method='post'>
								<input type='submit' name='like' value='LIKE'>
					 		  </form><br>";
					}else{								
						echo "<form action='unlike.php?id=$id_publication&page=profile&user=$user' method='post'>
								<input type='submit' name='unlike' value='UNLIKE'>
							  </form><br>";
					}


					if($data8['user_name']==$user_name)
					{
						echo "<a href='delete_publication.php?id=$id_publication&page=profile'>supprimer</a>";
					}

					if ($share==0) 
					{
						echo "<a href='share_publication.php?id=$id_publication&page=profile'>Share</a><hr>";
					}

					echo "<form method='post' action='comment.php?id=$id_publication&user=$user&page=profile'>
					<textarea name='comment' id='post' cols='30' rows='5' placeholder='vous voulez commenter quelque chose ?'></textarea><br>
					<input type='submit' class='commenter' name='commenter' value='commenter'>
					</form>";

					$sql4="SELECT * from comments where id_publication='$id_publication' order by date desc";
					$result4=mysqli_query($link,$sql4);
					while($data3=mysqli_fetch_assoc($result4))
					{
						$id_user_comment=$data3['id_user'];
						$id_comment=$data2['id_comment'];

                        $sql5="SELECT * from user where id_user='$id_user_comment'";
                        $result5=mysqli_query($link,$sql5);
                        $data5=mysqli_fetch_assoc($result5);
						echo $data5['user_name'].": ".substr($data3['date'],0,-3)."<br><br>".$data3['contenue']."<br>";
						
//supprimer commentaire
						if($data5['user_name']==$user_name)
						{
							echo "<a href='delete_comment.php?id=$id_comment&page=profile'>supprimer</a><hr width=200px; align=left><br>";
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