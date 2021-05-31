<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/workout-viewer.css">
    <link rel="stylesheet" href="/project/public/css/settings.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/admin-navbar.php");
    ?>
    <main>      
        <section class="main-bubble">
        <div class="main-bubble__area main-bubble__area--tab-area">
            <div> <button id="exercisesBtn" class="tab-area__button tab-area__button--user-settings tab-area__button--selected"> Exercises </button></div>
            <div> <button id="editorBtn" class="tab-area__button tab-area__button--user-settings"> Add/Edit </button></div>
        </div>
        <div id="viewerArea" class="main-bubble__area main-bubble__area--list-area">
            <ul id="exerciseListElement" class="list-area__list">
            </ul>   
        </div>
        <div id="editorArea" class="main-bubble__area main-bubble__area--settings-area settings-area--hidden">
            <div class="settings-area"> 
                <div class="settings-area__setting">
                    <p> Exercise Details </p>
                    <div class="settings-area__setting--indented">
                        <form class="setting__form">
                            <div class="setting__form--separator">
                                <label> Name: </label>
                                <input id="nameInput" type="text" class="output-area">
                            </div>
                            <div class="setting__form--separator">
                                <label> Video link: </label>
                                <input id="linkInput" type="" class="output-area">
                            </div>
                            <div class="setting__form--separator">
                                <label> Duration: </label>
                                <input id="durationInput" type="number" class="output-area">
                            </div>
                            <div class="setting__form--separator">
                                <label> Muscle Groups: </label>
                                    <div id="muscleCheckboxes" class="selector-area__input-area output-area">
                                        <?php
                                            foreach ($data["muscles"] as $key => $value) {
                                                echo "<input id='muscle" . $value[1] . "' type='checkbox'>" . $value[1] . " </input>\n";
                                            }
                                        ?>
                                    </div>      
                            </div>
                            <div class="setting__form--separator">
                                <label> Location: </label>
                                    <div id="locationCheckboxes" class="selector-area__input-area output-area">
                                        <?php
                                            foreach ($data["locations"] as $key => $value) {
                                                echo "<input id='location" . $value[1] . "' type='checkbox'>" . $value[1] . "</input>\n";
                                            }
                                        ?>
                                    </div>      
                            </div>
                            <div class="setting_form--separator">
                                <label> Instructions: </label>
                                <textarea id="instructionsInput" name="instructions" class="output-area instructions-area"> </textarea>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="settings-area__button-area">
                    <button id="saveBtn" class="settings-area__save-button"> Save </button>
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

<style>
    .settings-area {
        position: relative;
    }
    .settings-area__button-area {
        position: absolute;
        bottom: 5%;
    }
    .instructions-area {
        width: 60%;
        height: 20%;
    }
    .selector-area__input-area {
        display: inline;
    }
</style>

<script src="/project/public/javascript/listbackgroundselector.js"></script>
<script src="/project/public/javascript/admin/admin.js"></script>

