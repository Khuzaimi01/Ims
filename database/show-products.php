<?php
    // Include the database connection
    include('connection.php');

    // Function to fetch products data
    function getProducts() {
        global $conn; // Use the global database connection

        try {
            $stmt = $conn->prepare("SELECT * FROM products_db ORDER BY created_at DESC");
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();
            return $result;
        } catch (PDOException $e) {
            // Handle the error if needed
            die("Error: " . $e->getMessage());
        }
    }
?>

