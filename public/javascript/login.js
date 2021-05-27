let loginForm = document.getElementById("login-form");
let errorMessage = document.getElementById("error-message");
loginForm.addEventListener('submit', checkCredentials);

function checkCredentials(event) {
    event.preventDefault();
    errorMessage.classList.add('error-message--hidden');
    sendRequest();
}

const sendRequest = async () => {
    var queryString = {};
    var formData = new FormData(loginForm);
    formData.forEach(function(value, key) {
        queryString[key] = value;
    });
    var query = Object.keys(queryString)
                  .map(k => encodeURIComponent(k) + '=' + encodeURIComponent(queryString[k]))
                  .join('&');
    var apiUri = "http://92.115.143.213:3000/project/api/users/login?" + query;
    const response = await fetch(apiUri, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    const responseBody = await response.json();
    if (!responseBody["statusCode"]) {
        window.location.href = "/project/public/authorization/beginSession/" + responseBody["description"];
    }
    else {
        showErrors();
    }

}

function showErrors(errorCode) {

    errorMessage.classList.remove('error-message--hidden');
    document.getElementById("password-field").value = '';

}