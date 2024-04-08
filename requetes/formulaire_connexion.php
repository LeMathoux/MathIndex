<?php

    session_start();

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

        $errors = addMessageIfValueIsEmpty($errors, 'email');
        $errors = addMessageIfValueIsEmpty($errors, 'password');
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
                'email' => htmlspecialchars($_POST['email']),
                'password' => htmlspecialchars($_POST['password']),
                
            ];
            // On affiche les informations de contact.
            $query = "SELECT * FROM user where email=:email AND password=:password";
            $stmt = $mysqlClient->prepare($query);
            $stmt->bindParam(":email", $informations['email']);
            $stmt->bindParam(":password", $informations['password']);
            $stmt->execute();
            $result = $stmt->fetch();
            var_dump($result);
            if(empty($result)){
                echo "email ou mot de passe incorrect";
            }
            else{
                $_SESSION['account'] = $result;
                header("Location: index.php");
            }
            
        }
    }

?>