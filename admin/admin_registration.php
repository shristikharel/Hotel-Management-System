<?php

include ('config.php');
include ('../functions/common_function.php');
if (isset($_POST['admin_registration'])) {

    $admin_name = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['apassword']);
    $cpassword = md5($_POST['confirm_password']);
    $admin = "Admin";
    $select = " SELECT * FROM user_table WHERE email = '$email' && password = '$password' ";
    
    $result = mysqli_query($con, $select);
    if ($admin_name == '' or $email == '' or $password == ''or $cpassword == '') {
        echo "<script>alert('Please fill all the available fields!')</script>";
    }else{
        if (mysqli_num_rows($result)> 0) {
            echo "<script>alert('User already exists!')</script>";
        } else {
            if ($password != $cpassword) {
                echo "<script>alert('password not matched!')</script>";

            } else {
                $insert = "INSERT INTO user_table(username, email, password, user_type) 
          VALUES('$admin_name','$email', '$password', '$admin')";
          $result=mysqli_query($con, $insert) or trigger_error("Query Failed! SQL: $insert - Error: ".mysqli_error($con), E_USER_ERROR);


                if ($result) {
                    echo "<script>alert('Registered Successfully!')</script>";
                    echo "<script>window.open('admin/dashboard.php', '_self')</script>";
                }else{
                    echo "<script>alert('Invalid Credentials!')</script>";
                }
            }
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
    <title>Admin Registration</title>
    <style>
        body{
            overflow: hidden;
            background-color: #eeeff1;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">Admin Registration</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <img src="../images/rooms/1.jpg" alt="Admin Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
                <form action="admin_registration.php" method="post">
                    <div class="form-outline mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your Username" 
                        required="required" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email" 
                        required="required" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label for="apassword" class="form-label">Password</label>
                        <input type="password" id="apassword" name="apassword" placeholder="Enter your Password" 
                        required="required" class="form-control">
                    </div>
                    <div class="form-outline mb-4">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your Password" 
                        required="required" class="form-control">
                    </div>
                    <div>
                        <input type="submit" class="bg-info py-2 px-3 border-0" name="admin_registration" value="Register">
                        <p class="small fw-bold mt-2 pt-1">Already have an account? <a href="admin_login.php" class="link-danger">Login Now!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>



