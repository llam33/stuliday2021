<?php include "header.php" ?>
<?php
//! Récupérer toutes les infos relatives à l'utilisateur connecté depuis la base de données. En ce moment dans le token de session on possède l'id de l'utilisateur, son username et son email. Il faut éventuellement récupérer tout le reste depuis la base de données.

//? 1. On insère l'id de session dans une variable qui va servir pour une requête SQL
$user_id = $_SESSION['id'];

//? 2. On réalise une requête SQL de récupération de données (SELECT) qui utilise l'id de l'utilisateur connecté pour récupérer toutes sa ligne dans la BDD
$sqlUser = "SELECT * FROM users WHERE id = '{$user_id}'";

//? 3. On effectue la requête via PDO sur la base de données.
$resultUser = $connect->query($sqlUser);

//? 4. On récupère les données avec un fetch, en précisant que l'on souhaite obtenir les données sous forme de tableau associatif (PDO::FETCH_ASSOC)
$user = $resultUser->fetch(PDO::FETCH_ASSOC);
// $user = $connect->query($sql)->fetch(PDO::FETCH_ASSOC);
?>

<div class="callout large primary">
      <div class="row column text-center">
        <h1>Profil</h1>
        <h3 class="subheader">Bienvenue <?php echo ucwords($user['username']); ?>
            </h3>
            <p>Vous possédez le role <?php echo $user['role']; ?></p>
      </div>
    </div>
  
      <div class="lesboutons">
        <div class="col-3 offset-1">
            <a href="profileproducts.php" class="btn" data-toggle="modal" data-target="#exampleModal">Voir mes articles publiés </a>
              
           
            <a href="addproducts.php" class="btn"> Ajouter un article </a>
            <?php
                    if ($user['role'] === 'ROLE_ADMIN') {
                        echo '<a href="admin.php" class="btn"> Accéder à l\'espace administrateur </a>';
                    }
                    ?>
        </div>
        </div>



<?php include "footer.php"?>