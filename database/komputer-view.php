<?php
    // Start the session.
    session_start();

    // Include your database connection
    include('database/connection.php');

    // Include the getProducts function
    include('database/show-products.php');

    // Call the getProducts function to fetch products data
    $products = getProducts();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <script src="https://kit.fontawesome.com/6e8523a870.js" crossorigin="anonymous"></script>
    <style>
        /* Apply your CSS styles here */
        /* ... Your existing styles ... */

        /* Additional CSS styles for table design */
        .product_table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        .product_table th, .product_table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
        }

        .product_table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .product_table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .product_table tbody tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php'); ?>
        <div class="dashboard_content_container">
            <?php include('partials/app-topnav.php'); ?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <div class="row">
                        <div class="column">
                            <div class="section_header">
                                <h1><i class="fa-solid fa-list"></i> List Of Products</h1>
                            </div>
                            <div class="section_content">
                                <div class="products">
                                    <p class="productCount"><?= count($products) ?> Products</p>
                                    <table class="product_table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Description</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($products as $index => $product) { ?>
                                                <tr>
                                                    <td><?= $index + 1 ?></td>
                                                    <td><?= $product['product_name'] ?></td>
                                                    <td><?= $product['description'] ?></td>
                                                    <td><?= date('M d, Y @ h:i:s A', strtotime($product['created_at'])) ?></td>
                                                    <td><?= date('M d, Y @ h:i:s A', strtotime($product['updated_at'])) ?></td>
                                                </tr>
                                            <?php } ?>

                                            <!-- Add more rows here if needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Your toggle button and sidebar JavaScript code
        });
    </script>
</body>
</html>
