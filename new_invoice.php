<?php
require "functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //generating invoice number
    $year = date('Y');
    $gen_invoice_no = new Database();
    $query_gen_invoice_no = "SELECT * FROM invoices; ";
    $gen_invoice_no->query($query_gen_invoice_no);
    $rowCount = $gen_invoice_no->rowCount();
    $num = $rowCount + 1;
    $currency = $_REQUEST['currency'];
    if($num <= 9) {
        $Invoice_Number = '2018'.'-000'.$num;
    }
    elseif($r <= 99) {
        $Invoice_Number = '2018'.'-00'.$num;
    }
    elseif ($r <= 999) {
        $Invoice_Number = '2018'.'-0'.$num;
    }
    else {
        $Invoice_Number = '2018'.'-'.$num;
    }

    //inserting data to the table invoice header
    table_invoice_headers('insert', $Invoice_Number);
    table_invoice_details('insert', $Invoice_Number, $currency);
    table_invoices('insert', $Invoice_Number);

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <?php
    $page_title = "New Invoice";
    include "includes/head.html";
    ?>
    <body>
        <!-- content -->
        <div class="content">
            <?php
            $header = "New Invoice";
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
                                    <input type="text" name="Bill_To" id="Bill_To" placeholder="Bill to">
                                </td>
                                <td>
                                    Invoice Date: &nbsp;
                                    <input type="date" name="Invoice_Date" id="Invoice_Date" value="<?php echo date('Y-m-d'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Address: &nbsp;
                                    <input type="text" name="Address" id="Address" placeholder="Address" style="width: 80%">
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    City: &nbsp;
                                    <input type="text" name="City" id="City" placeholder="City">
                                </td>
                                <td>
                                    Country: &nbsp;
                                    <input type="text" name="Country" id="Country" placeholder="Country">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Attn: &nbsp;
                                    <input type="text" name="Attn" id="Attn" placeholder="Attention">
                                </td>
                                <td>
                                    Clients Reference: &nbsp;
                                    <input type="text" name="Clients_Reference" id="Clients_Reference" placeholder="Clients Ref#">
                                </td>
                            </tr>
                        </thead>
                    </table>
                    <table class="invoice_details">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            while ($i <= 20) {
                                include "includes/invoice_details.html";
                                $i++;
                            }
                            ?>
                            <tr>
                                <th colspan="3">
                                    Currency: &nbsp;
                                    <select name="currency" id="currency">
                                        <option value="">Select One</option>
                                        <option value="USD">USD</option>
                                        <option value="SGD">SGD</option>
                                    </select>
                                    <button type="submit" class="button link" id="buttonSubmit" name="buttonSubmit">Generate</button>
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
</html>
