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
            <p> Workout 1 </p>
            <p> Exercise 1 </p>
        </div>
        <div class="main-bubble__area main-bubble__area--exercise-description-area">
            <div class="exercise-description exercise-description__video-half">
                <video class="video-half__video" controls>
                    <source src="https://www.youtube.com/watch?v=XIMLoLxmTDw">
                </video>
                <div class="video-half__controls">
                    <p> Time remaining: ... </p>
                    <div class="controls__button-area">
                        <button class="button-area__button button-area__button--start" type="button"> Start </button>
                        <button class="button-area__button button-area__button--pause" type="button"> Pause </button>
                        <button class="button-area__button button-area__button--stop" type="button"> Stop </button>
                    </div>
                    <div class="controls__button-area">
                        <button class="button-area__button button-area__button--previous" type="button"> Previous Exercise </button>
                        <button class="button-area__button button-area__button--next" type="button"> Next Exercise </button>
                    </div>
                </div>
            </div>
            <div class="exercise-description exercise-description__instructions-half">
                <p> Instructions </p>
                <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sagittis nisi id semper sollicitudin. Ut interdum mauris a ipsum congue, quis ullamcorper augue pulvinar. Sed facilisis lectus turpis, in ultricies lectus ultricies imperdiet. Curabitur pulvinar nec leo vel ullamcorper. Vestibulum luctus iaculis sem ac luctus. Aenean consequat feugiat diam, hendrerit condimentum odio placerat a. Vivamus id mi mollis, maximus magna nec, vulputate dui. Aenean facilisis viverra lacus sed molestie. Quisque blandit nisl nec urna tempor, id aliquet velit luctus. Cras suscipit erat efficitur, sollicitudin risus ac, accumsan ante. Donec bibendum aliquet sapien et egestas. Phasellus dictum leo eget turpis dapibus faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi vitae urna erat. Curabitur et nisi nec eros consequat vestibulum ut a turpis.
                </p>
            </div>
        </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>


