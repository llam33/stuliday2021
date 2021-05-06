<?php include "header.php" ?>
<?php
$alert = false;

//? Etape 1 : Vérification du remplissage du formulaire
if (!empty($_POST['email_login']) && !empty($_POST['password_login']) && isset($_POST['submit_login'])) {
    //? Etape 2 : Initialisation des variables + assainissement via htmlspecialchars
    $email = htmlspecialchars($_POST['email_login']);
    $password = htmlspecialchars($_POST['password_login']);
    // var_dump($password);
    try {
        $sqlMail = "SELECT * FROM users WHERE email = '{$email}'";
        $resultMail = $connect->query($sqlMail);
        $user = $resultMail->fetch(PDO::FETCH_ASSOC);
        // var_dump($user);
        if ($user) {
            $dbpassword = $user['password'];
            if (password_verify($password, $dbpassword)) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['username'] = $user['username'];

                $alert = true;
                $type = 'success';
                $message = "Vous êtes désormais connectés";
                unset($_POST);
                header('Location: profile.php');
            } else {
                $alert = true;
                $type = 'danger';
                $message = "Le mot de passe est erroné";
                unset($_POST);
            }
        } else {
            $alert = true;
            $type = 'warning';
            $message = "Ce compte n'existe pas";
            unset($_POST);
        }
    } catch (PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}

?>

<div class="form">

    <form action="#" method="POST">
        
    <div class="form-icons">
        <h4>Se connecter</h4>
        

        <div class="input-group">
        <span class="input-group-label">
            <i class="fa fa-envelope"></i>
        </span>
        <input class="input-group-field" type="email" placeholder="Email" id="InputEmail1" aria-describedby="emailHelp" name="email_login" required>
       
    </div>
        
        <div class="input-group">
        <span class="input-group-label">
            <i class="fa fa-key"></i>
        </span>
        <input class="input-group-field" type="password" placeholder="Password" id="InputPassword1" name="password_login" required>
        
    
        </div>
        <?php echo $alert ? "<div class='alert alert-{$type} mt-2'>{$message}</div>" : ''; ?>
        
    </div>

    <button class="btn"  type="submit" name="submit_login" value="connexion">Se connecter</button>
    <p>Vous ne possédez pas de compte ? <a href="./signin.php">Inscrivez-vous ici </a></p>
    </form>
</div>

<?php include "footer.php"?>