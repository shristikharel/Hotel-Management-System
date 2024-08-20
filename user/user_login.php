<?php

include '../admin/config.php';

// session_start();

if(isset($_POST['user_login'])){

   $email = mysqli_real_escape_string($con, $_POST['email']);
   $password = md5($_POST['password']);
   

   $select_query="Select * from `user_table` where email='$email'";
   $result=mysqli_query($con,$select_query);

   if(mysqli_num_rows($result) > 0){

      $row = mysqli_fetch_array($result);
      if ($row['user_type'] == 'customer') {
        $_SESSION['cust_name'] = $row['username'];
        header('location:userindex.php');
        exit();
    } elseif ($row['user_type'] == 'staff') {
        $_SESSION['staff_name'] = $row['username'];
        $_SESSION['user_id'] = $row['user_id']; // Set user_id in the session
        header('location:../staff/staff.php');
    } elseif ($row['user_type'] == 'Admin') {
        $_SESSION['admin_name'] = $row['username'];
        header('location:../admin/admin.php');
    }
    }
   
   
};
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
    <title>User Login </title>
    <style>
        body{
            overflow: hidden;
            background-color: #eeeff1;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">Welcome Back!</h2>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-6 col-xl-5">
                <img src="../images/rooms/1.jpg" alt="User Login" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
                <form action="user_login.php" method="post">
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
                        <input type="submit" class="bg-info py-2 px-3 border-0" name="user_login" value="Login">
                        <p class="small fw-bold mt-2 pt-1">Don't have an account? <a href="user_registration.php" class="link-danger">Register Now!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

