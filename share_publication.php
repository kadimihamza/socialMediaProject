<?php
    include("connect_database.php");
    session_start();
    $id_publication=$_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>share</title>
</head>
<body>
    <form method="post" action="#" enctype="multipart/form-data">
		<textarea name="publication" id="post" cols="30" rows="5" placeholder="vous voulez poster quelque chose ?"></textarea><br>
		<input type="file" class="photo" name="photo">
		<input type="submit" class="share" name="share" value="Share">
	</form>

<?php 

    $sql2="SELECT * from publication where id_publication='$id_publication'";
    $result2=mysqli_query($link,$sql2);
    $data1=mysqli_fetch_assoc($result2);

    if($data1['photo']=='NULL')
	{
        $sql7="SELECT * from user where id_user='".$data1['id_user']."'"; 
        $result7=mysqli_query($link,$sql7);
        $data7=mysqli_fetch_assoc($result7);
	    echo "<img width='40px;' src='photodeprofil/".$data7['photo']."'>";
	    echo $data7['user_name'].": ".substr($data1['date'],0,-3)."<br><br>".$data1['contenue']."<br>";
    }
    else 
    {
        $sql7="SELECT * from user where id_user='".$data1['id_user']."'"; 
        $result7=mysqli_query($link,$sql7);
        $data7=mysqli_fetch_assoc($result7);
		echo "<img width='40px;' src='photodeprofil/".$data7['photo']."'>";
		echo $data7['user_name'].": ".substr($data1['date'],0,-3)."<br><br>".$data1['contenue']."<br> <img src='photo/".$data1['photo']."'><br>";
    }
    

    if (isset($_POST['share']) && !empty($_POST['publication'])) 
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

        $sql1="INSERT INTO `publication` VALUES (0,'$contenue','$id_user','$date','$photo',0,'".$data1['id_user']."',$id_publication)";
        $result1=mysqli_query($link,$sql1);

        // $sql2="SELECT * from publication order by date desc";
        // $result2=mysqli_query($link,$sql2);
        // $data2=mysqli_fetch_assoc($result2);
        
        // $sql3="INSERT INTO `share` VALUES (0,'$id_publication','".$data2['id_publication']."')";
        // $result3=mysqli_query($link,$sql3);

        if ($page=='profile') 
        {
            header("location: profile.php?user=$user_name");
        }
        if ($page=='acceuil')
        {
            header("location: acceuil.php");
        }
          
    }
    else if (isset($_POST['publier']) && empty($_POST['publication']))
    {
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
</body>
</html>