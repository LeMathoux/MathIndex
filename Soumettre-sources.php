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
  <link href='assets/styles/Soumettre_source.css' rel='stylesheet'/>
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
            echo "<div class='compte'>$lastname $firstname <img src='$profile_picture' alt='photo de profil' class='profil-image'></div>";
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
