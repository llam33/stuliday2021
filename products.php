<?php include "header.php" ?>

<?php
//! Affichage de tous les produits. Il faudra une requête SQL qui récupère tous les produits, et qui les affiche dans des cartes séparées.

//? Création de ma requête SQL. Vu que j'ai des colonne qui font référence à d'autres tables, je dois ajouter des jointures sur category et author.
$sqlProducts = "SELECT p.*, u.username, c.categories_name FROM products AS p LEFT JOIN users AS u ON p.author = u.id LEFT JOIN categories AS c ON p.category = c.categories_id";

//? Le résultat de ma requête est affiché dans un tableau associatif à l'aide du chaînage de méthodes.
$products = $connect->query($sqlProducts)->fetchAll(PDO::FETCH_ASSOC);
?>

     

<div class="row column text-center">
    <div class="product">
    <hr>

    
      <h2>Locations récemment postées</h2>
      <hr>
      </div>

    </div>

   

    <div class="row small-up-2 large-up-4">
    <?php
        //? Je veux afficher tous mes produits, selon le même modèle, donc je fais une boucle, et j'insère les données dynamiques dans une carte sur laquelle je ferais une boucle. Résultat: J'obtiens autant de cartes que de produits, et toutes les cartes respectent le même format HTML.
        foreach ($products as $product) {
      ?>
      <div class="column">
        <a href="product.php?id=<?php echo $product['products_id']?>"> <img class="thumbnail" src="./assets/image/appart.jpg"></a>
        <a href="product.php?id=<?php echo $product['products_id']?>"><h5 class="card-title"><?php echo $product['products_name']; ?> </h5></a>
        <p class="card-text"><?php echo $product['products_description']; ?>
        <p><?php echo $product['categories_name']; ?></p>
        <p><?php echo $product['created_at']; ?></p>
       
      </div>

      <?php
        }
        ?>

    </div>

    

    <hr>

    <div class="row column text-center">
      <h2>Locations</h2>
      <hr>
    </div>

    <div class="row small-up-2 medium-up-3 large-up-5">
    <?php

    $sqlProducts = "SELECT p.*, u.username, c.categories_name FROM products AS p LEFT JOIN users AS u ON p.author = u.id LEFT JOIN categories AS c ON p.category = c.categories_id";
    $products = $connect->query($sqlProducts)->fetchAll(PDO::FETCH_ASSOC);
        //? Je veux afficher tous mes produits, selon le même modèle, donc je fais une boucle, et j'insère les données dynamiques dans une carte sur laquelle je ferais une boucle. Résultat: J'obtiens autant de cartes que de produits, et toutes les cartes respectent le même format HTML.
        foreach ($products as $product) {
      ?>
    <div class="column">
        <a href="product.php?id=<?php echo $product['products_id']?>"> <img class="thumbnail" src="./assets/image/appart.jpg"></a>
        <a href="product.php?id=<?php echo $product['products_id']?>"><h5 class="card-title"><?php echo $product['products_name']; ?> </h5></a>
        <p class="card-text"><?php echo $product['products_description']; ?>
        <p><?php echo $product['categories_name']; ?></p>
        <p><?php echo $product['created_at']; ?></p>
       
      </div>
      
     
      <?php
        }
        ?>
    </div>
  
    <hr>
   


    
 <?php include "footer.php" ?>