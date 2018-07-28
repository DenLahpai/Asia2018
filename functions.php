<?php
require_once "../conn.php";

//checking whether the user is logged in
if (!isset($_SESSION['users_Id'])) {
    header("location: index.php");
    $_SESSION['error_message'] = "Session Expired";
}
else {
    $_SESSION['error_message'] = NULL;
}


//getting data from the table users
function table_users($task, $users_Id) {
    $database = new Database();
    switch ($task) {
        case 'insert':
            // code...
            break;

        case 'select':
            if ($users_Id == NULL || $users_Id == "" || empty($users_Id)) {
                $query = "SELECT * FROM users ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM users WHERE Id = :users_Id ;";
                $database->query($query);
                $database->bind(':users_Id', $users_Id);
            }
            return $r = $database->resultset();
            break;

        case 'update':
            // code...
            break;

        default:
            // code...
            break;
    }
}

//function to use data from the table invoice_headers
function table_invoice_headers($task, $Invoice_Number) {
    $database = new Database();
    switch ($task) {
        case 'insert':
            $Bill_To = trim($_REQUEST['Bill_To']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
            $Country = trim($_REQUEST['Country']);
            $Attn = trim($_REQUEST['Attn']);

            $query = "INSERT INTO invoice_headers (
                Invoice_Number,
                Bill_To,
                Address,
                City,
                Country,
                Attn
                ) VALUES (
                :Invoice_Number,
                :Bill_To,
                :Address,
                :City,
                :Country,
                :Attn
                )
            ;";
            $database->query($query);
            $database->bind(':Invoice_Number', $Invoice_Number);
            $database->bind(':Bill_To', $Bill_To);
            $database->bind(':Address', $Address);
            $database->bind(':City', $City);
            $database->bind(':Country', $Country);
            $database->bind(':Attn', $Attn);
            $database->execute();
            break;

        case 'select':
            if ($Invoice_Number == "" || $Invoice_Number == NULL || empty($Invoice_Number)) {
                $query = "SELECT * FROM invoice_headers ORDER BY Id ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM invoice_headers WHERE Invoice_Number = :Invoice_Number ;";
                $database->query($query);
                $database->bind('Invoice_Number', $Invoice_Number);
            }
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}

//function to use data from the table invoice_details
function table_invoice_details($task, $Invoice_Number, $currency){
    $database = new Database();

    switch ($task) {
        case 'insert':
            $currency = $_REQUEST['currency'];
            $i = 1;
            while ($i < 20) {
                $Date = $_REQUEST["Date$i"];
                $Description = $_REQUEST["Description$i"];
                $amount = $_REQUEST["amount$i"];

                $query = "INSERT INTO invoice_details (
                    Invoice_Number,
                    Date,
                    Description,
                    $currency
                    ) VALUES (
                    :Invoice_Number,
                    :Date,
                    :Description,
                    :amount
                    )
                ;";
                $database->query($query);
                $database->bind(':Invoice_Number', $Invoice_Number);
                $database->bind(':Date', $Date);
                $database->bind(':Description', $Description);
                $database->bind(':amount', $amount);
                $database->execute();
                $i++;
            }
            break;
        case 'sum':
            $query = "SELECT SUM($currency) AS $currency FROM invoice_details
                WHERE Invoice_Number = :Invoice_Number
            ;";
            $database->query($query);
            $database->bind(':Invoice_Number', $Invoice_Number);
            $rows = $database->resultset();
            foreach ($rows as $row) {
                $sum = $row->$currency;
            }
            return $sum;
            break;

        case 'select':
            if ($Invoice_Number == "" || $Invoice_Number == NULL || empty($Invoice_Number)) {
                $query = "SELECT * FROM invoice_details ORDER BY Id ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM invoice_details WHERE Invoice_Number = :Invoice_Number ;";
                $database->query($query);
                $database->bind(':Invoice_Number', $Invoice_Number);
            }
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}

// //function to use data from the table invoices
function table_invoices($task, $Invoice_Number) {
    $database = new Database();

    switch ($task) {
        case 'insert':
            $Clients_Reference = trim($_REQUEST['Clients_Reference']);
            $currency = $_REQUEST['currency'];
            $Status = 'Invoiced';
            $Invoice_date = $_REQUEST['Invoice_Date'];
            $one_month = 30;
            $Due_Date = date('Y-m-d', strtotime($Invoice_date."+".$one_month.'days'));
            $sum = table_invoice_details('sum', $Invoice_Number);

            $query = "INSERT INTO invoices (
                Invoice_Number,
                Clients_Reference,
                $currency,
                Status,
                Invoice_Date,
                Due_Date
                ) VALUES(
                :Invoice_Number,
                :Clients_Reference,
                :sum,
                :Status,
                :Invoice_Date,
                :Due_Date
                )
            ;";
            $database->query($query);
            $database->bind(':Invoice_Number', $Invoice_Number);
            $database->bind(':Clients_Reference', $Clients_Reference);
            $database->bind(':sum', $sum);
            $database->bind(':Status', $Status);
            $database->bind(':Invoice_Date', $Invoice_date);
            $database->bind(':Due_Date', $Due_Date);
            if ($database->execute()) {
                header("location: invoices.php");
            }
            break;

        case 'select':
            if ($Invoice_Number == NULL || $Invoice_Number == "" || empty($Invoice_Number)) {
                $query = "SELECT * FROM invoices ORDER BY Id";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM invoices WHERE Invoice_Number = :Invoice_Number ;";
                $database->query($query);
                $database->bind(':Invoice_Number', $Invoice_Number);
            }
            return $r = $database->resultset();
            break;

        default:
            // code...
            break;
    }
}



?>
