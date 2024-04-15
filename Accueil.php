<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil</title>
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
  display: flex; /* Ajout */
  flex-direction: column; /* Ajout */
  align-items: center; /* Ajout */
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

.barre-navigation a.accueil-liens {
    background-color: #F6F6F6;
    color: #1B3168;
    width: 253.38px;
    height: 38.64px;
    padding: 0px 7.32px 0px 7.32px;
    border-radius: 3.66px;
    display: flex;
    align-items: center;
    text-decoration:none;
}

.barre-navigation a.recherche-liens {
    color: #757575;
    display: flex;
    align-items: center;
    text-decoration:none;
}
.barre-navigation a.mesexercices-liens {
    color: #757575;
    display: flex;
    align-items: center;
    text-decoration:none;
}
.barre-navigation a.soumettre-liens {
    color: #757575;
    display: flex;
    align-items: center;
    text-decoration:none;
}

.barre-navigation a.fonctions-liens {
    color: #757575;
    display: flex;
    align-items: center;
    text-decoration:none;
}

.deconnexion .deconnexion-liens{
  color: #757575;
  display: flex;
    align-items: center;
    text-decoration:none;
    font-size:14px;
    background-color:#F6F6F6;
    width:253px;
    height:38px;
  }

.deconnexion{
  margin-top: 265%;
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

.profil-image {
    width: 30px; /* ou la taille que vous souhaitez */
    height: 30px; /* ou la taille que vous souhaitez */
    border-radius: 50%; /* rend l'image ronde */
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
    margin-top: 20px;
    margin-left:45px;
    padding-top: 24px;
    font-weight:400;
    line-height:24.57px;
}

.carre-blanc h2{
    padding-left: 50px;
    line-height: 2;
}

.carre-blanc ol{
    margin-left: 30px;
    font-size: 22px;
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
        <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home.svg"><strong>Accueil</strong></a></li>
        <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg">Recherche</a></li>
        <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
        <?php 
            if(isset($_SESSION["account"]) &&(($_SESSION["account"]['role'] === 'Administrateur') || ($_SESSION["account"]['role'] === 'Contributeur'))){
                echo '<li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
                <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>';
              } 
        ?>
        <div class="deconnexion">
          <?php if(isset($_SESSION["account"])): ?>
            <li><a href="requetes/logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg">Déconnexion</a></li>
          <?php endif; ?>
        </div>
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
            $profile_picture = isset($_SESSION['account']['profil-image']) ? $_SESSION['account']['profil-image'] : 'chemin/vers/image_par_defaut.jpg';
            echo "<div class='compte'>$lastname $firstname <img src='$profile_picture' alt='photo de profil' class='profil-image'></div>";
        } else {
            echo "<a href='Connexion.php' class='connexion'><img src='assets/images/icone_login.svg' alt='login'>Connexion</a>";
        }
      ?>
    </div>
    
  </header>
  <div class="contenu">
    <h1>Accueil</h1>
    <div class="carre-blanc">
        <p>Nous sommes ravis de vous accueillir sur <strong>Math Index</strong>, la plateforme mathématique exclusive du lycée Saint-Vincent Senlis. Développée<br>avec passion pour enrichir l'expérience éducative de nos étudiants, cette ressource en ligne offre un accès simplifié à une vaste<br> bibliothèque d'exercices mathématiques de qualité.</p>
        <br>
        <h2>Explorez les Avantages Spécifiques à Notre Lycée :</h2>
        <ol>
            <li>Exercices Personnalisés : Découvrez une collection soigneusement sélectionnée d'exercices qui complètent notre programme<br>éducatif, adaptés aux niveaux et aux besoins spécifiques en classe.</li>
            <br>
            <li>Soutien Pédagogique : <strong>Math Index</strong> sert de complément idéal à nos cours, offrant aux enseignants et aux étudiants un outil puissant<br> pour renforcer la compréhension des concepts mathématiques enseignés en classe.</li>
            <br>
            <li>Collaboration Communautaire : En tant que membre de notre lycée, participez à la communauté en partageant vos propres<br>exercices, collaborez avec d'autres enseignants et favorisez un environnement d'apprentissage collaboratif.</li>
        </ol>
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
