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

?>
