<?php
require "functions.php";

// getting Voucher_Number
$Voucher_Number = trim($_REQUEST['Voucher_Number']);

// getting data from the table payment_headers
$rows_payment_headers = table_payment_headers('select', $Voucher_Number);
foreach ($rows_payment_headers as $row_payment_headers) {
    // code...
}

// getting data from the table payment_details
$rows_payment_details = table_payment_details('select', $Voucher_Number, NULL);

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

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "View Payment";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Payment Voucher Preview";
            include "includes/header.html";
            include "includes/menu.html";
            ?>
            <main>
                <!-- invoice_top -->
                <div class="invoice_top">
                    <table>
                        <thead>
                            <tr>
                                <td>
                                    <ul>
                                        <li>
                                            To: &nbsp;
                                            <?php echo $row_payment_headers->Addressee; ?>
                                        </li>
                                        <li>
                                            Address: &nbsp;
                                            <?php echo $row_payment_headers->Address1; ?>
                                        </li>
                                        <li>
                                            <?php echo $row_payment_headers->Address2; ?>
                                        </li>
                                        <li>
                                            <?php echo $row_payment_headers->City.", ".$row_payment_headers->Country; ?>
                                        </li>
                                    </ul>
                                </td>
                                <td>
                                    <ul>
                                        <li>
                                            Payment Voucher No: &nbsp;
                                            <?php echo $Voucher_Number; ?>
                                        </li>
                                        <li>
                                            Payment Date: &nbsp;
                                            <?php echo date('d-M-Y', strtotime($row_payments->Payment_Date)); ?>
                                        </li>
                                        <li>
                                            Method: &nbsp;
                                            <?php echo $row_payments->Method; ?>
                                        </li>
                                        <li>
                                            Prepared By: &nbsp;
                                            <?php
                                            // getting users Fullname
                                            $rows_users = table_users('select', $row_payments->UsersId);
                                            foreach ($rows_users as $row_users) {
                                                $Fullname = $row_users->Fullname;
                                            }
                                            echo $Fullname;
                                            ?>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- end of invoice_top -->
                <!-- view_invoice_details -->
                <div class="view_invoice_details">
                    <table>
                        <thead>
                            <tr>
                                <th>Invoice Date</th>
                                <th>Invoice Number or Descrption</th>
                                <th>
                                    Amount in
                                    <?php echo $currency; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rows_payment_details as $row_payment_details) {
                                $year = date("Y", strtotime($row_payment_details->Invoice_Date));
                                if ($year >= 2018) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo date('d-M-Y', strtotime($row_payment_details->Invoice_Date));
                                    echo "</td>";
                                    echo "<td>".$row_payment_details->Invoice_Number."</td>";
                                    echo "<td>";
                                    if ($currency == 'USD') {
                                        echo $row_payment_details->USD;
                                    }
                                    else {
                                        echo $row_payment_details->SGD;
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                            <tr>
                                <th colspan="2" style="text-align: right;">
                                    TOTAL PAYMENT &nbsp;
                                    <?php echo $currency; ?>
                                </th>
                                <th>
                                    <?php
                                    if ($currency == 'USD') {
                                        echo $row_payments->USD;
                                    }
                                    else {
                                        echo $row_payments->SGD;
                                    }
                                    ?>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="3">
                                    <a href="<?php echo "edit_payment.php?Voucher_Number=$Voucher_Number"; ?>"><button type="button" class="button link">Edit</button></a>
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <a href="<?php echo "print_payment.php?Voucher_Number=$Voucher_Number"; ?>" target="_blank"><button type="button" class="button link">Print</button></a>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- end of view_invoice_details -->
            </main>
        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
