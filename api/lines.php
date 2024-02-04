<?php

require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $lines = $cnx->query("SELECT id,name, departure_hour, arrival_hour,is_active FROM line");

    $data = array();

    foreach ($lines as $line) {
        $data[] = [
            "id" => $line["id"],
            "name" => $line['name'],
            "departure_hour" => $line["departure_hour"],
            "arrival_hour" => $line["arrival_hour"],
            "is_active" => $line["is_active"],
        ];
    }

    echo json_encode($data);
}

elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenir l'heure actuelle au format datetime
    $currentDateTime = date('Y-m-d H:i:s');
    $upd = $cnx->prepare("INSERT INTO line SET name = ?, departure_hour = ?, arrival_hour = ?, is_active = ?, id_user_ref = ?,created_at = ?, updated_at = ?");
    
    if ($upd->execute([
        $_POST['name'],
        $_POST['departure_hour'],
        $_POST['arrival_hour'],
        $_POST['is_active'],
        $_POST['id_user_ref'],
        $currentDateTime,  
        $currentDateTime  
    ])) {
        echo json_encode(["message" => "ligne créé avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la création de la ligne"]);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $upd = $cnx->prepare("DELETE FROM line WHERE id = ?");
    if ($upd->execute([$data->id])) {
        echo json_encode(["message" => "ligne supprimée avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression de la ligne"]);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $currentDateTime = date('Y-m-d H:i:s');
    if (!isset($data->id)) {
        echo json_encode(["message" => "L'id est requis pour modifier une ligne"]);
        http_response_code(400); 
        exit;
    }

    $setValues = [];
    $params = [];

    if (isset($data->name)) {
        $setValues[] = "name = ?";
        $params[] = $data->name;
    }

    if (isset($data->departure_hour)) {
        $setValues[] = "departure_hour = ?";
        $params[] = $data->departure_hour;
    }
    if (isset($data->arrival_hour)) {
        $setValues[] = "arrival_hour = ?";
        $params[] = $data->arrival_hour;
    }
    
    if (isset($data->is_active)) {
        $setValues[] = "is_active = ?";
        $params[] = $data->is_active;
    }
    
    if (isset($data->id_user_ref)) {
        $setValues[] = "id_user_ref = ?";
        $params[] = $data->id_user_ref;
    }
    
    $setValues[] = "updated_at = ?";
    $params[] = $currentDateTime;

    if (empty($setValues)) {
        echo json_encode(["message" => "Aucune données a modifier"]);
        http_response_code(400); 
        exit;
    }

    $params[] = $data->id; 
    $setClause = implode(', ', $setValues);
    $upd = $cnx->prepare("UPDATE line SET $setClause WHERE id = ?");
    
    if ($upd->execute($params)) {
        echo json_encode(["message" => "ligne mis à jour avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la mise à jour de l'étape"]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Méthode HTTP non supportée"]);
}
?>