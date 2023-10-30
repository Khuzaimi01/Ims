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
        
        /* ... Your existing styles ... */
        
        /* Sidebar Styles */
        .dashboard_sidebar {
            /* Your sidebar styles */
        }

        .dashboard_sidebar_user {
            /* Your user info styles */
        }

        .dashboard_menu_lists {
            /* Your menu list styles */
        }

        .dashboard_menu_lists li {
            /* Your menu item styles */
        }

        .dashboard_menu_lists .subMenus {
            display: none;
            position: absolute;
            background-color: gray;
            border: 1px solid #ccc;
            z-index: 1;
        }

        .dashboard_menu_lists .subMenus li {
            /* Your submenu item styles */
        }

        .dashboard_menu_lists .dropdown:hover .subMenus {
            display: block;
        }
    </style>
</head>
<body>
    <div class="dashboard_sidebar" id="dashboard_sidebar">
    <h1 class="dashboard_logo" id="dashboard_logo">IMS</h1>
    
    <div class="dashboard_sidebar_user">
        <img src="images/profile.jpg" alt="User Image" id="userImage">
        <?php if (isset($user)) { ?>
            <span><?= $user['first_name'] . ' ' . $user['last_name'] ?></span>
        <?php } ?>
    </div>
        <div class="dashboard_sidebar_menus">
            <ul class="dashboard_menu_lists">
                <!--class="menuActive"-->
                <li>
                    <a href="./pilih-alatan.php"><i class="fa-solid fa-house"></i><span class="menuText">Pejabat Wilayah</span></a>
                </li>
                <li class="dropdown">
                    <a href="#"><i class="fa-solid fa-briefcase"></i><span class="menuText">Kawasan</span></a>
                    <ul class="subMenus">
                        <li><a href="./pilih-alatan-bf.php">Kawasan Beaufort</a></li>
                        <li><a href="./pilih-alatan-kin.php">Kawasan Kinabatangan</a></li>
                        <li><a href="./pilih-alatan-kd.php">Kawasan Kudat</a></li>
                        <li><a href="./pilih-alatan-ld.php">Kawasan Lahad Datu</a></li>
                        <li><a href="./pilih-alatan-nab.php">Kawasan Nabawan</a></li>
                        <li><a href="./pilih-alatan-san.php">Kawasan Sandakan</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#"><i class="fa-solid fa-sign-hanging"></i><span class="menuText">Estet</span></a>
                    <ul class="subMenus">
                        <li><a href="pilih-alatan-da.php">Estet Danum</a></li>
                        <li><a href="pilih-alatan-per.php">Estet Perdana</a></li>
                        <li><a href="pilih-alatan-ptm.php">Estet Pertama</a></li>
                        <li><a href="pilih-alatan-ru.php">Estet Ruku-Ruku</a></li>
                        <li><a href="pilih-alatan-sl.php">Estet Sungai Lokan</a></li>
                        <li><a href="pilih-alatan-tel.php">Estet Telupid</a></li>
                    </ul>
                </li>
                <li>
                    <a href="./users-add.php"><i class="fa-solid fa-person-circle-plus"></i><span class="menuText">Add User</span></a>
                </li>
            </ul>
        </div>
    </div>
</body>
</html>

