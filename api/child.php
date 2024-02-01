<?php
require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $personnes = $cnx->query("SELECT id, last_name, first_name, birthdate,id_user_parent,id_line,id_step FROM child");

    $data = array();

    foreach ($personnes as $personne) {
        $data[] = [
            "id" => $personne['id'],
            "last_name" => $personne['last_name'],
            "first_name" => $personne["first_name"],
            "id_user_parent" => $personne["id_user_parent"],
            "id_line" => $personne["id_line"],
            "id_step" => $personne["id_step"],
        ];
    }

    echo json_encode($data);
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentDateTime = date('Y-m-d H:i:s');
    $upd = $cnx->prepare("INSERT INTO child SET last_name = ?, first_name = ?, birthdate = ?, id_user_parent = ?, id_line = ?, id_step = ?, created_at = ?, updated_at = ?");

    if ($upd->execute([
        $_POST['lastName'],
        $_POST['firstName'],
        $currentDateTime,
        $_POST['parent'],
        $_POST['line'],
        $_POST['step'],
        $currentDateTime,  
        $currentDateTime,
    ])) {
        echo json_encode(["message" => "Enfant créé avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la création de l'enfant"]);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $upd = $cnx->prepare("DELETE FROM child WHERE id = ?");
    if ($upd->execute([$data->id])) {
        echo json_encode(["message" => "Enfant supprimé avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression de l'enfant"]);
    }
}
elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $currentDateTime = date('Y-m-d H:i:s');
    if (!isset($data->id)) {
        echo json_encode(["message" => "L'id est requis pour modifier un user"]);
        http_response_code(400);
        exit;
    }

    $setValues = [];
    $params = [];

    if (isset($data->last_name)) {
        $setValues[] = "last_name = ?";
        $params[] = $data->last_name;
    }

    if (isset($data->first_name)) {
        $setValues[] = "first_name = ?";
        $params[] = $data->first_name;
    }
    if (isset($data->birthdate)) {
        $setValues[] = "birthdate = ?";
        $params[] = $data->birthdate;
    }
    
    if (isset($data->id_user_parent)) {
        $setValues[] = "id_user_parent = ?";
        $params[] = $data->id_user_parent;
    }
    
    if (isset($data->id_line)) {
        $setValues[] = "id_line = ?";
        $params[] = $data->id_line;
    }
    
    
    if (isset($data->id_step)) {
        $setValues[] = "id_step = ?";
        $params[] = $data->id_step;
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
    $upd = $cnx->prepare("UPDATE child SET $setClause WHERE id = ?");
    
    if ($upd->execute($params)) {
        echo json_encode(["message" => "Enfant mis à jour avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la mise à jour de l'enfant"]);
    }
} else {
    http_response_code(405); 
    echo json_encode(["message" => "Méthode HTTP non supportée"]);
}




?>