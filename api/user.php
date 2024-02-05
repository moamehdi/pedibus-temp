<?php

require_once('bdd.php');

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PATCH');
header('Content-Type: application/json');
header("Access-Control-Allow-Headers: *");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    $upd = $cnx->prepare("SELECT id, last_name, first_name, birthdate,address,zipcode,phone_number_1,phone_number_2,mail  FROM user WHERE id = ?");
    
    $upd->bindParam(1, $id, PDO::PARAM_INT);

    $upd->execute();
    

    $personne = $upd->fetch(PDO::FETCH_ASSOC);

    $data = array();

    if ($personne) {
        $data[] = [
            "id" => $personne['id'],
            "last_name" => $personne['last_name'],
            "first_name" => $personne["first_name"],
            "birthdate" => $personne["birthdate"],
            "address" => $personne["address"],
            "zipcode" => $personne["zipcode"],
            "phone_number_1" => $personne["phone_number_1"],
            "phone_number_2" => $personne["phone_number_2"],
            "mail" => $personne["mail"],
        ];
    }

    echo json_encode($data);
}
