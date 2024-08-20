<?php
include 'config.php';

if (isset($_POST['admin_login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);

    $select_query = "SELECT * FROM `user_table` WHERE email=? AND password=?";
    $stmt = mysqli_prepare($con, $select_query);
    
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    
    $result_query = mysqli_stmt_get_result($stmt);

    $row_count = mysqli_num_rows($result_query);
    $row_data = mysqli_fetch_assoc($result_query);

    if ($row_count > 0) {
        $_SESSION['admin_name'] = $row_data['username']; // Use 'username' from your database
        if ($password == $row_data['password']) {
            echo "<script>window.open('admin.php', '_self')</script>";
        }
    } else {
        echo "<script>alert('Invalid Credentials!')</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
<!-- Fontawesome Link -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Admin Login</title>
    <style>
        body{
            overflow: hidden;
            background-color: #eeeff1;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">Admin Login</h2>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6 col-xl-5">
                <img src="../images/rooms/1.jpg" alt="Admin Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
                <form action="" method="post">

                <!-- Admin Name -->
<div class="form-outline mb-4">
    <label for="admin_name" class="form-label">Admin Name</label>
    <input type="text" id="admin_name" name="admin_name" placeholder="Enter your Admin Name" 
        required="required" class="form-control">
</div>

                    <div class="form-outline mb-4">
                    <label for="email" class="form-label">Email</label>
                        <input type="text" id="email" name="email" placeholder="Enter your Email" 
                        required="required" class="form-control">
                    </div>
                    
                    <div class="form-outline mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your Password" 
                        required="required" class="form-control">
                    </div>
                    
                    <div class>
                        <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_login" value="Login">
                        <p class="small fw-bold mt-2 pt-1">Don't have an account? <a href="admin_registration.php" class="link-danger">Register Now!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

