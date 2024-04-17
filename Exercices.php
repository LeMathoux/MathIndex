<?php 
session_start();
// Connexion à la base de données (à remplacer avec vos informations de connexion)
include_once 'requetes/configdb.php';

// Vérifiez si l'utilisateur est connecté et est un admin
$is_admin = isset($_SESSION["account"]) && ($_SESSION["account"]["role"] === "Administrateur");
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
  <link href='assets/styles/Exercices.css' rel='stylesheet'/>
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
            <?php if ($is_admin): ?>
                <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
                <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>
            <?php endif; ?>
            <div class="deconnexion">
                <?php if(isset($_SESSION["account"])): ?>
                    <li><a href="admin/authentification/logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg">Déconnexion</a></li>
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
