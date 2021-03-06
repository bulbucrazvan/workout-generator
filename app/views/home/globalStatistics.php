<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
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
                <p> Global Statistics </p>
                <form>
                <label> Rank by </label>
                <select class="combo-box" id="comboBox">
                    <option value="currentStreak"> Current streak </option>
                    <option value="longestStreak"> Longest streak </option>
                    <option value="workoutsCompleted"> Completed workouts </option>
                </select> 
                </form>
            </div>
            <div class="main-bubble__area main-bubble__area--list-area">
                <ul id="rankingsList" class="list-area__list">
                </ul>
            </div>
        </section>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>
<script src="/project/public/javascript/cookieSetter.js"></script>
<script src="/project/public/javascript/listbackgroundselector.js">
</script>

<script src="/project/public/javascript/comboboxclick.js">
</script>

<script src="/project/public/javascript/home/userRankings.js"></script>

