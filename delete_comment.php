<?php 
	include("connect_database.php");
    session_start();

    if (isset($_GET['id']))
    {
        $id_comment=$_GET['id'];
        $page=$_GET['page'];

        $user_name=$_SESSION['user_name'];

        $sql="DELETE FROM `comments` WHERE `id_comment`='$id_comment'";
        $result=mysqli_query($link,$sql);
        
        if ($page=='profile') 
        {
            header("location: profile.php?user=$user_name");
        }
        if ($page=='acceuil') 
        {
            header("location: acceuil.php");
        }
    }
    
    
?>