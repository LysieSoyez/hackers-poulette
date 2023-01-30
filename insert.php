<?php

$stmt = $bdd->prepare("INSERT INTO poulette (first_name,last_name,email,comment) VALUES (:first_name,:last_name, :email, :comment)");
    $stmt->bindValue(':first_name', $firsName);
    $stmt->bindValue(':last_name', $lastName);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':comment', $comment);
$stmt->execute();

?>