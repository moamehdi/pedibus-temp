<?php
require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $personnes = $cnx->query("SELECT id, last_name, first_name, birthdate,address,zipcode,phone_number_1,phone_number_2,mail FROM user");

    $data = array();

    foreach ($personnes as $personne) {
        $data[] = [
            "id" => $personne['id'],
            "last_name" => $personne['last_name'],
            "first_name" => $personne["first_name"],
            "birthdate" => $personne["birthdate"],
            "address" => $personne["address"],
            "zipcode" => $personne["zipcode"],
            "phone_number_1" => $personne["phone_number_1"],
            "mail" => $personne["mail"],

        ];
    }

    echo json_encode($data);
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $currentDateTime = date('Y-m-d H:i:s');
    $upd = $cnx->prepare("INSERT INTO user SET last_name = ?, first_name = ?, birthdate = ?, address = ?, zipcode = ?, phone_number_1 = ?,phone_number_2 = ?, mail = ?, password = ?, created_at = ?, updated_at = ?");

    if ($upd->execute([
        $_POST['lastName'],
        $_POST['firstName'],
        $currentDateTime,
        $_POST['address'],
        $_POST['zipcode'],
        $_POST['phone_number_1'],
        $_POST['phone_number_2'],
        $_POST['mail'],
        $hashedPassword,
        $currentDateTime,  
        $currentDateTime  
    ])) {
        echo json_encode(["message" => "Utilisateur créé avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la création de l'utilisateur"]);
    }
}

elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $parse = file_get_contents('php://input');
    $data = json_decode($parse);
    $upd = $cnx->prepare("DELETE FROM user WHERE id = ?");
    if ($upd->execute([$data->id])) {
        echo json_encode(["message" => "Utilisateur supprimé avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la suppression de l'utilisateur"]);
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
    
    if (isset($data->address)) {
        $setValues[] = "address = ?";
        $params[] = $data->address;
    }
    
    if (isset($data->zipcode)) {
        $setValues[] = "zipcode = ?";
        $params[] = $data->zipcode;
    }
    
    if (isset($data->phone_number_1)) {
        $setValues[] = "phone_number_1 = ?";
        $params[] = $data->phone_number_1;
    }
    
    if (isset($data->phone_number_2)) {
        $setValues[] = "phone_number_2 = ?";
        $params[] = $data->phone_number_2;
    }
    
    if (isset($data->mail)) {
        $setValues[] = "mail = ?";
        $params[] = $data->mail;
    }
    
    if (isset($data->password)) {
        $setValues[] = "password = ?";
        $params[] = $data->password;
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
    $upd = $cnx->prepare("UPDATE user SET $setClause WHERE id = ?");
    
    if ($upd->execute($params)) {
        echo json_encode(["message" => "Utilisateur mis à jour avec succès"]);
    } else {
        echo json_encode(["message" => "Erreur lors de la mise à jour de l'utilisateur"]);
    }
} else {
    http_response_code(405); 
    echo json_encode(["message" => "Méthode HTTP non supportée"]);
}




?>