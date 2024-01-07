const registerWrapper = document.querySelector('.register-wrapper');
const registerButton = document.querySelector('.register-login-button');

const closeCross = document.querySelector('.close-cross');

registerButton.addEventListener('click', () => {
    registerWrapper.classList.toggle('active-register-wrapper');
});

closeCross.addEventListener('click', () => {
    registerWrapper.classList.toggle('active-register-wrapper');
});
