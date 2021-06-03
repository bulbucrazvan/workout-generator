<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/workout-generator.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../signed-navbar.php");
    ?>
    <main>
        <section class="main-bubble">
            <div class="main-bubble__area main-bubble__area--header-area">
                <p> Workout Generator </p>
            </div>
            <div class="main-bubble__area main-bubble__area--generator-area">
                <form class="workout-generator__form">
                    <div class="selector-area">
                        <p> Choose location: </p>
                        <div class="selector-area__input-area">
                            <?php
                                foreach ($data["locations"] as $key => $value) {
                                    echo "<div> <input type='radio' name='location' value='" . $value[0] . "'>" . $value[1] . "</input> </div>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="selector-area">
                        <p> Choose muscle group: </p>
                        <div class="selector-area__input-area">
                            <?php
                                foreach($data["muscles"] as $key => $value) {
                                    echo "<div> <input type='checkbox' name='muscle' value='" . $value[0] . "'>" . $value[1] . "</input> </div>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="selector-area">
                        <p> Choose duration(minutes): </p>
                        <div class="selector-area__input-area">
                            <div> <input type="radio" name="time" value="1"> 10-29 </input> </div>
                            <div> <input type="radio" name="time" value="2"> 30-59 </input> </div>
                            <div> <input type="radio" name="time" value="3"> 60-90 </input> </div>
                        </div>
                    </div>
                    <div class="selector-area selector-area--button-area">
                        <button id="generateBtn" class="selector-area__generate-button" type="button"> Generate Workout </button>
                    </div>
                </form>
            </div> 
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>

<script>
    var userID = "<?php echo $_SESSION['SESSION_USER'];?>";
    var loginID = "<?php echo $_SESSION['LOGIN_KEY'];?>"
</script>

<script src="/project/public/javascript/workouts/generate.js"></script>
