<?php
session_start();
//setting up the timezone
date_default_timezone_set("Asia/Yangon");

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Welcome";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="login_page">
            <form action="login.php" method="post">
                <ul>
                    <li>
                        <h3>
                            Please Login
                        </h3>
                    </li>
                    <li class="notice error">
                        <?php
                        if (isset($_SESSION['error_message']) ) {
                            echo $_SESSION['error_message'];
                        }
                        ?>
                    </li>
                    <li>
                        <input type="text" name="Username" id="Username" placeholder="Username">
                    </li>
                    <li>
                        <input type="password" name="Password" id="Password" placeholder="Password">
                    </li>
                    <li>
                        <button type="button" class="button login" name="buttonSubmit" id="buttonSubmit" onclick="check_two_fields('Username','Password');">Login</button>
                    </li>
                </ul>
            </form>
        </div>
        <?php include "includes/footer.html"; ?>
        <!-- end of content -->
    </body>
    <script type="text/javascript" src="js/scripts.js">

    </script>
</html>
