const registerWrapper = document.querySelector('.register-wrapper');
const registerButton = document.querySelector('.register-login-button');

const closeCross = document.querySelector('.close-cross');

registerButton.addEventListener('click', () => {
    registerWrapper.classList.toggle('active-register-wrapper');
});

closeCross.addEventListener('click', () => {
    registerWrapper.classList.toggle('active-register-wrapper');
});

const registerForm = document.getElementById('register-form');
registerForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    let formData = new FormData(registerForm);
    let object = {};
    formData.forEach(function(value, key){
        object[key] = value;
    });
    let json = JSON.stringify(object);
 

    const response = await fetch('http://localhost:80/api/users.php', {
        method: 'POST',
        mode: 'cors',
        headers: {
            'Content-Type': 'application/json'
        },
        body: json
    }).then(response => response.json())
    console.log(response);
    return true
})

const loginForm = document.getElementById('login-form')

loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();

    let formData = new FormData(loginForm);
    let object = {};
    formData.forEach(function(value, key){
        object[key] = value;
    });
    let json = JSON.stringify(object);
 

    const response = await fetch('http://localhost:80/api/login.php', {
        method: 'POST',
        mode: 'cors',
        headers: {
            'Content-Type': 'application/json'
        },
        body: json
    }).then(response => response.json())
    console.log(response.message);
    if (response.message == "Connexion réussie") {
        // Rediriger l'utilisateur vers profile.php
        window.location.href = 'profile.php';
    }
    return true
})