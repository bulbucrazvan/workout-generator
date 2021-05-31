<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/exercise-viewer.css">
    <link rel="stylesheet" href="/project/public/css/workout-runner.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../signed-navbar.php");
    ?>
    <main>
        <section class="main-bubble">
        <div class="main-bubble__area main-bubble__area--current-exercise-area">
            <p id="workoutName"> <?=$data['name']?> </p>
            <p id="exerciseName"> Exercise 1 </p>
        </div>
        <div class="main-bubble__area main-bubble__area--exercise-description-area">
            <div class="exercise-description exercise-description__video-half">
                <video class="video-half__video" controls>
                    <source id="videoURL">
                </video>
                <div class="video-half__controls">
                    <p> Time remaining: </p>
                    <p id="remainingTime"> 40 s</p>
                    <div class="controls__button-area">
                        <button id="startBtn" class="button-area__button button-area__button--start" type="button"> Start </button>
                        <button id="pauseBtn" class="button-area__button button-area__button--pause" type="button"> Pause </button>
                        <button id="stopBtn" class="button-area__button button-area__button--stop" type="button"> Stop </button>
                    </div>
                    <div class="controls__button-area">
                        <button id="previousExercise" class="button-area__button button-area__button--previous" type="button"> Previous Exercise </button>
                        <button id="nextExercise" class="button-area__button button-area__button--next" type="button"> Next Exercise </button>
                        <button id="finish" class="button-area__button button-area__button--next button-area__button--hidden" type="button"> Finish </button>
                    </div>
                </div>
            </div>
            <div class="exercise-description exercise-description__instructions-half">
                <p> Instructions </p>
                <p id="exerciseInstructions"> </p>
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
    var userID = "<?php echo $_SESSION['SESSION_USER']; ?>";
    var workout = JSON.parse(`<?php echo json_encode($data);?>`);
</script>

<script src="/project/public/javascript/workouts/run.js"></script>