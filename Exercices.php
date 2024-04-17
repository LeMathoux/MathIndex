<?php 
session_start();
// Connexion à la base de données (à remplacer avec vos informations de connexion)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mathindex";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

// Pagination
$exercices_par_page = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $exercices_par_page;

// Requête pour obtenir le nombre total d'exercices
$sql_total_exercices = "SELECT COUNT(*) AS total FROM exercise";
$result_total_exercices = $conn->query($sql_total_exercices);
$row_total_exercices = $result_total_exercices->fetch_assoc();
$total_exercices = $row_total_exercices['total'];

// Calculer le nombre total de pages
$total_pages = ceil($total_exercices / $exercices_par_page);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exercices</title>
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
    width: 79%;
    height: 832px;
    background-color: #FFFFFF;
    border-radius: 7.36px;
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

.carre-blanc table {
            width: 90%;
            height: 44px;
            border-collapse: collapse;
            border-radius: 5px;
            overflow: hidden; /* Pour que les coins arrondis soient visibles */
            margin-left: 48px;
}

.carre-blanc thead {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            background-color: #E7E7E7;
            color: #464646;
}

.carre-blanc td, th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: #464646;
}

.carre-blanc td a{
    text-decoration:none;
    color:#74828F;
    margin-right: 5px;
}

.carre-blanc td img{
    margin-right:5px;
    position: relative;
    top: 5px;
}

.carre-blanc .mot_cle {
    display: inline-block;
    padding: 5px 10px;
    margin: 5px;
    border-radius: 20px;
    background-color: #DBDBDB;
    border:none;
}

.carre-blanc .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
}

.pagination a{
            margin: 0 5px;
            width:24px;
            height:24px;
            color: black;
            border: 1px solid #DFE3E8;
            border-radius:4px;
            text-decoration:none;
            display: flex;
            align-items: center;
            justify-content: center;
}

span.page-actuel{
            border: 1px solid black; /* Ajout de la bordure par défaut */
            margin: 0 5px;
            width: 24px;
            height: 24px;
            border-radius: 5px;
            color: black;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
}

.pagination .page-actuel:hover {
    border: 1px solid black; 
}

a.pagination-bouton-gauche{
            border: 1px solid #DFE3E8;
            margin: 0 5px;
            width: 24px;
            height: 24px;
            border-radius: 5px;
            color: #C4CDD5;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content: center;
}

span.pagination-bouton-gauche{
            border:none;
            margin: 0 5px;
            width: 26px;
            height: 26px;
            border-radius: 5px;
            color: #C4CDD5;
            background-color:#919EAB;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content: center;
}

span.pagination-bouton-droite{
            border:none;
            margin: 0 5px;
            width: 26px;
            height: 26px;
            border-radius: 5px;
            color: #C4CDD5;
            background-color:#919EAB;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content: center;
}

a.pagination-bouton-droite{
            border: 1px solid #DFE3E8;
            margin: 0 5px;
            width: 24px;
            height: 24px;
            border-radius: 5px;
            color: #C4CDD5;
            text-decoration:none;
            display:flex;
            align-items:center;
            justify-content: center;
}

footer {
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
            <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions.svg"><strong>Exercices</strong></a></li>
            <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
            <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>
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
        <h1>Exercices</h1>
        <div class="carre-blanc">
            <h2>Nouveautés</h2>
                <table border="1">
                    <thead>
                        <tr>
                        <th>Nom</th>
                        <th>Thématique</th>
                        <th>Difficulté</th>
                        <th>Durée</th>
                        <th>Mots clés</th>
                        <th>Fichier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Requête SQL pour récupérer les trois dernières nouveautés en fonction des dates
                        $sql_nouveautes = "SELECT exercise.name AS exercise_name, thematic.name AS thematic_name, exercise.difficulty, exercise.duration, exercise.keywords, file_exercice.original_name AS exercice_original_name, file_exercice.extension, file_correction.original_name AS correction_original_name, file_correction.extension AS correction_extension
                        FROM exercise
                        LEFT JOIN thematic ON exercise.thematic_id = thematic.id
                        LEFT JOIN file AS file_exercice ON exercise.id_file_exercice = file_exercice.id
                        LEFT JOIN file AS file_correction ON exercise.id_file_correction = file_correction.id
                        ORDER BY exercise.date DESC LIMIT 3";

                        $result_nouveautes = $conn->query($sql_nouveautes);

                        if ($result_nouveautes->num_rows > 0) {
                            // Affiche chaque exercice dans une ligne du tableau
                            while ($row = $result_nouveautes->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["exercise_name"] . "</td>";
                                echo "<td>" . $row["thematic_name"] . "</td>";
                                echo "<td>".'Niveau '. $row["difficulty"] . "</td>";
                                echo "<td>" . $row["duration"] .'h00'."</td>";
                                echo '<td>';
                                $keywords = explode(',', $row['keywords']);
                                foreach ($keywords as $keyword) {
                                    echo '<span class="mot_cle">' . $keyword . '</span>';
                                }
                                echo '</td>';
                                echo "<td>";
                                echo "<img src='assets/images/icone_download.svg'>
                                      <a href='assets/Exercices/" . $row["exercice_original_name"] . "." . $row["extension"] . "' download>Exercice</a>";
                                if ($row["correction_original_name"] && $row["correction_extension"]) {
                                    echo "<br><img src='assets/images/icone_download.svg'>
                                          <a href='assets/Corrigé/" . $row["correction_original_name"]. "." . $row["correction_extension"] ."' download>Corrigé</a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "Aucune nouveauté trouvée.";
                        }
                        ?>
                    </tbody>
                </table>

                <h2>Tous les exercices</h2>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Thématique</th>
                            <th>Difficulté</th>
                            <th>Durée</th>
                            <th>Mots clés</th>
                            <th>Fichiers</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       
                            $sql_all_exercices = "SELECT exercise.name AS exercise_name, thematic.name AS thematic_name, exercise.difficulty, exercise.duration, exercise.keywords, file_exercice.original_name AS exercice_original_name, file_exercice.extension, file_correction.original_name AS correction_original_name, file_correction.extension AS correction_extension
                            FROM exercise
                            LEFT JOIN thematic ON exercise.thematic_id = thematic.id
                            LEFT JOIN file AS file_exercice ON exercise.id_file_exercice = file_exercice.id
                            LEFT JOIN file AS file_correction ON exercise.id_file_correction = file_correction.id
                            LIMIT $exercices_par_page OFFSET $offset";

                            $result_all_exercices = $conn->query($sql_all_exercices);

                            if ($result_all_exercices->num_rows > 0) {
                            // Affiche chaque exercice dans une ligne du tableau
                            while ($row = $result_all_exercices->fetch_assoc()) {
                                echo "<tr>";
                                    echo "<td>" . $row["exercise_name"] . "</td>";
                                    echo "<td>" . $row["thematic_name"] . "</td>";
                                    echo "<td>".'Niveau '. $row["difficulty"] . "</td>";
                                    echo "<td>" . $row["duration"] .'h00'."</td>";
                                    echo '<td>';
                                    $keywords = explode(',', $row['keywords']);
                                    foreach ($keywords as $keyword) {
                                        echo '<span class="mot_cle">' . $keyword . '</span>';
                                    }
                                    echo '</td>';
                                    echo "<td>";
                                    echo "<img src='assets/images/icone_download.svg'>
                                          <a href='assets/Exercices/" . $row["exercice_original_name"] . "." . $row["extension"] . "' download>Exercice</a>";
                                    if ($row["correction_original_name"] && $row["correction_extension"]) {
                                        echo "<br><img src='assets/images/icone_download.svg'>
                                              <a href='assets/Corrigé/" . $row["correction_original_name"]. "." . $row["correction_extension"] . "' download>Corrigé</a>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                            }
                            } 
                        ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <?php
                        if ($page > 1) {
                            echo "<a href='Exercices.php?page=".($page - 1)."' class='pagination-bouton-gauche'>&lt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-gauche'>&lt;</span>";
                        }

                        for ($i=1; $i<=$total_pages; $i++) {
                            if ($i == $page) {
                                echo "<span class='page-actuel'>$i</span>";
                            } else {
                                echo "<a href='Exercices.php?page=".$i."' class='pagination-lien'>$i</a>";
                            }
                        }

                        if ($page < $total_pages) {
                            echo "<a href='Exercices.php?page=".($page + 1)."' class='pagination-bouton-droite'>&gt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-droite'>&gt;</span>";
                        }
                    ?>
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

<?php
// Fermer la connexion à la base de données
$conn->close();
?>
