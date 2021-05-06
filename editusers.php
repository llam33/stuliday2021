<?php require './header.php'; ?>
<?php
$id = $_GET['id'];

        $sqlUsers= "SELECT * FROM users WHERE id = '{$id}'";
        $user = $connect->query($sqlUsers)->fetch(PDO::FETCH_ASSOC);
    
        if (isset($_POST['user_submit']) && !empty($_POST['username']) && !empty($_POST['email_signup']) && !empty($_POST['role'])) {
            $username = strip_tags($_POST['username']);
                $email = strip_tags($_POST['email_signup']);
                $role = strip_tags($_POST['role']);
                $user_id = $_SESSION['id'];
            
            var_dump($username);
                try {
                    //? Préparation de la requête, je définis la requête à exécuter avec des valeurs génériques (des paramètres nommés).
                    //! Attention, les requêtes INSERT et UPDATE sont sensiblement différentes sur leur syntaxe
                    $sth = $connect->prepare("UPDATE users
                    SET
                    username=:username,email=:email,role=:role WHERE id = :id");
                    //? J'affecte chacun des paramètres nommés à leur valeur via un bindValue. Cette opération me protège des injections SQL (en + de l'assainissement des variables).
                    $sth->bindValue(':username', $username);
                    $sth->bindValue(':email', $email);
                    $sth->bindValue(':role', $role);
                    $sth->bindValue(':id', $id);
                    
                    
        
                    //? J'exécute ma requête SQL de modification avec execute()
                    $sth->execute();

                    
                            
                    echo "Votre article a bien été modifié";
        
                    //? Je redirige vers la page des produits.
                    header('Location: admin.php');
                } catch (PDOException $error) {
                    echo 'Erreur: ' . $error->getMessage();
                    }
                
            }
        // var_dump($users);
?>
        <main class="px-3">
        <div class="row column text-center">
        <form action="#" method="POST">
        
        <hr>
        <h2>Modification de l'utilisateur</h2>
        <hr>
            <table class="table bg-light text-black">
                <thead>
                    <tr>
                        <th scope="col"># id</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>

                    </tr>
                </thead>
                <tbody>
                <tr>
                    
                        <th scope="row"><?php echo $user['id'] ?></th>
                        <td><input type="text" class="form-control" id="InputName" placeholder="Nom d'utilisateur" name="username" value="<?php echo $user['username']; ?>" required></td>
                        <td><input class="form-control" type="email" placeholder="Email" id="InputEmail1" aria-describedby="emailHelp" name="email_signup" value="<?php echo $user['email'] ?>" required></td>
                        <td>
                    <select class="form-control" id="InputRole" name="role" required>
                    <?php
                    if ($user['role']=== 'ROLE_ADMIN'){

                        ?>
                        <option value="ROLE_ADMIN" selected>ADMIN</option>
                        <option value="ROLE_USER" >USER</option>
                        <?php
                        }else{
                                
                            ?>

                            <option value="ROLE_ADMIN" >ADMIN</option>
                            <option value="ROLE_USER" selected>USER</option> 
                            <?php
                        }

                        ?>
                        </select>
                       </td>
                   
                       
                        </tr>
                 
                </tbody>
            </table>
            <button type="submit" class="btn" name="user_submit">Enregistrer les modifications</button>
            </form>
            
            </div>

            

           
        </main>


<?php require './footer.php'; ?>