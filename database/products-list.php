<?php
    // Start the session.
    session_start();

    // Include your database connection
    include('database/connection.php');

    // Retrieve products data from the database
    try {
        $stmt = $conn->prepare("SELECT * FROM products_db ORDER BY created_at DESC");
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error fetching products: ' . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product List - Inventory Management System</title>
</head>
<body>
    <h1>Product List</h1>
    
    <?php if(count($products) > 0) { ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) { ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td><?= $product['products_name'] ?></td>
                        <td><?= $product['description'] ?></td>
                        <td><?= $product['created_at'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No products found.</p>
    <?php } ?>
    
</body>
</html>
