<?php

require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $lines = $cnx->query("SELECT ls.id, ls.name, ls.hour, ls.type, ls.id_line, lt.name AS line_name
                          FROM step ls
                          JOIN line lt ON ls.id_line = lt.id");

    $data = array();
    foreach ($lines as $line) {
        $data[] = [
            "id" => $line['id'],
            "name" => $line['name'],
            "hour" => $line["hour"],
            "type" => $line["type"],
            "line_name" => $line["line_name"],
        ];
    }

    echo json_encode($data);
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentDateTime = date('Y-m-d H:i:s');
    $upd = $cnx->prepare("INSERT INTO step SET name = ?, hour = ?, type = ?, id_line = ?, created_at = ?, updated_at = ?");
    
    if ($upd->execute([
        $_POST['name'],
        $_POST['hour'],
        $_POST['type'],
        $_POST['id_line'],
        $currentDateTime,  
        $currentDateTime  
    ])) {
        echo json_encode(["message" => "étape créé avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la création de l'étape"]);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $upd = $cnx->prepare("DELETE FROM step WHERE id = ?");
    if ($upd->execute([$data->id])) {
        echo json_encode(["message" => "étape supprimée avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression de l'étape"]);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $currentDateTime = date('Y-m-d H:i:s');
    if (!isset($data->id)) {
        echo json_encode(["message" => "L'id est requis pour modifier une étape"]);
        http_response_code(400); 
        exit;
    }

    $setValues = [];
    $params = [];

    if (isset($data->name)) {
        $setValues[] = "name = ?";
        $params[] = $data->name;
    }

    if (isset($data->hour)) {
        $setValues[] = "hour = ?";
        $params[] = $data->hour;
    }
    if (isset($data->type)) {
        $setValues[] = "type = ?";
        $params[] = $data->type;
    }
    
    if (isset($data->id_line)) {
        $setValues[] = "id_line = ?";
        $params[] = $data->id_line;
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
    $upd = $cnx->prepare("UPDATE step SET $setClause WHERE id = ?");
    
    if ($upd->execute($params)) {
        echo json_encode(["message" => "étape mis à jour avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la mise à jour de l'étape"]);
    }
} else {
    http_response_code(405);
    echo json_encode(["message" => "Méthode HTTP non supportée"]);
}


?>