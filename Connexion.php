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
<body>
    <nav class="barre-navigation">
        <div class="ensembles-logo">
            <img alt="logo" src="assets/images/Logo.svg">
            <div class="ensembles-logo-titre ">
            <span class="titre">Math Index</span>
            <span class="sous-titre">Lycée Saint-Vincent -Senlis</span>
            </div>
        </div>
        <div class="navigation">
            <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home_gris.svg">Accueil</a></li>
            <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg">Recherche</a></li>
            <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
        </div>
    </nav>
    <header>
        <div class="header-droite">
            <?php
           
            if (session_status() == PHP_SESSION_NONE) {
            }

            if(isset($_SESSION["account"])){
                $lastname=$_SESSION['account']['last_name'];
                $firstname=$_SESSION['account']['first_name'];
                $role=$_SESSION['account']['role'];
                echo "<div class='compte'>$lastname $firstname ($role)</div>
                    </div>";
                }
                else{
                echo "<a href='Connexion.php' class='connexion'><img src='assets/images/icone_login.svg' alt='login'>Connexion</a>";
                }
            ?>
        </div>
    </header>
    <div class="contenu">
        <h1>Connexion</h1>
        <div class="carre-blanc">
            <p>Cet espace est réservé aux enseignants du lycée Saint-Vincent - Senlis. Si vous n’avez pas encore de compte, veuillez effectuer votre<br>demande directement en envoyant un email à <span class="contact-email">contact@lyceestvincent.net</span>.</p>
            <form class="formulaire" method="post">
                <label for="email">Email :</label>
                <input type="email" name="email" placeholder="Saisissez votre adresse email"></input>
                <br>
                <label for="password">Mot de passe :</label>
                <input type="password" name="password" placeholder="Saisissez votre mot de passe"></input>
                <br>
                <?php
                if(empty($result) && $_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) === false){
                echo "email ou mot de passe incorrect";
                }
                ?>
                <div style="display: flex;">
                    <input type="submit" value="Connexion">
                    <a href="mdp.php">Mot de passe oublié ?</a>
                </div>
            </form>
        </div>
    </div>
    <footer>
        <div class="mentionlegales">
            <div class="mentionlegales-text">Mentions légales</div>
            <div class="mentionlegales-text">•</div>
            <div class="mentionlegales-text">Contact</div>
            <div class="mentionlegales-text">•</div>
            <div class="mentionlegales-text">Lycée Saint-Vincent</div>
        </div>
    </footer>   
</body>
</html>
