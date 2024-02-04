<?php

require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $role = $cnx->query("SELECT id, name FROM role");

    $data = array();

    foreach ($role as $role) {
        $data[] = [
            "id" => $role['id'],
            "name" => $role["name"],
        ];
    }

    echo json_encode($data);
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenir l'heure actuelle au format datetime
    $currentDateTime = date('Y-m-d H:i:s');
    $upd = $cnx->prepare("INSERT INTO role SET name = ?, created_at = ?, updated_at = ?");
    
    if ($upd->execute([
        $_POST['name'],
        $currentDateTime,  
        $currentDateTime  
    ])) {
        echo json_encode(["message" => "role créé avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la création de la role"]);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $upd = $cnx->prepare("DELETE FROM role WHERE id = ?");
    if ($upd->execute([$data->id])) {
        echo json_encode(["message" => "role supprimée avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression de la role"]);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $currentDateTime = date('Y-m-d H:i:s');
    if (!isset($data->id)) {
        echo json_encode(["message" => "L'id est requis pour modifier un role"]);
        http_response_code(400); 
        exit;
    }

    $setValues = [];
    $params = [];

    if (isset($data->name)) {
        $setValues[] = "name = ?";
        $params[] = $data->name;
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
    $upd = $cnx->prepare("UPDATE role SET $setClause WHERE id = ?");
    
    if ($upd->execute($params)) {
        echo json_encode(["message" => "role mis à jour avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la mise à jour de l'étape"]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Méthode HTTP non supportée"]);
}


?>