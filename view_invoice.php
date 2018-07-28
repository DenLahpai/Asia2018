<?php
require "functions.php";

//getting Invoice_Number
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
    <?php
    $page_title = "View Invoice";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Invoice Preview";
            include "includes/header.html";
            include "includes/menu.html";
            ?>
            <main>
                <div class="invoice_top">
                    <table>
                        <thead>
                            <tr>
                                <td>
                                    <img src="images/LinkLogo.jpg" alt="">
                                </td>
                                <td>
                                    <ul>
                                        <li>
                                            Invoice No: &nbsp;
                                            <?php echo $row_invoices->Invoice_Number; ?>
                                        </li>
                                        <li>
                                            Invoice Date: &nbsp;
                                            <?php echo date('d-M-Y', strtotime($row_invoices->Invoice_Date)); ?>
                                        </li>
                                        <li>
                                            Clients Reference: &nbsp;
                                            <?php echo $row_invoices->Clients_Reference; ?>
                                        </li>
                                        <li>
                                            Due Date: &nbsp;
                                            <?php echo date('d-M-Y', strtotime($row_invoices->Due_Date)); ?>
                                        </li>
                                    </ul>

                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="view_invoice_header">
                    <table>
                        <thead>
                            <tr>
                                <td>
                                    Bill To: &nbsp;
                                    <?php echo $row_invoice_headers->Bill_To; ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Address: &nbsp;
                                    <?php echo $row_invoice_headers->Address; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    City: &nbsp;
                                    <?php echo $row_invoice_headers->City; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Country: &nbsp;
                                    <?php echo $row_invoice_headers->Country; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Attn: &nbsp;
                                    <?php echo $row_invoice_headers->Attn; ?>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </main>
        </div>
        <div class="view_invoice_details">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>
                            Amount in
                            <?php echo $currency; ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($rows_invoice_details as $row_invoice_details) {
                        if (date('Y', strtotime($row_invoice_details->Date)) == 2018) {
                            echo "<tr>";
                            echo "<td>".date('d-M-Y', strtotime($row_invoice_details->Date))."</td>";
                            echo "<td>".$row_invoice_details->Description."</td>";
                            if ($currency == 'USD') {
                                echo "<td>".$row_invoice_details->USD."</td>";
                            }
                            else {
                                echo "<td>".$row_invoice_details->SGD."</td>";
                            }
                            echo "</tr>";
                        }
                        else {
                            echo "<tr>";
                            echo "<td>&nbsp;</td>";
                            echo "<td>&nbsp;</td>";
                            echo "<td>&nbsp;</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    <tr>
                        <th colspan="2">
                            Total in <?php echo $currency; ?>
                        </th>
                        <th>
                            <?php
                            if ($currency == 'USD') {
                                echo $row_invoices->USD;
                            }
                            else {
                                echo $row_invoices->SGD;
                            }
                            ?>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="3">
                            <a href="<?php echo "edit_invoice.php?Invoice_Number=$Invoice_Number"; ?>"><button type="button" class="button lilnk">Edit</button></a>
                            &nbsp;
                            &nbsp;
                            &nbsp;
                            <a href="<?php echo "print_invoice.php?Invoice_Number=$Invoice_Number"; ?>" target="_blank"><button type="button" class="button link">Print</button></a>
                        </th>
                    </tr>
                </tbody>
            </table>

        </div>
        <!-- end of content -->
        <?php include "includes/footer.html"; ?>
    </body>
</html>
