<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='assets/styles/Recherche.css' rel='stylesheet'/>
    <title>Recherche</title>

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
            <li><a href="Recherche.php" class="recherche-liens"><img src="assets/images/icone_search.svg"><strong>Recherche</strong></a></li>
            <li><a href="Exercices.php" class="fonctions-liens <?php echo basename($_SERVER['PHP_SELF']) == 'Exercices.php' ? 'active' : ''; ?>"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
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
            $profile_picture = isset($_SESSION['account']['profile_photo_file']) ? $_SESSION['account']['profile_photo_file'] : 'chemin/vers/image_par_defaut.jpg';
            echo "<div class='compte'>$lastname $firstname <img src='assets/photos_de_profil/$profile_picture' alt='photo de profil' class='profil-image'></div>";
        } else {
            echo "<a href='Connexion.php' class='connexion'><img src='assets/images/icone_login.svg' alt='login'>Connexion</a>";
        }
      ?>
        </div>
        
    </header>
    <div class="contenu">
        <h1>Rechercher un exercice</h1>
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
                    <th>Difficulté</th>
                    <th>Mots clés</th>
                    <th>Durée</th>
                    <th>Fichier</th>
                </tr>
                <?php
                    
                    include_once 'requetes/configdb.php';

                    // Construction de la requête SQL de base
                    $sql_all_exercices = "SELECT exercise.name AS exercise_name, thematic.name AS thematic_name, exercise.difficulty, exercise.duration, exercise.keywords, file_exercice.original_name AS exercice_original_name, file_exercice.extension, file_correction.original_name AS correction_original_name, file_correction.extension AS correction_extension
                    FROM exercise
                    LEFT JOIN thematic ON exercise.thematic_id = thematic.id
                    LEFT JOIN file AS file_exercice ON exercise.exercice_file_id = file_exercice.id
                    LEFT JOIN file AS file_correction ON exercise.exercice_file_id = file_correction.id";

                   
                    if (!empty($where_conditions)) {
                        $sql_all_exercices .= " WHERE " . implode(" AND ", $where_conditions);
                    }

                    $result = null;
                    if (empty($_GET['thematique']) && empty($_GET['difficulte']) && empty($_GET['mot_cle'])) {
                        echo "<tr><td colspan='6'>Effectuez une recherche pour afficher les résultats</td></tr>";
                    } else{
                        // Récupére les valeurs des champs de recherche
                        $thematique = isset($_GET['thematique']) ? $_GET['thematique'] : '';
                        $difficulte = isset($_GET['difficulte']) ? $_GET['difficulte'] : '';
                        $mot_cle = isset($_GET['mot_cle']) ? $_GET['mot_cle'] : '';

                        // Construie la condition WHERE en fonction des champs remplis dans le formulaire
                        $where_conditions = [];
                        if (!empty($thematique)) {
                            $where_conditions[] = "thematic.name = '$thematique'";
                        }
                        if (!empty($difficulte)) {
                            $where_conditions[] = "exercise.difficulty = '$difficulte'";
                        }
                        if (!empty($mot_cle)) {
                            $where_conditions[] = "exercise.keywords LIKE '%$mot_cle%'";
                        }

                        // Si au moins une condition est spécifiée, ajoutez le WHERE à la requête SQL
                        if (!empty($where_conditions)) {
                            $sql_all_exercices .= " WHERE " . implode(" AND ", $where_conditions);
                        }
                        // Exécute la requête SQL
                        $result = $mysqlClient->query($sql_all_exercices);

                        // Affiche le nombre d'exercices trouvés
                        $num_exercices = $result->rowCount();
                        if ($num_exercices > 1) {
                            echo "<p><strong>$num_exercices exercices trouvés</strong></p>";
                        } elseif ($num_exercices == 1) {
                            echo "<p><strong>$num_exercices exercice trouvé</strong></p>";
                        } else {
                            echo "<p><strong>Aucun exercice trouvé</strong></p>";
                        }    

                        if ($result !== null && $result->rowCount() > 0) {

                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                                echo "<tr>";
                                echo "<td>" . $row["exercise_name"] . "</td>";
                                echo "<td>" . 'Niveau ' . $row["difficulty"] . "</td>";
                                echo '<td>';
                                $keywords = explode(',', $row['keywords']);
                                foreach ($keywords as $keyword) {
                                    echo '<span class="keyword">' . $keyword . '</span>';
                                }
                                echo '</td>';
                                echo "<td>" . $row["duration"] . 'h00' . "</td>";
                                echo "<td>";
                                echo "<img src='assets/images/icone_download.svg'>
                                      <a href='assets/Exercices/" . $row["exercice_original_name"] . "." . $row["extension"] . "' download>Exercice</a>";
                                if ($row["correction_original_name"] && $row["correction_extension"]) {
                                    echo "<img src='assets/images/icone_download.svg'>
                                          <a href='assets/Corrigé/" . $row["correction_original_name"]. "." . $row["correction_extension"] . "' download>Corrigé</a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun exercice trouvé</td></tr>";
                        }
                       
                    }
                ?>
            </table>
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
