<?php 
	include("connect_database.php");
	session_start();
    if (isset($_POST['publier']) && !empty($_POST['publication'])) 
    {
        if (empty($_FILES['photo']['name']))
        {
            $photo='NULL';
        }
        else
        {
            $photo=$_FILES['photo']['name'];
            $upload="photo/".$photo;
            move_uploaded_file($_FILES['photo']['tmp_name'],$upload);
        }

        $page=$_GET['page'];

        $user_name=$_SESSION['user_name'];
        $id_user=$_SESSION['id_user'];

        $contenue=addslashes($_POST['publication']);
        $date=date("Y-m-d H:i:s");

        $sql1="INSERT INTO `publication`(`id_publication`, `contenue`, `id_user`, `date`, `photo`, `likes`, `id_user_share`, `id_publication_share`) VALUES (0,'$contenue','$id_user','$date','".$photo."',0,0,0)";
        $result1=mysqli_query($link,$sql1);

        if ($page=='profile') {
            header("location: profile.php?user=$user_name");
        }
        if ($page=='acceuil'){
            header("location: acceuil.php");
        }
          
    }else if (isset($_POST['publier']) && empty($_POST['publication'])){
        $page=$_GET['page'];
        if ($page=='acceuil') 
        {
            header("location: acceuil.php");
        }

        if ($page=='profile') 
        {
            header("location: profile.php?user=$user_name");
        }
    }
    
?>