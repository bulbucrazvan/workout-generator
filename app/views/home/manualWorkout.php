<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/workout-viewer.css">
    <link rel="stylesheet" href="/project/public/css/new-workout.css">
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
                <p class="filter-area__workout-name"> Manual Workout </p>
                <div id="addExerciseArea" class="filter-area__add-exercise-area">
                    <button id="addExerciseButton" class="add-exercise-area__button"> Add exercise </button>
                    <div class="add-exercise-area__dropdown add-exercise-area__blur-area"></div>
                    <ul class="add-exercise-area__dropdown add-exercise-area__list">
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                        <li class="exercise-list__item">
                            <p class=exercise-list__exercise> Bicep Curl </p>
                            <form class="exercise-list__form">
                                <button class="exercise-list-form__button exercise-list-form__button--view"> View </button>
                                <button class="exercise-list-form__button exercise-list-form__button--add"> Add </button> 
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-bubble__area main-bubble__area--list-area">
                <ul class="list-area__list">
                </ul>   
            </div>
            <div class="main-bubble__area main-bubble__area--button-area">
                <button class="list-area__button button-area__button button-area__button--save"> Save </button>
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

<script src="/project/public/javascript/addexercisebutton.js">
</script>

<script>
    let viewBtn = document.getElementById("test");
    viewBtn.addEventListener('click', function(){
        window.location.href = "/project/public/home/exerciseViewer";
    })


</script>
