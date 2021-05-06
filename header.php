<?php include "config.php" ?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/foundation-sites@6.6.3/dist/css/foundation.min.css" integrity="sha256-ogmFxjqiTMnZhxCqVmcqTvjfe1Y/ec4WaRj/aQPvn+I=" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <title>Stuliday</title>
   
<body>
<div class="responsive-nav-social-mobile" data-responsive-toggle="responsive-nav-social" data-hide-for="medium">
  <div class="responsive-nav-social-mobile-left">
    <ul class="menu">
      <li><a href="https://www.facebook.com/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
      <li><a href="https://www.instagram.com/?hl=en"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
      <li><a href="https://www.pinterest.com/"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
      <li><a href="https://twitter.com/?lang=en"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    </ul>
  </div>
  <div class="responsive-nav-social-mobile-right">
    <button class="menu-icon" type="button" data-toggle="responsive-nav-social"></button>
  </div>
</div>

<div data-sticky-container>
  <div class="responsive-nav-social" id="responsive-nav-social" data-sticky data-options="marginTop:0;">
    <div class="row align-justify align-middle" id="responsive-menu">
      <div class="responsive-nav-social-left">
        <ul class="menu vertical medium-horizontal">
          <li><a href="./index.php">Accueil</a></li>
          <li><a href="./products.php">Locations</a></li>
         
          <?php
                    //? Vérification des variables des sessions : si elle n'existent pas, alors afficher un bouton se connecter
                    if (empty($_SESSION)) {
                    ?>
                        <a class="nav-link" href="login.php">Se connecter</a>
                    <?php
                        //? Si elles existent, afficher un bouton qui redirige vers la page de profil et un bouton de déconnexion
                    } else {
                    ?>
                        <!-- //? J'affiche le nom de l'utilisateur connecté qui est stocké en token de session dans le bouton -->
                        <a class="nav-link" href="profile.php"><?php echo ucwords($_SESSION['username']); ?></a>
                        <!-- //? Pour me déconnecter j'envoie une requête GET avec l'info logout qui permet de se déconnecter de n'importe où. -->
                        <a class="nav-link" href="?logout">Se déconnecter</a>
                    <?php
                    }
                    ?>
        </ul>
      </div>
      <img src="assets/image/Stulidsm.png" alt="">
      <div class="responsive-nav-social-right hide-for-small-only">
        <ul class="menu">
        
        </ul>
      </div>
    </div>
  </div>
</div>