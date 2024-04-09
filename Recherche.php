<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Epilogue:wght@100;200;300;400;500;600;700;800;900&display=swap');
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

.barre-navigation a.fonctions-liens {
    color: #757575;
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

.carre-blanc  form {
            margin: 0 auto;
            margin-left: 42px;
            margin-top: 55px;
        }

        .carre-blanc label{
            color:#666666;
            font-size:16px;
        }

        .carre-blanc  .form-group {
            display: inline-block;
            margin-right: 10px;
        }

        .form-group input[type="text"] {
            display: block;
            margin-top: 5px;
            border:2px solid #F6F6F6;
            width:242px;
            height:56px;
            border-radius:8px;
            color:#666666;
        }

        .form-group select {
            display: block;
            margin-top: 5px;
            border:2px solid #F6F6F6;
            width:242px;
            height:63px;
            border-radius:8px;
            color:#666666;
        }

        .carre-blanc  input[type="submit"] {
            margin-top: 10px;
            margin-left: 0;
            width:172px;
            height: 56px;
            border-radius:8px;
            padding:16px;
            background-color:#F6F6F6;
            color: #757575;
            font-size:16px;
            border:none;
        }

        .carre-blanc  p{
            color: #1B3168;
            margin-left: 42px;
            font-size:20px;
        }

table {
    border-collapse: collapse;
    width: 1240px;
    height:44px;
    border-radius: 8px; /* Arrondir les bords du tableau */
    overflow: hidden; /* Pour cacher les coins arrondis débordants */
    border: 1px solid #E7E7E7; /* Bordure du tableau */
    margin-left:43px;
    margin-top:45px;
}

th {
   text-align:left;
}

 th, td {
    padding: 8px;
    border-bottom: 1px solid #E7E7E7; /* Bordure basse des cellules */
}


th {
    background-color: #F0F0F0;
    color:#464646;
}

form a{
    text-decoration:none;
    color:#74828F;
    margin-right: 5px;
}

table img{
    margin-right:5px;
    position: relative;
    top: 5px;
}

footer {
  padding: 20px 0;
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

.keyword {
    display: inline-block;
    padding: 5px 10px;
    margin: 5px;
    border-radius: 20px;
    background-color: #DBDBDB;
    border:none;
}

  </style>
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
            <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search.svg"><strong>Recherche</strong></a></li>
            <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
            <li><a href="#" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
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
        <h1>Rechercher un exercice</h1>
        <footer>
            <div class="mentionlegales">
            <div class="mentionlegales-text">Mentions légales</div>
            <div class="mentionlegales-text">•</div>
            <div class="mentionlegales-text">Contact</div>
            <div class="mentionlegales-text">•</div>
            <div class="mentionlegales-text">Lycée Saint-Vincent</div>
            </div>
        </footer>
        <div class="carre-blanc">
            <form method="GET">
                <div class="form-group">
                    <label for="thematique">Thématique :</label>
                    <select id="thematique" name="thematique">
                        <option value="">Toutes</option>
                        <option value="Algèbre linéaire">Algèbre linéaire</option>
                        <option value="Géométrie des fractales">Géométrie des fractales</option>
                        <option value="Théorie des nombres">Théorie des nombres</option>
                        <option value="Calcul différentiel sur les variétés">Calcul différentiel sur les variétés</option>
                        <option value="Algèbre linéaire avancée">Algèbre linéaire avancée</option>
                        <option value="Géométrie non euclidienne">Géométrie non euclidienne</option>
                        <option value="Analyse fonctionnelle">Analyse fonctionnelle</option>
                        <option value="Théorie des graphes">Théorie des graphes</option>
                        <option value="Cryptographie">Cryptographie</option>
                        <option value="Analyse complexe avancée">Analyse complexe avancée</option>              
                        <option value="Analyse complexe avancée">Calcul stochastique</option>
                        <option value="Théorie des catégories">Théorie des catégories</option>
                        <option value="Logique floue">Logique floue</option>
                        <option value="Probabilités élémentaires">Probabilités élémentaires</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="difficulte">Difficulté :</label>
                    <select id="difficulte" name="difficulte">
                        <option value="">Toutes</option>
                        <option value="1">Niveau 1</option>
                        <option value="2">Niveau 2</option>
                        <option value="3">Niveau 3</option>
                        <option value="4">Niveau 4</option>
                        <option value="5">Niveau 5</option>
                        <option value="6">Niveau 6</option>
                        <option value="7">Niveau 7</option>
                        <option value="8">Niveau 9</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="mot_cle">Mot clé :</label>
                    <input type="text" id="mot_cle" name="mot_cle" value="<?php echo isset($_GET['mot_cle']) ? $_GET['mot_cle'] : ''; ?>">
                </div>

                <input type="submit" value="Rechercher">

                
            </form>
            
            <table>
                <tr>
                    <th>Nom</th>
                    <th>Thématique</th>
                    <th>Difficulté</th>
                    <th>Mots clés</th>
                    <th>Durée</th>
                    <th>Fichiers</th>
                    <!-- Ajoutez d'autres en-têtes de colonne selon votre structure de base de données -->
                </tr>
    
                <?php
// Définir la variable $result en dehors de la condition
$result = null;

// Vérifier si au moins un champ est rempli
if (!empty($_GET['thematique']) || !empty($_GET['difficulte']) || !empty($_GET['mot_cle'])) {
    // Effectuer la recherche
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // Connexion à la base de données (assurez-vous d'avoir vos propres informations de connexion)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "exercice_db";

        // Création de la connexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Échec de la connexion : " . $conn->connect_error);
        }

        // Construction de la requête SQL de base
        $sql = "SELECT exercise.name AS name, exercise.duration AS duration, exercise.difficulty AS difficulty, exercise.keywords AS keywords, thematic.name AS thematic FROM exercise LEFT JOIN thematic ON exercise.thematic_id = thematic.id WHERE 1";

        // Récupérer les valeurs des champs de recherche
        $thematique = isset($_GET['thematique']) ? $_GET['thematique'] : '';
        $difficulte = isset($_GET['difficulte']) ? $_GET['difficulte'] : '';
        $mot_cle = isset($_GET['mot_cle']) ? $_GET['mot_cle'] : '';

        // Ajouter les conditions de recherche en fonction des champs remplis
        if (!empty($thematique)) {
            $sql .= " AND thematic.name = '$thematique'";
        }
        if (!empty($difficulte)) {
            $sql .= " AND exercise.difficulty = '$difficulte'";
        }
        if (!empty($mot_cle)) {
            $sql .= " AND exercise.keywords LIKE '%$mot_cle%'";
        }

        // Exécuter la requête SQL
        $result = $conn->query($sql);
    }
}
?>
              
                <?php
                    // Afficher les résultats de la recherche dans un tableau HTML
                    if ($result !== null && $result->num_rows > 0) {
                        $num_exercices = $result->num_rows;
                                        echo "<p><strong>$num_exercices exercices trouvés</strong> </p>";
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["name"] . "</td>";
                            echo "<td>" . $row["thematic"] . "</td>";
                            echo "<td>" . 'Niveau ' . $row["difficulty"] . "</td>";
                            echo '<td>';
                            $keywords = explode(',', $row['keywords']);
                            $count = 0;
                            foreach ($keywords as $keyword) {
                                $count++;
                                if ($count == 2) {
                                    echo '<span class="keyword">' . $keyword . '</span>';
                                } else {
                                    echo '<span class="keyword">' . $keyword . '</span>';
                                }
                            }
                            echo '</td>';
                            echo "<td>" . $row["duration"] . 'h00' . "</td>";  
                            echo "<td>";
                            echo "<img src='assets/images/icone_download.svg' alt='Exercice'>Exercice";
                            echo "<img src='assets/images/icone_download.svg' alt='Corrigé'>Corrigé";
                            echo "</td>";                        
                        }
                    } else {
                        echo "<tr><td colspan='5'>Veuillez effectuer une recherche</td></tr>";
                    }
                
                ?>
            </table>
        

        </div>
    </div>
    
</body>
</html>

