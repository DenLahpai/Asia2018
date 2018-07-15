<?php
require "../conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Username = trim($_REQUEST['Username']);
    $Password = trim($_REQUEST['Password']);

    $database = new Database();
    $query = "SELECT * FROM users WHERE
        BINARY Username = :Username AND
        BINARY Password = :Password
    ;";
    $database->query($query);
    $database->bind(':Username', $Username);
    $database->bind(':Password', $Password);
    $rowCount = $database->rowCount();
    $rows = $database->resultset();


    if ($rowCount > 0) {
        foreach ($rows as $row) {
            echo $_SESSION['users_Id'] = $row->Id;
        }
        header("location:home.php");
    }
    else {
        header("location:index.php");
    }
}

?>
