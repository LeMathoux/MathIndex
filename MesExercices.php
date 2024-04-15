<?php
include_once 'requetes/configdb.php';
session_start();
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
        <?php 
            if(isset($_SESSION["account"]) &&(($_SESSION["account"]['role'] === 'Administrateur') || ($_SESSION["account"]['role'] === 'Contributeur'))){
                echo '<li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
                <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>';
            } 
        ?>
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
          $role=$_SESSION['account']['role'];
          echo "<div class='compte'><p>$lastname $firstname ($role)</p></div>";
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
            <tr>
                <td class="nom"><p>Exo suite</p></td>
                <td class="thematiques"><p>Suites</p></td>
                <td class="fichiers"><p>Exercices Corrigé</p></td>
                <td class="actions"><p>Modifier Supprimer</p></td>
            </tr>
            <?php
                $id=$_SESSION['account']['id'];
                $sql = "SELECT * FROM exercise WHERE id = $id ";
                $req = $mysqlClient->query($sql);
                while ($rep = $req->fetch()) {
                $id = $rep['id'];

                ?>
                <tr>
                <td class="nom"><?php echo $rep['name'];?></td>
                <td class="thematiques"<?php echo $rep['thematic_id'];?></td>
                <td class="fichiers">
                  <a href="Exercices/"></a>
                </td>
                <td class="actions">

                </td>
                </tr>
                <?php
                }
                ?>


        </table>
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