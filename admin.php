<?php
require_once('./api/bdd.php');

session_start();

$upd = $cnx->prepare("SELECT u.id, u.last_name, u.first_name, u.birthdate, u.address, u.zipcode, u.phone_number_1, u.phone_number_2, u.mail, u.id_role, r.name AS role_name FROM user u LEFT JOIN role r ON u.id_role = r.id WHERE u.id = ?");
    
$upd->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);

$upd->execute();

$personne = $upd->fetch(PDO::FETCH_ASSOC);

$usersQuery = $cnx->query("SELECT u.id, u.last_name, u.first_name, u.birthdate, u.address, u.zipcode, u.phone_number_1, u.phone_number_2, u.mail, u.id_role, r.name AS role_name FROM user u LEFT JOIN role r ON u.id_role = r.id");
$users = $usersQuery->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="dist/output.css">
</head>
<body class="min-h-screen">
    <main class="flex font-inter">
        <section class="h-screen w-1/6 flex flex-col bg-lightBlue text-white">
            <div class="rounded-full h-24 w-24 avatar mx-auto mt-7"></div>
            <button class="ml-6 w-fit my-16 text-xl">Tableau de bord</button>
            <div class=" flex flex-col">
                <!-- Profile Tab -->
                <div class="flex flex-col h-1/4 overflow-hidden p-3" id="profile-wrapper">
                    <div class="flex justify-between cursor-pointer" id="profile-header">
                        <div class="flex items-center">
                            <img src="src/assets/images/profile/dashboard/profile.svg" alt="" class="w-7 mr-3">
                            <p>Mon profil</p>
                        </div>
                        <button id="profile-btn"><img src="src/assets/images/profile/dashboard/arrow.svg" alt="" id="profile-arrow"></button>
                    </div>
                    <div class="w-full mt-3" id="profile-menu">
                        <div class="flex pl-6 items-center mt-3 hover:bg-blue-500 bg-transparent rounded-lg py-1 transition-colors">
                            <img src="src/assets/images/profile/dashboard/admin.svg" alt="">
                            <a href="profile.php"  class="ml-2 ">Mes informations</a>
                        </div>
                        <div class="flex pl-6 items-center mt-3 hover:bg-blue-500 bg-transparent rounded-lg py-1 transition-colors">
                            <img src="src/assets/images/profile/dashboard/admin.svg" alt="">
                            <a href="profile.php"  class="ml-2 ">Mes enfants</a>
                        </div>
                    </div>
                </div>
                <!-- Calendar Tab -->
                <div class="flex flex-col h-1/4 overflow-hidden p-3" id="calendar-wrapper">
                    <div class="flex justify-between cursor-pointer" id="calendar-header">
                        <div class="flex items-center">
                            <img src="src/assets/images/profile/dashboard/calendar.svg" alt="" class="w-7 mr-3">
                            <a href="profile.php">Calendrier</a>
                        </div>
                    </div>
                </div>
                <!-- Settings Tab -->
                <div class="flex flex-col h-1/4 overflow-hidden p-3" id="settings-wrapper">
                    <div class="flex justify-between cursor-pointer" id="settings-header">
                        <div class="flex items-center">
                            <img src="src/assets/images/profile/dashboard/settings.svg" alt="" class="w-7 mr-3">
                            <a href="profile.php">Paramètres</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Logout Tab -->
            <div class="flex flex-col mt-auto  overflow-hidden p-3" id="logout-wrapper">
                <div class="flex justify-between cursor-pointer" id="logout-header">
                    <div class="flex items-center">
                        <img src="src/assets/images/profile/dashboard/logout.svg" alt="" class="w-7 mr-3">
                        <a href="logout.php">Déconnexion</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="w-5/6 h-screen bg-primary flex flex-col">
            <header class="w-full flex justify-between items-center p-8 border-b border-b-slate-200">
                <h1 class="text-secondary font-medium text-2xl">Bonjour <?= $personne['first_name'] . ' ' . $personne['last_name'] ?></h1>
                <nav class="flex">
                    <button><img src="src/assets/images/profile/mail.svg" alt="" class="mr-2"></button>
                    <button><img src="src/assets/images/profile/notification.svg" alt="" class="mr-8"></button>
                    <div class="rounded-full h-8 w-8 avatar "></div>
                </nav>
            </header>
            <div class="p-8">
                <h2>Liste des Utilisateurs</h2>
                <table class="w-full">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td class="text-center data-column"><?= $user['last_name'] ?></td>
                                <td class="text-center data-column"><?= $user['first_name'] ?></td>
                                <td class="text-center data-column"><?= $user['mail'] ?></td>
                                <td class="text-center data-column"><?= $user['role_name'] ?></td>
                                <td>
                                    <button class="edit-user-btn" data-id="<?= $user['id']?>">Modifier</button>
                                    <button class="delete-user-btn" data-id="<?= $user['id']?>"">Supprimer</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <script src="src/js/profile.js"></script>
    <script src="src/js/admin.js"></script>
</body>
</html>
