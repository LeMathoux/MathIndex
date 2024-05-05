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
</script>
<?php
if (!isset($_SESSION['stockage'])){
  $_SESSION['stockage'] = array();
}
$_POST['suivant1'] = "none";
$_POST['suivant2'] = "none";
if((!empty($_POST['name']) && !empty($_POST['classe']) && !empty($_POST['difficulte']) && !empty($_POST['thematique']) && !empty($_POST['chapitre']))){
  $_POST['suivant1'] = "true";
  $_SESSION['stockage']['name'] = $_POST['name'];
  $_SESSION['stockage']['classe'] = $_POST['classe'];
  $_SESSION['stockage']['mots_clés'] = $_POST['mots_clés'];
  $_SESSION['stockage']['durée'] = $_POST['durée'];
  $_SESSION['stockage']['difficulte'] = $_POST['difficulte'];
  $_SESSION['stockage']['thematique'] = $_POST['thematique'];
  $_SESSION['stockage']['chapitre'] = $_POST['chapitre'];
}
if(!empty($_POST['origine']) && !empty($_POST['Nom_source']) && !empty($_POST['thematique_origine'])){
  $_POST['suivant2'] = "true";
  $_POST['suivant1'] = "none";
  $_SESSION['stockage']['origine']=$_POST['origine'];
  $_SESSION['stockage']['Nom_source']=$_POST['Nom_source'];
  $_SESSION['stockage']['thematique_origine']=$_POST['thematique_origine'];
}

include_once("requetes/configdb.php");
$sql_no_exercices = "SELECT name FROM classroom";
$result_no_exercice = $conn->query($sql_no_exercices);
$listeclasses = $result_no_exercice->fetch_all();

$sql_no_exercices = "SELECT name FROM thematic";
$result_no_exercice = $conn->query($sql_no_exercices);
$listethematiques = $result_no_exercice->fetch_all();

$sql_no_exercices = "SELECT name FROM origin";
$result_no_exercice = $conn->query($sql_no_exercices);
$listeorigines = $result_no_exercice->fetch_all();

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
        <li><a href="Accueil.php" class="accueil-liens"><img src="assets/images/icone_home.svg"><strong>Accueil</strong></a></li>
        <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search_gris.svg">Recherche</a></li>
        <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>

        <?php if(isset($_SESSION["account"])): ?>
          <?php if($_SESSION["account"]["role"] == "Administrateur" || $_SESSION["account"]["role"] == "Contributeur"): ?>
            <li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
            <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>
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
                        <label name='name'> Nom de l'exercice*: <input class="inputTexte" type='text' name='name' value=<?php if(isset($_SESSION['stockage']['name'])){echo $_SESSION['stockage']['name'];}?>></input></label>
                        <label name='mots_clés'> Mots clés: <input class="inputTexte" type='text' name='mots_clés' value=<?php if(isset($_SESSION['stockage']['mots_clés'])){echo $_SESSION['stockage']['mots_clés'];}?>></input></label>
                      </div>
                      <div class='ligne'>
                        <label name='classe'> Classe*: 
                            <select name="classe" id="classe">
                              <?php
                              foreach($listeclasses as $element){
                                echo "<option value=$element[0]>$element[0]</option>";
                              }
                              ?>
                            </select>
                        </label>
                        <label name='difficulte'> Difficulté*:
                          <select name="thematique" id="thematique">
                            <option value="Niveau 1">Niveau 1</option>
                            <option value="Niveau 2">Niveau 2</option>
                            <option value="Niveau 3">Niveau 3</option>
                            <option value="Niveau 4">Niveau 4</option>
                            <option value="Niveau 5">Niveau 5</option>
                          </select>
                        </label>
                      </div>
                      <div class='ligne'>
                        <label name='thematique'> Thematique*: 
                          <select name="thematique" id="thematique">
                            <?php
                            foreach($listethematiques as $element){
                              echo "<option value=$element[0]>$element[0]</option>";
                            }
                            ?>
                          </select>
                        </label>
                        <label name='durée'> Durée(en heure): <input class="inputTexte" type='text' name='durée' value=<?php if(isset($_SESSION['stockage']['durée'])){echo $_SESSION['stockage']['durée'];}?>></input></label>
                      </div>
                      <div class='ligne'>
                        <label name='chapitre'> Chapitre du cours* : <input class="inputTexte" type='text' name='chapitre' value=<?php if(isset($_SESSION['stockage']['chapitre'])){echo $_SESSION['stockage']['chapitre'];}?>></input></label>
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
                            foreach($listeorigines as $element){
                              echo "<option value=$element[0]>$element[0]</option>";
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
                  <form method='post' name='Fichiers'>
                      <div class='ligne'>
                        <label name='exercice'> Fiche exercice(PDF, word)*:
                          <div class='file'>
                            <input type="file" id="hiddenfile" class="label-upload" style="display:none" name="file" onChange="getvalue();"/>
                            <input class="leFichier" type="text" id="selectedfile" value="Sélectionner un fichier à télécharger"/>
                            <input class='bouton-upload' type="button" onclick="getfile();"/>
                          </div>
                        </label>
                      </div>
                      <div class='ligne'>
                        <label name='corrige'> Fiche corrigé(PDF, word)*: 
                          <div class='file'>
                              <input type="file" id="hiddenfile" class="label-upload" style="display:none" name="file" onChange="getvalue();"/>
                              <input class="leFichier" type="text" id="selectedfile" value="Sélectionner un fichier à télécharger"/>
                              <input class='bouton-upload' type="button" onclick="getfile();"/>
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