<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/exercise-viewer.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../signed-navbar.php");
    ?>
    <main>
        <section class="main-bubble">
        <div class="main-bubble__area main-bubble__area--exercise-name-area">
            <p> <?=$data["name"]?> </p>
        </div>
        <div class="main-bubble__area main-bubble__area--exercise-description-area">
            <div class="exercise-description exercise-description__video-half">
                <video class="video-half__video" controls>
                    <source src="https://www.youtube.com/watch?v=XIMLoLxmTDw">
                </video>
                <div class="video-half__description">
                    <div> Location: 
                        <p>
                            <?php
                                echo implode(", ", $data["locations"]);
                            ?> 
                        </p> 
                    </div>
                    <div> Muscles worked:
                        <p>
                            <?php
                                echo implode(", ", $data["muscles"]);
                            ?>
                        </p> 
                    </div>
                    <div> Duration: <p> <?=$data["duration"] . " minutes"?> </div>
                </div>
            </div>
            <div class="exercise-description exercise-description__instructions-half">
                <p> Instructions </p>
                <p> <?=$data["instructions"]?></p>
            </div>
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

