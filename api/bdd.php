<?php
$host = "127.0.0.1";
$database="qcqc_pedibus_api";
$user ="root";
$pass="password";
$charset = 'utf8mb4'; //encodage des caractères
//script de connexion PDO
$dsn = "mysql:host=$host;dbname=$database;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,// affiche les erreurs PDO
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,// On utilise les noms de champs et pas les index
    PDO::ATTR_EMULATE_PREPARES   => false,// On force la compilation côté serveur et non côté client
];
// ont teste
try {
     $cnx = new PDO($dsn, $user, $pass, $options);
} 
// On affiche les messages s'il y a des erreurs de connexion
catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>