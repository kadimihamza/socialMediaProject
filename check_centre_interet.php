<?php
if (isset($_POST['sign_up'])) {
    include('connect_database.php');
    session_start();
    $first_name=$_SESSION['F_Name'];
    $last_name=$_SESSION['L_Name'];
    $user_name=$_SESSION['user_name'];
    $userid=$_SESSION['id_user'];
    
    $check_empty=0;

// SPORT
    if (isset($_POST['Sport'])) {
        $Sport=1;
        $check_empty++;
    }
    else {
        $Sport=0;
    }
// musique
    if (isset($_POST['musique'])) {
        $musique=1;
        $check_empty++;
    }
    else {
        $musique=0;
    }
//gaming
    if (isset($_POST['gaming'])) {
        $gaming=1;
        $check_empty++;
    }
    else {
        $gaming=0;
    }
//politique
    if (isset($_POST['politique'])) {
        $politique=1;
        $check_empty++;
    }
    else {
        $politique=0;
    }
//science
    if (isset($_POST['science'])) {
        $science=1;
        $check_empty++;
    }
    else {
        $science=0;
    }
    $sql="INSERT INTO `centreinteret`(`userid`, `sport`, `musique`, `gaming`, `politique`, `science`) VALUES ('$userid','$Sport','$musique','$gaming','$politique','$science')";
    mysqli_query($link,$sql);
    if ($check_empty==0) {
        header('Location: acceuil.php');
    }
    else{
        /* ajouter session ? */
        header('Location: acceuil.php');
    }
 
}    
   
else {
    header('Location: sign_in.php');
}
?>