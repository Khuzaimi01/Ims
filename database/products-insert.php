<?php
    // Start the session.
    session_start();

    // Include your database connection
    include('database/connection.php');

    // Initialize the response array
    $response = array();

    // Retrieve form data
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];

    try {
        // Prepare and execute the SQL query to insert the data
        $stmt = $conn->prepare("INSERT INTO products_db (products_name, description, created_at, updated_at) 
                                VALUES (:product_name, :description, NOW(), NOW())");

        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':description', $description);

        $stmt->execute();

        $response = array(
            'success' => true,
            'message' => 'Product added successfully'
        );
    } catch (PDOException $e) {
        $response = array(
            'success' => false,
            'message' => 'Error adding product: ' . $e->getMessage()
        );
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
?>
