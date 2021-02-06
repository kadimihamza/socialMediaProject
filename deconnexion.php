<?php 
	include('connect_database.php');
    session_start();
    session_destroy();
    $id_user=$_SESSION['id_user'];
    header("Location: sign_in.php");
    $req3="UPDATE user SET is_active='status/offline.jpg' WHERE id_user='$id_user'";
	mysqli_query($link,$req3);
    
?>