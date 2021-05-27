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
            <form class="form-box" id="register-form">
                <p class="error-message error-message--hidden" id="email-message"> E-mail in use already. </p>
                <input type="email" name="email" placeholder="E-mail" required></br>
                <p class="error-message error-message--hidden" id="username-message"> Username in use already. </p>
                <input type="text" name="username" placeholder="Username" required></br>
                <input type="password" name="password" placeholder="Password" id="password-field" required></br>
                <input type="submit" value="Register">
            </form>
            <p class="under-text"> Have an account already? <span>Login <a href="/project/public/authorization/login"> here</a>.</span> </p>
        </div>
    </main>
    <?php
        require_once(__DIR__."/../footer.php");
    ?>
</body>

<script src="/project/public/javascript/register.js"></script>
</html>