<?php
session_start();  // Start the session

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mathindex";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $origin_id = isset($_POST['origine']) ? $_POST['origine'] : '';
    $nom_livre = isset($_POST['nom_livre']) ? $_POST['nom_livre'] : '';
    $info_supplementaires = isset($_POST['info_supplementaires']) ? $_POST['info_supplementaires'] : '';

    $sql_exercice = "INSERT INTO exercise (origin_id, origin_name, origin_information) VALUES ('$origin_id', '$nom_livre', '$info_supplementaires')";

    if ($conn->query($sql_exercice) === TRUE) {
        $last_id = $conn->insert_id;
        $reset_auto_increment = "ALTER TABLE exercise AUTO_INCREMENT = " . ($last_id + 1);
        $conn->query($reset_auto_increment);

        $_SESSION['message'] = "Soumission réussie";
        header("Location: Soumettre_fichiers.php");
        exit();
    } else {
        $_SESSION['error'] = "Erreur lors de l'insertion dans la table exercices: " . $conn->error;
        header("Location: test.php");
        exit();
    }
}

$conn->close();

// Set $message and $error variables from session
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';

// Clear the session messages
unset($_SESSION['message']);
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Soumettre un exercice - Sources</title>
  <style>
   @import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@100;200;300;400;500;600;700;800;900&display=swap');
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

.barre-navigation a.accueil-liens {
    color: #757575;
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

.barre-navigation a.fonctions-liens {
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
    background-color: #F6F6F6;
    color: #1B3168;
    width: 253.38px;
    height: 38.64px;
    border-radius: 3.66px;
    display: flex;
    align-items: center;
    text-decoration:none;
}

.deconnexion a.deconnexion-liens{
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
  margin-top: 239%;
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
  padding-top: 15px;
}

.contenu h1{
    margin-left: 19%;
    color: #1B3168;
    font-size:28px;
}

.carre-blanc  {
    width: 1518px;
    height: 762px;
    background-color: #FFFFFF;
    border-radius: 0 7.36px 7.36px 7.36px;
    position: absolute;
    top: 605px;
    left: 58%;
    transform: translate(-50%, -50%);
}

.carre-blanc h2{
            font-size: 22px;
            padding-left: 50px;
            padding-top: 24px;
        }

.onglets {
    display: flex;
    margin-left: 355px;
    margin-top: 21px;
}

        .onglet1:hover {
          background-color: #1B3168;
        }

.onglet3:hover {
          background-color: #1B3168;
}

.onglet1 {
            width: 225px;
            height: 41px;
            cursor: pointer;
            background-color: #1B3168CC;
            color: white;
            border-radius: 5px 5px 0 0;
            font-size: 20px;
            margin-right: 10px; /* Ajout de la marge entre les onglets*/
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

.onglet2 {
            width: 132px;
            height: 41px;
            cursor: pointer;
            background-color: #1B3168;
            color: white;
            border-radius: 5px 5px 0 0;
            font-size: 20px;
            margin-right: 10px; /* Ajout de la marge entre les onglets */
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

.onglet3 {
            width: 132px;
            height: 41px;
            cursor: pointer;
            background-color: #1B3168CC;
            color: white;
            border-radius: 5px 5px 0 0;
            font-size: 20px;
            margin-right: 10px; /* Ajout de la marge entre les onglets */
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
        }

.onglet.active {
            background-color: #1B3168;
        }

.formulaire-contenu{
            margin-left: 30px;
        }

form{
            width:1002px;
height: 578px;
padding-left: 20px;
        }

form label{
    color: #666666;
font-size: 16px;
font-weight: 600;
line-height: 18px;
text-align: left;
margin-top: 30px;
display: block;
}

span{
    color: #1B3168;
}

select {
    width: 469px;
    height: 56px;
    padding: 16px;
    font-size: 16px;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 16px; /* Définir la taille de la police */
}

select, input[type="text"] {
    margin-bottom: 10px;
    width: 469px;
    height: 56px;
    padding: 16px;
    font-size: 16px;
    border: 2px solid #ccc;
    border-radius: 8px;
    box-sizing: border-box;
    margin-right: 20px;
    color: #666666;
    margin-top: 10px;
}

#info_supplementaires {
    width: 999px;
    height: 214px;
    gap: 0px;
    border-radius: 8px;
    opacity: 0.7; /* Vous pouvez ajuster cette valeur pour l'opacité */
    border: 2px solid #ccc; /* Ajout d'une bordure pour améliorer la visibilité */
    resize: none; /* Empêche le redimensionnement manuel */
}

#origine, #nom_livre {
    width: 999px;
    height: 56px;
    border-radius: 8px ;
    border: 2px solid #ccc;
    opacity: 0.7; /* Vous pouvez ajuster cette valeur pour l'opacité */
}

form h2 {
    margin-top: 0;
    font-size: 20px;
}

form input[type="submit"] {
    width: 172px;
    height: 56px;
    padding: 16px;
    border-radius: 8px;
    border: none;
    background-color: #F6F6F6;
    color: #757575;
    font-size: 16px;
    cursor: pointer;
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
            <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home_gris.svg">Accueil</a></li>
            <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg">Recherche</a></li>
            <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
            <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
            <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre.svg"><strong>Soumettre</strong></a></li>
            <div class="deconnexion">
                <?php if(isset($_SESSION["account"])): ?>
                    <li><a href="logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg">Déconnexion</a></li>
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
            $profile_picture = isset($_SESSION['account']['profile_picture']) ? $_SESSION['account']['profile_picture'] : 'chemin/vers/image_par_defaut.jpg';
            echo "<div class='compte'>$lastname $firstname <img src='$profile_picture' alt='photo de profil' class='profile-picture'></div>";
            }
            else{
            echo "<a href='Connexion.php' class='connexion'><img src='assets/images/icone_login.svg' alt='login'>Connexion</a>";
            }
        ?>
        </div>
        
    </header>
    <div class="contenu">
        <h1>Soumettre un exercice</h1>
        <div class="onglets">
            <a href="Soumettre-information_generales.php" class="onglet onglet1">Informations générales</a>
            <a href="Soumettre-sources.php" class="onglet onglet2 active">Sources</a>
            <a href="Soumettre_fichiers.php" class="onglet onglet3">Fichiers</a>
        </div>
        <div class="carre-blanc">
            <h2>Sources</h2>
            <div class="formulaire-contenu">
                <?php if ($message): ?>
                    <p><?= $message ?></p>
                <?php endif; ?>

                 <?php if ($error): ?>
                    <p><?= $error ?></p>
                <?php endif; ?>
                <form method="post">
                    <label for="origine">Origine<span>*</span>:</label>
                    <select id="origine" name="origine" required>
                        <option value="1">Livre de Mathématique</option>
                        <option value="2">Manuel scolaire</option>
                    </select><br>
                        
                    <label for="nom_livre">Nom de la source/lien du site <span>*</span> :</label>
                    <input type="text" id="nom_livre" name="nom_livre" required>

                    <label for="info_supplementaires">Informations complémentaires :</label>
                    <input type="text" id="info_supplementaires" name="info_supplementaires"></input><br>

                    <input type="submit" value="Continuer">
                </form>
            </div>
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
