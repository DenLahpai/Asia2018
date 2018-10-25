<?php
require "functions.php";

//getting date from the users
$rows_users = table_users('select', $_SESSION['users_Id']);
foreach ($rows_users as $row_users) {
    //code
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Payments";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Payments";
            include "includes/header.html";
            include "includes/menu.html";
            ?>
            <main>
                <!-- sub_menu -->
                <div class="sub_menu">
                    <form class="search form" action="#" method="post">
                        <ul>
                            <li>
                                <a href="new_payment.php"><button type="button" class="button link" name="button">Create New</button></a>
                                &nbsp;
                            </li>
                            <li>
                                <input type="text" name="search" id="search" class="searchbox" placeholder="Search Payments">
                            </li>
                            <li>
                                <button type="button" class="button search" name="buttonSearch">Search</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <!-- end of sub_menu -->
                <!-- table large -->
                <div class="table large">
                    <table>
                        <thead>
                            <tr>
                                <th>Payment Voucher No</th>
                                <th>Payment Date</th>
                                <th>USD</th>
                                <th>SGD</th>
                                <th>Method</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rows_payments = table_payments('select', NULL);
                            foreach ($rows_payments as $row_payments) {
                                echo "<tr>";
                                echo "<td>".$row_payments->Voucher_Number."</td>";
                                echo "<td>".date('d-M-Y', strtotime($row_payments->Payment_Date))."</td>";
                                echo "<td>".$row_payments->USD."</td>";
                                echo "<td>".$row_payments->SGD."</td>";
                                echo "<td>".$row_payments->Method."</td>";
                                echo "<td><a href=\"view_payment.php?Voucher_Number=$row_payments->Voucher_Number\">View</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of table large -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
