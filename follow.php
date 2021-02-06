<?php
    include("connect_database.php");
    session_start();
    
    if (isset($_POST['follow']))
    {
        $user_follower=$_GET['user'];
        $user_following=$_SESSION['user_name'];

        $sql="SELECT * from user where user_name='$user_follower'";
        $result=mysqli_query($link,$sql);
        $data=mysqli_fetch_assoc($result);
        $id_user_follower=$data['id_user'];

        $id_user_following=$_SESSION['id_user'];

        $sql2="INSERT into follow values(0,'$id_user_following','$id_user_follower')";
        $result2=mysqli_query($link,$sql2);
        header("location: profile.php?user=$user_follower");
        
    }
?>