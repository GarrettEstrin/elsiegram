<?php
    if(is_user_logged_in()) {
        wp_redirect("/");
        die();
    }
    include("header.php");
    include("header-custom.php");
?>
        <!-- <div class="container"> in header-custom.php -->
        <p class="home__link"><a href="/wp-login.php">LOGIN</a></p>
        <p class="home__link"><a href="/invite">REQUEST INVITATION</a></p> 
    </div>
</body>
</html>