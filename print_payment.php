<?php
require "functions.php";

//getting Voucher_Number
$Voucher_Number = trim($_REQUEST['Voucher_Number']);

//getting data from the table payment_headers
$rows_payment_headers = table_payment_headers('select', $Voucher_Number);
foreach ($rows_payment_headers as $row_payment_headers) {
    // code...
}

// getting data from the table payments
$rows_payments = table_payments('select', $Voucher_Number);
foreach ($rows_payments as $row_payments) {
    // code...
}

//getting currency
if ($row_payments->USD == "" || $row_payments->USD == NULL || $row_payments->USD == 0 || empty($row_payments->USD)) {
    $currency = 'SGD';
}
else {
    $currency = 'USD';
}

$rows_payment_details = table_payment_details('select', $Voucher_Number, $currency);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <link rel="stylesheet" href="styles/print.css">
        <link rel="Shortcut icon" href="images/small-logo.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo "Payment Voucher: ".$Voucher_Number; ?></title>
    </head>
    <body>
        <!-- content -->
        <div class="content">
            <header>
                <img src="images/Link-in-Asia 2.png" alt="">
                <table>
                    <thead>
                        <tr>
                            <td>
                                <ul>
                                    <li>
                                        111 North Bridge Road
                                    </li>
                                    <li>
                                        #13-01 Peninsula Plaza
                                    </li>
                                    <li>
                                        Singapore 179098
                                    </li>
                                    <li>
                                        Company Registration: 201313773E
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </thead>
                </table>
            </header>
            <!-- invoice_header -->
            <div class="payment_header">
                <table>
                    <thead>
                        <tr>
                            <td>
                                <ul>
                                    <li>
                                        To: <span class="bold"><?php echo $row_payment_headers->Addressee; ?></span>
                                    </li>
                                    <li>
                                        <?php echo $row_payment_headers->Address1; ?>
                                    </li>
                                    <li>
                                        <?php echo $row_payment_headers->Address2; ?>
                                    </li>
                                    <li>
                                        <?php echo $row_payment_headers->City; ?>
                                    </li>
                                    <li>
                                        <?php echo $row_payment_headers->Country; ?>
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <li>
                                        <span class="bold">PAYMENT ADVICE</span>
                                    </li>
                                    <li>
                                        Payment Voucher No:
                                        <?php echo $Voucher_Number; ?>
                                    </li>
                                    <li>
                                        Payment Date:
                                        <?php echo date("d-M-Y", strtotime($row_payments->Payment_Date)); ?>
                                    </li>
                                    <li>
                                        Method (Cheque No):
                                        <?php echo $row_payments->Method; ?>
                                    </li>
                                    <li>
                                        Prepared by:
                                        <?php
                                        $rows_users = table_users('select', $row_payments->UsersId);
                                        foreach ($rows_users as $row_users) {
                                            // code...
                                        }
                                        echo $row_users->Fullname;
                                        ?>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <!-- end of payment_header -->
            <!-- payment_details -->
            <div class="payment_details">
                <table>
                    <thead>
                        <tr>
                            <td>
                                Invoice Date
                            </td>
                            <td>
                                Invoice No. / Descriptions
                            </td>
                            <td>
                                Amount
                                <?php echo $currency; ?>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows_payment_details as $row_payment_details) {
                            $y = date('Y', strtotime($row_payment_details->Invoice_Date));

                            if ($y >= 2018) {
                                echo "<tr>";
                                echo "<td>";
                                echo date('d-M-Y', strtotime($row_payment_details->Invoice_Date));
                                echo "</td>";
                                echo "<td>";
                                echo $row_payment_details->Invoice_Number;
                                echo "</td>";
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
                        <tr style="font-weight: bold; border-top: 1px solid black; border-bottom: 1px solid black;">
                            <td></td>
                            <td style="text-align: right; padding-right: 12px;">
                                TOTAL PAYMENT:
                                <?php echo $currency; ?>
                            </td>
                            <td>
                                <?php
                                if ($currency == 'USD') {
                                    echo $row_payments->USD;
                                }
                                else {
                                    echo $row_payments->SGD;
                                }
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- end of payment_details -->
            <!-- payment_footer -->
            <div class="payment_footer">
                <table>
                    <thead>
                        <tr>
                            <td></td>
                            <td>
                                Checked by:_____________________
                            </td>
                        </tr>
                        <tr>
                            <td>Approved and Signed By:_____________________</td>
                            <td>
                                Received By:_____________________
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- end of content -->
    </body>
</html>
