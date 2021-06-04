let userSettingsButton = document.getElementById("userSettingsBtn");
let accountSettingsButton = document.getElementById("accountSettingsBtn");
let userSettingsArea = document.getElementById("userSettingsArea");
let accountSettingsArea = document.getElementById("accountSettingsArea");

async function getUser() {
    var uri = "http://92.115.143.213:3000/project/api/users/" + userID;
    const response = await fetch(uri, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': loginKey 
        }
    });
    const responseBody = await response.json();
    if (responseBody["statusCode"]) {
        document.cookie = "errorMessage=" + encodeURIComponent(responseBody["description"]) + "; path=/";
        window.location.href = "/project/public/errorMessage";
    }
    return responseBody["description"];
}

async function putUser(user) {
    var uri = "http://92.115.143.213:3000/project/api/users/" + userID;
    const response = await fetch(uri, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': loginKey 
        },
        body: JSON.stringify(user)
    });
    const responseBody = await response.json();
    if (responseBody["statusCode"]) {
        document.cookie = "errorMessage=" + encodeURIComponent(responseBody["description"]) + "; path=/";
        window.location.href = "/project/public/errorMessage";
    }
    return responseBody["description"];
}

function genderToInt(gender) {
    if (gender == 'Male') {
        return 1;
    }
    return 0;
}

async function updateUserSettings() {
    var data = {};
    data['height'] = document.getElementById('height').value;
    data['weight'] = document.getElementById('weight').value;
    data['dateOfBirth'] = document.getElementById('dateOfBirth').value;
    genderElement = document.getElementById('gender'); 
    if (genderElement.hasAttribute('value')) {
        data['gender'] = genderElement.value;
    }
    else {
        data['gender'] = genderToInt(genderElement.innerHTML);
    }
    data["email"] = "";
    data["oldPassword"] = "";
    data["newPassword"] = "";
    data["type"] = 0;
    var response = await putUser(data);
    window.alert(response["description"]);
    await initializePage();
}

async function updateAccountSettings() {
    let newPassword = document.getElementById('newPassword').value;
    let retypePassword = document.getElementById('retypePassword').value;
    if (newPassword != retypePassword) {
        window.alert("Passwords don't match");
        document.getElementById('newPassword').value = '';
        document.getElementById('retypePassword').value = '';
        document.getElementById('currentPassword').value = '';
        return;
    }
    var data = {};
    data['height'] = ""
    data['weight'] = "";
    data['dateOfBirth'] = "";
    data['gender'] = "";
    data['email'] = document.getElementById('newEmail').value;
    data['oldPassword'] = document.getElementById('currentPassword').value;
    data['newPassword'] = document.getElementById('newPassword').value;
    data['type'] = 0;
    if (data['newPassword']) {
        data['type'] += 1;
    }
    if (data['email']) {
        data['type'] += 2;
    }
    console.log(data);
    var response = await putUser(data);
    window.alert(response["description"]);
    await initializePage();
}

function appendGenderElement(gender) {
    let genderParentElement = document.getElementById("genderDiv");
    var genderElement;
    if (!(gender === null)) {
        genderElement = `<p id="gender" class="output-area output-area--inline">` + gender + `</p>`
    }
    else {
        genderElement = `
        <select id="gender" class="output-area output-area--inline">
            <option value="1"> Male </option>
            <option value="0"> Female </option>    
        </select>`;
    }
    genderParentElement.innerHTML += genderElement;
}

function initializeUserSettings(userSettings) {
    appendGenderElement(userSettings["gender"]);

    for (setting in userSettings) {
        settingElement = document.getElementById(setting);
        settingElement.value = userSettings[setting];
    }
}

function initializeAccountSettings(accountSettings) {
    document.getElementById('username').innerHTML = accountSettings['username'];
    document.getElementById('email').innerHTML = accountSettings['email'];
    document.getElementById('newEmail').value = '';
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('retypePassword').value = ''; 
}

async function initializePage() {
    var user = await getUser();
    userSettings = (({gender, dateOfBirth, height, weight}) => ({gender, dateOfBirth, height, weight}))(user);
    accountSettings = (({username, email}) => ({username, email}))(user);
    initializeUserSettings(userSettings);
    initializeAccountSettings(accountSettings);
}

initializePage();

userSettingsButton.addEventListener('click', function() {
    userSettingsArea.classList.remove('settings-area--hidden');
    accountSettingsArea.classList.add('settings-area--hidden');
    userSettingsButton.classList.add('tab-area__button--selected');
    accountSettingsButton.classList.remove("tab-area__button--selected");
})

accountSettingsButton.addEventListener('click', function() {
    userSettingsArea.classList.add('settings-area--hidden');
    accountSettingsArea.classList.remove('settings-area--hidden');
    userSettingsButton.classList.remove('tab-area__button--selected');
    accountSettingsButton.classList.add("tab-area__button--selected");
})

document.getElementById('userSettingsSaveBtn').addEventListener('click', function(event) {
    event.preventDefault();
    updateUserSettings();
})

document.getElementById('accountSettingsSaveBtn').addEventListener('click', function(event) {
    event.preventDefault();
    updateAccountSettings();
})