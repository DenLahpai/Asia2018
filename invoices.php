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
    $page_title = "Invoices";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Invoices";
            include "includes/header.html";
            include "includes/menu.html";
            ?>
            <main>
                <!-- sub_menu -->
                <div class="sub_menu">
                    <form class="search form" action="#" method="post">
                        <ul>
                            <li>
                                <a href="new_invoice.php"><button type="button" class="button link" name="button">Create New</button></a>
                                &nbsp;
                            </li>
                            <li>
                                <input type="text" name="search" id="search" placeholder="Search Invoices">

                            </li>
                            <li>
                                <button type="button" class="button search" name="buttonSearch">Search</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of sub_menu -->
                <!-- table large  -->
                <div class="table large">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    Invoice Number
                                </th>
                                <th>
                                    Invoice Date
                                </th>
                                <th>
                                    Bill To
                                </th>
                                <th>
                                    Currency
                                </th>
                                <th>
                                    Amount
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Paid Date
                                </th>
                                <th>
                                    #
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <!-- end of table large -->
            </main>
        </div>
        <!-- end of content -->
    </body>
</html>
