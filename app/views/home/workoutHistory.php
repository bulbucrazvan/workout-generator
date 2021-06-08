<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/workout-history.css">
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
                <p> Workout History </p>
                <form>
                <label> Sort by </label>
                <select id="comboBox" class="combo-box">
                    <option value="asc"> Most recent </option>
                    <option value="desc"> Least recent </option>
                </select> 
                </form>
            </div>
            <div class="main-bubble__area main-bubble__area--list-area">
                <ul id="workoutList" class="list-area__list">
                </ul>
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
    var loginKey = "<?php echo $_SESSION['LOGIN_KEY'];?>";
</script>
<script src="/project/public/javascript/cookieSetter.js"></script>
<script src="/project/public/javascript/listbackgroundselector.js">
</script>

<script src="/project/public/javascript/comboboxclick.js">
</script>

<script src="/project/public/javascript/history.js"></script>