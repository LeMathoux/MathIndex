<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https : //fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Admin</title>
    <link href="../assets/styles/Administration.css" rel="stylesheet">
</head>
<?php 
    include_once '../requetes/configdb.php';
    if(!isset($_GET['onglet'])){
        $_GET['onglet'] = 'contributeurs';
    }
?>
<body>
  <nav class="barre-navigation">
    <div class="ensembles-logo">
        <img alt="logo" src="../assets/images/Logo.svg">
        <div class="ensembles-logo-titre ">
          <span class="titre">Math Index</span>
          <span class="sous-titre">Lycée Saint-Vincent -Senlis</span>
        </div>
    </div>
    <div class="navigation">
        <li><a href="../Accueil.php" class="accueil-liens"><img src="../assets/images/icone_home.svg"><strong>Accueil</strong></a></li>
        <li><a href="../Recherche.php" class="recherche-liens"><img src="../assets/images/icone_search_gris.svg">Recherche</a></li>
        <li><a href="../Exercices.php" class="fonctions-liens"><img src="../assets/images/icone_fonctions_gris.svg">Exercices</a></li>
        <?php 
            if(isset($_SESSION["account"]) &&(($_SESSION["account"]['role'] === 'Administrateur') || ($_SESSION["account"]['role'] === 'Contributeur'))){
                echo '<li><a href="../MesExercices.php" class="mesexercices-liens"><img src="../assets/images/icone_liste_gris.svg">Mes exercices</a></li>
                <li><a href="../Soumettre-information_generales.php" class="soumettre-liens"><img src="../assets/images/icone_soumettre_gris.svg">Soumettre</a></li>';
              } 
        ?>
        <div class="deconnexion">
          <?php if(isset($_SESSION["account"])): ?>
            <li><a href="../requetes/logout.php" class="deconnexion-liens"><img src="../assets/images/icone_logout.svg">Déconnexion</a></li>
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
            echo "<a href='../Connexion.php' class='connexion'><img src='../assets/images/icone_login.svg' alt='login'>Connexion</a>";
        }
      ?>
    </div>
    
  </header>
  <div class='grand_conteneur'>
        <div class='menu_arriere'></div>
        <div class="contenu">
            <h1>Administration</h1>  
            <div class="menu-onglets">
                
                <div id="menu-tab"><!----------------tableau-01---------------------------------->
                <div id="page-wrap">
                <div class="tabs"><!----------------onglet-01-contributeurs-------------------------->
                <div class="tab"><input id="tab-1" checked="checked" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'contributeurs'){ echo 'checked';} ?>/> <label for="tab-1">Contributeurs</label>
                <div class="content">
                    
                    <h2>Gestion des contributeurs :</h2>
                    
                    <p>Rechercher un contributeur par nom, prénom, email :</p>
                    
                    <form action="" method="">
                        <input type="text" id="recherche" name="recherche" placeholder="Rechercher :">
                        <button class="button">Rechercher</button>
                        <button class="button2">Ajouter +</button>
                    </form>
                </div>
                </div>
                <!----------------onglet-02-exercices-------------------------->
                <div class="tab" id="tab-exo"><input id="tab-2" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'exercices'){ echo 'checked';} ?>/> <label for="tab-2">Exercices</label>
                <?php
                    $exercices_par_page = 4;
                    $page_exercices = isset($_GET['page_exercice']) ? $_GET['page_exercice'] : 1;
                    $offset = ($page_exercices - 1) * $exercices_par_page;

                    // Requête pour obtenir le nombre total d'exercices
                    $sql_total_exercices = "SELECT COUNT(*) AS total FROM exercise";
                    $result_total_exercices = $conn->query($sql_total_exercices);
                    $row_total_exercices = $result_total_exercices->fetch_assoc();
                    $total_exercices = $row_total_exercices['total'];

                    // Calculer le nombre total de pages
                    $total_pages_exercices = ceil($total_exercices / $exercices_par_page);
                ?>
                    <div class="content">
                        <h2>Gestion des exercices</h2>
                        <p>Rechercher un contributeur par nom, prénom ou email :</p>
                        <div class="recherche_exo">
                            <form action="Admin.php"  method="get">
                                <input type='hidden' name='onglet' value='exercices'>
                                <input type="text" id="recherche" name="recherche">
                                <button type="submit">Rechercher</button>
                            </form>
                            <div class="bouton_ajout">
                                <a href="../Soumettre.php"><p style="color: white;">Ajouter +</p></a>
                            </div> 
                        </div>
                        <table class="tab_exercice">
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
                                        LIMIT $exercices_par_page OFFSET $offset";

                        $result_all_exercices = $conn->query($sql_all_exercices);

                  
                    while ($row = $result_all_exercices->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='nom'><p>" . $row["exercise_name"] . "</p></td>";
                      echo "<td class='thematiques'><p>" . $row["thematic_name"] . "</p></td>";
                      echo "<td class='fichiers_exercices'>";
                      echo "<img src='../assets/images/icone_download.svg'>
                            <a href='../assets/Exercices/" . $row["exercice_original_name"] . "." . $row["extension"] . "' download>Exercice</a>";
                      if ($row["correction_original_name"] && $row["correction_extension"]) {
                        echo "<img src='../assets/images/icone_download.svg'>
                        <a href='../assets/Corrigé/" . $row["correction_original_name"]. "." . $row["correction_extension"] ."' download>Corrigé</a>";
                      }
                      echo "</td>";
                      echo "<td class='actions_exercices'>";
                      echo "<img src='../assets/images/icone_modifier_gris.svg'>
                            <p><a href='../Soumettre.php?info=".$row["exercise_id"]."'>Modifier</a></p>";
                      echo "<img src='../assets/images/icone_poubelle_gris.svg'>";
                      if (isset($_GET['page_exercice'])) {
                        echo "<p><a href='?onglet=exercices&page_exercice=".$_GET['page_exercice']."&action_exercice=delete&id=".$row["exercise_id"]."'>Supprimer</a></p>";
                      }
                      else {
                        echo "<p><a href='?onglet=exercices&action_exercice=delete&id=".$row["exercise_id"]."'>Supprimer</a></p>";
                      }
                      echo "</td>";
                     echo "</tr>";
                    }
                  echo "</table>";
                    ?>  
                    <div class="pagination">
                            <?php
                        if ($page_exercices > 1) {
                            echo "<a href='Admin.php?onglet=exercices&page_exercice=".($page_exercices - 1)."' class='pagination-bouton-gauche'>&lt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-gauche'>&lt;</span>";
                        }

                        for ($i=1; $i<=$total_pages_exercices; $i++) {
                            if ($i == $page_exercices) {
                            echo "<span class='page-actuel'>$i</span>";
                            } else {
                                echo "<a href='Admin.php?onglet=exercices&page_exercice=".$i."' class='pagination-lien'>$i</a>";
                            }
                        }

                        if ($page_exercices < $total_pages_exercices) {
                            echo "<a href='Admin.php?onglet=exercice&page_exercice=".($page_exercices + 1)."' class='pagination-bouton-droite'>&gt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-droite'>&gt;</span>";
                        }
                      
                        ?>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_GET['action_exercice']) && $_GET['action_exercice'] === 'delete') {
                        ?>
                            <div class="confirmation">
                            <div class="contenu_confirmation">
                                <div class="info_confirmation">
                                <div class="fond_image"><img src="../assets/images/icone_valider.svg"></div>
                                <div>
                                    <h2>Confirmez la suppression</h2>
                                    <p>Êtes-vous certain de vouloir supprimer cet exercice ?</p>
                                </div>
                                </div>
                                <?php
                                if (isset($_GET['page_exercice'])) {
                                echo '<a href="?onglet='.$_GET['onglet'].'page_exercice='.$_GET['page_exercice'].'"class="annuler_btn" style="color: black;">Annuler</a>';
                                echo '<a href="?onglet='.$_GET['onglet'].'?page_exercice='.$_GET['page_exercice'].'&confirmed_exercice=true&id='.$_GET['id'].'"class="confirmer_btn" style="color: white;">Confirmer</a>';
                                }
                                else {
                                echo '<a href="./admin.php?onglet=exercices" class="annuler_btn" style="color: black;">Annuler</a>';
                                echo '<a href="?onglet=exercices&confirmed_exercice=true&id='.$_GET['id'].'"class="confirmer_btn" style="color: white;">Confirmer</a>';
                                } 
                                ?>
                            </div>
                            </div>
                        <?php
                        }
                        if (isset($_GET['confirmed_exercice']) && $_GET['confirmed_exercice'] == 'true') {
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
                                  
                                    unlink("../assets/Exercices/".$name_file);
                                    unlink("../assets/Corrige/".$name_file);
                          
                                }
                          
                          
                                $sql_supp = "DELETE FROM exercise WHERE id = $id_exercise";
                                $stmt_supp = $conn->prepare($sql_supp);
                           
                                $stmt_supp->execute();
                                
                                $sql_supp2 = "DELETE FROM file WHERE id=$file_ex OR id=$file_corr ";
                                $stmt_supp2 = $conn->prepare($sql_supp2);
                                $stmt_supp2->execute();
                          
                                if (isset($_GET['page_exercice'])) {
                                  header("Location: ./Admin.php?page_exercice=" . $_GET['page_exercice']);
                              } else {
                                  header("Location: ./Admin.php");
                              }
                            }
                          }
                        ?>
                <!----------------onglet-04-classes-------------------------->
                <div class="tab"><input id="tab-4" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'classes'){ echo 'checked';} ?>/> <label for="tab-4">Classes</label>
                    <div class="content">
                            
                        <h2>Gestion des classes :</h2>
                        <p>Rechercher une classes :</p>
                        <form action="" method="">
                            <input type="text" id="recherche" name="recherche" placeholder="Rechercher :">
                            <button class="button">Rechercher</button>
                            <button class="button2">Ajouter +</button>
                        </form>
                        
                        <p>Une Gestion..!</p>
                        <br /> <iframe src="/" frameborder="0" width="420" height="315" allowfullscreen="allowfullscreen"></iframe>
                    </div>
                </div>
                <!----------------onglet-05-thematiques------------------------->
                <div class="tab"><input id="tab-5" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'thematiques'){ echo 'checked';} ?>/> <label for="tab-5">Thématiques</label>
                    <?php
                        $thematiques_par_page = 4;
                        $page_thematiques = isset($_GET['page_thematiques']) ? $_GET['page_thematiques'] : 1;
                        $offset = ($page_thematiques - 1) * $thematiques_par_page;

                        // Requête pour obtenir le nombre total d'exercices
                        $sql_total_thematiques = "SELECT COUNT(*) AS total FROM thematic";
                        $result_total_thematiques = $conn->query($sql_total_thematiques);
                        $row_total_thematiques = $result_total_thematiques->fetch_assoc();
                        $total_thematiques = $row_total_thematiques['total'];

                        // Calculer le nombre total de pages
                        $total_pages_thematiques = ceil($total_thematiques / $thematiques_par_page);
                    ?>
                    <div class="content">
                        <h2>Gestion des Thematiques</h2>
                        <p>Rechercher une thematique par son nom :</p>
                        <div class="recherche_origines">
                            <form action="Admin.php?onglet=thematiques" method="get">
                                <input type="text" id="recherche" name="recherche">
                                <button type="submit">Rechercher</button>
                            </form>
                            <div class="bouton_ajout">
                                <a href="../Soumettre.php"><p style="color: white;">Ajouter +</p></a>
                            </div> 
                        </div>
                        <table class="tab_exercice">
                            <thead>
                                <td><p>Nom</p></td>
                                <td><p>Matiere</p></td>
                                <td><p>Nombre d'exercices</p></td>
                                <td><p>Actions</p></td>
                            </thead>
                            <?php
                            $sql_all_thematiques = "SELECT id, name FROM thematic LIMIT $thematiques_par_page OFFSET $offset";
                            $result_all_thematiques = $conn->query($sql_all_thematiques);

                  
                            while ($row_thematiques = $result_all_thematiques->fetch_assoc()) {
                                $stmt = $mysqlClient->prepare("SELECT count(*) FROM exercise WHERE thematic_id=:id;");
                                $stmt->bindParam(":id", $row_thematiques["id"]);
                                $stmt->execute();
                                $nb_exercices = $stmt->fetchAll();

                                echo "<tr>";
                                echo "<td class='nom'><p>" . $row_thematiques["name"] . "</p></td>";
                                echo "<td class='nom'><p>Mathematiques</p></td>";
                                echo "<td class='nom'><p>" . $nb_exercices[0][0]. "</p></td>";
                                echo "<td class='actions_exercices'>";
                                echo "<img src='../assets/images/icone_modifier_gris.svg'>
                                        <p><a href=''>Modifier</a></p>";
                                echo "<img src='../assets/images/icone_poubelle_gris.svg'>";
                                if (isset($_GET['page_thematiques'])) {
                                    echo "<p><a href='?page_thematiques=".$_GET['page_thematiques']."&action_thematiques=delete&id=".$row_thematiques["id"]."'>Supprimer</a></p>";
                                }
                                else {
                                    echo "<p><a href='?action_thematiques=delete&id=".$row_thematiques["id"]."'>Supprimer</a></p>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        echo "</table>";
                        ?>
                        <div class="pagination">
                            <?php
                                if ($page_thematiques > 1) {
                                    echo "<a href='Admin.php?onglet=thematiques&page_thematiques=".($page_thematiques - 1)."' class='pagination-bouton-gauche'>&lt;</a>";
                                } else {
                                    echo "<span class='pagination-bouton-gauche'>&lt;</span>";
                                }

                                for ($i=1; $i<=$total_pages_thematiques; $i++) {
                                    if ($i == $page_thematiques) {
                                    echo "<span class='page-actuel'>$i</span>";
                                    } else {
                                        echo "<a href='Admin.php?onglet=thematiques&page_thematiques=".$i."' class='pagination-lien'>$i</a>";
                                    }
                                }

                                if ($page_thematiques < $total_pages_thematiques) {
                                    echo "<a href='Admin.php?onglet=thematiques&page_thematiques=".($page_thematiques + 1)."' class='pagination-bouton-droite'>&gt;</a>";
                                } else {
                                    echo "<span class='pagination-bouton-droite'>&gt;</span>";
                                }
                            ?>
                        </div> 
                    </div>
                </div>
                <!----------------onglet-06-origines-------------------------->
                <div class="tab"><input id="tab-6" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'origines'){ echo 'checked';} ?> /> <label for="tab-6">Origines</label>
                <?php
                    $origines_par_page = 4;
                    $page_origines = isset($_GET['page_origines']) ? $_GET['page_origines'] : 1;
                    $offset = ($page_origines - 1) * $origines_par_page;

                    // Requête pour obtenir le nombre total d'exercices
                    $sql_total_origines = "SELECT COUNT(*) AS total FROM origin";
                    $result_total_origines = $conn->query($sql_total_origines);
                    $row_total_origines = $result_total_origines->fetch_assoc();
                    $total_origines = $row_total_origines['total'];

                    // Calculer le nombre total de pages
                    $total_pages_origines = ceil($total_origines / $origines_par_page);
                ?>
                    <div class="content">
                        <h2>Gestion des origines</h2>
                        <p>Rechercher une origine par son nom :</p>
                        <div class="recherche_origines">
                            <form action="Admin.php" method="get">
                                <input type="text" id="recherche" name="recherche">
                                <button type="submit">Rechercher</button>
                            </form>
                            <div class="bouton_ajout">
                                <a href="../Soumettre.php"><p style="color: white;">Ajouter +</p></a>
                            </div> 
                        </div>
                        <table class="tab_origines">
                            <thead>
                                <td><p>Nom</p></td>
                                <td><p>Actions</p></td>
                            </thead>
                    <?php
                        $sql_all_origines = "SELECT id, name
                                        FROM origin
                                        LIMIT $origines_par_page OFFSET $offset";

                        $result_all_origines = $conn->query($sql_all_origines);

                  
                    while ($row_origines = $result_all_origines->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='nom'><p>" . $row_origines["name"] . "</p></td>";
                      echo "<td class='actions_origines'>";
                      echo "<img src='../assets/images/icone_modifier_gris.svg'>
                            <p><a href=''>Modifier</a></p>";
                      echo "<img src='../assets/images/icone_poubelle_gris.svg'>";
                      if (isset($_GET['page_origines'])) {
                        echo "<p><a href='?page_origines=".$_GET['page_origines']."&action_origines=delete&id=".$row_origines["id"]."'>Supprimer</a></p>";
                      }
                      else {
                        echo "<p><a href='?action_origines=delete&id=".$row_origines["id"]."'>Supprimer</a></p>";
                      }
                      echo "</td>";
                     echo "</tr>";
                    }
                  echo "</table>";
                    ?>  
                    <div class="pagination">
                            <?php
                        if ($page_origines > 1) {
                            echo "<a href='Admin.php?page=".($page_origines - 1)."' class='pagination-bouton-gauche'>&lt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-gauche'>&lt;</span>";
                        }

                        for ($i=1; $i<=$total_pages_origines; $i++) {
                            if ($i == $page_origines) {
                            echo "<span class='page-actuel'>$i</span>";
                            } else {
                                echo "<a href='Admin.php?page=".$i."' class='pagination-lien'>$i</a>";
                            }
                        }

                        if ($page_origines < $total_pages_origines) {
                            echo "<a href='Admin.php?page=".($page_origines + 1)."' class='pagination-bouton-droite'>&gt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-droite'>&gt;</span>";
                        }
                      
                        ?>
                        </div>
                    </div>
                </div>
                <?php
                if (isset($_GET['action_origines']) && $_GET['action_origines'] === 'delete') {
                        ?>
                            <div class="confirmation">
                            <div class="contenu_confirmation">
                                <div class="info_confirmation">
                                <div class="fond_image"><img src="../assets/images/icone_valider.svg"></div>
                                <div>
                                    <h2>Confirmez la suppression</h2>
                                    <p>Êtes-vous certain de vouloir supprimer cette origine ?</p>
                                </div>
                                </div>
                                <?php
                                if (isset($_GET['page_origines'])) {
                                echo '<a href="?page_origines='.$_GET['page_origines'].'"class="annuler_btn" style="color: black;">Annuler</a>';
                                echo '<a href="?page_origines='.$_GET['page_origines'].'&confirmed_origines=true&id='.$_GET['id'].'"class="confirmer_btn" style="color: white;">Confirmer</a>';
                                }
                                else {
                                echo '<a href="./admin.php" class="annuler_btn" style="color: black;">Annuler</a>';
                                echo '<a href="?confirmed_origines=true&id='.$_GET['id'].'"class="confirmer_btn" style="color: white;">Confirmer</a>';
                                } 
                                ?>
                            </div>
                            </div>
                        <?php
                        }
                        if (isset($_GET['confirmed_origines']) && $_GET['confirmed_origines'] == 'true') {
                            $id_origines = $_GET['id'];
                          
                                $sql_supp = "DELETE FROM origin WHERE id = $id_origines";
                                $stmt_supp = $conn->prepare($sql_supp);
                           
                                $stmt_supp->execute();
                          
                                if (isset($_GET['page_origines'])) {
                                  header("Location: ./Admin.php?page=" . $_GET['page_origines']);
                              } else {
                                  header("Location: ./Admin.php");
                              }
                        }
                        ?>
                    




                </div>
                </div>
                </div>
                <p><br /><br /><br /></p>
            
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
    </div>
</body>
</html>
