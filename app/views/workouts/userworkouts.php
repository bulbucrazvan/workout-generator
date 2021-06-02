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
            </div>
            <div class="main-bubble__area main-bubble__area--list-area">
                <ul class="list-area__list">
                <?php
                    foreach ($data as $workout) {
                        echo "
                            <li> 
                                <p class=\"list-area__paragraph list-area__paragraph--left\">" . $workout['workoutName'] . "</p> 
                                <form class=\"list-area__form\">
                                    <button type=\"button\" class=\"list-area__button list-area__button--start\" onclick=\"location.href='/project/public/workouts/run/" . $workout['workoutID'] ."';\">Start</button>
                                    <button type=\"button\" class=\"list-area__button list-area__button--view\" onclick=\"location.href='/project/public/workouts/edit/" . $workout['workoutID'] ."';\">View</button>
                                </form>
                            </li>
                        ";
                    }
                ?>
                </ul>
            </div>
            <div class="main-bubble__area main-bubble__area--new-workout">
                <p> Create new workout </p>
                <div>
                    <button id="manualWrkt" onclick="location.href='/project/public/workouts/create';"> Manual </button>
                    <button id="generateWrkt" onclick="location.href='/project/public/workouts/generate';"> Generate workout </button>
                </div>
            </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>


<script src="/project/public/javascript/listbackgroundselector.js"></script>
<script>
    setListBackgroundColour("list-area__list", "");
</script>

