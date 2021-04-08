<?php 

require 'connec.php';
$pdo = new \PDO(DSN, USER, PASS);


$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();
var_dump($friends);

$errors = [];

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        $friend = array_map('trim', $_POST);
    
        // Validate data
        if (empty($friend['firstname'])) {
            $errors[] = 'The title is required';
        }
        if (empty($friend['lastname'])) {
            $errors[] = 'The description is required';
        }

    
        // Save the recipe
        if (empty($errors)) {
                       
            $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";
            $statement = $pdo->prepare($query);
            $statement->bindValue(':firstname', $friend['firstname'], PDO::PARAM_STR);
            $statement->bindValue(':lastname', $friend['lastname'], PDO::PARAM_STR);
            $statement->execute();
           
        }
        
    }



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <h1>friends liste : </h1>
        <ul>
            <?php foreach ($friends as $friend):?>
                <li>   
                    <?= $friend['firstname'] ." ". $friend['lastname']; ?>
                
                </li>
            <?php endforeach; ?>
        </ul>





        <form action="" method="post">
            <div>
                <label for="firstname">Firstname : </label>
                <input id="firstname" name="firstname" type="text" max = 45 value="<?= $friend['firstname'] ?? '' ?>">
            </div>
            <div>
                <label for="lastname">Lastname : </label>
                <textarea id="lastname" name="lastname"><?= $friend['lastname'] ?? '' ?></textarea>
            </div>
            <button>Send</button>
        </form>

</body>
</html>