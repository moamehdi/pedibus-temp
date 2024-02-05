<?php
require_once('./api/bdd.php');

session_start();

// var_dump($_SESSION);
$upd = $cnx->prepare("SELECT id, last_name, first_name, birthdate,address,zipcode,phone_number_1,phone_number_2,mail  FROM user WHERE id = ?");
    
$upd->bindParam(1, $_SESSION['user_id'], PDO::PARAM_INT);

$upd->execute();
    
$personne = $upd->fetch(PDO::FETCH_ASSOC);
// var_dump($personne);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="dist/output.css">
</head>
<body class="min-h-screen">
    <main class="flex font-inter">
        <!-- Dashboar sidebar -->
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
                        <div class="flex pl-6 items-center hover:bg-blue-500 bg-transparent rounded-lg py-1 transition-colors">
                            <img src="src/assets/images/profile/dashboard/admin.svg" alt="">
                            <a href="profile.html"  class="ml-2 ">Administration</a>
                        </div>
                        <div class="flex pl-6 items-center mt-3 hover:bg-blue-500 bg-transparent rounded-lg py-1 transition-colors">
                            <img src="src/assets/images/profile/dashboard/admin.svg" alt="">
                            <a href="profile.html"  class="ml-2 ">Mes informations</a>
                        </div>
                        <div class="flex pl-6 items-center mt-3 hover:bg-blue-500 bg-transparent rounded-lg py-1 transition-colors">
                            <img src="src/assets/images/profile/dashboard/admin.svg" alt="">
                            <a href="profile.html"  class="ml-2 ">Mes enfants</a>
                        </div>
                    </div>
                </div>
                <!-- Calendar Tab -->
                <div class="flex flex-col h-1/4 overflow-hidden p-3" id="calendar-wrapper">
                    <div class="flex justify-between cursor-pointer" id="calendar-header">
                        <div class="flex items-center">
                            <img src="src/assets/images/profile/dashboard/calendar.svg" alt="" class="w-7 mr-3">
                            <a href="profile.html">Calendrier</a>
                        </div>
                    </div>
                </div>
                <!-- Settings Tab -->
                <div class="flex flex-col h-1/4 overflow-hidden p-3" id="settings-wrapper">
                    <div class="flex justify-between cursor-pointer" id="settings-header">
                        <div class="flex items-center">
                            <img src="src/assets/images/profile/dashboard/settings.svg" alt="" class="w-7 mr-3">
                            <a href="profile.html">Paramètres</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Logout Tab -->
                <div class="flex flex-col mt-auto  overflow-hidden p-3" id="logout-wrapper">
                    <div class="flex justify-between cursor-pointer" id="logout-header">
                        <div class="flex items-center">
                            <img src="src/assets/images/profile/dashboard/logout.svg" alt="" class="w-7 mr-3">
                            <a href="profile.html">Déconnexion</a>
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
        </section>
    </main>

    <script src="src/js/profile.js"></script>
</body>
</html>