<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/project/public/css/font.css">
    <link rel="stylesheet" href="/project/public/css/main-framework.css">
    <link rel="stylesheet" href="/project/public/css/footer.css">
    <title>Document</title>
</head>
<body>
<main>
    <section class="main-bubble">
        <div class="main-bubble__area main-bubble__area--error-area">
            <div>
                <p> Oops! An error occurred! </p>
                <p> Error description: </p>
                <p> <?php echo $data ?> </p>  
            </div> 
            <button> Home </button>
        </div>
    </section>
</main>
<?php
        require_once(__DIR__."/footer.php");
?>

    
</body>
</html>