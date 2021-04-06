<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
            <div class="main-bubble__inner-bubble main-bubble__inner-bubble--last-workout main-bubble__inner-bubble--has-button">
                <div class=>
                    <p> Last workout: </p>
                    <p> Chest training </p>
                </div>
                <button type="button" class="inner-bubble__button inner-bubble__button--last-workout"> Start </button>
            </div>
            <div class="main-bubble__inner-bubble">
                <p> Current streak </p>
                <p> [User dependent] </p>
            </div>
            <div class="main-bubble__inner-bubble">
                <p> Longest streak </p>
                <p> [User dependent] </p>
            </div>
            <div class="main-bubble__inner-bubble main-bubble__inner-bubble--has-button">
                <p> Workout history </p>
                <button type="button" class="inner-bubble__button"> View </button>
            </div>
            <div class="main-bubble__inner-bubble">
                Dummy
            </div>
            <div class="main-bubble__inner-bubble">
                Dummy
            </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>