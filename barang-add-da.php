<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'inventory';


// Connecting to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit(); // Make sure to exit the script after displaying the error message
}

// Process form submission if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $much = $_POST['much'];
    $code = $_POST['code'];
    $status = $_POST['status'];
    $quantity = $_POST['quantity'];
    $manual_date = $_POST['manual_date']; // Get the manual_date from the form
    $loc_code = $_POST['loc_code'];
    $loc_asset = $_POST['loc_asset'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $image_name = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    
    // Specify the directory where you want to save the uploaded images
    $upload_directory = 'images/'; // You may need to create this directory if it doesn't exist
    
    // Generate a unique filename for the image to avoid overwriting existing files
    $unique_image_name = uniqid() . '_' . $image_name;
    
    // Set the full path for saving the image
    $image_path = $upload_directory . $unique_image_name;
    
    // Check if the image was successfully moved to the upload directory
    if (move_uploaded_file($image_tmp_name, $image_path)) {
        // Image upload successful, you can now store $image_path in the database
    } else {
        // Image upload failed
        $response = array(
            'success' => false,
            'message' => 'Error uploading image.'
        );
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}


    // Insert product data into the database
    try {
    $stmt = $conn->prepare("INSERT INTO barang_pejabat_da (product_name, descriptions, much, code, status, quantity, created_at, manual_date, updated_at, image_path, loc_code, loc_asset) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, NOW(), ?, ?, ?)");
    $stmt->bindParam(1, $product_name);
    $stmt->bindParam(2, $description);
    $stmt->bindParam(3, $much);
    $stmt->bindParam(4, $code);
    $stmt->bindParam(5, $status);
    $stmt->bindParam(6, $quantity);
    $stmt->bindParam(7, $manual_date);
    $stmt->bindParam(8, $image_path);
    $stmt->bindParam(9, $loc_code);
    $stmt->bindParam(10, $loc_asset); // Bind the image_path parameter
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

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}




// ... (The rest of your PHP code) ...


// Fetch list of products
$stmt = $conn->prepare("SELECT * FROM barang_pejabat_da ORDER BY created_at DESC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$products = $stmt->fetchAll();
$grandTotal = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Inventory Management System</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <!-- Include your other CSS files here -->
    <script src="https://kit.fontawesome.com/6e8523a870.js" crossorigin="anonymous"></script>
    <!-- Include your other scripts here -->
    <style>
        
        /* Add these styles to your styles.css file */

        /* Input field styling */
        .input-field {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        /* Primary button styling */
        .btn-primary {
            background-color: #4caf50;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 18px;
            padding: 12px 24px;
            width: 100%;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #45a049;
        }

        /* Response message styling */
        .response-message {
            margin-top: 12px;
            padding: 10px;
            font-size: 16px;
            text-align: center;
            background-color: #f5f5f5;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Section box styling */
        .section_box {
            background-color: #fff;
            padding: 20px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        .section_header {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        /* Table styling */
        .product_table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }

        .product_table th,
        .product_table td {
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
        .dashboard_header {
            text-align: left;
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        /* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 50px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
}

.modal-content {
    display: block;
    margin: 0 auto;
    max-width: 80%;
    max-height: 80%;
}

.close {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 30px;
    color: #fff;
    cursor: pointer;
}
/* Back button styles */
.back-button {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.back-button:hover {
    background-color: #45a049;
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
                    <!-- Your form code here -->
                    <!-- ... (Your existing PHP and HTML code) ... -->

                        <div class="section_box">
                            <div class="section_header">
                                <div class="dashboard_header">Estet Danum</div>
                                <i class="fa-solid fa-plus"></i> Barang Pejabat
                            </div>
                            <form id="addProductForm" method="POST">
                               <form id="addProductForm" method="POST">
                            <div class="form-group">
                                <label for="loc_code">Location Code</label>
                                <select id="loc_code" name="loc_code" class="input-field">
                                    <option value="15035">15035</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">Type of Asset</label>
                                <input type="text" id="description" name="description" class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" id="quantity" name="quantity" class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="product_name">Brand</label>
                                <input type="text" id="product_name" name="product_name" class="input-field">
                            </div>
                            <div class="form-group">
                                    <label for="code">Asset Code</label>
                                    <input type="text" id="code" name="code" class="input-field">
                                </div>
                            <div class="form-group">
                                <label for="manual_date">Date of purchase</label>
                                <input type="date" id="manual_date" name="manual_date" class="input-field">
                            </div>
                            <div class="form-group">
                                <label for="much">Price(RM)</label>
                                <input type="text" id="much" name="much" class="input-field">
                            </div>
                                <div class="form-group">
                                    <label for="loc_asset">Asset Location</label>
                                    <input type="text" id="loc_asset" name="loc_asset" class="input-field">
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select id="status" name="status" class="input-field">
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Lupus">Lupus</option>
                                        <option value="Rosak">Rosak</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" id="image" name="image" class="input-field">
                                </div> 
                                <button type="submit" class="btn-primary">
                                    <i class="fa-solid fa-plus"></i> Add Product
                                </button>
                            </form>
                        </div>

                        <!-- ... (Your existing JavaScript code) ... -->

                    <div id="responseMessage" class="response-message"></div>
                    <!-- Code for listing products here -->
                    <div class="column column-6">
                        <div class="section_box">
                            <div class="section_header">
                                <i class="fa-solid fa-list"></i> List Of Products
                            </div>

                                <p><a href="export-excel-da.php">Export to Excel</a></p>
                           <div class="section_content">
    <div class="products">
        <table class="product_table">
    <thead>
        <tr>
            <th>#</th>
            <th>Location Code</th>
            <th>Type of Asset</th>
            <th>Quantity</th>
            <th>Brand</th>
            <th>Asset Code</th>
            <th>Date of Purchase</th>
            <th>Price(RM)</th>
            <th>Asset Location</th>
            <th>Status</th>
            <th>Image</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $index => $product) { ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= $product['loc_code'] ?></td>
            <td><?= $product['descriptions'] ?></td>
            <td><?= $product['quantity'] ?></td>
            <td><?= $product['product_name'] ?></td>
            <td><?= $product['code'] ?></td>
            <td><?= date('M d, Y @ h:i:s A', strtotime($product['manual_date'])) ?></td>
            <td><?= $product['much'] ?></td>
            <td><?= $product['loc_asset'] ?></td>
            <td><?= $product['status'] ?></td>
            <td>
                <a href="<?= $product['image_path'] ?>" target="_blank">
                    <img src="<?= $product['image_path'] ?>" alt="Product Image" width="100" height="100">
                </a>
            </td>
            <td><?= date('M d, Y @ h:i:s A', strtotime($product['created_at'])) ?></td>
            <td><?= date('M d, Y @ h:i:s A', strtotime($product['updated_at'])) ?></td>
            <td>
                <a href="barang-edit-da.php?id=<?= $product['id'] ?>">Edit</a> |
                <a href="barang-delete-da.php?id=<?= $product['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
            </td>
        </tr>
        <?php $grandTotal += $product['much']; // Update grand total ?>
    <?php } ?>
</tbody>
<tfoot>
    <tr>
        <td colspan="9"></td> <!-- Adjusted colspan to 9 for the columns before Price(RM) -->
        <td colspan="2">Grand Total (RM)</td>
        <td><?= $grandTotal ?></td>
        <td colspan="2"></td> <!-- Adjusted colspan to 2 for the columns after Price(RM) -->
    </tr>
</tfoot>
</table>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
    const addProductForm = document.getElementById('addProductForm');
    const responseMessage = document.getElementById('responseMessage');

    addProductForm.addEventListener('submit', (event) => {
        event.preventDefault(); // Prevent the default form submission

        // Collect form data
        const formData = new FormData(addProductForm);

        // Get the manual_date input value and append it to formData
        const manualDateInput = document.getElementById('manual_date');
        formData.append('manual_date', manualDateInput.value); // Make sure this is correct

         const imageInput = document.getElementById('image');

        // Check if an image file is selected
        if (imageInput.files.length > 0) {
            // Append the selected image file to the form data
            formData.append('image', imageInput.files[0]);
        }

        // Send AJAX request to add product
        fetch('barang-add-da.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const message = document.createElement('p');
            message.textContent = data.message;
            responseMessage.innerHTML = '';
            responseMessage.appendChild(message);

            if (data.success) {
                // Clear form fields and update product list
                addProductForm.reset();
                // You can also update the list dynamically here if needed
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
    </script>
</body>
</html>