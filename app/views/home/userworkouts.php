<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/user-workouts.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../signed-navbar.php");
    ?>
    <main>
        <section class="main-bubble">
            <div class="main-bubble__area main-bubble__area--filter-area"> 
                <p> My Workouts </p>
                <form>
                <label> Filter by </label>
                <select id="comboBox" class="combo-box">
                    <option> All </option>
                    <optgroup label="Location">
                        <option> Outside </option>
                        <option> Gym </option>
                        <option> Home </option>
                    </optgroup>
                    <optgroup label="Muscle Group">
                        <option> Chest </option>
                        <option> Back </option>
                    </optgroup>
                    <optgroup label="More to follow..">
                    </optgroup>
                </select> 
                </form>
            </div>
            <div class="main-bubble__area main-bubble__area--list-area">
                <ul class="list-area__list">
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="submit">Start</button>
                        <button class="list-area__button list-area__button--view" type="submit">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="submit">Start</button>
                        <button class="list-area__button list-area__button--view" type="submit">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="submit">Start</button>
                        <button class="list-area__button list-area__button--view" type="submit">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="submit">Start</button>
                        <button class="list-area__button list-area__button--view" type="submit">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="submit">Start</button>
                        <button class="list-area__button list-area__button--view" type="submit">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="submit">Start</button>
                        <button id="test" class="list-area__button list-area__button--view" type="button">View</button>
                    </form>
                </li>
                </ul>
            </div>
            <div class="main-bubble__area main-bubble__area--new-workout">
                <p> Create new workout </p>
                <div>
                    <button id="manualWrkt"> Manual </button>
                    <button id="generateWrkt"> Generate workout </button>
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
let workoutHistory = document.getElementById("test");
let generate = document.getElementById("generateWrkt");
let manual = document.getElementById("manualWrkt");

manual.addEventListener('click', function() {
    window.location.href = "/project/public/home/manualWorkout";
})

generate.addEventListener('click', function() {
    window.location.href = "/project/public/home/generateWorkout";
})

workoutHistory.addEventListener('click', function() {
    window.location.href = "/project/public/home/workoutViewer";
});
</script>

<script src="/project/public/javascript/listbackgroundselector.js">
</script>

<script src="/project/public/javascript/comboboxclick.js">
</script>
