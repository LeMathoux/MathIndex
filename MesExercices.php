<?php
include_once 'requetes/configdb.php';
session_start();
if(!isset($_SESSION['account']['id'])){
  header("Location: Connexion.php");
  exit(); 
}
$exercices_par_page = 7;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $exercices_par_page;

// Sécuriser l'ID de l'utilisateur connecté
$id = isset($_SESSION['account']['id']) ? intval($_SESSION['account']['id']) : 0;

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
  <title>Accueil</title>
  <link rel="stylesheet" href="assets/styles/MesExercices.css" />
</head>
<body>
  <nav class="barre-navigation">
    <div class="ensembles-logo">
        <img alt="logo" src="assets/images/Logo.svg">
        <div class="ensembles-logo-titre ">
          <span class="titre">Math Index</span>
          <span class="sous-titre">Lycée Saint-Vincent - Senlis</span>
        </div>
    </div>
    <div class="navigation">
        <li><a href="Accueil.php" class="fonctions-liens"><img src="assets/images/icone_home.svg">Accueil</a></li>
        <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg">Recherche</a></li>
        <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
        <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
        <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>
        <div class="deconnexion">
            <li><a href="logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg">Déconnexion</a></li>
        </div>
    </div>
  </nav>
  <header>
    <div class="header-droite">
      <?php
          $lastname=$_SESSION['account']['last_name'];
          $firstname=$_SESSION['account']['first_name'];
          $iduser=$_SESSION['account']['id'];
          $profile_picture = isset($_SESSION['account']['profile_photo_file']) ? $_SESSION['account']['profile_photo_file'] : 'chemin/vers/image_par_defaut.jpg';
          echo "<div class='compte'>$lastname $firstname <img src='assets/photos de profil/$profile_picture' alt='photo de profil' class='profil-image'></div>";
      ?>
    </div>
    
  </header>
  <div class="contenu">
    <h1>Mes Exercices</h1>
    <div class="carre-blanc">
        <h2>Vous pouvez modifier ou supprimer un de vos excercices</h2>
        <table>
            <thead>
                <td><p>Nom</p></td>
                <td><p>Thématiques</p></td>
                <td><p>Fichiers</p></td>
                <td><p>Actions</p></td>
            </thead>
            <?php
            $sql_all_exercices = "SELECT exercise.name AS exercise_name, thematic.name AS thematic_name, file_exercice.original_name AS exercice_original_name, file_exercice.extension, file_correction.original_name AS correction_original_name, file_correction.extension AS correction_extension, exercise.id AS exercise_id
                                  FROM exercise
                                  LEFT JOIN thematic ON exercise.thematic_id = thematic.id
                                  LEFT JOIN file AS file_exercice ON exercise.exercice_file_id = file_exercice.id
                                  LEFT JOIN file AS file_correction ON exercise.correction_file_id = file_correction.id
                                  WHERE created_by_id = $iduser
                                  LIMIT $exercices_par_page OFFSET $offset";

            $result_all_exercices = $conn->query($sql_all_exercices);

            if ($result_all_exercices->num_rows > 0) {
              while ($row = $result_all_exercices->fetch_assoc()) {
                echo "<tr>";
                echo "<td class='nom'><p>" . $row["exercise_name"] . "</p></td>";
                echo "<td class='thematiques'><p>" . $row["thematic_name"] . "</p></td>";
                echo "<td class='fichiers'>";
                echo "<img src='assets/images/icone_download.svg'>
                      <a href='assets/Exercices/" . $row["exercice_original_name"] . "." . $row["extension"] . "' download>Exercice</a>";
                if ($row["correction_original_name"] && $row["correction_extension"]) {
                  echo "<img src='assets/images/icone_download.svg'>
                        <a href='assets/Corrigé/" . $row["correction_original_name"]. "." . $row["correction_extension"] ."' download>Corrigé</a>";
                }
                echo "</td>";
                echo "<td class='actions'>";
                echo "<img src='assets/images/icone_modifier_gris.svg'>
                      <p><a href=''>Modifier</a></p>";
                echo "<img src='assets/images/icone_poubelle_gris.svg'>
                      <p><a href=''>Supprimer</a></p>";
                echo "</td>";
                echo "</tr>";
              }
            } 
            $sql_no_exercices = "SELECT COUNT(*) AS NbreEx FROM exercise WHERE created_by_id = $iduser";
            $result_no_exercice = $conn->query($sql_no_exercices);
            if ($result_no_exercice = 0) {
              echo "<p>Vous n'avez pas ajouté d'exercices.</p>";
            }
            ?>
        </table>
        <?php echo $result_no_exercice; ?>
        <div class="pagination">
                    <?php
                        if ($page > 1) {
                            echo "<a href='MesExercices.php?page=".($page - 1)."' class='pagination-bouton-gauche'>&lt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-gauche'>&lt;</span>";
                        }

                        for ($i=1; $i<=$total_pages; $i++) {
                            if ($i == $page) {
                                echo "<span class='page-actuel'>$i</span>";
                            } else {
                                echo "<a href='MesExercices.php?page=".$i."' class='pagination-lien'>$i</a>";
                            }
                        }

                        if ($page < $total_pages) {
                            echo "<a href='MesExercices.php?page=".($page + 1)."' class='pagination-bouton-droite'>&gt;</a>";
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

</body>
</html>
