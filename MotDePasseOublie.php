<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion</title>
  <style>
   body {
  margin: 0;
  padding: 0;
  font-family: Arial, sans-serif;
  background-color: #eff2f4;
}

.barre-navigation {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 297px;
  background-color: #FFFFFF;
  padding-top: 15px;
  box-shadow: 5px 0px 15px rgba(0, 0, 0, 0.2);
  z-index: 1;
  display: flex; 
  flex-direction: column; 
}

.barre-navigation li {
  list-style: none;
  margin-left: 16px;
  line-height:2;
}

.navigation{
    padding-top:75px;
}

.barre-navigation ul li {
  padding: 10px 20px;
}

.barre-navigation strong{
    margin-left:6px;
}

.barre-navigation a.accueil-liens  {
    color: #757575;
    display: flex;
    align-items: center;
    text-decoration:none;
}

.barre-navigation a.recherche-liens  {
    color: #757575;
    display: flex;
    align-items: center;
    text-decoration:none;
}

.barre-navigation a.fonctions-liens  {
    color: #757575;
    display: flex;
    align-items: center;
    text-decoration:none;
}

.barre-navigation a img {
    margin-right: 10px;
}

.ensembles-logo  {
  display: flex;
  position: relative;
  margin-left: 15px;
}

        .ensembles-logo-titre img{
            width: 32px;
            height: 34px;
        }

        .ensembles-logo-titre {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 15px;
        }

        .ensembles-logo-titre .titre{
            color: #1B3168;
            font-size: 26px;
        }

        .ensembles-logo-titre .sous-titre {
            font-size: 17px;
            font-weight: 500;
            color: #5D7285;
        }

header {
  background-color: #FFFFFF;
  position: relative;
  width: 100%;
  height: 96px;
}

.header-droite {
  position: absolute;
  top: 50%;
  right: 20px;
  transform: translateY(-50%);
}

.header-droite a {
  text-decoration: none;
  color: #333;
  padding: 10px 20px;
  display: flex;
    align-items: center;
}

.header-droite img{
    margin-right: 10px;
    width: 21px;
    height: 20px;
}

.contenu {
  padding-top: 35px;
}

.contenu h1{
    margin-left: 19%;
    color: #1B3168;
    font-size:28px;
}

.carre-blanc {
    width: 1518px;
    height: 762px;
    background-color: #FFFFFF;
    border-radius: 7.36px;
    position: absolute;
    top: 605px;
    left: 58%;
    transform: translate(-50%, -50%);
}

.carre-blanc p{
    font-size: 22px;
    padding-left: 50px;
    padding-top: 24px;
}

.carre-blanc .contact-email {
    color: #1B3168; /* Changer la couleur en bleu */
}

.carre-blanc form{
    padding-top: 40px;
    padding-left: 50px;
}

.carre-blanc label{
    color: #666666;
    font-size: 16px;
}

.carre-blanc input[type="email"],
.carre-blanc input[type="password"]{
    display: block;
    margin-bottom: 15px;
    width: 459px;
    padding: 10px;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
    border: 1px solid #F6F6F6;
}

.carre-blanc input[type="submit"] {
    background-color:#F6F6F6;
    color: #757575;
    cursor: pointer;
    border: none;
    width: 172px;
    height: 56px;
    font-size: 16px;
    border-radius: 8px;
}

.carre-blanc a {
    text-decoration: none;
    color: #757575;
    gap: 52px;
    margin-left: 113px;
    display: flex;
    align-items: center;
    font-size: 16px;
}

footer {
  padding: 20px 0;
  position: fixed;
  bottom: 0;
  width: 100%;
}

.mentionlegales {
  font-size: 20px;
  color: #000000;
  width: 100%;
  display: flex;
  flex-direction: row;
  margin-left: 350px;
  margin-top: 31.3px;
  margin-bottom: 9px;
}

.mentionlegales-text {
  display: inline-block;
  margin: 0 10px;
  font-size: 20px;
}

  </style>
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
                echo "<div class='compte'>$lastname $firstname ($role)</div>";
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
                <div style="display: flex;">
                    <input type="submit" value="Connexion">
                    <a href="Mot_de_passe.php">Mot de passe oublié ?</a>
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
