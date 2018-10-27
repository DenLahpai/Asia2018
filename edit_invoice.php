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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    table_invoice_headers('update', $Invoice_Number);
    table_invoice_details('update', $Invoice_Number, $currency);
    table_invoices('update', $Invoice_Number);
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "Edit Invoice";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "Edit Invoice";
            include "includes/header.html";
            include "includes/menu.html";
            ?>
            <main>
                <form id="invoice" action="#" method="post">
                    <table class="invoice_header">
                        <thead>
                            <tr>
                                <td>
                                    Bill To: &nbsp;
                                    <input type="text" name="Bill_To" id="Bill_To" value="<?php echo $row_invoice_headers->Bill_To; ?>" required>
                                </td>
                                <td>
                                    Invoice Date: &nbsp;
                                    <input type="date" name="Invoice_Date" id="Invoice_Date" value="<?php echo $row_invoices->Invoice_Date; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Address: &nbsp;
                                    <input type="text" name="Address" id="Address" value="<?php echo $row_invoice_headers->Address; ?>" style="width: 80%;">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    City: &nbsp;
                                    <input type="text" name="City" id="City" value="<?php echo $row_invoice_headers->City; ?>" required>
                                </td>
                                <td>
                                    Country: &nbsp;
                                    <input type="text" name="Country" id="Country" value="<?php echo $row_invoice_headers->Country; ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Attn: &nbsp;
                                    <input type="text" name="Attn" id="Attn" value="<?php echo $row_invoice_headers->Attn; ?>">
                                </td>
                                <td>
                                    Clients Reference: &nbsp;
                                    <input type="text" name="Clients_Reference" id="Clients_Reference" value="<?php echo $row_invoices->Clients_Reference; ?>">
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <table class="invoice_details">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Description</th>
                                <th><?php echo "Amount in $currency"; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($rows_invoice_details as $row_invoice_details) {
                                echo "<tr>";
                                echo "<td>";
                                echo "<input type=\"number\" name=\"Id$i\" value=\"$row_invoice_details->Id\"
                                min=\"1\" max=\"9999\" readonly>";
                                echo "</td>";
                                echo "<td><input type=\"text\" class=\"wide_input\" name=\"Description$i\" value=\"$row_invoice_details->Description\"></td>";
                                echo "<td>";
                                if ($currency == 'USD'){
                                    echo "<input type=\"number\" name=\"amount$i\" value=\"$row_invoice_details->USD\" step=\"0.01\">";
                                }
                                else {
                                    echo "<input type=\"number\" name=\"amount$i\" value=\"$row_invoice_details->SGD\" step=\"0.01\">";
                                }
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                            }
                            ?>
                            <tr>
                                <th colspan="2" class="bold"><?php echo "Total in $currency"; ?></th>
                                <th>
                                    <?php echo table_invoice_details('sum', $Invoice_Number, $currency); ?>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="notice error">

                                </th>
                            </tr>
                            <tr>
                                <th colspan="4">
                                    <button type="button" class="button link" id="buttonSubmit" name="buttonSubmit" onclick="check_fields('Bill_To', 'City', 'City');">Update</button>
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    &nbsp;
                                    <a href="<?php echo "print_invoice.php?Invoice_Number=$Invoice_Number"; ?>" target="_blank"><button type="button" class="button link">Print</button></a>
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
