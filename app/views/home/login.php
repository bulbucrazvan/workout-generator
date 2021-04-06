<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/project/public/css/login.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../unsigned-navbar.php");
    ?>
    <main>
        <div class="outer-box">
            <form class="form-box" action="/project/public/home/home">
                <input type="text" placeholder="Username"></br>
                <input type="password" placeholder="Password"></br>
                <input type="submit" value="Login">
            </form>
            <p class="under-text"> Don't have an account yet? <span>Register <a href="/project/public/home/register"> here</a>.</span> </p>
        </div>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>