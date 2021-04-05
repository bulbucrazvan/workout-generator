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
            <div class="inner-bubble last-workout">
                <div>
                    <p> Last workout: </p>
                    <p> Chest training </p>
                </div>
                <button type="button" class="button last-workout-btn"> Start </button>
            </div>
            <div class="inner-bubble">
                <p> Current streak </p>
            </div>
            <div class="inner-bubble">
                <p> Longest streak </p>
            </div>
            <div class="inner-bubble">
                <p> Dummy </p>
            </div>
            <div class="inner-bubble">
                Dummy
            </div>
            <div class="inner-bubble">
                Dummy
            </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>