<?php
include('config.php');
include('../inc/links.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
     <!-- FontAwesome Styles-->
     <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <title>Admin Dashboard</title>
    <style>
    .vehicle_img{
    width: 100px;
    object-fit: contain;
    }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="bi bi-houses-fill me-2"></i>HMS</div>
            <div class="list-group list-group-flush my-3">
                <a href="admin.php?dashboard" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="admin.php?insert_category" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-house-add-fill me-2"></i>Insert Category</a>
                <a href="admin.php?insert_room" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-house-add-fill me-2"></i>Insert Rooms</a>
                <a href="admin.php?view_room" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-house-check-fill me-2"></i>View Rooms</a>
                <a href="admin.php?insert_facility" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                    <i class="bi bi-house-gear-fill me-2"></i>View Facilities</a>
                <a href="admin.php?insert_feature" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-house-heart-fill me-2"></i>View Features</a>
                <a href="admin.php?view_staffs" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-people-fill me-2"></i>View Staffs</a>
                <a href="admin.php?view_users" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-people-fill me-2"></i>View Users</a>
                <a href="admin.php?view_bookings" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-calendar-check-fill me-2"></i>Bookings</a>
                <a href="admin.php?view_complaints" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-chat-dots-fill me-2"></i>Manage Complaints</a>
                <a href="admin.php?view_charts" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="bi bi-graph-up-arrow me-2"></i>Statistics</a>
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Logout</a>
            </div>
        </div>
    <div class="container my-5">
    <?php
    if(isset($_GET['dashboard'])){
        include('dashboard.php');
    }
    if(isset($_GET['insert_room'])){
        include('insert_rooms.php');
    }
    if(isset($_GET['insert_facility'])){
        include('insert_facilities.php');
    } 
    if(isset($_GET['insert_category'])){
        include('insert_category.php');
    } 
    if(isset($_GET['insert_feature'])){
        include('insert_features.php');
    }
    if(isset($_GET['view_room'])){
            include('view_rooms.php');
    } 
    if(isset($_GET['view_users'])){
        include('users.php');
} 
    if(isset($_GET['view_staffs'])){
        include('staffs.php');
    } 
    if(isset($_GET['edit_rooms'])){
        include('edit_rooms.php');
    }
    if(isset($_GET['edit_category'])){
        include('edit_category.php');
    }
    if(isset($_GET['edit_customers'])){
        include('edit_customer.php');
    }
    if(isset($_GET['approve_vehicles'])){
        include('confirm_vehicles.php');
    } 
    if(isset($_GET['delete_rooms'])){
        include('delete_rooms.php');
    }
    if(isset($_GET['delete_category'])){
        include('delete_category.php');
    }
    if(isset($_GET['delete_user'])){
        include('delete_user.php');
    }
    if(isset($_GET['edit_features'])){
        include('edit_feature.php');
    } 
    if(isset($_GET['edit_facility'])){
        include('edit_facility.php');
    }
    if(isset($_GET['delete_features'])){
        include('delete_features.php');
    } 
    if(isset($_GET['delete_facility'])){
        include('delete_facility.php');
    }
    if(isset($_GET['view_bookings'])){
        include('book.php');
    } 
    if(isset($_GET['view_complaints'])){
        include('resolve.php');
    } 
    if(isset($_GET['view_charts'])){
        include('statistics.php');
    }      
    ?>
    </div>
    </div>

    <!-- /#page-content-wrapper -->
    


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");

        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script> -->
</body>

</html>