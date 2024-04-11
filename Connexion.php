<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/styles/connexion.css" rel="stylesheet" />
        <link href="style.css" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https : //fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <title>Connexion</title>
    </head>
    <?php
    include "requetes/formulaire_connexion.php";
    ?>
    <body class="font">
    <div class="contenaire">
        <div class="partie_gauche">
            <div class="logo">
                <img alt="logo" src="assets/images/logo-st-vincent.png">
                <div class="logo-titre">
                    <span class="titre">Math Index</span>
                    <span class="sous-titre">Lycée Saint-Vincent - Senlis</span>
                </div>
            </div>
            <div class="navigation">
                <a href="index.php" class="bouton-menu1"><img src="assets/images/icone-home.png" alt="Home"><strong>Accueil</strong></a>
                <a href="Recherche.php" class="bouton-menu2"><img src="assets/images/icone-search.png" alt="search">Recherche</a>
                <a href="Mathematique.php" class="bouton-menu3"><img src="assets/images/icone-fonction.png" alt="fonction">Exercices</a>
                <div class="nouveaux-menus" style="display: none;margin-top: 10px;">
                <a href="#" class="bouton-menu3"><img src="assets/images/icone_liste_gris.svg" alt="leading">Mes exercices</a>
                    <a href="Soumettre.html" class="bouton-menu3"><img src="icone_soumettre.svg" alt="envoyer">Soumettre</a>
                </div>
            </div>
        </div>
        <div class="partie_droite">
            <div class="header">
                <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    if(isset($_SESSION["account"])){
                        $lastname=$_SESSION['account']['last_name'];
                        $firstname=$_SESSION['account']['first_name'];
                        $role=$_SESSION['account']['role'];
                        echo "<div class='compte'>$lastname $firstname ($role)
                        <div class='deconnexion'>
                                <a href='admin/authentification/logout.php'><h2>se deconnecter</h2></a>
                            </div>
                        </div>";
                    }
                    else{
                        echo "<a href='Connexion.php' class='connexion'><img src='assets/images/icone-login.png' alt='login'>Connexion</a>";
                    }
                ?>
            </div>
            <h1 class="titre">Connexion</h1>
            <div class="carre-blanc">
                <p>Cet espace est réservé aux enseignants du lycée Saint-Vincent - Senlis. Si vous n’avez pas encore de compte, veuillez effectuer votre demande directement en envoyant un email à contact@lyceestvincent.net.</p>
                <form class="formulaire" method="post">
                    <div>
                        <label for="email"> Email : </label> <input  id="email" type="email" name="email" placeholder="Saisissez votre adresse email" value= <?= displayValue('email') ?>></input>
                        <?php displayErrors($errors, 'email'); ?>
                    </div>
                    <div>
                        <label for="password"> Mot de passe : </label> <input type="password" name="password" placeholder="Saisissez votre mot de passe" value=<?= displayValue('mdp') ?>></input>
                        <?php displayErrors($errors, 'password'); ?>
                    </div>
                    <div style="display: flex;">
                    <input type="submit" value="Connexion">
                    <a href="mdp.php">Mot de passe oublié ?</a>
                </div>
                </form>
            </div>
            <div class="mentionlegales">
                <div class="mentionlegales-text">Mentions légales</div>
                <div class="mentionlegales-text">•</div>
                <div class="mentionlegales-text">Contact</div>
                <div class="mentionlegales-text">•</div>
                <div class="mentionlegales-text">Lycée Saint-Vincent</div>
            </div>
        </div>
    </div>
    
</body>
</html>
