<?php 
	include("connect_database.php");
    session_start();

    if (isset($_GET['id']))
    {
        $id_publication=$_GET['id'];
        $page=$_GET['page'];
        

        
        echo $id_publication;

        $user_name=$_SESSION['user_name'];

        $sql="DELETE FROM `publication` WHERE `id_publication`='".$id_publication."' or id_publication_share='$id_publication'";
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