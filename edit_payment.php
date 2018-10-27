<?php
require_once "functions.php";

//getting Voucher_Number
$Voucher_Number = trim($_REQUEST['Voucher_Number']);

// getting data from the table payment_headers
$rows_payment_headers = table_payment_headers('select', $Voucher_Number);
foreach ($rows_payment_headers as $row_payment_headers) {
    // code...
}

// getting data from the table payment_details
$rows_payment_details = table_payment_details('select', $Voucher_Number);

// getting data from the table payments
$rows_payments = table_payments('select', $Voucher_Number);
foreach ($rows_payments as $row_payments) {
    // code...
}

// getting currency
if ($row_payments->USD == "" || $row_payments->USD == NULL || $row_payments->USD == 0 || empty($row_payments->USD)) {
    $currency = 'SGD';
}
else {
    $currency = 'USD';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_payment_headers('update', $Voucher_Number);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Payment Voucher";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Payment Voucher";
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
                                    <input type="text" name="Addressee" id="Addressee" value="<?php echo $row_payment_headers->Addressee; ?>">
                                </td>
                                <td>
                                    Payment Date:
                                    <input type="date" name="Payment_Date" id="Payment_Date" value="<?php echo $row_payments->Payment_Date; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Address Line 1:
                                    <input type="text" name="Address1" value="<?php echo $row_payment_headers->Address1; ?>">
                                </td>
                                <td>
                                    Method:
                                    <input type="text" name="Method" value="<?php echo $row_payments->Method; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Address Line 2:
                                    <input type="text" name="Address2" value="<?php echo $row_payment_headers->Address2; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    City:
                                    <input type="text" name="City" id="City" value="<?php echo $row_payment_headers->City; ?>">
                                </td>
                                <td>
                                    Country:
                                    <input type="text" name="Country" value="<?php echo $row_payment_headers->Country; ?>">
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <table class="invoice_details">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Invoice Date</th>
                                <th>Invoice No / Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($rows_payment_details as $row_payment_details) {
                                echo "<tr>";
                                echo "<td>";
                                echo "<input type=\"number\" name=\"Id$i\" value=\"$row_payment_details->Id\"
                                min=\"1\" max=\"9999\" readonly>";
                                echo "</td>";
                                echo "<td><input type=\"text\" name=\"Invoice_Date$i\" value=\"$row_payment_details->Invoice_Date\"></td>";
                                echo "<td>";
                                echo "<input type=\"text\" class=\"wide_input\" name=\"Invoice_Number$i\" value=\"$row_payment_details->Invoice_Number\">";
                                echo "</td>";
                                echo "<td>";
                                if ($currency == 'USD') {
                                    echo "<input type=\"number\" name=\"amount$i\" value=\"$row_payment_details->USD\" step=\"0.01\">";
                                }
                                else {
                                    echo "<input type=\"number\" name=\"amount$i\" value=\"$row_payment_details->SGD\" step=\"0.01\">";
                                }
                                echo "</td>";
                            }
                            ?>
                            <tr>
                                <th colspan="4" class="bold">
                                    <?php echo "Total in $currency"; ?>
                                </th>
                            </tr>

                            <tr>
                                <th colspan="4" class="notice error"></th>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    <button type="button" class="button link" id="buttonSubmit" name="buttonSubmit" onclick="check_fields('Addressee', 'City', 'Payment_Date');">Update</button>
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <a href="<?php echo "print_voucher.php?Voucher_Number=$Voucher_Number"; ?>" target="_blank"><button type="button" class="button link">Print</button></a>
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
