<?php
    include("connect_database.php");
    session_start();

    if (isset($_POST['unfollow']))
    {
        $user_follower=$_GET['user'];
        $user_following=$_SESSION['user_name'];
        $id_user_following=$_SESSION['id_user'];

        $sql="SELECT * from user where user_name='$user_follower'";
        $result=mysqli_query($link,$sql);
        $data=mysqli_fetch_assoc($result);

        $id_user_follower=$data['id_user'];

        $sql2="DELETE FROM `follow` WHERE id_user_follower=$id_user_follower and id_user_following=$id_user_following";
        $result2=mysqli_query($link,$sql2);
    
        header("location: profile.php?user=$user_follower");
    }
?>