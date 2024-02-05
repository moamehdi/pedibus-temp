<?php
require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");

session_start(); // Commencez la session

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse, true);

    $mail = $data['mail'];
    $password = $data['password'];

    $stmt = $cnx->prepare("SELECT id, mail, password FROM user WHERE mail = ?");
    $stmt->execute([$mail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(["message" => "Connexion réussie", "data" => $data]);
    } else {
        echo json_encode(["message" => "Identifiants invalides", "data" => $data]);
    }
} else {
    // Gérer les autres cas (méthodes non prises en charge, etc.) si nécessaire
    echo json_encode(["message" => "Méthode non prise en charge", "data" => null]);
}
?>
