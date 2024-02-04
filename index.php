<?php
// On insère le code HTML du début de page 
require_once('include/top.php');
?>
</head>
<body>
<?php 
// Ternaire qui définit si on a transmis une variable action via l'URL
$action= isset($_GET['action']) ? $_GET['action'] : 'home';

//Connexion à la base de données
require_once('api/bdd.php');
// Récupération du fichier api en fonction de la variable $action
require_once('api/'.$action.'.php');
// Insère du pied de page
require_once('include/bottom.php');
?>