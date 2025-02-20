<?php
session_start();
require "Entity/Audio.php";

// Afficher un alert JS pour vérifier si cette page est bien chargée
echo "<script>alert('save_audio.php chargé !');</script>";

$audio = new Audio();
$audio->setAudioTitle("r");
$audio->setDescription("t");
$audio->setIdUser(1);

$audio->insertAudio();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["audioTitle"], $_POST["description"]) && isset($_SESSION['user'])) {
        $audio = new Audio();
        $audio->setAudioTitle($_POST["audioTitle"]);
        $audio->setDescription($_POST["description"]);
        $audio->setIdUser($_SESSION['user']);

        $audio->insertAudio();

        echo json_encode(["success" => true, "message" => "Audio ajouté avec succès !"]);
        exit;
    } else {
        echo json_encode(["success" => false, "message" => "Données invalides"]);
        exit;
    }
}
?>
