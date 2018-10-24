<?php
require_once "functions.php";

//getting data from the users
$rows_users = table_users('select', $_SESSION['users_Id']);
foreach ($rows_users as $row_users) {
    $Fullname = $row_users->Fullname;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //generating payment voucher number
    $gen_payment = new Database();
    $query_gen_payment = "SELECT * FROM payments ;";
    $gen_payment->query($query_gen_payment);
    $rowCount = $gen_payment->rowCount();
    $num = $rowCount + 1;
    if ($num <= 9) {
        $Voucher_Number = '00000'.$num;
    }
    elseif ($num <= 99) {
        $Voucher_Number = '0000'.$num;
    }
    elseif ($num <= 999) {
        $Voucher_Number = '000'.$num;
    }
    elseif ($num <= 9999) {
        $Voucher_Number = '00'.$num;
    }
    elseif ($num <= 99999) {
        $Voucher_Number = '0';
    }
    else {
        $Voucher_Number = $num;
    }

    //inserting date to the table payments_headers
    table_payment_headers('insert', $Voucher_Number);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Payment Vouchers";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Payment Voucher";
            include "includes/header.html";
            include "includes/menu.html";
            ?>
            <main>
                <form id="payment" action="#" method="post">
                    <table class="invoice_header">
                        <thead>
                            <tr>
                                <td>
                                    To:
                                    <input type="text" name="To">
                                </td>
                                <td>
                                    Payment Date:
                                    <input type="date" name="Payment_Date">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Address Line 1:
                                    <input type="text" name="Address1" placeholder="Address Line 1">
                                </td>
                                <td>
                                    Method:
                                    <input type="text" name="Method" placeholder="Payment Method">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Address Line 2:
                                    <input type="text" name="Address2" placeholder="Address Line 2">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    City:
                                    <input type="text" name="City" placeholder="City">
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <table class="invoice_details">
                        <thead>
                            <tr>
                                <th>Invoice Date</th>
                                <th>Invoice No</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($i <= 20) {
                                include "includes/payment_details.html";
                                $i++;
                            }
                            ?>
                            <tr>
                                <th colspan="3" class="notice error"></th>
                            </tr>
                            <tr>
                                <th colspan="3">
                                    Currency: &nbsp;
                                    <select name="currency" id="currency">
                                        <option value="">Select One</option>
                                        <option value="USD">USD</option>
                                        <option value="SGD">SGD</option>
                                    </select>
                                    <button type="button" class="button link" id="buttonSubmit" name="buttonSubmit" onclick="check_fields('Bill_To', 'City', 'currency');">Generate</button>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
    <script type="text/javascript" src="js/scripts.js"></script>
</html>
