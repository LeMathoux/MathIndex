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
    session_start();
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
    <button onclick='CachecheMenu()' class='btnFerme'>fermer le menu</button>
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
    <div class="nav_ipad">
      <ul>
        <li><a href="Accueil.php" class="accueil-liens"><img src="../assets/images/icone_home.svg"></a></li>
        <li><a href="Recherche.php" class="recherche-liens"><img src="../assets/images/icone_search_gris.svg"></a></li>
        <li><a href="Exercices.php" class="exercices-liens"><img src="../assets/images/icone_fonctions_gris.svg"></a></li>
      </ul>

      <?php if(isset($_SESSION["account"])): ?>
        <?php if($_SESSION["account"]["role"] == "Administrateur" || $_SESSION["account"]["role"] == "Contributeur"): ?>
          <ul>
            <li><a href="MesExercices.php" class="mesexercices-liens"><img src="../assets/images/icone_liste_gris.svg"></a></li>
            <li><a href="Soumettre.php" class="soumettre-liens"><img src="../assets/images/icone_soumettre_gris.svg"></a></li>
            <div class="deconnexion">
              <li><a href="admin/authentification/logout.php" class="deconnexion-liens"><img src="../assets/images/icone_logout.svg"></a></li>
            </div>
          </ul>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </nav>
  <header>
  <button onclick="AfficheMenu()" class='btn_menu_tel'><img src="../assets/images/Hamburger_icon.png"></button>
    <div class="header-droite">
      <?php
          if (session_status() == PHP_SESSION_NONE) {
          }

          if(isset($_SESSION["account"])){
            $lastname=$_SESSION['account']['last_name'];
            $firstname=$_SESSION['account']['first_name'];
            $role=$_SESSION['account']['role'];
            $profile_picture = isset($_SESSION['account']['profile_photo_file']) ? $_SESSION['account']['profile_photo_file'] : 'chemin/vers/image_par_defaut.jpg';
            echo "<div class='compte'>$lastname $firstname <img src='../assets/photos_de_profil/$profile_picture' alt='photo de profil' class='profil-image'></div>";
        } else {
            echo "<a href='../Connexion.php' class='connexion'><img src='../assets/images/icone_login.svg' alt='login'>Connexion</a>";
        }

        //script d'insertion thematique
        if(isset($_POST['nom_thematique']) && !empty($_POST['nom_thematique']) && $_GET['add_thematique'] === 'true'){
            var_dump($_POST['nom_thematique']);
            $stmt = $mysqlClient->prepare("INSERT INTO thematic(name) VALUES(:name);");
            $stmt->bindParam(":name", $_POST['nom_thematique']);
            $stmt->execute();

            header("location: admin.php?onglet=thematiques");
        }
        //script de modification thematique
        if(isset($_POST['nom_thematique']) && !empty($_POST['nom_thematique']) && $_GET['add_thematique'] === 'modify'){
            $stmt = $mysqlClient->prepare("UPDATE thematic SET name=:name WHERE id=:id");
            $stmt->bindParam(":name", $_POST['nom_thematique']);
            $stmt->bindParam(":id", $_GET['id']);
            $stmt->execute();

            header("location: admin.php?onglet=thematiques");
        }
        //script de recuperation du nom thematique a modifier
        if(isset($_GET['id']) && isset($_GET['add_thematique']) && $_GET['add_thematique'] === 'modify'){
            $stmt = $mysqlClient->prepare("SELECT name FROM thematic WHERE id=:id");
            $stmt->bindParam(":id", $_GET['id']);
            $stmt->execute();
            $thematique = $stmt -> fetchAll();
            $thematique = $thematique[0][0];
        }

        //script d'insertion origine
        if(isset($_POST['nom_origine']) && !empty($_POST['nom_origine']) && $_GET['add_origine'] === 'true'){
            var_dump($_POST['nom_origine']);
            $stmt = $mysqlClient->prepare("INSERT INTO origin(name) VALUES(:name);");
            $stmt->bindParam(":name", $_POST['nom_origine']);
            $stmt->execute();

            header("location: admin.php?onglet=origines");
        }
        //script de modification origine
        if(isset($_POST['nom_origine']) && !empty($_POST['nom_origine']) && $_GET['add_origine'] === 'modify'){
            $stmt = $mysqlClient->prepare("UPDATE origin SET name=:name WHERE id=:id");
            $stmt->bindParam(":name", $_POST['nom_origine']);
            $stmt->bindParam(":id", $_GET['id']);
            $stmt->execute();

            header("location: admin.php?onglet=origines");
        }
        //script de recuperation du nom origine a modifier
        if(isset($_GET['id']) && isset($_GET['add_origine']) && $_GET['add_origine'] === 'modify'){
            $stmt = $mysqlClient->prepare("SELECT name FROM origin WHERE id=:id");
            $stmt->bindParam(":id", $_GET['id']);
            $stmt->execute();
            $origine = $stmt -> fetchAll();
            $origine = $origine[0][0];
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
                <div class="tab"><input id="tab-1" checked="checked" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'contributeurs'){ echo 'checked';} ?>/> <label class='label_onglet' for="tab-1">Contributeurs</label>
                <div class="content">

                    <h2>Gestion des contributeurs :</h2>
                    <p>Rechercher un contributeurs par nom, prénom ou email :</p>
                    <div class="recherche_exo">
                        <form action="Admin.php"  method="Get">
                            <input type='hidden' name='onglet' value=''>
                            <input type="text" id="recherche_contrib" name="recherche_contrib">
                            <button type="submit">Rechercher</button>
                        </form>
                                
                        <div class="bouton_ajout">
                            <a href=""><p style="color: white;">Ajouter +</p></a>
                        </div> 
                    </div>
                    
                    <table class="tab_exercice">
                        <thead>
                            <td><p>Nom</p></td>
                            <td><p>Prénom</p></td>
                            <td><p>Rôle</p></td>
                            <td><p>Email</p></td>
                            <td><p>Actions</p></td>
                        </thead>
                    </table>
                    
                </div>
                </div>
                <!----------------onglet-02-exercices-------------------------->
                <div class="tab" id="tab-exo"><input id="tab-2" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'exercices'){ echo 'checked';} ?>/> <label class='label_onglet' for="tab-2">Exercices</label>
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
                        <p>Rechercher un exercices par son nom ou sa thématique :</p>
                        <div class="recherche_exo">
                            <form action="Admin.php"  method="get">
                                <input type='hidden' name='onglet' value='exercices'>
                                <input type="text" id="recherche_exo" name="recherche_exo"
                                <?php
                                if (isset($_GET["recherche_exo"])) {
                                    echo 'value="'.$_GET["recherche_exo"].'"';
                                }
                                ?>
                                >
                                <button type="submit">Rechercher</button>
                            </form>
                            <?php 
                                if (isset($_GET["recherche_exo"])) {
                                    echo '<a class="annuler_recherche" href="Admin.php?onglet=exercices"><p>X</p></a>';
                                }
                            ?>
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
                        

                if (isset($_GET["recherche_exo"])) {
                    $sql_search_exercices = "SELECT exercise.name AS exercise_name, thematic.name AS thematic_name, file_exercice.original_name AS exercice_original_name, file_exercice.extension, file_correction.original_name AS correction_original_name, file_correction.extension AS correction_extension, exercise.id AS exercise_id
                                        FROM exercise
                                        LEFT JOIN thematic ON exercise.thematic_id = thematic.id
                                        LEFT JOIN file AS file_exercice ON exercise.exercice_file_id = file_exercice.id
                                        LEFT JOIN file AS file_correction ON exercise.correction_file_id = file_correction.id
                                        WHERE exercise.name LIKE '%" . $_GET["recherche_exo"] . "%'
                                        OR thematic.name LIKE '%" . $_GET["recherche_exo"] . "%'
                                        LIMIT " . $exercices_par_page . " OFFSET " . $offset;
                    $result_all_exercices = $conn->query($sql_search_exercices);

                }
                else {
                    $sql_all_exercices = "SELECT exercise.name AS exercise_name, thematic.name AS thematic_name, file_exercice.original_name AS exercice_original_name, file_exercice.extension, file_correction.original_name AS correction_original_name, file_correction.extension AS correction_extension, exercise.id AS exercise_id
                                        FROM exercise
                                        LEFT JOIN thematic ON exercise.thematic_id = thematic.id
                                        LEFT JOIN file AS file_exercice ON exercise.exercice_file_id = file_exercice.id
                                        LEFT JOIN file AS file_correction ON exercise.correction_file_id = file_correction.id
                                        LIMIT $exercices_par_page OFFSET $offset";
                    $result_all_exercices = $conn->query($sql_all_exercices);
                }
                    while ($row = $result_all_exercices->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='nom'><p>" . $row["exercise_name"] . "</p></td>";
                      echo "<td class='thematiques'><p>" . $row["thematic_name"] . "</p></td>";
                      echo "<td class='fichiers_exercices'>";
                      echo "<img src='../assets/images/icone_download.svg'>
                            <a href='../assets/Exercices/" . $row["exercice_original_name"] . "' download>Exercice</a>";
                      if ($row["correction_original_name"] && $row["correction_extension"]) {
                        echo "<img src='../assets/images/icone_download.svg'>
                        <a href='../assets/Corriges/" . $row["correction_original_name"]."' download>Corrigé</a>";
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
                            echo "<a href='Admin.php?onglet=exercices&page_exercice=".($page_exercices + 1)."' class='pagination-bouton-droite'>&gt;</a>";
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
                <!----------------onglet-03-classes-------------------------->
                <div class="tab"><input id="tab-4" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'classes'){ echo 'checked';} ?>/> <label class='label_onglet' for="tab-4">Classes</label>
                    <div class="content">
                            
                        <h2>Gestion des classes :</h2>
                        <p>Rechercher une classes :</p>
                        <form action="" method="">
                            <input type="text" id="recherche" name="recherche" placeholder="Rechercher :">
                            <button class="button">Rechercher</button>
                            <button class="button2">Ajouter +</button>
                        </form>
                        
                       
                    </div>
                </div>
                <!----------------onglet-04-thematiques------------------------->
                <div class="tab" id="tab-thema"><input id="tab-5" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'thematiques'){ echo 'checked';} ?>/> <label class='label_onglet' for="tab-5">Thématiques</label>
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
                    <?php if(isset($_GET['add_thematique'])){ ?>
                        <div class="content">
                            <h1> Ajouter une thematique </h1>
                            <form action='' method='post'>
                                <div>
                                    <label class='label_formu' for='nom_thematique'>Nom de la thematique :<input type='text' name='nom_thematique' id='nom_thematique' value="<?php if(isset($thematique)){echo $thematique;}?>" /></label>
                                </div>
                                <a href='Admin.php?onglet=thematiques'>revenir à la liste</a><input type='submit' />
                            </form>
                        </div>


                    <?php }else{?>
                        <div class="content">
                            <h2>Gestion des Thematiques</h2>
                            <p>Rechercher une thematique par son nom :</p>
                            <div class="recherche_origines">
                            <form action="Admin.php"  method="get">
                                <input type='hidden' name='onglet' value='thematiques'>
                                <input type="text" id="recherche_thema" name="recherche_thema"
                                <?php
                                if (isset($_GET["recherche_thema"])) {
                                    echo 'value="'.$_GET["recherche_thema"].'"';
                                }
                                ?>
                                >
                                <button type="submit">Rechercher</button>
                            </form>
                            <?php 
                                if (isset($_GET["recherche_thema"])) {
                                    echo '<a class="annuler_recherche" href="Admin.php?onglet=thematiques"><p>X</p></a>';
                                }
                            ?>
                                <div class="bouton_ajout">
                                    <a href="Admin.php?onglet=thematiques&add_thematique=true"><p style="color: white;">Ajouter +</p></a>
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

                                if (isset($_GET["recherche_thema"])) {
                                    $sql_search_thematiques = "SELECT id, name FROM thematic
                                                        WHERE name LIKE '%" . $_GET["recherche_thema"] . "%'
                                                        LIMIT $thematiques_par_page OFFSET $offset";
                                    $result_all_thematiques = $conn->query($sql_search_thematiques);
                
                                }
                                else {
                                    $sql_all_thematiques = "SELECT id, name FROM thematic LIMIT $thematiques_par_page OFFSET $offset";
                                    $result_all_thematiques = $conn->query($sql_all_thematiques);
                                }
                    
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
                                            <p><a href='Admin.php?onglet=thematiques&add_thematique=modify&id=".$row_thematiques["id"]."'>Modifier</a></p>";
                                    echo "<img src='../assets/images/icone_poubelle_gris.svg'>";
                                    if (isset($_GET['page_thematiques'])) {
                                        echo "<p><a href='?onglet=thematiques&page_thematiques=".$_GET['page_thematiques']."&action_thematiques=delete&id=".$row_thematiques["id"]."'>Supprimer</a></p>";
                                    }
                                    else {
                                        echo "<p><a href='?onglet=thematiques&action_thematiques=delete&id=".$row_thematiques["id"]."'>Supprimer</a></p>";
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

                    <?php } ?>
                    <?php
                if (isset($_GET['action_thematiques']) && $_GET['action_thematiques'] === 'delete') {
                    // verifiaction si la thematique est utilisée sur des exercice
                    $stmt = $mysqlClient->prepare("SELECT count(*) FROM exercise WHERE thematic_id=:id;");
                    $stmt->bindParam(":id", $_GET['id']);
                    $stmt->execute();
                    $nb_exercices = $stmt->fetchAll();
                    $nb_exercices = $nb_exercices[0][0];

                    if($nb_exercices === "0"){
                    ?>
                    
                    <div class="confirmation">
                    <div class="contenu_confirmation">
                        <div class="info_confirmation">
                        <div class="fond_image"><img src="../assets/images/icone_valider.svg"></div>
                        <div>
                            <h2>Confirmez la suppression</h2>
                            <p>Êtes-vous certain de vouloir supprimer cette thematique ?</p>
                        </div>
                        </div>
                        <?php
                        if (isset($_GET['page_thematiques'])) {
                        echo '<a href="?onglet=thematiques&page_thematiques='.$_GET['page_thematiques'].'"class="annuler_btn" style="color: black;">Annuler</a>';
                        echo '<a href="?onglet=thematiques&page_thematiques='.$_GET['page_thematiques'].'&confirmed_thematique=true&id='.$_GET['id'].'"class="confirmer_btn" style="color: white;">Confirmer</a>';
                        }
                        else {
                        echo '<a href="./Admin.php?onglet=thematiques" class="annuler_btn" style="color: black;">Annuler</a>';
                        echo '<a href="?onglet=thematiques&confirmed_thematique=true&id='.$_GET['id'].'"class="confirmer_btn" style="color: white;">Confirmer</a>';
                        } 
                        ?>
                    </div>
                    </div>
                    <?php
                        }
                        else{
                    ?>
                    <div class="confirmation">
                    <div class="contenu_confirmation">
                        <div class="info_confirmation">
                        <div class="fond_image"><img src="../assets/images/icone_valider.svg"></div>
                        <div>
                            <h2>Suppression impossible</h2>
                            <p>La thematique est utilisée sur au moins un exerice.</p>
                        </div>
                        </div>
                        <?php
                        if (isset($_GET['page_thematiques'])) {
                        echo '<a href="?onglet=thematiques&page_thematiques='.$_GET['page_thematiques'].'"class="annuler_btn" style="color: black;">Annuler</a>';
                        }
                        else {
                        echo '<a href="./Admin.php?onglet=thematiques" class="annuler_btn" style="color: black;">Annuler</a>';
                        } 
                        ?>
                    </div>
                    </div>
                    <?php
                        }
                    }
                    if (isset($_GET['confirmed_thematique']) && $_GET['confirmed_thematique'] == 'true') {
                        $id_thematique = $_GET['id'];
                        $sql_supp = "DELETE FROM thematic WHERE id = $id_thematique";
                        $stmt_supp = $conn->prepare($sql_supp);
                        $stmt_supp->execute();
                        
                    
                        header("Location: Admin.php?onglet=thematiques");
                        
                    }
                    ?> 
                </div>
                <!----------------onglet-05-origines-------------------------->
                <div class="tab" id="tab-ori"><input id="tab-6" name="tab-group-1" type="radio" <?php if( $_GET['onglet'] === 'origines'){ echo 'checked';} ?> /> <label class='label_onglet' for="tab-6">Origines</label>
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
                <?php if(isset($_GET['add_origine'])){ ?>
                        <div class="content">
                            <h1> Ajouter une origine </h1>
                            <form action='' method='post'>
                                <div>
                                    <label class='label_formu' for='nom_origine'>Nom de l'origine :<input type='text' name='nom_origine' id='nom_origine' value="<?php if(isset($origine)){echo $origine;}?>" /></label>
                                </div>
                                <a href='Admin.php?onglet=origines'>revenir à la liste</a><input type='submit' />
                            </form>
                        </div>


                    <?php }else{?>
                    <div class="content">
                        <h2>Gestion des origines</h2>
                        <p>Rechercher une origine par son nom :</p>
                        <div class="recherche_origines">
                        <form action="Admin.php"  method="get">
                                <input type='hidden' name='onglet' value='origines'>
                                <input type="text" id="recherche_thema" name="recherche_origines"
                                <?php
                                if (isset($_GET["recherche_origines"])) {
                                    echo 'value="'.$_GET["recherche_origines"].'"';
                                }
                                ?>
                                >
                                <button type="submit">Rechercher</button>
                            </form>
                            <?php 
                                if (isset($_GET["recherche_origines"])) {
                                    echo '<a class="annuler_recherche" href="Admin.php?onglet=origines"><p>X</p></a>';
                                }
                            ?>
                            <div class="bouton_ajout">
                                <a href="Admin.php?onglet=origines&add_origine=true"><p style="color: white;">Ajouter +</p></a>
                            </div> 
                        </div>
                        <table class="tab_origines">
                            <thead>
                                <td><p>Nom</p></td>
                                <td><p>Actions</p></td>
                            </thead>
                    <?php
                  
                        if (isset($_GET["recherche_origines"])) {
                            $sql_search_origines = "SELECT id, name FROM origin
                                                WHERE name LIKE '%" . $_GET["recherche_origines"] . "%'
                                                LIMIT $origines_par_page OFFSET $offset";
                            $result_all_origines = $conn->query($sql_search_origines);
        
                        }
                        else {
                            $sql_all_origines = "SELECT id, name
                            FROM origin
                            LIMIT $origines_par_page OFFSET $offset";
                            $result_all_origines = $conn->query($sql_all_origines);
                        }

                    while ($row_origines = $result_all_origines->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td class='nom'><p>" . $row_origines["name"] . "</p></td>";
                      echo "<td class='actions_origines'>";
                      echo "<img src='../assets/images/icone_modifier_gris.svg'>
                            <p><a href='Admin.php?onglet=origines&add_origine=modify&id=".$row_origines["id"]."'>Modifier</a></p>";
                      echo "<img src='../assets/images/icone_poubelle_gris.svg'>";
                      if (isset($_GET['page_origines'])) {
                        echo "<p><a href='?page_origines=".$_GET['page_origines']."&action_origines=delete&id=".$row_origines["id"]."'>Supprimer</a></p>";
                      }
                      else {
                        echo "<p><a href='?onglet=origines&action_origines=delete&id=".$row_origines["id"]."'>Supprimer</a></p>";
                      }
                      echo "</td>";
                     echo "</tr>";
                    }
                  echo "</table>";
                    ?>  
                    <div class="pagination">
                            <?php
                        if ($page_origines > 1) {
                            echo "<a href='Admin.php?onglet=origines&page_origines=".($page_origines - 1)."' class='pagination-bouton-gauche'>&lt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-gauche'>&lt;</span>";
                        }

                        for ($i=1; $i<=$total_pages_origines; $i++) {
                            if ($i == $page_origines) {
                            echo "<span class='page-actuel'>$i</span>";
                            } else {
                                echo "<a href='Admin.php?onglet=origines&page_origines=".$i."' class='pagination-lien'>$i</a>";
                            }
                        }

                        if ($page_origines < $total_pages_origines) {
                            echo "<a href='Admin.php?onglet=origines&page_origines=".($page_origines + 1)."' class='pagination-bouton-droite'>&gt;</a>";
                        } else {
                            echo "<span class='pagination-bouton-droite'>&gt;</span>";
                        }
                      
                        ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php
                if (isset($_GET['action_origines']) && $_GET['action_origines'] === 'delete') {
                    $stmt = $mysqlClient->prepare("SELECT count(*) FROM exercise WHERE origin_id=:id;");
                    $stmt->bindParam(":id", $_GET['id']);
                    $stmt->execute();
                    $nb_exercices = $stmt->fetchAll();
                    $nb_exercices = $nb_exercices[0][0];

                    if($nb_exercices === "0"){

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
                        echo '<a href="./Admin.php" class="annuler_btn" style="color: black;">Annuler</a>';
                        echo '<a href="?confirmed_origines=true&id='.$_GET['id'].'"class="confirmer_btn" style="color: white;">Confirmer</a>';
                        } 
                        ?>
                        </div>
                        </div>
                        <?php
                            }
                            else{
                        ?>
                                <div class="confirmation">
                                <div class="contenu_confirmation">
                                    <div class="info_confirmation">
                                    <div class="fond_image"><img src="../assets/images/icone_valider.svg"></div>
                                    <div>
                                        <h2>Suppression impossible</h2>
                                        <p>L'origine est utilisée sur au moins un exerice.</p>
                                    </div>
                                    </div>
                                    <?php
                                    if (isset($_GET['page_origines'])) {
                                    echo '<a href="?onglet=origines&page_origines='.$_GET['page_origines'].'"class="annuler_btn" style="color: black;">Annuler</a>';
                                    }
                                    else {
                                    echo '<a href="./Admin.php?onglet=origines" class="annuler_btn" style="color: black;">Annuler</a>';
                                    } 
                                    ?>
                                </div>
                                </div>
                    <?php
                        }
                    }
                        if (isset($_GET['confirmed_origines']) && $_GET['confirmed_origines'] == 'true') {
                            $id_origines = $_GET['id'];
                            $sql_supp = "DELETE FROM origin WHERE id = $id_origines";
                            $stmt_supp = $conn->prepare($sql_supp);
                            $stmt_supp->execute();
                            
                            header("Location: Admin.php?onglet=origines");
                              
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
