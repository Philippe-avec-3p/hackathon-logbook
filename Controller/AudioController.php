<?php
require "Entity/Audio.php";
session_start();

header('Content-Type: application/json');

// Vérifier si les données sont bien reçues
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['audioTitle']) || !isset($data['description'])) {
    echo json_encode(["status" => "error", "message" => "Données incomplètes"]);
    exit;
}

// Récupérer l'ID utilisateur depuis la session
$idUser = $_SESSION['idUser'] ?? null;
if (!$idUser) {
    echo json_encode(["status" => "error", "message" => "Utilisateur non authentifié"]);
    exit;
}

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=your_database;charset=utf8", "your_username", "your_password", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur de connexion à la base de données"]);
    exit;
}

// Création et enregistrement de l'objet Audio
$Audio = new Audio();
$Audio->setAudioTitle($data['audioTitle']);
$Audio->setDescription($data['description']);
$Audio->setIdUser($idUser);

$query = "INSERT INTO audio (idUser, audioTitle, description) VALUES (:idUser, :audioTitle, :description)";
$statement = $pdo->prepare($query);

try {
    $statement->execute([
        ':idUser' => $idUser,
        ':audioTitle' => $Audio->getAudioTitle(),
        ':description' => $Audio->getDescription()
    ]);
    echo json_encode(["status" => "success", "message" => "Audio enregistré avec succès"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erreur lors de l'enregistrement"]);
}
