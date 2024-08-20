<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');

if (isset($_POST['edit_customers'])) {
    $user_id = $_GET['edit_customers']; // Assuming you are passing user_id in the URL
    $user_name = $_POST['username'];
    $user_email = $_POST['email'];

    // Assuming you want to update the user information in the database
    $update_query = "UPDATE `user_table` SET `username`='$user_name', `email`='$user_email' WHERE `id`='$user_id'";
    mysqli_query($con, $update_query);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        .centered-button {
            text-align: center;
        }

        .black-button {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center"><i class="bi bi-person-fill-exclamation fa-2x"></i>Edit Customer</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <?php
        // Fetching existing customer data based on the user_id in the URL
        if (isset($_GET['edit_customers'])) {
            $user_id = $_GET['edit_customers'];
            $result = mysqli_query($con, "SELECT * FROM `user_table` WHERE `id`='$user_id' AND `user_type`='customer'");
            $row = mysqli_fetch_array($result);

            $user_name = $row['username'];
            $user_email = $row['email'];
        }
        ?>
        <!-- Room Title -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="name" class="form-label fw-bold">Customer Name</label>
            <input type="text" value="<?php echo $user_name ?>" name="username" class="form-control">
        </div>

        <!-- Room Description -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="description" class="form-label fw-bold">Customer Email</label>
            <input type="text" value="<?php echo $user_email ?>" name="email" class="form-control">
        </div>

        <div class="centered-button">
            <button type="submit" name="edit_customers" class="btn btn-primary black-button">Save Changes</button>
        </div>
    </form>
</div>

</body>
</html>
