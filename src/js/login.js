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
    // let registerFormData = new FormData(registerForm);

    // var lastName = registerFormData.get('lastName');
    // var firstName = registerFormData.get('firstName');
    // var birthdate = registerFormData.get('birthdate');
    // var mail = registerFormData.get('mail');
    // var password = registerFormData.get('password');
    // var phone_number_1 = registerFormData.get('phone_number_1');
    // var address = registerFormData.get('address');
    // var zipcode = registerFormData.get('zipcode');
    // var city = registerFormData.get('city');
    // const registerData = {
    //     lastName: lastName,
    //     firstName: firstName,
    //     birthdate: birthdate,
    //     mail: mail,
    //     password: password,
    //     phone_number_1: phone_number_1,
    //     address: address,
    //     zipcode: zipcode,
    //     city: city
    // }
    // const jsonRegisterData = JSON.stringify(registerData);
    // console.log(jsonRegisterData);
    let formData = new FormData(registerForm);
    let object = {};
    formData.forEach(function(value, key){
        object[key] = value;
    });
    let json = JSON.stringify(object);
 

    const response = await fetch('http://localhost:8080/api/user.php', {
        method: 'POST',
        mode: 'cors',
        headers: {
            'Content-Type': 'application/json'
        },
        body: json
    }).then(response => response.json())
    console.log(response);
})
