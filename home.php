<?php
require "functions.php";

//getting data from the users
$rows_users = table_users('select', $_SESSION['users_Id']);
foreach ($rows_users as $row_users) {
    // code
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Home Page";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Welcome: ".$row_users->Fullname;
            include "includes/header.html";
            include "includes/menu.html";
            ?>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
