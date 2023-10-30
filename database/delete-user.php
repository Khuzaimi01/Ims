<?php
    // Include database connection and functions to delete user
    include('database/connection.php');
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userId = $_POST['user_id'];

        // Delete the user record from the database

        $response = array('success' => true, 'message' => 'User deleted successfully');
        echo json_encode($response);
        exit();
    }
?>

<!-- No need for HTML content in this file -->
