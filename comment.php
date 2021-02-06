<?php 
	include("connect_database.php");
    session_start();

    if (isset($_POST['commenter']))
    {
        $page=$_GET['page'];
        $id_publication=$_GET['id'];
        $user=$_GET['user'];

        $user_name=$_SESSION['user_name'];
        $id_user=$_SESSION['id_user'];

        $contenue=addslashes($_POST['comment']);
        $date=date("Y-m-d H:i:s");
        $sql1="INSERT INTO `comments` VALUES (0,'$contenue','$id_publication','$date','$id_user')";
        $result1=mysqli_query($link,$sql1);
	    
        if ($page=='acceuil') {
            header("location: acceuil.php");
        }
        if ($page=='profile') {
            header("location: profile.php?user=$user");
        }
    }  
    
?>