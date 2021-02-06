<?php
	session_start();
	$user_sender=$_SESSION['id_user'];
	$user_receiver=$_COOKIE['userReceiver'];
	include('connect_database.php');
	$sql3="SELECT * FROM messages INNER JOIN user ON user.id_user=user_sender  WHERE (user_receiver='$user_receiver' AND user_sender='$user_sender') OR (user_receiver='$user_sender' AND user_sender='$user_receiver') ORDER BY heure ASC";
	$result3=mysqli_query($link,$sql3);
	while($data3=mysqli_fetch_assoc($result3)){
		   echo $data3['user_name'].' : '.$data3['contenu'].' -> '.' <span style="color:red;font-size:12px;">'.$data3['heure'].'</span><br>';
	}
?>