<?php include "header.php" ?>
<?php
if (!empty($_SESSION)) {
    //! Récupérer toutes les infos relatives à l'utilisateur connecté depuis la base de données. Il faut que cet utilisateur soit impérativement un administrateur pour accéder à la page.
    //? 1. On insère l'id de session dans une variable qui va servir pour une requête SQL si il y a un utilisateur connecté
    $user_id = $_SESSION['id'];

    //? 2. On réalise une requête SQL de récupération de données (SELECT) qui utilise l'id de l'utilisateur connecté pour récupérer toutes sa ligne dans la BDD à condition qu'il soit un ADMIN
    $sqlProducts = "SELECT p.* FROM products AS p LEFT JOIN users AS u ON p.author = u.id WHERE p.author = '{$user_id}'";

    //? 3. On effectue la requête via PDO sur la base de données.
    $products = $connect->query($sqlProducts)->fetchAll(PDO::FETCH_ASSOC);
   
   
        }
    ?>

<div class="row column text-center">
<hr>
<h2>Mes articles</h2>
      <hr>
<div class="row small-up-2 large-up-4">

    <?php
        //? Je veux afficher tous mes produits, selon le même modèle, donc je fais une boucle, et j'insère les données dynamiques dans une carte sur laquelle je ferais une boucle. Résultat: J'obtiens autant de cartes que de produits, et toutes les cartes respectent le même format HTML.
        foreach ($products as $product) {
      ?>
      <div class="column">
      <a href="product.php?id=<?php echo $product['products_id']?>"> <img class="thumbnail" src="./assets/image/appart.jpg"></a>
      <a href="product.php?id=<?php echo $product['products_id']?>"><h5 class="card-title"><?php echo $product['products_name']; ?> </h5></a>
        <p class="card-text"><?php echo $product['products_description']; ?>
        
        <p><?php echo $product['created_at']; ?></p>
        <a href="editproducts.php?id=<?php echo $product['products_id']; ?>" class="card-link btn btn-primary">Modifier</a>
      </div>

      <?php
        }
        ?>

    </div>
    </div>


<?php require './footer.php' ?>