<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href='assets/styles/Soumettre.css' rel="stylesheet" />
  <script src="requetes/menu_tel.js"></script>
  <title>Soumettre</title>
</head>
<script>
  function getfile(){
    document.getElementById('hiddenfile').click();
  }
  function getvalue(){
    document.getElementById('selectedfile').value=document.getElementById('hiddenfile').value;
  }
  function getfile2(){
    document.getElementById('hiddenfile2').click();
  }
  function getvalue2(){
    document.getElementById('selectedfile2').value=document.getElementById('hiddenfile2').value;
  }
</script>
<?php
include_once("requetes/configdb.php");

if (!isset($_SESSION['stockage'])){
  $_SESSION['stockage'] = array();
  $_SESSION['stockage']['mode'] = 'ajout';
}
if(isset($_GET['info']) && !isset($_SESSION['stockage'])){
  $_SESSION['stockage']['mode'] = 'modification';

  $stmt = $mysqlClient->prepare("SELECT * FROM exercise WHERE id=:id;");
  $stmt->bindParam(":id", $_GET['info']);
  $stmt->execute();
  $informations = $stmt->fetchAll();
  

  $stmt = $mysqlClient->prepare("SELECT * FROM file WHERE id=:id;");
  $stmt->bindParam(":id", $informations[0]['correction_file_id']);
  $stmt->execute();
  $correction_infos = $stmt->fetchAll();

  $stmt = $mysqlClient->prepare("SELECT * FROM file WHERE id=:id;");
  $stmt->bindParam(":id", $informations[0]['exercice_file_id']);
  $stmt->execute();
  $exercice_infos = $stmt->fetchAll();

  $stmt = $mysqlClient->prepare("SELECT * FROM origin WHERE id=:id;");
  $stmt->bindParam(":id", $informations[0]['origin_id']);
  $stmt->execute();
  $origin_infos = $stmt->fetchAll();

  $stmt = $mysqlClient->prepare("SELECT * FROM thematic WHERE id=:id;");
  $stmt->bindParam(":id", $informations[0]['thematic_id']);
  $stmt->execute();
  $thematic_infos = $stmt->fetchAll();

  $stmt = $mysqlClient->prepare("SELECT * FROM classroom WHERE id=:id;");
  $stmt->bindParam(":id", $informations[0]['classroom_id']);
  $stmt->execute();
  $classroom_infos = $stmt->fetchAll();

  
  switch($informations[0]['difficulty']){
    case '1': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 1';
      break;

    case '2': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 2';
      break;


    case '3': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 3';
      break;


    case '4': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 4';
      break;

    case '5': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 5';
      break;

    case '6': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 6';
      break;

    case '7': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 7';
      break;

    case '8': 
      $_SESSION['stockage']['difficulte'] = 'Niveau 8';
      break;
  }
  
  
  $_SESSION['stockage']['name'] = $informations[0]['name'];
  $_SESSION['stockage']['durée'] = $informations[0]['duration'];
  $_SESSION['stockage']['chapitre'] = "'".$informations[0]['chapter']."'";
  $_SESSION['stockage']['information_sup']=$informations[0]['origin_information'];
  $_SESSION['stockage']['thematique']=$thematic_infos[0]['name'];
  $_SESSION['stockage']['origine']=$origin_infos[0]['name'];
  $_SESSION['stockage']['mots_clés'] = "'".$informations[0]['keywords']."'";
  $_SESSION['stockage']['Nom_source'] = "'".$origin_infos[0]['name']."'";
  $_SESSION['stockage']['classe'] = $classroom_infos[0]['name'];
  $_SESSION['stockage']['exercice'] = $exercice_infos[0]['original_name'];
  $_SESSION['stockage']['corrige'] = $correction_infos[0]['original_name'];
}

$_POST['suivant1'] = "none";
$_POST['suivant2'] = "none";

if(!empty($_POST['name']) && !empty($_POST['classe']) && !empty($_POST['difficulte']) && !empty($_POST['thematique']) && !empty($_POST['chapitre'])){
  $_POST['suivant1'] = "true";
  $_SESSION['stockage']['name'] = $_POST['name'];
  $_SESSION['stockage']['classe'] = $_POST['classe'];
  $_SESSION['stockage']['mots_clés'] = $_POST['mots_clés'];
  $_SESSION['stockage']['durée'] = $_POST['durée'];
  $_SESSION['stockage']['difficulte'] = $_POST['difficulte'];
  $_SESSION['stockage']['thematique'] =$_POST['thematique'];
  $_SESSION['stockage']['chapitre'] = $_POST['chapitre'];
  var_dump($_SESSION['stockage']);
}

if(!empty($_POST['origine']) && !empty($_POST['Nom_source']) && !empty($_POST['information_sup'])){
  var_dump('yes');
  $_POST['suivant2'] = "true";
  $_POST['suivant1'] = "none";
  $_SESSION['stockage']['origine']=$_POST['origine'];
  $_SESSION['stockage']['Nom_source']=$_POST['Nom_source'];
  $_SESSION['stockage']['information_sup']=$_POST['information_sup'];
  var_dump($_SESSION['stockage']);
}

if(!empty($_POST['corrige']) && !empty($_POST['exercice']) && !empty($_POST['NewNameExercice']) && !empty($_POST['NewNameCorrige'])){
  $_POST['suivant2'] = "true";
  $_POST['suivant1'] = "none";
  $_SESSION['stockage']['exercice']=$_POST['exercice'];
  $_SESSION['stockage']['corrige']=$_POST['corrige'];
  var_dump($_SESSION['stockage']);
}


$sql_no_exercices = "SELECT name FROM classroom";
$result_no_exercice = $conn->query($sql_no_exercices);
$listeclasses = $result_no_exercice->fetch_all();


$sql_no_exercices = "SELECT name FROM thematic";
$result_no_exercice = $conn->query($sql_no_exercices);
$listethematiques = $result_no_exercice->fetch_all();

$sql_no_exercices = "SELECT name FROM origin";
$result_no_exercice = $conn->query($sql_no_exercices);
$listeorigines = $result_no_exercice->fetch_all();

if(!empty($_SESSION['stockage']['origine']) && !empty($_SESSION['stockage']['Nom_source']) && !empty($_SESSION['stockage']['name']) && !empty($_SESSION['stockage']['classe']) && !empty($_SESSION['stockage']['difficulte']) && !empty($_SESSION['stockage']['thematique']) && !empty($_SESSION['stockage']['chapitre']) && !empty($_FILES['exercice']) && !empty($_FILES['corrige'])){

  if(!empty($_FILES)){
    $_SESSION['stockage']['NameExercice']= $_POST['NewNameExercice'];
    $_SESSION['stockage']['NameCorrige']= $_POST['NewNameCorrige'];
    $uploads_dir = './assets/Corriges';
    $tmp_name = $_FILES["corrige"]["tmp_name"];
    $name = basename($_FILES["corrige"]["name"]);
    move_uploaded_file($tmp_name, "$uploads_dir/$name");

    $uploads_dir = './assets/Exercices';
    $tmp_name = $_FILES["exercice"]["tmp_name"];
    $name = basename($_FILES["exercice"]["name"]);
    move_uploaded_file($tmp_name, "$uploads_dir/$name");
  }
  $stmt = $mysqlClient->prepare("SELECT id FROM classroom WHERE name=:name;");
  $stmt->bindParam(":name", $_SESSION['stockage']['classe']);
  $stmt->execute();
  $id_classe = $stmt->fetchAll();

  $id_utilisateur = $_SESSION['account']['id'];

  $stmt = $mysqlClient->prepare("SELECT id FROM thematic WHERE name=:name1;");
  $stmt->bindParam(":name1", $_SESSION['stockage']['thematique']);
  $stmt->execute();
  $id_thematique = $stmt->fetchAll();

  switch($_SESSION['stockage']['difficulte']){
    case 'Niveau 1': 
      $num_difficulte = 1;
      break;

    case 'Niveau 2':
      $num_difficulte = 2;
      break;

    case 'Niveau 3':
      $num_difficulte = 3;
      break;

    case 'Niveau 4':
      $num_difficulte = 4;
      break;

    case 'Niveau 5': 
      $num_difficulte = 5;
      break;

    case 'Niveau 6':
      $num_difficulte = 6;
      break;

    case 'Niveau 7':
      $num_difficulte = 7;
      break;

    case 'Niveau 8':
      $num_difficulte = 8;
      break;  
  }

  $stmt = $mysqlClient->prepare("SELECT id FROM origin WHERE name=:name2;");
  $stmt->bindParam(":name2", $_SESSION['stockage']['origine']);
  $stmt->execute();
  $id_origine = $stmt->fetchAll();
  var_dump($id_origine);
  
  $stmt = $mysqlClient->prepare("SELECT id FROM file WHERE original_name=:name_ori or name=:name_ori;");
  $stmt->bindParam(":name_ori", $_FILES['exercice']['name']);
  $stmt->execute();
  $elements = $stmt->fetchAll();

  if(empty($elements)){
    $stmt = $mysqlClient->prepare("INSERT INTO file (name, original_name, extension, size) VALUES(:name, :original_name, :extension, :size);");
    $stmt->bindParam(":name", $_SESSION['stockage']['NameExercice']);
    $stmt->bindParam(":original_name", $_FILES['exercice']['name']);
    $stmt->bindParam(":extension", $_FILES['exercice']['type']);
    $stmt->bindParam(":size", $_FILES['exercice']['size']);
    $stmt->execute();

    $stmt = $mysqlClient->prepare("SELECT id FROM file WHERE original_name=:name_ori or name=:name_ori;");
    $stmt->bindParam(":name_ori", $_FILES['exercice']['name']);
    $stmt->execute();
    $elements = $stmt;
  }
  $exercice_id = $elements;

  $stmt = $mysqlClient->prepare("SELECT id FROM file WHERE original_name=:name_ori or name=:name_ori;");
  $stmt->bindParam(":name_ori", $_FILES['exercice']['name']);
  $stmt->execute();
  $elements = $stmt->fetchAll();

  if(empty($elements)){
    $stmt = $mysqlClient->prepare("INSERT INTO file (name, original_name, extension, size) VALUES(:name, :original_name, :extension, :size);");
    $stmt->bindParam(":name", $_SESSION['stockage']['NameCorrige']);
    $stmt->bindParam(":original_name", $_FILES['corrige']['name']);
    $stmt->bindParam(":extension", $_FILES['corrige']['type']);
    $stmt->bindParam(":size", $_FILES['corrige']['size']);
    $stmt->execute();

    $stmt = $mysqlClient->prepare("SELECT id FROM file WHERE original_name=:name_ori or name=:name_ori;");
    $stmt->bindParam(":name_ori", $_FILES['corrige']['name']);
    $stmt->execute();
    $elements = $stmt->fetchAll();
  }
  $correction_id = $elements;

  if($_SESSION['stockage']['mode'] === 'ajout'){

    $id_classe = intval($id_classe[0][0]);
    $id_origine = intval($id_origine[0][0]);
    $correction_id = intval($correction_id[0][0]);
    $exercice_id = intval($exercice_id[0][0]);
    $id_thematique = intval($id_thematique[0][0]);
    $date=date("Y-n-j");
    $stmt = $mysqlClient->prepare("INSERT INTO exercise (name, classroom_id, thematic_id, chapter, keywords,difficulty, duration, origin_id, exercice_file_id, correction_file_id, origin_information, created_by_id, date) VALUES(:name, :classroom_id, :thematic_id, :chapter, :keywords, :difficulty, :duration, :origin_id, :exercice_file_id, :correction_file_id, :origin_information, :created_by_id, :date); ");
    $stmt->bindParam(":name", $_SESSION['stockage']['name']);
    $stmt->bindParam(":classroom_id", $id_classe);
    $stmt->bindParam(":thematic_id", $id_thematique);
    $stmt->bindParam(":chapter", $_SESSION['stockage']['chapitre']);
    $stmt->bindParam(":keywords", $_SESSION['stockage']['mots_clés']);
    $stmt->bindParam(":difficulty", $num_difficulte);
    $stmt->bindParam(":duration", $_SESSION['stockage']['durée']);
    $stmt->bindParam(":origin_id", $id_origine);
    $stmt->bindParam(":exercice_file_id", $exercice_id);
    $stmt->bindParam(":correction_file_id", $correction_id);
    $stmt->bindParam(":origin_information", $_SESSION['stockage']['information_sup']);
    $stmt->bindParam(":created_by_id", $_SESSION['account']['id']);
    $stmt->bindParam(":date", $date);
    $stmt->execute();

  }
  if($_SESSION['stockage']['mode'] === 'modification'){

    var_dump($_SESSION['stockage']);

    $id_classe = intval($id_classe[0][0]);
    $id_origine = intval($id_origine[0][0]);
    $correction_id = intval($correction_id[0][0]);
    $exercice_id = intval($exercice_id[0][0]);
    $id_thematique = intval($id_thematique[0][0]);
    $date=date("Y-n-j");
    $stmt = $mysqlClient->prepare("UPDATE exercise SET name=:name, classroom_id=:classroom_id, thematic_id=:thematic_id, chapter=:chapter, keywords=:keywords, difficulty=:difficulty, duration=:duration, origin_id=:origin_id, exercice_file_id=:exercice_file_id, correction_file_id=:correction_file_id, origin_information=:origin_information, created_by_id=:created_by_id, date=:date WHERE id=:id;");
    $stmt->bindParam(":name", $_SESSION['stockage']['name']);
    $stmt->bindParam(":classroom_id", $id_classe);
    $stmt->bindParam(":thematic_id", $id_thematique);
    $stmt->bindParam(":chapter", $_SESSION['stockage']['chapitre']);
    $stmt->bindParam(":keywords", $_SESSION['stockage']['mots_clés']);
    $stmt->bindParam(":difficulty", $num_difficulte);
    $stmt->bindParam(":duration", $_SESSION['stockage']['durée']);
    $stmt->bindParam(":origin_id", $id_origine);
    $stmt->bindParam(":exercice_file_id", $exercice_id);
    $stmt->bindParam(":correction_file_id", $correction_id);
    $stmt->bindParam(":origin_information", $_SESSION['stockage']['information_sup']);
    $stmt->bindParam(":created_by_id", $_SESSION['account']['id']);
    $stmt->bindParam(":date", $date);
    
    $id_exo = intval($_GET['info']);
    $stmt->bindParam(":id", $id_exo);

    $stmt->execute();

  }
  ///detruit la session de stockage des valeurs.
  $_SESSION['stockage'] = [];
}
?>
<body>
  <nav class="barre-navigation hidden">
    <div class="ensembles-logo">
        <img alt="logo" src="assets/images/Logo.svg">
        <div class="ensembles-logo-titre ">
          <span class="titre">Math Index</span>
          <span class="sous-titre">Lycée Saint-Vincent -Senlis</span>
        </div>
    </div>
    <div class="ensembles-logo-ipad">
        <img alt="logo" src="assets/images/Logo.svg">
    </div>
    <button onclick='CachecheMenu()' class='btnFerme'>fermer le menu</button>
    <div class="navigation">
        <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home_gris.svg"><strong>Accueil</strong></a></li>
        <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg">Recherche</a></li>
        <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>

        <?php if(isset($_SESSION["account"])): ?>
          <?php if($_SESSION["account"]["role"] == "Administrateur" || $_SESSION["account"]["role"] == "Contributeur"): ?>
            <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
            <li><a href="Soumettre.php" class="soumettre-liens"><img src="assets/images/icone_soumettre.svg">Soumettre</a></li>
            <?php endif; ?>
            <div class="deconnexion">
              <li><a href="admin/authentification/logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg">Déconnexion</a></li>
            </div>
        <?php endif; ?>
    </div>
    <div class="nav_ipad">
      <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home.svg"></a></li>
      <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg"></a></li>
      <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg"></a></li>

      <?php if(isset($_SESSION["account"])): ?>
        <?php if($_SESSION["account"]["role"] == "Administrateur" || $_SESSION["account"]["role"] == "Contributeur"): ?>
          <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg"></a></li>
          <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg"></a></li>
          <?php endif; ?>
          <div class="deconnexion">
            <li><a href="admin/authentification/logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg"></a></li>
          </div>
      <?php endif; ?>
    </div>
  </nav>
  <header>
    <button onclick="AfficheMenu()" class='btn_menu_tel'><img src="assets/images/Hamburger_icon.png"></button>
    <div class="header-droite">
      <?php
          if (session_status() == PHP_SESSION_NONE) {
          }

          if(isset($_SESSION["account"])){
            $lastname=$_SESSION['account']['last_name'];
            $firstname=$_SESSION['account']['first_name'];
            $role=$_SESSION['account']['role'];
            $profile_picture = isset($_SESSION['account']['profile_photo_file']) ? $_SESSION['account']['profile_photo_file'] : 'chemin/vers/image_par_defaut.jpg';
            echo "<div class='compte'>$lastname $firstname <img src='assets/photos_de_profil/$profile_picture' alt='photo de profil' class='profil-image'></div>";
        } else {
            echo "<a href='Connexion.php' class='connexion'><img src='assets/images/icone_login.svg' alt='login'>Connexion</a>";
        }
      ?>
    </div>
    
  </header>
  <div class='grand_conteneur'>
    <div class='menu_arriere'></div>
    <div class="contenu">
        <h1>Soumettre Exercice</h1>
        <div class="menu-onglets">
                
            <div id="menu-tab"><!----------------tableau-01---------------------------------->
            <div id="page-wrap">
            <div class="tabs"><!----------------onglet-01-accueil-------------------------->
            <div class="tab"><input id="tab-1" checked name="tab-group-1" type="radio" /> <label class='label1' for="tab-1">Informations generales</label>
                <div class="content">
                    <h1>Informations générales</h1>
                    <form method='post' name='informations Generales'>
                      <div class='ligne'>
                        <label name='name'> Nom de l'exercice*: <input class="inputTexte" type='text' name='name' value=<?php if(isset($_SESSION['stockage']['name'])){echo "'".$_SESSION['stockage']['name']."'";}?>></input></label>
                        <label name='mots_clés'> Mots clés: <input class="inputTexte" type='text' name='mots_clés' value=<?php if(isset($_SESSION['stockage']['mots_clés'])){echo "'".$_SESSION['stockage']['mots_clés']."'";}?>></input></label>
                      </div>
                      <div class='ligne'>
                        <label name='classe'> Classe*: 
                            <select name="classe" id="classe">
                              <?php
                              for($i=0; $i < count($listeclasses); $i++){
                                $element = "'".$listeclasses[$i][0]."'";
                              ?>
                                <option value=<?php echo $element; ?> <?= isset($_SESSION['stockage']['classe']) && $_SESSION['stockage']['classe'] === $element ? 'selected' : '' ?>><?php echo $listeclasses[$i][0]; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                        </label>
                        <label name='difficulte'> Difficulté*:
                          <select name="difficulte" id="difficulte">
                            <option value="Niveau 1" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 1" ? 'selected' : '' ?>>Niveau 1</option>
                            <option value="Niveau 2" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 2" ? 'selected' : '' ?>>Niveau 2</option>
                            <option value="Niveau 3" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 3" ? 'selected' : '' ?>>Niveau 3</option>
                            <option value="Niveau 4" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 4" ? 'selected' : '' ?>>Niveau 4</option>
                            <option value="Niveau 5" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 5" ? 'selected' : '' ?>>Niveau 5</option>
                            <option value="Niveau 6" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 6" ? 'selected' : '' ?>>Niveau 6</option>
                            <option value="Niveau 7" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 7" ? 'selected' : '' ?>>Niveau 7</option>
                            <option value="Niveau 8" <?= isset($_SESSION['stockage']['difficulte']) && $_SESSION['stockage']['difficulte'] === "Niveau 8" ? 'selected' : '' ?>>Niveau 8</option>
                          </select>
                        </label>
                      </div>
                      <div class='ligne'>
                        <label name='thematique'> Thematique*: 
                          <select name="thematique" id="thematique">
                          <?php
                              for($i=0; $i < count($listethematiques); $i++){
                                $element = "'".$listethematiques[$i][0]."'";
                              ?>
                                <option value=<?php echo $element; ?> <?= isset($_SESSION['stockage']['thematique']) && $_SESSION['stockage']['thematique'] === $element ? 'selected' : '' ?>><?php echo $listethematiques[$i][0]; ?></option>
                              <?php
                              }
                              ?>
                          </select>
                        </label>
                        <label name='durée'> Durée(en heure): <input class="inputTexte" type='text' name='durée' value=<?php if(isset($_SESSION['stockage']['durée'])){echo $_SESSION['stockage']['durée'];}?>></input></label>
                      </div>
                      <div class='ligne'>
                        <label name='chapitre'> Chapitre du cours* : <input class="inputTexte" type='text' name='chapitre' value=<?php if(isset($_SESSION['stockage']['chapitre'])){echo "'".$_SESSION['stockage']['chapitre']."'";}?>></input></label>
                      </div>
                      <input type='submit' value='Continuer'></input>
                    </form>
                </div>
            </div>
            <!----------------onglet-02-articles-------------------------->
            <div class="tab"><input id="tab-2" name="tab-group-1" type="radio" <?php if($_POST['suivant1'] === "true"){echo 'checked';}?> /> <label class='label1' for="tab-2">Sources</label>
                <div class="content">
                  <h1>Sources</h1>
                  <form method='post' name='Sources'>
                      <div class='ligne'>
                        <label name='origine'> Origine*: 
                          <select name="origine" id="origine">
                            <?php
                            for($i=0; $i < count($listeorigines); $i++){
                              $element = "'".$listeorigines[$i][0]."'";
                            ?>
                              <option value=<?php echo $element; ?> <?= isset($_SESSION['stockage']['origine']) && $_SESSION['stockage']['origine'] === $element ? 'selected' : '' ?>><?php echo $listeorigines[$i][0]; ?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </label>
                      </div>
                      <div class='ligne'>
                        <label name='Nom_source'> Nom de la source/lien du site*: <input class="inputTexte" type='text' name='Nom_source' value=<?php if(isset($_SESSION['stockage']['Nom_source'])){echo $_SESSION['stockage']['Nom_source'];}?>></input></label>
                      </div>
                      <div class='ligne'>
                        <label name='information_sup'> Informations complémentaires: <textarea name='information_sup'><?php if(isset($_SESSION['stockage']['information_sup'])){echo $_SESSION['stockage']['information_sup'];}?></textarea></label>
                      </div>
                      <input type='submit' value='Continuer'></input>
                    </form>
                </div>
            </div>
            <!----------------onglet-04-libre-------------------------->
            <div class="tab"><input id="tab-4" name="tab-group-1" type="radio" <?php if($_POST['suivant2'] === "true"){echo 'checked';}?>/> <label class='label1' for="tab-4">Fichiers</label>
                <div class="content">
                  <h1>Fichiers</h1>
                  <form enctype="multipart/form-data" method='post' name='Fichiers'>
                      <div class='ligne'>
                        <label name='exercice'> Fiche exercice(PDF, word)*:
                          <div class='file'>
                            <input type="file" id="hiddenfile" class="label-upload" style="display:none" name="exercice" onChange="getvalue();"/>
                            <input class="leFichier" type="text" id="selectedfile" name='NewNameExercice' value=<?= !empty($_SESSION['stockage']['exercice']) === true ? $_SESSION['stockage']['exercice'] : "Sélectionner un fichier à télécharger"?>/>
                            <input class='bouton-upload' type="button" onclick="getfile();"/>
                          </div>
                        </label>
                      </div>
                      <div class='ligne'>
                        <label name='corrige'> Fiche corrigé(PDF, word)*: 
                          <div class='file'>
                              <input type="file" id="hiddenfile2" class="label-upload" style="display:none" name="corrige" onChange="getvalue2();"/>
                              <input class="leFichier" type="text" id="selectedfile2"  name='NewNameCorrige' value=<?= !empty($_SESSION['stockage']['corrige']) === true ? $_SESSION['stockage']['corrige'] : "Sélectionner un fichier à télécharger"?>/>
                              <input class='bouton-upload' type="button" onclick="getfile2();"/>
                            </div>
                        </label>
                      </div>
                      <input type='submit' value='Continuer'></input>
                    </form>
                </div>
            </div>
        </div>
        <p><br /><br /><br /></p>
      <div class="mentionlegales">
        <div class="mentionlegales-text">Mentions légales</div>
        <div class="mentionlegales-text">•</div>
        <div class="mentionlegales-text">Contact</div>
        <div class="mentionlegales-text">•</div>
        <div class="mentionlegales-text">Lycée Saint-Vincent</div>
      </div>
    </div>
  </div>
</body>
</html>