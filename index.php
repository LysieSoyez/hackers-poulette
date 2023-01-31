<?php
$host = "mysql_db";
$username = "root";
$password = "root";
$dbname = "hackers";
try
{
	// On se connecte à MySQL
	$bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $username , $password);
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

$sql = "SELECT * FROM poulette";
$result = $bdd->query($sql);

//récupération des données du bd
$resultat = $bdd->query('SELECT * FROM poulette');
$donnees = $resultat->fetchALL(PDO::FETCH_ASSOC);

//REQUIRE POUR SEPARER LES FICHIERS

$errorFirstName = $errorLastName = $errorEmail = $errorComment = "";
$firstName = $lastName = $email = $comment = "";
$error = false;
if (isset($_POST['submit'])) {
    if (!empty($_POST['hp'])) {
        die("Nice try robot");
    } else {
        if (!empty($_POST['firstName'])) {
            $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_SPECIAL_CHARS);
            if (preg_match('/^[a-zA-ZÀ-ù|\s-]{2,255}$/', $firstName)) {
                $firstName = $_POST['firstName'];
                $error = false;

            } else {
                $errorFirstName = "The first name must be between 2 and 255 characters";
                $firstName = "";
                $error = true;
            }
        } else {
            $errorFirstName = "The first name can't be empty";
            $error = true;
        }



        if (!empty($_POST['lastName'])) {
            $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_SPECIAL_CHARS);
            if (preg_match('/^[a-zA-ZÀ-ù|\s-]{2,255}$/', $lastName)) {
                $lastName = $_POST['lastName'];
                $error = false;
            } else {
                $errorLastName = "The last name must be between 2 and 255 characters";
                $lastName = "";
                $error = true;
            }
        } else {
            $errorLastName = "The last name can't be empty";
            $error = true;
        }


        if (!empty($_POST['email'])) {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorEmail = "Invalid email format";
                $email = "";
                $error = true;
            }
        } else {
            $errorEmail = "Email can't be empty";
            $error = true;
        }


        if (!empty($_POST['comment'])) {
            $comment = filter_var($_POST['comment'], FILTER_SANITIZE_SPECIAL_CHARS);
            if (preg_match('/^[a-zA-ZÀ-ù-]{0,249}$/', $comment)) {
                $errorComment = "The comment must be more than 250 characters";
                $error = true;
            } else if (preg_match('/^[a-zA-ZÀ-ù-]{1001,}$/', $comment)) {
                $errorComment = "The comment must be lest than 1000 characters";
                $error = true;
            } else if (preg_match('/^[a-zA-ZÀ-ù-]{250,1000}$/', $comment)) {
                $comment = $_POST['comment'];
                $error = false;
            }
        } else {
            $errorComment = "The comment can't be empty";
            $error = true;
        }
        if ($error == false) {
            $stmt = $bdd->prepare("INSERT INTO poulette (first_name,last_name,email,comment) VALUES (:first_name,:last_name, :email, :comment)");
            $stmt->bindValue(':first_name', $firstName);
            $stmt->bindValue(':last_name', $lastName);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':comment', $comment);
            $stmt->execute();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Contact support">
    <link rel="stylesheet" type="text/css" href="./style.css">
    <title>Hackers</title>
</head>

<body>
    <form " method="post" action="">

        <label for="firstName">First Name *</label>
        <input name="firstName" id="firstName" type="text" value="<?php echo $firstName?>" />
        <?php echo '<span class="error">'.$errorFirstName.'</span>';?>

        <label for="lastName">Last Name *</label>
        <input name="lastName" id="lastName" type="text" value="<?php echo $lastName?>">
        <?php echo '<span class="error">'.$errorLastName.'</span>';?>

        <label for="email">Email *</label>
        <input name="email" type="email" id="email" value="<?php echo $email?>">
        <?php echo '<span class="error">'.$errorEmail.'</span>';?>

        <label for="comment">Comment *</label>
        <textarea name="comment" type="text" id="comment"><?php echo $comment?></textarea>
        <?php echo '<span class="error">'.$errorComment.'</span>';?>

        <input type="text" name="hp" style="display: none;" >

        <input name="submit" type="submit" id="submit" value="Submit">

    </form>
</body>

</html>