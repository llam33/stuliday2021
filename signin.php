<?php include("header.php")?>

<?php
// var_dump($_POST);
if (!empty($_POST['email_signup']) && !empty($_POST['password1_signup']) && !empty($_POST['password2_signup']) && !empty($_POST['username_signup']) &&  isset($_POST['submit_signup'])) {
    $email = htmlspecialchars($_POST['email_signup']);
    $password1 = htmlspecialchars($_POST['password1_signup']);
    $password2 = htmlspecialchars($_POST['password2_signup']);
    $username = htmlspecialchars($_POST['username_signup']);

    try {
        //? Etape 1 : Ajout d'un filtre pour la validation du format d'email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // echo "Etape 1 : Email ok <br>";
            //? Etape 2 : Vérification de la disponibilité de l'email dans la BDD
            $sqlMail = "SELECT * FROM users WHERE email = '{$email}'";
            $resultMail = $connect->query($sqlMail);
            // var_dump($resultMail);
            $countMail = $resultMail->fetchColumn();
            if (!$countMail) {
                // echo "Etape 2 : Email BDD ok <br>";
                //? Etape 3 : Vérification de la disponibilité de l'username dans la BDD
                $sqlUsername = "SELECT * FROM users WHERE username = '{$username}'";
                $resultUsername = $connect->query($sqlUsername);
                $countUsername = $resultUsername->fetchColumn();
                if (!$countUsername) {
                    // echo "Etape 3 : Username BDD ok <br>";
                    //? Etape 4 : Vérification de la concordance des mots de passe
                    if ($password1 === $password2) {
                        // echo "Etape 4 : Concordance Mdp ok <br>";
                        //? Etape 5 : Hashage du mot de passe
                        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
                        // echo "Etape 5 : Hashage Mdp ok <br>";
                        //? Etape 6 : Enregistrement des données utilisateur
                        $sth = $connect->prepare("INSERT INTO users (email,username,password) VALUES (:email,:username,:password)");
                        $sth->bindValue(':email', $email);
                        $sth->bindValue(':username', $username);
                        $sth->bindValue(':password', $hashedPassword);
                        $sth->execute();
                        echo "L'utilisateur a bien été enregistré !";
                        //? Etape 7 : Ajout de messages d'erreurs adaptés.
                    } else {
                        echo "Les mots de passe ne sont pas concordants.";
                        unset($_POST);
                    }
                } else {
                    echo " Ce nom d'utilisateur existe déja";
                    unset($_POST);
                }
            } else {
                echo "Un compte existe déja pour cette adresse mail";
                unset($_POST);
            }
        } else {
            echo "L'adresse email saisie n'est pas valide";
            unset($_POST);
        }
    } catch (PDOException $error) {
        echo 'Error: ' . $error->getMessage();
    }
}

?>

<div class="form">
    <form method="POST" action="#">
        
    <div class="form-icons">
        <h4>Créer un compte</h4>

        <div class="input-group">
        <span class="input-group-label">
            <i class="fa fa-user"></i>
        </span>
        <input class="input-group-field" type="text" placeholder="Nom d'utilisateur" id="InputUsername1" aria-describedby="userHelp" name="username_signup" required> 
    </div>
    
    
        <div class="input-group">
        <span class="input-group-label">
            <i class="fa fa-envelope"></i>
        </span>
        <input class="input-group-field" type="email" placeholder="Email" id="InputEmail1" aria-describedby="emailHelp" name="email_signup" required>
        </div>

        <div class="input-group">
        <span class="input-group-label">
            <i class="fa fa-key"></i>
        </span>
        <input class="input-group-field" type="password" placeholder="Password" id="InputPassword1" name="password1_signup" required>
        </div>

        <div class="input-group">
        <span class="input-group-label">
            <i class="fa fa-key"></i>
        </span>
        <input class="input-group-field" type="password" placeholder="Confirm Password" id="InputPassword2" name="password2_signup" required>
        </div>
    </div>

    <button class="btn" type="submit" name="submit_signup" value="inscription">S'inscrire</button>
    <p>Déja inscrits ? <a href="./login.php">Connectez-vous ici </a></p>
    </form>
    
</div>
<?php include("footer.php")?>