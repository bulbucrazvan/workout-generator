<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/project/public/css/login.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <link rel="stylesheet" href="/project/public/css/unsigned-navbar.css">
</head>
<body>
    <?php
        require_once(__DIR__."/../unsigned-navbar.php");
    ?>
    <main>
        <div class="outer-box">
            <form class="form-box">
                <input type="email" placeholder="E-mail"></br>
                <input type="text" placeholder="Username"></br>
                <input type="password" placeholder="Password"></br>
                <input type="submit" value="Register">
            </form>
            <p class="under-text"> Have an account already? <span>Login <a href="/project/public/home/login"> here</a>.</span> </p>
        </div>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>
</html>