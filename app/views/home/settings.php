<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/settings.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../signed-navbar.php");
    ?>
    <main>      
        <section class="main-bubble">
        <div class="main-bubble__area main-bubble__area--tab-area">
            <div> <button id="userSettingsBtn" class="tab-area__button tab-area__button--user-settings tab-area__button--selected"> User Settings </button></div>
            <div> <button id="accountSettingsBtn" class="tab-area__button tab-area__button--account-settings"> Account Settings </button> </div>
        </div>
        <div class="main-bubble__area main-bubble__area--settings-area">
            <div id="userSettingsArea" class="settings-area">
                <div class="settings-area__setting">
                    <p> User Data </p>
                    <div class="settings-area__setting--indented">
                        <div class="setting__form--separator">
                            <p class="output-area--inline"> Gender: </p>
                            <p class="output-area output-area--inline"> Male </p>
                        </div>
                        <div class="setting__form--separator">
                            <form class="setting__form">
                                <div class="setting__form--separator">
                                    <label> Date of birth: </label>
                                    <input class="output-area" type="date" value="2000-01-01">
                                </div> 
                            </form>
                        </div>
                        <div class="setting__form--separator">
                            <form class="setting__form">
                                <div class="setting__form--separator">
                                    <label> Height: </label>
                                    <input class="output-area" type="number" value="170">
                                </div> 
                            </form>
                        </div>
                        <div class="setting__form--separator">
                            <form class="setting__form">
                                <div class="setting__form--separator">
                                    <label> Weight: </label>
                                    <input class="output-area" type="number" value="60">
                                </div> 
                            </form>
                        </div>
                    </div>
                </div>
                <div class="settings-area__button-area">
                    <button class="settings-area__save-button"> Save </button>
                </div>
            </div>
            <div id="accountSettingsArea" class="settings-area settings-area--hidden"> 
                <div class="settings-area__setting">
                    <p> Account Username </p>
                    <div class="settings-area__setting--indented"> 
                        <p> Username: </p>
                        <p class="output-area"> User1 </p> 
                    </div>
                </div>
                <div class="settings-area__setting">
                    <p> Account E-Mail </p>
                    <div class="settings-area__setting--indented">
                        <p> Current E-Mail: </p>
                        <p class="output-area"> user1@email.com </p> 
                        <form class="setting__form">
                            <div class="setting__form--separator">
                                <label> New E-Mail: </label>
                                <input class="output-area" type="email" placeholder="Insert e-mail">
                            </div>
                        </form>
                    </div> 
                </div>
                <div class="settings-area__setting">
                    <p> Account Password </p>
                    <div class="settings-area__setting--indented">
                        <form class="setting__form">
                            <div class="setting__form--separator">
                                <label> Current password: </label>
                                <input type="password" class="output-area">
                            </div>
                            <div class="setting__form--separator">
                                <label> New password: </label>
                                <input type="password" class="output-area">
                            </div>
                            <div class="setting__form--separator">
                                <label> Re-type password: </label>
                                <input type="password" class="output-area">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="settings-area__button-area">
                    <button class="settings-area__save-button"> Save </button>
                </div>
            </div>
        </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>

<script>
    let userSettings = document.getElementById("userSettingsBtn");
    let accountSettings = document.getElementById("accountSettingsBtn");
    let userSettingsArea = document.getElementById("userSettingsArea");
    let accountSettingsArea = document.getElementById("accountSettingsArea");


    userSettings.addEventListener('click', function() {
        userSettingsArea.classList.remove('settings-area--hidden');
        accountSettingsArea.classList.add('settings-area--hidden');
        userSettings.classList.add('tab-area__button--selected');
        accountSettings.classList.remove("tab-area__button--selected");
    })

    accountSettings.addEventListener('click', function() {
        userSettingsArea.classList.add('settings-area--hidden');
        accountSettingsArea.classList.remove('settings-area--hidden');
        userSettings.classList.remove('tab-area__button--selected');
        accountSettings.classList.add("tab-area__button--selected");
    })
</script>


