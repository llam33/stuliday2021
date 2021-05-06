<?php require './header.php'; ?>
<?php
//! On va vérifier que l'utilisateur est connecté dans un premier temps.
if (!empty($_SESSION)) {
    //! Récupérer toutes les infos relatives à l'utilisateur connecté depuis la base de données. Il faut que cet utilisateur soit impérativement un administrateur pour accéder à la page.
    //? 1. On insère l'id de session dans une variable qui va servir pour une requête SQL si il y a un utilisateur connecté
    $admin_id = $_SESSION['id'];

    //? 2. On réalise une requête SQL de récupération de données (SELECT) qui utilise l'id de l'utilisateur connecté pour récupérer toutes sa ligne dans la BDD à condition qu'il soit un ADMIN
    $sqlAdmin = "SELECT * FROM users WHERE id = '{$admin_id}' AND role = 'ROLE_ADMIN'";

    //? 3. On effectue la requête via PDO sur la base de données.
    $resultAdmin = $connect->query($sqlAdmin);

    //? 4. On récupère les données avec un fetch, en précisant que l'on souhaite obtenir les données sous forme de tableau associatif (PDO::FETCH_ASSOC)
    //* Le if permet de valider la récupération et d'initialiser la prochaine étape. Si la récupération depuis la BDD échoue, alors on utilisera le else, qui lui contiendra un message d'erreur.
    if ($admin = $resultAdmin->fetch(PDO::FETCH_ASSOC)) {
        //? 5. On récupère tous les utilisateurs qui ne sont pas l'administrateur connecté
        $sqlUsers = "SELECT * FROM users WHERE id != '{$admin_id}'";
        $sqlProducts = "SELECT p.*, u.username, c.categories_name FROM products AS p LEFT JOIN users AS u ON p.author = u.id LEFT JOIN categories AS c ON p.category = c.categories_id";
        $users = $connect->query($sqlUsers)->fetchAll(PDO::FETCH_ASSOC);
        $products = $connect->query($sqlProducts)->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($users);
?>
        <main class="px-3">
        <div class="row column text-center">
        <hr>
        <h2>User</h2>
        <hr>
            <table class="table bg-light text-black">
                <thead>
                    <tr>
                        <th scope="col"># id</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //? On crée une boucle sur la table users, qui permet d'afficher les infos de tous les utilisateurs
                    foreach ($users as $user) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $user['id'] ?></th>
                            <td><?php echo $user['username'] ?></td>
                            <td><?php echo $user['email'] ?></td>
                            <td><?php echo $user['role'] ?></td>
                            <td><a href="editusers.php?id=<?php echo $user['id'] ?>" class="btn">Modifier</a></td>
                            <!-- <td><a href="delete.php?id=<?php echo $user['id'] ?>?token=<?php echo $token ;?>" class="btn">Supprimer</a></td> -->
                            <td><form action="delete.php" method="POST">
                                <input type="hidden" name="token" value="<?php echo $token ?>">
                                <input type="hidden" name="id" value="<?php echo $user['id'] ?>" >
                                <input type="submit" name="submit-deleteuser" value="supprimer">
                            </form></td>
                        </tr>
                    <?php
                    }

                    
                    ?>
                </tbody>
            </table>
            </div>

            <div class="row column text-center">
        <hr>
        <h2>Annonces</h2>
        <hr>
            <table class="table bg-light text-black">
                <thead>
                    <tr>
                        <th scope="col"># id article</th>
                        <th scope="col">Titre</th>
                        <th scope="col">Description</th>
                        <th scope="col">Catégorie</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //? On crée une boucle sur la table users, qui permet d'afficher les infos de tous les utilisateurs
                    foreach ($products as $product) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo $product['products_id']?></th>
                            <td><?php echo $product['products_name'] ?></td>
                            <td><?php echo $product['products_description'] ?></td>
                            <td><?php echo $product['categories_name'] ?></td>
                            <td><?php echo $product['products_price'] ?></td>
                            <td><a href="editproducts.php?id=<?php echo $product['products_id'] ?>" class="btn">Modifier</a></td>
                            <td><form action="deletep.php" method="POST">
                                <input type="hidden" name="token" value="<?php echo $token ?>">
                                <input type="hidden" name="idp" value="<?php echo $product['products_id'] ?>" >
                                <input type="submit" name="submit-deletep" value="supprimer">
                            </form></td>

    
                        </tr>
                    <?php
                    }
                    ?>
        </main>

<?php
    } else {
        // echo "Vous ne possédez pas les droits pour accéder à cette page";
        echo "Cette page n'existe pas";
        echo "<a class='btn' href='index.php'>Retourner à la page d'accueil</a>";
    }
} else {
    // echo "Vous ne possédez pas les droits pour accéder à cette page";
    echo "Cette page n'existe pas";
    echo "<a class='btn' href='index.php'>Retourner à la page d'accueil</a>";
}
?>
<?php require './footer.php'; ?>