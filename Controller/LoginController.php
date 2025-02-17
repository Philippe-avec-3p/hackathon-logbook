<?php
require_once '../Entity/Bdd.php';
require_once '../Entity/User.php';
$result = false;
$bdd = new Bdd();
session_start();
$connect = $bdd->getConnexion()->prepare('SELECT * FROM user WHERE email = :email AND password = :password');
$connect->bindParam(':email', $_POST['email']);
$connect->bindParam(':password', $_POST['password']);
$connect->execute();

$fetch = $connect->fetchAll();

foreach ($fetch as $row) {
    if($row['role'] == "prof") {
        $_SESSION['prof'] = true;
        header('Location: ../View/profIndex.php');
        exit();
    }else if ($row['role'] == "student") {
        $_SESSION['student'] = true;
        header('Location: ../View/studentIndex.php');
        exit();
    }

}
$_SESSION['error'] = '<div class="alert alert-danger" role="alert">Attention, la combinaison mail et/ou mot de passe est incorrecte, veuillez réessayer</div>';
header('Location: ../login.php');


?>
