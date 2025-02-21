<?php
require_once '../Entity/Bdd.php';
require_once '../Entity/User.php';
$bdd = new Bdd();
session_start();
$email = $_POST['email'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$connect = $bdd->getConnexion()->prepare('INSERT INTO user (email, password, nom, prenom, role) VALUES (:email, :password, :nom, :prenom, :role)');
$pwd = sha1($_POST['password']);
$role = "prof";
$connect->bindParam(':role', $role);
$connect->bindParam(':email', $email);
$connect->bindParam(':password', $pwd);
$connect->bindParam(':nom', $nom);
$connect->bindParam(':prenom', $prenom);
$connect->execute();



header('Location: ../login.php');


?>
