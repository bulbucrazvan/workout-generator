<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/home.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../unsigned-navbar.php");
    ?>
    <main>
        <div class="home-image home-image-1">
            <h2> Get the best workouts for YOU </h2>
        </div>
        <div class="home-image home-image-2">
            <h2> Keep track of your workouts </h2>
        </div>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>