<?php
include('../admin/config.php');
include('../functions/common_function.php');

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    $IMAGE = $_FILES['image']['name'];
    $TEMPIMAGE = $_FILES['image']['tmp_name'];

    $select = "SELECT * FROM user_table WHERE email = '$email' && password = '$password'";
    $result = mysqli_query($con, $select);

    if ($username == '' or $email == '' or $password == '' or $cpassword == '' or $IMAGE == '') {
        echo "<script>alert('Please fill all the available fields!')</script>";
    } else {
        move_uploaded_file($TEMPIMAGE, "userimages/$IMAGE");

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('User already exists!')</script>";
        } else {
            if ($password != $cpassword) {
                echo "<script>alert('Password not matched!')</script>";
            } else {
                // Include 'join_date' in the INSERT statement and set its value to CURRENT_TIMESTAMP
                $insert = "INSERT INTO user_table(`username`, `email`, `user_image`, `password`, `user_type`, `join_date`) 
                           VALUES('$username','$email', '$IMAGE', '$password','$user_type', CURRENT_TIMESTAMP)";

                if (mysqli_query($con, $insert)) {
                    echo "<script>alert('Registered Successfully!')</script>";
                    echo "<script>window.open('user_login.php', '_self')</script>";
                }
            }
        }
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
    <title>User Registration</title>
    <style>
        body{
            overflow: hidden;
            background-color: #eeeff1;
        }
    </style>
</head>
<body>
    <div class="container-fluid m-3">
        <h2 class="text-center mb-5">User Registration</h2>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-6 col-xl-5">
                <img src="../images/rooms/1.jpg" alt="User Registration" class="img-fluid">
            </div>
            <div class="col-lg-6 col-xl-4">
                <form action="user_registration.php" method="post" enctype="multipart/form-data">
                    <!-- Username -->
                    <div class="form-outline mb-2">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your Username" 
                        required="required" class="form-control" autocomplete="off">
                    </div>
                    <!-- Email -->
                    <div class="form-outline mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your Email" 
                        required="required" class="form-control" autocomplete="off">
                    </div>
                    <!-- Display Picture -->
                    <div class="form-outline mb-2">
                        <label for="image" class="form-label">Upload Display Picture</label>
                        <input type="file" name="image" id="user_image" class="form-control" 
                        required="required">
                    </div>
                    <!-- Password -->
                    <div class="form-outline mb-2">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your Password" 
                        required="required" class="form-control" autocomplete="off">
                    </div>
                    <!-- Confirm Password -->
                    <div class="form-outline mb-2">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" id="cpassword" name="cpassword" placeholder="Confirm your Password" 
                        required="required" class="form-control" autocomplete="off">
                    </div>
                    <!-- User Type -->
                    <div class="form-outline mb-2">
                        <label for="user_type" class="form-label">Enter User Type</label>
                            <select name="user_type" id="user_type" class="form-select" >
                                <option value="staff">Staff</option>
                                <option value="customer">Customer</option>
                        
                            </select>
                    </div>
                    
                    <div>
                        <input type="submit" class="bg-info py-2 px-3 border-0" name="submit" value="Register" >
                        <p class="small fw-bold mt-2 pt-1">Already have an account? <a href="user_login.php" class="link-danger">Login Now!</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>