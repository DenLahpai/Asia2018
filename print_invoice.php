<?php
require "functions.php";
//getting invoice number
$Invoice_Number = trim($_REQUEST['Invoice_Number']);

//getting data from the table invoice_headers
$rows_invoice_headers = table_invoice_headers('select', $Invoice_Number);
foreach ($rows_invoice_headers as $row_invoice_headers) {
    //code...
}

//getting data from the table invoices
$rows_invoices = table_invoices('select', $Invoice_Number);
foreach ($rows_invoices as $row_invoices) {
    // code...
}

// getting currency
if ($row_invoices->USD == "" || $row_invoices->USD == NULL || $row_invoices->USD == 0 || empty($row_invoices->USD)) {
    $currency = 'SGD';
}
else {
    $currency = 'USD';
}

$rows_invoice_details = table_invoice_details('select', $Invoice_Number, $currency);

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="styles/print.css">
        <link rel="Shortcut icon" href="images/small-logo.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo "Invoice: ".$Invoice_Number; ?></title>
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
                            <td>
                                <ul>
                                    <li>
                                        Invoice No:
                                        <?php echo $Invoice_Number; ?>
                                    </li>
                                    <li>
                                        Invoice Date:
                                        <?php echo date('d-M-Y', strtotime($row_invoices->Invoice_Date)); ?>
                                    </li>
                                    <li>
                                        Clients Reference:
                                        <?php echo $row_invoices->Clients_Reference; ?>
                                    </li>
                                    <li>
                                        Due Date:
                                        <?php echo date('d-M-Y', strtotime($row_invoices->Due_Date)); ?>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </thead>
                </table>
            </header>
            <!-- invoice_header -->
            <div class="invoice_header">
                <ul>
                    <li>
                        Bill To: <span class="bold"><?php echo $row_invoice_headers->Bill_To; ?></span>
                    </li>
                    <li>
                        Address: <?php echo $row_invoice_headers->Address; ?>
                    </li>
                    <li>
                        City: <?php echo $row_invoice_headers->City; ?>
                    </li>
                    <li>
                        Country: <?php echo $row_invoice_headers->Country; ?>
                    </li>
                </ul>
            </div>
            <!-- end of invoice_header -->
            <!-- invoice_body -->
            <div class="invoice_body">
                <h2>Invoice</h2>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2">Description</th>
                            <th>
                                Amount in
                                <?php echo $currency; ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rows_invoice_details as $row_invoice_details) {
                            if ($row_invoice_details->Description != "" || $row_invoice_details->Description != NULL) {
                                echo "<tr>";
                                echo "<td colspan=\"2\">".$row_invoice_details->Description."</td>";
                                if ($currency == 'USD') {
                                    echo "<td>".$row_invoice_details->USD."</td>";
                                }
                                else {
                                    echo "<td>".$row_invoice_details->SGD."</td>";
                                }
                                echo "</tr>";
                            }
                        }
                        ?>
                        <tr>
                            <th colspan="2">TOTAL IN <?php echo $currency; ?></th>
                            <th>
                                <?php
                                if ($currency == 'USD') {
                                    echo $sum = $row_invoices->USD;
                                }
                                else {
                                    echo $sum = $row_invoices->SGD;
                                }
                                ?>
                            </th>
                        </tr>
                    </tbody>
                </table>
                <p>
                    <?php
                    require "xcodes.php";
                    echo "Amount in ".$currency." : ".ucwords(convert_number_to_words($sum));
                    ?>
                </p>
            </div>
            <!-- end of invoice body -->
            <!-- invoice_tail -->
            <div class="invoice_tail">
                <ul>
                    <li><span class="bold" style="text-decoration: underline;">Remmitance Advice:</span></li>
                    <li><span class="bold">Bank: </span> United Oversea Bank Limited</li>
                    <li><span class="bold">Bank Address: </span> UOB Rochor, 149 Rochor Rd, #01-26 Fu Lu Shou Complex, Singapore 188425</li>
                    <li><span class="bold">Account Number USD: </span>354-900-773-0 (USD)</li>
                    <li><span class="bold">Account Number SGD: </span>348-315-980-1 (SGD)</li>
                    <li><span class="bold">Swift: </span>UOVBSGSG</li>
                    <li><span class="bold">Bank Code: </span>7375</li>
                    <li><span class="bold">Branch Code: </span>047</li>
                    <li><span class="bold">Beneficiary: </span>Link In Asia Pte Ltd</li>
                </ul>
            </div>
            <!-- end of invoice_tail -->
        </div>
        <!-- end of content -->
        <footer>
            <p>This is a computer-generated document. No signature is required.</p>
        </footer>
    </body>
</html>
