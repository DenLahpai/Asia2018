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

        case 'update':
            $Bill_To = trim($_REQUEST['Bill_To']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
            $Country = trim($_REQUEST['Country']);
            $Attn = trim($_REQUEST['Attn']);

            $query = "UPDATE invoice_headers SET
                Bill_To = :Bill_To,
                Address = :Address,
                City = :City,
                Country = :Country,
                Attn = :Attn
                WHERE Invoice_Number = :Invoice_Number
            ;";
            $database->query($query);
            $database->bind(':Bill_To', $Bill_To);
            $database->bind(':Address', $Address);
            $database->bind(':City', $City);
            $database->bind(':Country', $Country);
            $database->bind(':Attn', $Attn);
            $database->bind(':Invoice_Number', $Invoice_Number);
            $database->execute();
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
            $i = 1;
            while ($i <= 20) {
                $Description = trim($_REQUEST["Description$i"]);
                $amount = $_REQUEST["amount$i"];

                $query = "INSERT INTO invoice_details (
                    Invoice_Number,
                    Description,
                    $currency
                    ) VALUES (
                    :Invoice_Number,
                    :Description,
                    :amount
                    )
                ;";
                $database->query($query);
                $database->bind(':Invoice_Number', $Invoice_Number);
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

        case 'update':
            $i = 1;
            while ($i <= 20) {
                $Id = $_REQUEST["Id$i"];
                $Description = trim($_REQUEST["Description$i"]);
                $amount = $_REQUEST["amount$i"];

                $query = "UPDATE invoice_details SET
                    Description = :Description,
                    $currency = :amount
                    WHERE Id = :Id
                ;";
                $database->query($query);
                $database->bind(':Description', $Description);
                $database->bind(':amount', $amount);
                $database->bind(':Id', $Id);
                $database->execute();
                $i++;
            }
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
            $due_days = 45;
            $Due_Date = date('Y-m-d', strtotime($Invoice_date."+".$due_days.'days'));
            $sum = table_invoice_details('sum', $Invoice_Number, $currency);

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

        case 'update':
            $Clients_Reference = trim($_REQUEST['Clients_Reference']);

            $query_currency = "SELECT USD, SGD FROM invoices WHERE Invoice_Number = :Invoice_Number ;";
            $database->query($query_currency);
            $database->bind(':Invoice_Number', $Invoice_Number);
            $result_currency = $database->resultset();
            foreach ($result_currency as $result_currency) {
                // code...
            }
            if ($result_currency->USD == 0) {
                $currency = 'SGD';
            }
            else {
                $currency = 'USD';
            }
            $sum = table_invoice_details('sum', $Invoice_Number, $currency);
            $Invoice_Date = $_REQUEST['Invoice_Date'];
            $due_days = 45;
            $Due_Date = date('Y-m-d', strtotime($Invoice_date."+".$due_days.'days'));

            $query = "UPDATE invoices SET
                Clients_Reference = :Clients_Reference,
                $currency = :sum,
                Invoice_Date = :Invoice_Date,
                Due_Date = :Due_Date
                WHERE Invoice_Number = :Invoice_Number
            ;";
            $database->query($query);
            $database->bind(':Clients_Reference', $Clients_Reference);
            $database->bind(':sum', $sum);
            $database->bind(':Invoice_Date', $Invoice_Date);
            $database->bind(':Due_Date', $Due_Date);
            $database->bind(':Invoice_Number', $Invoice_Number);
            if ($database->execute()) {
                header("location:edit_invoice.php?Invoice_Number=$Invoice_Number");
            }
            break;

        default:
            // code...
            break;
    }
}

//function to use date from the table payment_headers
function table_payment_headers($task, $Voucher_Number) {
    $database = new Database();

    switch ($task) {
        case 'insert':
            $To = trim($_REQUEST['To']);
            $Address1 = trim($_REQUEST['Address1']);
            $Address2 = trim($_REQUEST['Address2']);
            $City = trim($_REQUEST['City']);
            $Country = trim($_REQUEST['Country']);

            $query = "INSERT INTO payment_headers (
                Voucher_Number,
                Addressee,
                Address1,
                Address2,
                City,
                Country
                ) VALUES (
                :Voucher_Number,
                :To,
                :Address1,
                :Address2,
                :City,
                :Country
                )
            ;";
            $database->query($query);
            $database->bind(':Voucher_Number', $Voucher_Number);
            $database->bind(':To', $To);
            $database->bind(':Address1', $Address1);
            $database->bind(':Address2', $Address2);
            $database->bind(':City', $City);
            $database->bind(':Country', $Country);
            $database->execute();
            break;
        case 'select':
            if ($Voucher_Number == "" || $Voucher_Number == NULL || empty($Voucher_Number)) {
                $query = "SELECT * FROM payment_headers ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM payment_headers
                    WHERE Voucher_Number = :Voucher_Number
                ;";
                $database->query($query);
                $database->bind(':Voucher_Number', $Voucher_Number);
            }
            return $r = $database->resultset();
            break;

        case 'update':
            $Addressee = trim($_REQUEST['Addressee']);
            $Address1 = trim($_REQUEST['Address1']);
            $Address2 = trim($_REQUEST['Address2']);
            $City = trim($_REQUEST['City']);
            $Country = trim($_REQUEST['Country']);

            $query = "UPDATE payment_headers SET
                Addressee = :Addressee,
                Address1 = :Address1,
                Address2 = :Address2,
                City = :City,
                Country = :Country
                WHERE Voucher_Number = :Voucher_Number
            ;";
            $database->query($query);
            $database->bind(':Addressee', $Addressee);
            $database->bind(':Address1', $Address1);
            $database->bind(':Address2', $Address2);
            $database->bind(':City', $City);
            $database->bind(':Country', $Country);
            $database->bind(':Voucher_Number', $Voucher_Number);
            $database->execute();
            break;

        default:
            // code...
            break;
    }
}

//function to use data from the table payment_details
function table_payment_details($task, $Voucher_Number, $currency) {
    $database = new Database();

    switch ($task) {
        case 'insert':
            $currency = $_REQUEST['currency'];
            $i = 1;
            while ($i <= 20) {
                $Invoice_Date = $_REQUEST["Invoice_Date$i"];
                $Invoice_Number = trim($_REQUEST["Invoice_Number$i"]);
                $amount = $_REQUEST["amount$i"];

                $query = "INSERT INTO payment_details (
                    Voucher_Number,
                    Invoice_Date,
                    Invoice_Number,
                    $currency
                    ) VALUES(
                    :Voucher_Number,
                    :Invoice_Date,
                    :Invoice_Number,
                    :amount
                    )
                ;";
                $database->query($query);
                $database->bind(':Voucher_Number', $Voucher_Number);
                $database->bind(':Invoice_Date', $Invoice_Date);
                $database->bind(':Invoice_Number', $Invoice_Number);
                $database->bind(':amount', $amount);
                $database->execute();
                $i++;
            }
            break;
        case 'select':
            if ($Voucher_Number == "" || $Voucher_Number == NULL || empty($Voucher_Number)) {
                $query = "SELECT * FROM payment_details ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM payment_details
                    WHERE Voucher_Number = :Voucher_Number
                ;";
                $database->query($query);
                $database->bind(':Voucher_Number', $Voucher_Number);
            }
            return $r = $database->resultset();
            break;

        case 'sum':
            $query = "SELECT SUM($currency) AS $currency FROM payment_details
                WHERE Voucher_Number = :Voucher_Number
            ;";
            $database->query($query);
            $database->bind(':Voucher_Number', $Voucher_Number);
            $rows = $database->resultset();
            foreach ($rows as $row) {
                $sum = $row->$currency;
            }
            return $sum;
            break;

        case 'update':
            $i = 1;
            while ($i <= 20) {
                $Id = $_REQUEST["Id$i"];
                $Invoice_Date = $_REQUEST["Invoice_Date$i"];
                $Invoice_Number = trim($_REQUEST["Invoice_Number$i"]);
                $amount = $_REQUEST["amount$i"];

                $query = "UPDATE payment_details SET
                    Invoice_Date = :Invoice_Date,
                    Invoice_Number = :Invoice_Number,
                    $currency = :amount
                    WHERE Id = :Id
                ;";
                $database->query($query);
                $database->bind(':Invoice_Date', $Invoice_Date);
                $database->bind(':Invoice_Number', $Invoice_Number);
                $database->bind(':amount', $amount);
                $database->bind(':Id', $Id);
                $database->execute();
                $i++;
            }
            break;

        default:
            // code...
            break;
    }
}

//fucntion to use data from the table payments
function table_payments($task, $Voucher_Number) {
    $database = new Database();

    switch ($task) {
        case 'insert':
            $currency = $_REQUEST['currency'];
            $Payment_Date = $_REQUEST['Payment_Date'];
            $sum = table_payment_details('sum', $Voucher_Number);
            $Method = trim($_REQUEST['Method']);
            $UsersId = $_SESSION['users_Id'];

            $query = "INSERT INTO payments (
                Voucher_Number,
                Payment_Date,
                $currency,
                Method,
                UsersId
                ) VALUES(
                :Voucher_Number,
                :Payment_Date,
                :sum,
                :Method,
                :UsersId
                )
            ;";
            $database->query($query);
            $database->bind(':Voucher_Number', $Voucher_Number);
            $database->bind(':Payment_Date', $Payment_Date);
            $database->bind(':sum', $sum);
            $database->bind(':Method', $Method);
            $database->bind(':UsersId', $UsersId);
            if ($database->execute()) {
                header("location: payments.php");
            }
            break;
        case 'select':
            if ($Voucher_Number == NULL || $Voucher_Number == "" || empty($Voucher_Number)) {
                $query = "SELECT * FROM payments ORDER BY Id ;";
                $database->query($query);
            }
            else {
                $query = "SELECT * FROM payments WHERE Voucher_Number = :Voucher_Number ;";
                $database->query($query);
                $database->bind(':Voucher_Number', $Voucher_Number);
            }
            return $r = $database->resultset();
            break;

        case 'update':
            $query_currency = "SELECT USD, SGD FROM payments WHERE Voucher_Number = :Voucher_Number ;";
            $database->query($query_currency);
            $database->bind(':Voucher_Number', $Voucher_Number);
            $result_currency = $database->resultset();
            foreach ($result_currency as $result_currency) {
                // code...
            }
            if ($result_currency->USD == 0) {
                $currency = 'SGD';
            }
            else {
                $currency = 'USD';
            }

            $query_sum = "SELECT SUM($currency) AS $currency FROM payment_details
                WHERE Voucher_Number = :Voucher_Number
            ;";
            $database->query($query_sum);
            $database->bind(':Voucher_Number', $Voucher_Number);
            $rows = $database->resultset();
            foreach ($rows as $row) {
                $sum = $row->$currency;
            }


            $Payment_Date = $_REQUEST['Payment_Date'];
            $query = "UPDATE payments SET
                Payment_Date = :Payment_Date,
                $currency = :sum,
                UsersId = :UsersId
                WHERE Voucher_Number = :Voucher_Number
            ;";
            $database->query($query);
            $database->bind(':Payment_Date', $Payment_Date);
            $database->bind(':sum', $sum);
            $database->bind(':UsersId', $UsersId);
            $database->bind(':Voucher_Number', $Voucher_Number);
            if ($database->execute()) {
                header("location:edit_payment.php?Voucher_Number=$Voucher_Number");
            }
            break;

        default:
            // code...
            break;
    }
}



?>
