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
                <div class="tabs"><!----------------onglet-01-accueil-------------------------->
                <div class="tab"><input id="tab-1" checked="checked" name="tab-group-1" type="radio" /> <label for="tab-1">Contributeurs</label>
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
                <!----------------onglet-02-articles-------------------------->
                <div class="tab"><input id="tab-2" name="tab-group-1" type="radio" /> <label for="tab-2">Exercices</label>
                <div class="content">
                <p>Exemple, une image, du texte</p>
                <br />
                <p><img src="http://ekladata.com/UM-RXN_kZ3q93_FwWhFA15FP_uc.jpg" alt="" /></p>
                </div>
                </div>
                <!----------------onglet-03-forum-------------------------->
                <div class="tab"><input id="tab-3" name="tab-group-1" type="radio" /> <label for="tab-3">Matières</label>
                <div class="content">
                <p>Exemple, une image, et une video...</p>
                <br />
                <p><img src="http://ekladata.com/UM-RXN_kZ3q93_FwWhFA15FP_uc.jpg" alt="" /> <iframe style="margin-left: 30px; box-shadow: 6px 6px 10px grey;" src="" frameborder="0" width="500" height="281"></iframe></p>
                </div>
                </div>
                <!----------------onglet-04-libre-------------------------->
                <div class="tab"><input id="tab-4" name="tab-group-1" type="radio" /> <label for="tab-4">Classes</label>
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
                <!----------------onglet-05-libre------------------------->
                <div class="tab"><input id="tab-5" name="tab-group-1" type="radio" /> <label for="tab-5">Thématiques</label>
                <div class="content"><br /> <iframe src="//www.youtube.com/embed/I3W3mRs4ULQ?rel=0" frameborder="0" width="560" height="315" allowfullscreen="allowfullscreen"></iframe></div>
                </div>
                <!----------------onglet-06-libre-------------------------->
                <div class="tab"><input id="tab-6" name="tab-group-1" type="radio" /> <label for="tab-6">Origines</label>
                <div class="content">
                    
                    <h2>Ajouter un contributeur :</h2>
                    
                    <form action="" method="">
                        <p>Nom :</p>
                        <input type="text" id="recherche" name="recherche" placeholder="Rechercher :">
                        
                        <p>Prénom :</p>
                        <input type="text" id="recherche" name="recherche" placeholder="Rechercher :">
                        
                        <p>Email :</p>
                        <input type="text" id="recherche" name="recherche" placeholder="Rechercher :">
                        
                        <p>Mot de passe :</p>
                        <input type="text" id="recherche" name="recherche" placeholder="Rechercher :">
                        
                        <select id="thematique" name="thematique" required>
                            <option value="algebre">Enseignant</option>
                            <option value="geometrie">Elève</option>
                        </select>
                    </form>
                    
                    <button class="button"> ◄ Retour à la liste</button>
                    <button class="button2">Enregistrer</button>
                
                </div>
                </div> 
                    
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