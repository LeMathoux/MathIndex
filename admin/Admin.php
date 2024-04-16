<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https : //fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <title>Admin</title>
    <link href="Admin.css" rel="stylesheet">
</head>
<body class="font">
    <div class="contenaire">
        <div class="partie_gauche">
            <div class="logo">
                <img alt="logo" src="../images/Logo.svg">
                <div class="logo-titre">
                    <span class="titre">Math Index</span>
                    <span class="sous-titre">Lycée Saint-Vincent - Senlis</span>
                </div>
            </div>
            <div class="navigation">
                <a href="index.php" class="bouton-menu1"><img src="../images/icone_home_gris.svg" alt="Home"><strong>Accueil</strong></a>
                <a href="Recherche.php" class="bouton-menu2"><img src="../images/icone_search_gris.svg" alt="search">Recherche</a>
                <a href="Exercices.php" class="bouton-menu3"><img src="../images/icone_fonctions_gris.svg" alt="fonction">Exercices</a>
                <div class="nouveaux-menus" style="display: none;margin-top: 10px;">
                    <a href="#"><img src="assets/images/icone-leading.png" alt="leading">Mes exercices</a>
                    <a href="Soumettre.php"><img src="assets/images/icone-envoyer.png" alt="envoyer">Soumettre</a>
                </div>
            </div>
        </div>
        <div class="partie_droite">
            <header>
            
            </header>
            <div class="bloc1">  
                <h1 class="titre">Administration</h1>
                
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
                
                
                
                
                <div class="mentionlegales">
                    <div class="mentionlegales-text">Mentions légales</div>
                    <div class="mentionlegales-text">•</div>
                    <div class="mentionlegales-text">Contact</div>
                    <div class="mentionlegales-text">•</div>
                    <div class="mentionlegales-text">Lycée Saint-Vincent</div>
                </div>
            </div>
        </div>        
    </div>
    
</body>
</html>
