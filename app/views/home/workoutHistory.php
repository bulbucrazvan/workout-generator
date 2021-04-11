<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
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
                <p> Workout History </p>
                <form>
                <label> Sort by </label>
                <select id="comboBox" class="combo-box">
                    <option> Most recent </option>
                    <option> Least recent </option>
                </select> 
                </form>
            </div>
            <div class="main-bubble__area main-bubble__area--list-area">
                <ul class="list-area__list">
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="button">Start</button>
                        <button class="list-area__button list-area__button--view" type="button">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="button">Start</button>
                        <button class="list-area__button list-area__button--view" type="button">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="button">Start</button>
                        <button class="list-area__button list-area__button--view" type="button">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="button">Start</button>
                        <button class="list-area__button list-area__button--view" type="button">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="button">Start</button>
                        <button class="list-area__button list-area__button--view" type="button">View</button>
                    </form>
                </li>
                <li> 
                    <p class="list-area__paragraph list-area__paragraph--left">Workout 1</p> 
                    <form class="list-area__form">
                        <button class="list-area__button list-area__button--start" type="button">Start</button>
                        <button class="list-area__button list-area__button--view" type="button">View</button>
                    </form>
                </li>
                </ul>
            </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>

<script src="/project/public/javascript/listbackgroundselector.js">
</script>

<script src="/project/public/javascript/comboboxclick.js">
</script>

<script>
    let viewBtns = document.getElementsByClassName("list-area__button--view");
    let startBtns = document.getElementsByClassName("list-area__button--start");

    for (var i = 0; i < viewBtns.length; i++){
        viewBtns[i].addEventListener('click', function() {
            window.location.href = "/project/public/home/workoutViewer";
        });

        startBtns[i].addEventListener('click', function() {
            window.location.href = "/project/public/home/startWorkout";
        })
    }
</script>