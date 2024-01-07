<?php

require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $upd = $cnx->prepare("SELECT id, name, departure_hour, arrival_hour, is_active FROM line WHERE id = ?");
    
    $upd->bindParam(1, $id, PDO::PARAM_INT);

    $upd->execute();

    $line = $upd->fetch(PDO::FETCH_ASSOC);

    $data = array();

    if ($line) {
        $data[] = [
            "id" => $line['id'],
            "name" => $line['name'],
            "departure_hour" => $line["departure_hour"],
            "arrival_hour" => $line["arrival_hour"],
            "is_active" => $line["is_active"],
        ];
    }

    echo json_encode($data);
}
