<?php
    if(is_user_logged_in()) {
        wp_redirect("/");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ElsieGram</title>
</head>
<body>
    <h1>ElsieGram</h1>
    <h2><a href="/wp-login.php">LOGIN</a></h2>
    <h2><a href="/invite">REQUEST INVITATION</a></h2> 
</body>
</html>