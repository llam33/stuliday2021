<?php include "header.php";

// On récupère l'id de l'user à supprimer
$id = $_POST['id'];

// On récupère le token de Cross Site Request Forgery que l'on a envoyé via le formulaire
$token = $_POST['token'];

// var_dump($_POST);

//? Deux méthodes (1 bonne, 1 mauvaise, la mauvaise est commentée)
// if (isset($_POST['delete']) && $_POST['csrf_token'] == $token) {
//* Je vérifie la soumission de mon formulaire et je vérifie le token csrf du formulaire avec celui que je possède.
if (isset($_POST['submit-deleteuser']) && hash_equals($token, $_POST['token'])) {
    //* Une fois la vérification passée, je prepare une requête SQL de suppression en fonction de l'id de l'user
    try {
        $sth = $connect->prepare("DELETE FROM users WHERE id =:id");
        $sth->bindValue(':id', $id);

        $result = $sth->execute();
        //* Je redirige vers la page précédente si la suppression a eu lieu, ou j'affiche un message autrement. 
        if ($result) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Il ya eu un problème avec votre requête, contactez le support";
        }
    } catch (PDOException $error) {
        echo 'Erreur: ' . $error->getMessage();
    }
}
?>