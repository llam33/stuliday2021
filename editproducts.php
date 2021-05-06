<?php require 'header.php' ?>
<?php

// ! Pour faire une requête de mise à jour (UPDATE), je vais mélanger affichage d'un seul produit, avec l'ajout d'un produit en modifiant légèrement ma requête SQL

//? J'insère la valeur de l'id de ma requête GET dans une variable qui va me servir à récupérer un produit depuis la BDD, mais aussi à le mettre à jour dans la BDD
$id = $_GET['id'];

// var_dump($_POST, $id);

//? REQUETE D'AFFICHAGE = Création de ma requête SQL. Vu que j'ai des colonnes qui font référence à d'autres tables, je dois ajouter des jointures sur category et author. Je rajoute aussi la condition WHERE products_id = {$id} afin de récupérer le produit souhaité
$sqlProduct = "SELECT p.*, u.username, c.categories_name FROM products AS p LEFT JOIN users AS u ON p.author = u.id LEFT JOIN categories AS c ON p.category = c.categories_id WHERE p.products_id = {$id} ";

//? Le résultat de ma requête est affiché dans un tableau associatif à l'aide du chaînage de méthodes.
$product = $connect->query($sqlProduct)->fetch(PDO::FETCH_ASSOC);
?>

<?php

//? Requête SQL pour récupérer toutes les catégories depuis la base de données, afin d'afficher un dropdown de toutes les catégories existantes.

$sqlCategory = 'SELECT * FROM categories';

//? On a raccourci la façon de récupérer en chaînant les méthodes query et fetch. (chaîner des méthodes signifie que l'on utilise deux fonctions d'un objet à la suite. exemple: $objet->function1()->fonction2())
//* Le fetchAll signifie que l'on utilise la méthode fetch de manière indifférenciée (pas de précision de retour d'array, on veut juste la totalité des données. Par défaut: il retourne un array associatif et un array indexé qui contient les mêmes données) pour toutes les lignes correspondantes à la requête.
$categories = $connect->query($sqlCategory)->fetchAll();

// var_dump($categories);

/**
 * ! Modifier un article à partir du formulaire.
 * 
 * TODO : Récupération des données depuis la BDD
 * 
 * TODO : Vérification intro : si le bouton est cliqué et si le formulaire est rempli
 * 
 * TODO : Initialisation des variables & assainissement
 * 
 * TODO : Vérification du prix positif
 * 
 * TODO : Modification des données
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
        //? Etape 4 : Enregistrement des données du formulaire via une requete préparée sql UPDATE
        try {
            //? Préparation de la requête, je définis la requête à exécuter avec des valeurs génériques (des paramètres nommés).
            //! Attention, les requêtes INSERT et UPDATE sont sensiblement différentes sur leur syntaxe
            $sth = $connect->prepare("UPDATE products
            SET
            products_name=:products_name,products_description=:products_description,products_price=:products_price, category=:category WHERE products_id = :id");
            //? J'affecte chacun des paramètres nommés à leur valeur via un bindValue. Cette opération me protège des injections SQL (en + de l'assainissement des variables).
            $sth->bindValue(':products_name', $name);
            $sth->bindValue(':products_description', $description);
            $sth->bindValue(':products_price', $price);
            $sth->bindValue(':category', $category);
            $sth->bindValue(':id', $id);

            //? J'exécute ma requête SQL de modification avec execute()
            $sth->execute();

            echo "Votre article a bien été modifié";

            //? Je redirige vers la page des produits.
            header('Location: product.php?id=' . $id);
        } catch (PDOException $error) {
            echo 'Erreur: ' . $error->getMessage();
        }
    }
    // var_dump($name, $description, $price, $category);
}
?>

<main class="px-3">
    <div class="row">
        <div class="col-12">
            <form action="#" method="POST">
                <hr>
                <div class="form-group">
                    <label for="InputName">Nom de l'article</label>
                    <input type="text" class="form-control" id="InputName" placeholder="Nom de votre article" name="product_name" value=<?php echo $product['products_name']; ?> required>
                </div>
                <div class="form-group">
                    <label for="InputDescription">Description de l'article</label>
                    <textarea class="form-control" id="InputDescription" rows="3" name="product_description" required><?php echo $product['products_description']; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="InputPrice">Prix de l'article</label>
                    <input type="number" min="1" max="999999" class="form-control" id="InputPrice" placeholder="Prix de votre article en €" name="product_price" value=<?php echo $product['products_price']; ?> required>
                </div>
                <div class="form-group">
                    <label for="InputCategory">Catégorie de l'article</label>
                    <select class="form-control" id="InputCategory" name="product_category" required>
                        <option value="<?php echo $product['category']; ?>"><?php echo $product['categories_name']; ?></option>
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