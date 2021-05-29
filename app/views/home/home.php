<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/signed-home.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../signed-navbar.php");
    ?>
    <main>
        <section class="main-bubble">
            <?php 
                if ($data->lastWorkout) {
                    echo "
                    <div class=\"main-bubble__inner-bubble main-bubble__inner-bubble--last-workout main-bubble__inner-bubble--has-button\">
                        <div>
                            <p> Last workout: </p>
                            <p> Chest training </p>
                        </div>
                        <button id=\"startWrkoutBtn\" type=\"button\" class=\"inner-bubble__button inner-bubble__button--last-workout\"> Start </button>
                    </div>";
                }
                else {
                    echo "
                    <div class=\"main-bubble__inner-bubble\">
                        <p> Last workout: </p>
                        <p> No workouts yet. </p>
                    </div>";
                }
            ?>
            <div class="main-bubble__inner-bubble">
                <p> Current streak </p>
                <p> <?=$data->currentStreak?> </p>
            </div>
            <div class="main-bubble__inner-bubble">
                <p> Longest streak </p>
                <p> <?=$data->longestStreak?> </p>
            </div>
            <div class="main-bubble__inner-bubble main-bubble__inner-bubble--has-button">
                <p> Workout history </p>
                <button id="wrkOutHistory" type="button" class="inner-bubble__button"> View </button>
            </div>
            <div class="main-bubble__inner-bubble">
                <p> Workouts completed </p>
                <p> <?=$data->workoutsCompleted?> </p>
            </div>
            <div class="main-bubble__inner-bubble main-bubble__inner-bubble--has-button">
                <p> RSS Feed </p>
                <button type="button" class="inner-bubble__button"> View </button>
            </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>

<script>
let startWorkout = document.getElementById("startWrkoutBtn");
let workoutHistory = document.getElementById("wrkOutHistory");
startWorkout.addEventListener('click', function() {
    window.location.href = "/project/public/home/startWorkout";
});

workoutHistory.addEventListener('click', function() {
    window.location.href = "/project/public/home/workoutHistory";
});
</script>