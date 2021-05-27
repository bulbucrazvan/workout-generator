let registerForm = document.getElementById("register-form");
let emailError = document.getElementById("email-message");
let userNameError = document.getElementById("username-message");
registerForm.addEventListener('submit', createUser);

function createUser(event) {
    event.preventDefault();
    emailError.classList.add('error-message--hidden');
    userNameError.classList.add('error-message--hidden');
    sendRequest();
}

const sendRequest = async () => {
    var requestBody = {};
    var formData = new FormData(registerForm);
    formData.forEach(function(value, key) {
        requestBody[key] = value;
    });
    const response = await fetch("http://92.115.143.213:3000/project/api/users", {
        method: 'POST',
         body: JSON.stringify(requestBody),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    const responseBody = await response.json();
    console.log(responseBody);
    if (!responseBody["statusCode"]) {
        window.location.href = "/project/public/home/exerciseViewer";
    }
    else {
        showErrors(responseBody["statusCode"]);
    }

}

function showErrors(errorCode) {

    if (errorCode == 1) {
        userNameError.classList.remove("error-message--hidden");
    }
    else if (errorCode == 2) {
        emailError.classList.remove("error-message--hidden");
    }
    else {
        emailError.classList.remove("error-message--hidden");
        userNameError.classList.remove("error-message--hidden");
    }

    document.getElementById("password-field").value = '';

}