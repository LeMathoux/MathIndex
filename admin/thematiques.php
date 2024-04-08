<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https : //fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet"/>
    <title>Accueil</title>
    <link href="../assets/styles/Accueil.css" rel="stylesheet" />
    <?php
        $username = 'root';
        $password = '';
        $name = 'mathindex';
        try
        {
            $mysqlClient = new PDO("mysql:host=127.0.0.1; dbname=$name", $username, $password);
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

        $Query = $mysqlClient->prepare('SELECT name FROM thematic');
        $Query->execute();
        $result = $Query->fetchAll();

    ?>
    <style>
    th {
        border: 1px solid rgb(160 160 160);
        padding: 8px 10px;
    }
    table {
        border-collapse: collapse;
        border: 2px solid rgb(140 140 140);
        font-family: sans-serif;
        font-size: 0.8rem;
        margin: 50px auto auto auto;
        letter-spacing: 1px;
    }
    h1{
        margin:50px auto auto auto;
        text-align: center;
        color:white;
    }
    tbody tr:nth-child(odd){
		background-color:lightgray;
	}
    tbody tr:nth-child(even){
		background-color:white;
	}
    </style>
<?php

function addMessageIfValueIsEmpty(array $errors, string $field): array
{
    if (empty($_POST[$field])) {
        $errors[$field][] = sprintf('Le champ doit être renseigné.', $field);
    }

    return $errors;
}
function displayValue(string $field): string
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST) || !isset($_POST[$field])) {
        return '';
    }

    return $_POST[$field];
}    
function displayErrors(array $errors, string $field): void
{

    if (isset($errors[$field])) {
        foreach ($errors[$field] as $error) {
            echo '<p class="error">' . $error . '</p>';
        }
    }
}

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) === false) {

    $errors = addMessageIfValueIsEmpty($errors, 'thematique');
    var_dump($errors);

    if (empty($errors)) {

        $username = 'root';
        $password = '';
        $name = 'mathindex';
        try
        {
            $mysqlClient = new PDO("mysql:host=127.0.0.1; dbname=$name", $username, $password);
        }
        catch (Exception $e){
            die('Erreur : ' . $e->getMessage());
        }

        $informations = [
            'thematique' => htmlspecialchars($_POST['thematique']),     
        ];
        // On affiche les informations de contact.
        $query = "INSERT INTO thematic VALUES(NULL,:thematique);";
        $stmt = $mysqlClient->prepare($query);
        $stmt->bindParam(":thematique", $informations['thematique']);
        $stmt->execute();
        header("Location: thematiques.php");  
    }
}

?>
</head>
<body class="font">
    <div class="contenaire">
        <div class="partie_gauche">
            <div class="logo">
                <img alt="logo" src="../assets/images/logo-st-vincent.png">
                <div class="logo-titre">
                    <span class="titre">Math Index</span>
                    <span class="sous-titre">Lycée Saint-Vincent - Senlis</span>
                </div>
            </div>
            <div class="navigation">
                <a href="index.php" class="bouton-menu1"><img src="../assets/images/icone-home.png" alt="Home"><strong>Accueil</strong></a>
                <a href="Recherche.php" class="bouton-menu2"><img src="../assets/images/icone-search.png" alt="search">Recherche</a>
                <a href="Mathematique.php" class="bouton-menu3"><img src="../assets/images/icone-fonction.png" alt="fonction">Mathématique</a>
                <div class="nouveaux-menus" style="display: none;margin-top: 10px;">
                    <a href="#"><img src="assets/images/icone-leading.png" alt="leading">Mes exercices</a>
                    <a href="Soumettre.html"><img src="assets/images/icone-envoyer.png" alt="envoyer">Soumettre</a>
                </div>
            </div>
            <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if(isset($_SESSION["account"])){
                        echo "
                        <div class='deconnexion'>
                            <a href='admin/authentification/logout.php'><h2>Deconnexion</h2></a>
                        </div>";
            }
            ?>
        </div>
        <div class="partie_droite">
            <div class="header">
                <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }

                    if(isset($_SESSION["account"])){
                        $lastname=$_SESSION['account']['last_name'];
                        $firstname=$_SESSION['account']['first_name'];
                        $role=$_SESSION['account']['role'];
                        echo "<div class='compte'>$lastname $firstname ($role)
                        </div>
                        ";
                    }
                    else{
                        echo "<a href='Connexion.php' class='connexion'><img src='../assets/images/icone-login.png' alt='login'>Connexion</a>";
                    }
                ?>
            </div>
            <h1 class="titre">Administration</h1>
            <div class="blockblanc">
                <p>liste des thematiques :</p>
                <table>
                    <th>Nom</th>
                    <th>Matiere</th>
                    <th colspan="2">Actions</th>


                    <?php
                    for($i=0; $i< count($result);$i++){
                    ?>

                    <tr>
                    <th><?php echo $result[$i][0];?></th>
                    <th>Mathematique</th>
                    <th><button>Modifier</button></th>
                    <th><button>Supprimer</button></th>

                    <?php
                    }
                    ?>
                </table>
                <div class="ajout">
                <p>ajouter une thematique :</p>
                    <form action="" method="post">
                        <div>
                            <label for="thematique">nom de la thematique : <input id="thematique" name="thematique"></input></label>
                            <input type="submit" value="Ajouter">
                        </div>
                    </form>
                </div>
            </div>
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