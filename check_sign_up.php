<?php 
	if (isset($_POST['sign_up']))
	{
		include("connect_database.php");
		$first_name=addslashes(strip_tags($_POST['first_name'])); 
		$last_name=addslashes(strip_tags($_POST['last_name']));  
		$user_name=addslashes(strip_tags($_POST['user_name']));  
		$email=addslashes(strip_tags($_POST['email']));
		$birthday=addslashes(strip_tags($_POST['birthday']));
		$city=$_POST['ville'];
		$password=addslashes(strip_tags($_POST['password']));
		$confirmation_password=addslashes(strip_tags($_POST['confirmation_password']));
		$telephone=addslashes(strip_tags($_POST['telephone']));
		/* photos de profils */
		$photo_de_profil=addslashes(strip_tags($_FILES['photo_de_profil']['name']));							

		if ($confirmation_password !== $password) { 
			/* check password */
			header("Location: sign_up.php?signup=password&first=$first_name&last=$last_name&user=$user_name");
			exit();
		}else{
			/* check mail */
			$requete="SELECT * FROM user WHERE Email='$email' LIMIT 1";
			$resultat=mysqli_query($link,$requete);
			$check_email= mysqli_num_rows($resultat);
			if ($check_email !== 0){
				header("Location: sign_up.php?signup=email&first=$first_name&last=$last_name&user=$user_name");
				exit();
			}else{
				/* check username */
				$requete="SELECT * FROM user WHERE user_name='$user_name' LIMIT 1";
				$resultat=mysqli_query($link,$requete);
				$check_username= mysqli_num_rows($resultat);
				if($check_username !== 0){
					header("Location: sign_up.php?signup=username&first=$first_name&last=$last_name&email=$email");
					exit();
				}else{
					if (isset($_FILES['photo_de_profil']) and $_FILES['photo_de_profil']['error']==NULL){
					/*gestion des erreurs dans l insertion de la photo de profil*/
						if (!is_uploaded_file($_FILES['photo_de_profil']['tmp_name'])){
							exit('fichier introuvable');
						}
						if ($_FILES['photo_de_profil']['size'] >= 1000000){
							exit("Erreur, le fichier est volumineux");
						}
						$infopdp=pathinfo($_FILES['photo_de_profil']['name']);
						$extension_upload = $infopdp['extension'];

						$extension_upload = strtolower($extension_upload);
						$extensions_autorisees = array('png','jpeg','jpg');
						if (!in_array($extension_upload, $extensions_autorisees)){
							exit("Erreur, Veuillez inserer une image svp (extensions autorisées: png,jpg,jpeg)");
						}
						$upload="photodeprofil/".$photo_de_profil;
						move_uploaded_file($_FILES['photo_de_profil']['tmp_name'],$upload);
					}
					/* insertion to DB */
					mail($email,'contact form','bienvenu','From: '.'hamzakadimi1999@gmail.com'.'\r\n');
					$sql2="INSERT INTO `user`(`id_user`, `F_Name`, `L_Name`, `Email`, `password`, `ville`, `birthday`, `user_name`, `photo`, `telephone`,`is_active`) VALUES (0,'$first_name','$last_name','$email','$password','$city','$birthday','$user_name','$photo_de_profil','$telephone',0)";
					$result2=mysqli_query($link,$sql2);
					$sql3="SELECT * FROM user WHERE user_name='".$user_name."' AND password='".$password."'";
					$result3=mysqli_query($link,$sql3);
					while($data=mysqli_fetch_assoc($result3)){
						session_start();
						$_SESSION['user_name']=$data['user_name'];
						$_SESSION['F_Name']=$data['F_Name'];
						$_SESSION['L_Name']=$data['L_Name'];
						$_SESSION['id_user']=$data['id_user'];
						header("Location: centre_interets.php?signup=succes&first=$first_name&last=$last_name&email=$email");
					}
				}	
			}
		}

	}	
?>