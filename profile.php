<?php
require_once('./api/bdd.php');

session_start();

// var_dump($_SESSION);
$upd = $cnx->prepare("SELECT id, last_name, first_name, birthdate,address,zipcode,phone_number_1,phone_number_2,mail,id_role  FROM user WHERE id = ?");
    
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
            <?php if ($personne['id_role'] == 2): ?>
            <div class="flex flex-col h-1/4 overflow-hidden p-3" id="settings-wrapper">
                    <div class="flex justify-between cursor-pointer" id="settings-header">
                        <div class="flex items-center">
                            <img src="src/assets/images/profile/dashboard/admin.svg" alt="" class="w-7 mr-3">
                            <a href="profile.html">Administration</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
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
                        <!-- <div class="flex pl-6 items-center hover:bg-blue-500 bg-transparent rounded-lg py-1 transition-colors">
                            <img src="src/assets/images/profile/dashboard/admin.svg" alt="">
                            
                            <a href="profile.html"  class="ml-2 ">Administration</a>
                        </div> -->
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
        <section class="w-5/6 h-screen bg-[#F5F5F5] flex flex-col text-secondary">
            <header class="w-full flex justify-between items-center p-8 border-b border-b-slate-200">
                <h1 class=" font-medium text-2xl">Bonjour <?= $personne['first_name'] . ' ' . $personne['last_name'] ?></h1>
                <nav class="flex">
                    <button><img src="src/assets/images/profile/mail.svg" alt="" class="mr-2"></button>
                    <button><img src="src/assets/images/profile/notification.svg" alt="" class="mr-8"></button>
                    <div class="rounded-full h-8 w-8 avatar "></div>
                </nav>
            </header>
            <section class="pt-20 pl-6 pr-36 h-full">
                <h2 class=" font-medium text-xl mt-2">Mes informations</h2>
                <p class="mt-2">Consultez et mettez à jour vos informations ici, ainsi que vos identifiants et mot de passe.</p>
                <div class="w-full h-4/6 bg-white rounded-xl mt-6">
                    <div class="h-full w-1/2 border-r border-neutral-200 px-6">
                    <h3 class="text-secondary font-semibold pt-4">Informations personnelles</h3>
                        <div class="mt-6 pb-10 flex flex-wrap border-b-2 border-neutral-100">
                            <div class="flex flex-col w-1/2">
                                <p class="font-medium mb-2">Nom</p>
                                <p><?= $personne['last_name'] ?></p>
                                
                            </div>
                            <div class="flex flex-col w-1/2">
                                <p class="font-medium mb-2">Prénom</p>
                                <p><?= $personne['first_name'] ?></p>
                                
                            </div>
                            <div class="flex flex-col w-1/2 mt-7">
                                <p  class="font-medium mb-2">Date de naissance</p>
                                <p><?= $personne['birthdate'] ?></p>
                                
                            </div>
                            <div class="flex flex-col w-1/2 mt-7">
                                <p class="font-medium mb-2">Numéro de téléphone</p>
                                <p><?= $personne['phone_number_1'] ?></p>
                                
                        </div>
                    </div>
                    <div class="h-full  flex ">
                        <div class="mt-6 w-1/2">
                            <p class="font-medium mb-2">Adresse mail</p>
                            <p><?= $personne['mail'] ?></p>
                        </div>
                        <div class="mt-6 w-1/2">
                            <p class="font-medium mb-2">Mot de passe</p>
                            <p>********</p>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        
    </main>

    <script src="src/js/profile.js"></script>
</body>
</html>