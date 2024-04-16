<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='assets/styles/recherche.css' rel='stylesheet'/>
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
            <li><a href="Exercices.php" class="fonctions-liens"><img src="assets/images/icone_fonctions_gris.svg">Exercices</a></li>
            <?php 
            if(isset($_SESSION["account"]) &&(($_SESSION["account"]['role'] === 'Administrateur') || ($_SESSION["account"]['role'] === 'Contributeur'))){
                echo '<li><a href="MesExercices.php" class="mesexercices-liens"><img src="assets/images/icone_liste_gris.svg">Mes exercices</a></li>
                <li><a href="Soumettre-information_generales.php" class="soumettre-liens"><img src="assets/images/icone_soumettre_gris.svg">Soumettre</a></li>';
            } ?>
            <div class="deconnexion">
                <?php if(isset($_SESSION["account"])): ?>
                    <li><a href="requetes/logout.php" class="deconnexion-liens"><img src="assets/images/icone_logout.svg">Déconnexion</a></li>
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
                <th>Durée</th>
                <th>Mots clés</th>
                <th>Fichier</th>
                </tr>
                <?php
                    // Définir la variable $result en dehors de la condition
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "mathindex";

                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Construction de la requête SQL de base
                    $sql_all_exercices = "SELECT exercise.name AS exercise_name, thematic.name AS thematic_name, exercise.difficulty, exercise.duration, exercise.keywords, file_exercice.original_name AS exercice_original_name, file_exercice.extension, file_correction.original_name AS correction_original_name, file_correction.extension AS correction_extension
                    FROM exercise
                    LEFT JOIN thematic ON exercise.thematic_id = thematic.id
                    LEFT JOIN file AS file_exercice ON exercise.id_file_exercice = file_exercice.id
                    LEFT JOIN file AS file_correction ON exercise.id_file_correction = file_correction.id";

                    // Check if any conditions are present and add the WHERE clause accordingly
                    if (!empty($where_conditions)) {
                        $sql_all_exercices .= " WHERE " . implode(" AND ", $where_conditions);
                    }

                    $result = null;
                    if (empty($_GET['thematique']) && empty($_GET['difficulte']) && empty($_GET['mot_cle'])) {
                        echo "<tr><td colspan='6'>Effectuez une recherche pour afficher les résultats</td></tr>";
                    } else{
                        // Récupérer les valeurs des champs de recherche
                        $thematique = isset($_GET['thematique']) ? $_GET['thematique'] : '';
                        $difficulte = isset($_GET['difficulte']) ? $_GET['difficulte'] : '';
                        $mot_cle = isset($_GET['mot_cle']) ? $_GET['mot_cle'] : '';

                        // Construire la condition WHERE en fonction des champs remplis dans le formulaire
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
                        // Exécuter la requête SQL
                        $result = $conn->query($sql_all_exercices);

                        // Afficher le nombre d'exercices trouvés
                        $num_exercices = $result->num_rows;
                        echo "<p><strong>$num_exercices exercices trouvés</strong></p>";

                        if ($result !== null && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["exercise_name"] . "</td>";
                                echo "<td>" . $row["thematic_name"] . "</td>";
                                echo "<td>" . 'Niveau ' . $row["difficulty"] . "</td>";
                                echo "<td>" . $row["duration"] . 'h00' . "</td>";
                                echo '<td>';
                                $keywords = explode(',', $row['keywords']);
                                foreach ($keywords as $keyword) {
                                    echo '<span class="keyword">' . $keyword . '</span>';
                                }
                                echo '</td>';
                                echo "<td>";
                                echo "<img src='assets/images/icone_download.svg'>
                                      <a href='assets/Exercices/" . $row["exercice_original_name"] . "." . $row["extension"] . "' target='_blank'>Exercice</a>";
                                if ($row["correction_original_name"] && $row["correction_extension"]) {
                                    echo "<img src='assets/images/icone_download.svg'>
                                          <a href='assets/Corrigé/" . $row["correction_original_name"]. "." . $row["correction_extension"] . "' target='_blank'>Corrigé</a>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Aucun exercice trouvé</td></tr>";
                        }
                        // Close the database connection
                        $conn->close();
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
