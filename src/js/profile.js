profileHeader = document.getElementById("profile-header");
profileWrapper = document.getElementById("profile-wrapper");
profileMenu = document.getElementById("profile-menu");
probileBtn = document.getElementById("profile-btn");
profileArrow = document.getElementById("profile-arrow");

function activeProfile(){
    profileWrapper.classList.toggle("active");
    profileArrow.classList.toggle("active");
    profileMenu.classList.toggle("active");
}

profileHeader.addEventListener("click", activeProfile);
profileBtn.addEventListener("click", activeProfile);