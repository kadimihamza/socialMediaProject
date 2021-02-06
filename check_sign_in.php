<?php 
	if (isset($_POST['sign_in'])) {
		$user_name=$_POST['user_name'];
		$password=$_POST['password'];
		include('connect_database.php');
		$sql="SELECT * FROM user WHERE user_name='".$user_name."' AND password='".$password."'";
		$result=mysqli_query($link,$sql);
		$data=mysqli_fetch_assoc($result);
		if($data!=false){
			session_start();
			$_SESSION['user_name']=$data['user_name'];
			$_SESSION['F_Name']=$data['F_Name'];
			$_SESSION['L_Name']=$data['L_Name'];
			$_SESSION['id_user']=$data['id_user'];
			if(isset($_COOKIE['error_sign_in'])){
				setcookie('error_sign_in','',time()-11);
			}
			header('Location: acceuil.php');
		}else{
			setcookie('error_sign_in','votre mot de passe ou email est incorrect',time()+100);
			header('Location: sign_in.php');
		}
	}
?>