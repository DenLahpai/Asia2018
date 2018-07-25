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

//function to use data from the table invoice_header
function table_invoice_headers($task, $Invoice_Number) {
    $database = new Database();
    switch ($task) {
        case 'insert':
            $Bill_To = trim($_REQUEST['Bill_To']);
            $Address = trim($_REQUEST['Address']);
            $City = trim($_REQUEST['City']);
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

        default:
            // code...
            break;
    }
}

//function to use data from the table invoices
function table_invoices($task, $Invoice_Number) {
    $database = new Database();
    // switch ($task) {
    //     case '':
    //         // code...
    //         break;
    //
    //     default:
    //         // code...
    //         break;
    // }
}

?>
