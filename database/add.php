<?php
    // Start the session.
    session_start();

    // Include database connection
    include('connection.php');

    $table_name = $_SESSION['table'];

    if ($table_name === 'users') {
        // Validation and Sanitization
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $encrypted = password_hash($password, PASSWORD_DEFAULT);

        // Prepared statement for user insertion
        $command = "INSERT INTO $table_name (first_name, last_name, email, password, created_at, updated_at) 
                    VALUES (:first_name, :last_name, :email, :password, NOW(), NOW())";

        $stmt = $conn->prepare($command);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $encrypted);

        $stmt->execute();

        $response = array(
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' successfully added to the system.'
        );

        header('Location: ../users-add.php');
        $_SESSION['response'] = $response;
        exit();
    } elseif ($table_name === 'products') {
        // Validation and Sanitization
        $product_name = $_POST['product_name'];
        $description = $_POST['description'];

        // Prepared statement for product insertion
        $command = "INSERT INTO $table_name (product_name, description, created_at, updated_at) 
                    VALUES (:product_name, :description, NOW(), NOW())";

        $stmt = $conn->prepare($command);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':description', $description);

        $stmt->execute();

        $response = array(
            'success' => true,
            'message' => 'Product ' . $product_name . ' successfully added to the system.'
        );

        header('Location: products-add.php');
        $_SESSION['response'] = $response;
        exit();
    }
?>
