<?php
    include("connect_database.php");
    session_start();
    $user_name=$_SESSION['user_name'];
    if (!empty($_POST['search'])) 
    {
//affichage des users 
        
        $user_cherche=$_POST['search'];

	    $sql="SELECT * from user where user_name like '$user_cherche%' or F_Name like '$user_cherche%' or L_Name like '$user_cherche%'";
	    $result=mysqli_query($link,$sql);

	    while($data=mysqli_fetch_assoc($result))
	    {
		    $user=$data['user_name'];
		    echo "<img width=20px; src='photodeprofil/".$data['photo']."'><a href='profile.php?user=$user'>Profile $user</a>  <img width='15px;' src=".$data['is_active']."><br>";
	    }
    }
    
    
?>

</body>
</html>