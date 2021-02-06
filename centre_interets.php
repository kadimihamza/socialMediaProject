<?php
/*
session_start();
if (isset($_SESSION['sign_up'])) {
*/
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 ,shrink-to-fit=no">
    <link rel="stylesheet" href="css/centre_interets.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Yusei+Magic&display=swap" rel="stylesheet">
    <title>Centre d'intéret</title>
</head>
<body>
    <div class="interets_form">
        <form action="check_centre_interet.php" method="POST">
            <div class="top">
                <img src="icons/among_us_twitter_icon.png" height="128px" width="93px" alt="twiter_logo" class="logo" >
            </div>
            <div class="description">
                <h2>Quels sont les sujets qui vous intéressent ? </h2>
                <div>
                    Sélectionnez des sujets qui vous intéressent afin de personnaliser votre éxperience Twitter, notamment pour trouver des personnes à suivre.
                </div>
            </div>

            <div class="checkbox-container">
                <div class="ck-button">
                <label for="Sport">
                    <input type="checkbox" name="Sport" class="interets" id="Sport" value="1">
                    <span>Sport</span>
                </label>
                </div>

                <div class="ck-button">
                <label for="musique">
                    <input type="checkbox" name="musique" class="interets" id="musique" value="1">
                <span>Musique</span>
                </label>
                </div>

                <div class="ck-button">
                <label for="gaming">
                    <input type="checkbox" name="gaming" class="interets" id="gaming" value="1">
                <span>Gaming</span>
                </label>
                </div>

                <div class="ck-button">
                <label for="politique">
                    <input type="checkbox" name="politique" class="interets" id="politique" value="1">
                <span>Politique</span>
                </label>
                </div>

                <div class="ck-button">
                <label for="science">
                    <input type="checkbox" name="science" class="interets" id="science" value="1">
                <span>Science</span>
                </label>
                </div> 
            </div> <br>
            <div class="submit-container">
                <input type="submit" name="sign_up" value="Suivant..." class="button">
            </div>
        </form>
    </div>
    
</body>
</html>

<?php
/*
}
else {
   header('Location: sign_up.php');
}
*/
?>
