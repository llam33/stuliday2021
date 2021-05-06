<?php require './header.php' ?>
<?php

//? Requête SQL pour récupérer toutes les catégories depuis la base de données, afin d'afficher un dropdown de toutes les catégories existantes.

$sqlCategory = 'SELECT * FROM categories';

//? On a raccourci la façon de récupérer en chaînant les méthodes query et fetch. (chaîner des méthodes signifie que l'on utilise deux fonctions d'un objet à la suite. exemple: $objet->function1()->fonction2())
//* Le fetchAll signifie que l'on utilise la méthode fetch de manière indifférenciée (pas de précision de retour d'array, on veut juste la totalité des données. Par défaut: il retourne un array associatif et un array indexé qui contient les mêmes données) pour toutes les lignes correspondantes à la requête.
$categories = $connect->query($sqlCategory)->fetchAll();

// var_dump($categories);

/**
 * ! Créer un nouvel article à partir du formulaire.
 * 
 * TODO : Vérification intro : si le bouton est cliqué et si le formulaire est rempli
 * 
 * TODO : Initialisation des variables & assainissement
 * 
 * TODO : Vérification du prix positif
 * 
 * TODO : Enregistrement des données
 */

//? Etape 1 : Vérification de la validité du formulaire et de l'appui sur le bouton envoi
if (isset($_POST['product_submit']) && !empty($_POST['product_name']) && !empty($_POST['product_price']) && !empty($_POST['product_description']) && !empty($_POST['product_category'])) {

    //? Etape 2 : Initialisation des variables & assainissement (via strip_tags cette fois)

    $name = strip_tags($_POST['product_name']);
    $description = strip_tags($_POST['product_description']);
    $price = intval(strip_tags($_POST['product_price']));
    $category = strip_tags($_POST['product_category']);
    $user_id = $_SESSION['id'];

    //? Etape 3 : Vérification du prix positif : Vérifier que le prix est un chiffre entier, que ce prix est supérieur à 0
    if (is_int($price) && $price > 0) {
        //? Etape 4 : Enregistrement des données du formulaire via une requete préparée sql INSERT
        try {
            //? Préparation de la requête, je définis la requête à exécuter avec des valeurs génériques (des paramètres nommés).
            $sth = $connect->prepare("INSERT INTO products
            (products_name,products_description,products_price, author, category)
            VALUES
            (:products_name,:products_description,:products_price, :author, :category)");
            //? J'affecte chacun des paramètres nommés à leur valeur via un bindValue. Cette opération me protège des injections SQL (en + de l'assainissement des variables)
            $sth->bindValue(':products_name', $name);
            $sth->bindValue(':products_description', $description);
            $sth->bindValue(':products_price', $price);
            $sth->bindValue(':author', $user_id);
            $sth->bindValue(':category', $category);

            //? J'exécute ma requête SQL d'insertion avec execute()
            $sth->execute();

            echo "Votre article a bien été ajouté";

            //? Je redirige vers la page des produits.
            header('Location: products.php');
        } catch (PDOException $error) {
            echo 'Erreur: ' . $error->getMessage();
        }
    }
    var_dump($name, $description, $price, $category);
}
?>
 <hr>
<main class="px-3">
<div class="row column text-center">
    <div class="product">
  
      <h2>Ajout d'un article</h2>
      <hr>
      </div>
    <div class="row">
        <div class="col-12">
            <form action="#" method="POST">
                <div class="form-group">
               
                    <label for="InputName">Titre</label>
                    <input type="text" class="form-control" id="InputName" placeholder="Titre de votre article" name="product_name" required>
                </div>
                <div class="form-group">
                    <label for="InputDescription">Description</label>
                    <textarea class="form-control" id="InputDescription" rows="3" name="product_description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="InputPrice">Loyer</label>
                    <input type="number" min="200" max="999999" class="form-control" id="InputPrice" placeholder="Loyer" name="product_price" required>
                </div>
                <div class="form-group">
                    <label for="InputCategory">Catégorie de l'article</label>
                    <select class="form-control" id="InputCategory" name="product_category" required>
                        <?php
                        //? On va boucler sur l'array categories, de façon à ce que chaque ligne de la boucle corresponde à une variable $category et aussi à une ligne de la BDD.
                        foreach ($categories as $category) {
                        ?>
                            <option value="<?php echo $category['categories_id']; ?>">
                                <?php echo $category['categories_name']; ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <hr>
                <button type="submit" class="btn btn-success" name="product_submit">Enregistrer l'article</button>
            </form>
        </div>
    </div>
</main>

<?php require './footer.php' ?>