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

if (isset($_GET['confirmed']) && $_GET['confirmed'] == 'true') {
  $id_exercise = $_GET['id'];

  $sql_recup_info = "SELECT exercice_file_id, correction_file_id
                      FROM exercise
                      WHERE id = $id_exercise";
  $stmt = $conn->prepare($sql_recup_info);
  $stmt->execute();
  $result_recup_info = $stmt->get_result();

  if ($result_recup_info->num_rows > 0) {
      $row2 = $result_recup_info->fetch_assoc();
      $file_ex = $row2["exercice_file_id"];
      $file_corr = $row2["correction_file_id"];

      $sql_recup_info2 = "SELECT name, extension
                          FROM file
                          WHERE id = $file_ex
                          OR id = $file_corr";
      $stmt2 = $conn->prepare($sql_recup_info2);
      $stmt2->execute();
      $result_recup_info2 = $stmt2->get_result();

      $row3 = $result_recup_info2->fetch_assoc();
      $name_file = $row3["name"];
      $ext_file = $row3["extension"];
      while ($row3 = $result_recup_info2->fetch_assoc()) {
        
          unlink("assets/Exercices/".$name_file);
          unlink("assets/Corrige/".$name_file);

      }

      $sql_supp = "DELETE FROM exercise WHERE id = $id_exercise";
      $stmt_supp = $conn->prepare($sql_supp);
 
      $stmt_supp->execute();
      
      $sql_supp2 = "DELETE FROM file WHERE id=$file_ex OR id=$file_corr ";
      $stmt_supp2 = $conn->prepare($sql_supp2);
      $stmt_supp2->execute();

      if (isset($_GET['page'])) {
        header("Location: ./MesExercices.php?page=" . $_GET['page']);
    } else {
        header("Location: ./MesExercices.php");
    }
  }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mes exercices</title>
  <link rel="stylesheet" href="assets/styles/MesExercices.css" />
  <script src="requetes/menu_tel.js"></script>
</head>
<body>
  <nav class="barre-navigation hidden">
    <div class="ensembles-logo">
        <img alt="logo" src="assets/images/Logo.svg">
        <div class="ensembles-logo-titre ">
          <span class="titre">Math Index</span>
          <span class="sous-titre">Lycée Saint-Vincent - Senlis</span>
        </div>
    </div>
    <div class="ensembles-logo-ipad">
            <img alt="logo" src="assets/images/Logo.svg">
        </div>
    <button onclick='CachecheMenu()' class='btnFerme'>fermer le menu</button>
    <div class="navigation">
        <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home_gris.svg">Accueil</a></li>
        <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg">Recherche</a></li>
        <li><a href="Exercices.php" class="exercices-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
        <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste.svg">Mes exercices</a></li>
        <li><a href="Soumettre.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>
        <div class="deconnexion">
            <li><a href="requetes/logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg">Déconnexion</a></li>
        </div>
    </div>
    <div class="nav_ipad">
      <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home_gris.svg"></a></li>
      <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg"></a></li>
      <li><a href="Exercices.php" class="exercices-liens"><img src="assets/images/icone_fonctions.svg"></a></li>
      <?php if(isset($_SESSION["account"])): ?>
          <?php if($_SESSION["account"]["role"] == "Administrateur" || $_SESSION["account"]["role"] == "Contributeur"): ?>
              <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg"></a></li>
              <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg"></a></li>
              <div class="deconnexion">
                  <li><a href="admin/authentification/logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg"></a></li>
              </div>
          <?php endif; ?>
      <?php endif; ?>
    </div>
  </nav>
  <header>
    <button onclick="AfficheMenu()" class='btn_menu_tel'><img src="assets/images/Hamburger_icon.png"></button>
    <div class="header-droite">
      <?php
          $lastname=$_SESSION['account']['last_name'];
          $firstname=$_SESSION['account']['first_name'];
          $iduser=$_SESSION['account']['id'];
          $role=$_SESSION['account']['role'];
          $profile_picture = isset($_SESSION['account']['profile_photo_file']) ? $_SESSION['account']['profile_photo_file'] : 'chemin/vers/image_par_defaut.jpg';
         echo "<div class='compte' id='bouton' tabindex='0'>$lastname $firstname <img src='assets/photos_de_profil/$profile_picture' alt='photo de profil' class='profil-image'></div>";
            if($role == "Administrateur" ){
              echo "<div class='cible' id='cible'>";
              echo "<a href='admin/Admin.php'><p>Administration</p><img class='img_admin' src='assets/images/icone-admin.svg'></a>";
              echo "<a href='admin/authentification/logout.php'><p>Déconnexion</p><img class='img_logout' src='assets/images/icone-logout-admin.svg'></a>";
              echo "</div></div>";
            }
      ?>
    </div>
    
  </header>
  <div class='grand_conteneur'>
    <div class='menu_arriere'></div>
    <div class="contenu">
      <h1>Mes Exercices</h1>
      <div class="carre-blanc">
        <?php $sql_no_exercices = "SELECT COUNT(*) AS NbreEx FROM exercise WHERE created_by_id = $iduser";
              $result_no_exercice = $conn->query($sql_no_exercices);
              $row = $result_no_exercice->fetch_assoc();
              $count = $row['NbreEx'];
              if ($count == 0) {
                echo "<tr><td><p>Vous n'avez pas ajouté d'exercices.</p></td></tr>";
              } else { 
                    ?>
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
                              <a href='assets/Exercices/" . $row["exercice_original_name"] . "' download>Exercice</a>";
                        if ($row["correction_original_name"] && $row["correction_extension"]) {
                          echo "<img src='assets/images/icone_download.svg'>
                          <a href='assets/Corrigé/" . $row["correction_original_name"]. "' download>Corrigé</a>";
                        }
                        echo "</td>";
                        echo "<td class='actions'>";
                        echo "<div class='uneAction'><img src='assets/images/icone_modifier_gris.svg'>
                              <a href='Soumettre.php?info=".$row["exercise_id"]."'>Modifier</a></div>";
                        echo "<div class='uneAction'><img src='assets/images/icone_poubelle_gris.svg'>";
                        if (isset($_GET['page'])) {
                          echo "<a href='?page=".$_GET['page']."&action=delete&id=".$row["exercise_id"]."'>Supprimer</a></div>";
                        }
                        else {
                          echo "<a href='?action=delete&id=".$row["exercise_id"]."'>Supprimer</a></div>";
                        }
                        echo "</td>";
                      echo "</tr>";
                      }
                    } 
                    echo "</table>";         
            }
          if ($count != 0) { 
          ?>
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
          <?php } ?>
      </div>
      <div class="mentionlegales">
        <div class="mentionlegales-text">Mentions légales</div>
        <div class="mentionlegales-text">•</div>
        <div class="mentionlegales-text">Contact</div>
        <div class="mentionlegales-text">•</div>
        <div class="mentionlegales-text">Lycée Saint-Vincent</div>
      </div>
      <?php
      if (isset($_GET['action']) && $_GET['action'] === 'delete') {
        ?>
          <div class="confirmation">
            <div class="contenu_confirmation">
              <div class="info_confirmation">
                <div class="fond_image"><img src="assets/images/icone_valider.svg"></div>
                <div>
                  <h2>Confirmez la suppression</h2>
                  <p>Êtes-vous certain de vouloir supprimer cet exercice ?</p>
                </div>
              </div>
              <?php
              if (isset($_GET['page'])) {
                echo '<a href="?page='.$_GET['page'].'"class="annuler_btn">Annuler</a>';
                echo '<a href="?page='.$_GET['page'].'&confirmed=true&id='.$_GET['id'].'"class="confirmer_btn">Confirmer</a>';
              }
              else {
                echo '<a href="./MesExercices.php" class="annuler_btn">Annuler</a>';
                echo '<a href="?confirmed=true&id='.$_GET['id'].'"class="confirmer_btn">Confirmer</a>';
              } 
              ?>
            </div>
          </div>
      <?php
      }
      ?>
    </div>
  </div>
</body>
</html>
