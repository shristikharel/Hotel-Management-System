<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('config.php');

if (isset($_GET['edit_rooms'])) {
    $edit_id = $_GET['edit_rooms'];

    $get_data = "SELECT * FROM `rooms` WHERE room_id=$edit_id";
    $result = mysqli_query($con, $get_data);
    $row = mysqli_fetch_assoc($result);

    $room_title = $row['Name'];
    $room_description = $row['Description'];
    $room_keywords = $row['Keywords'];
    $room_image1 = $row['Image'];
    $room_image2 = $row['Image2'];
    $room_price = $row['Price'];
}

?>
<style>
    .img {
        object-fit: contain;
        height: 100px;
        width: 100px;
    }
</style>

<div class="container mt-5">
    <h1 class="text-center"><i class="bi bi-house-exclamation-fill fa-2x"></i>Edit Room</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Room Title -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="name" class="form-label fw-bold">Room Title</label>
            <input type="text" value="<?php echo $room_title ?>" name="name" class="form-control">
        </div>

        <!-- Room Description -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="description" class="form-label fw-bold">Room Description</label>
            <input type="text" value="<?php echo $room_description ?>" name="description" class="form-control">
        </div>

        <!-- Room Keywords -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="keywords" class="form-label fw-bold">Room Keywords</label>
            <input type="text" value="<?php echo $room_keywords ?>" name="keywords" class="form-control">
        </div>

        <!-- Room Image 1 -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="image" class="form-label fw-bold">Room Image 1</label>
            <input type="file" name="image" class="form-control">
            <img src="../uploads/rooms/<?php echo $room_image1 ?>" alt="" class="img">
        </div>

        <!-- Room Image 2 -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="picture" class="form-label fw-bold">Room Image 2</label>
            <input type="file" name="picture" class="form-control">
            <img src="../uploads/rooms/<?php echo $room_image2 ?>" alt="" class="img">
        </div>

        <!-- Room Price -->
        <div class="form-outline mb-4 w-50 m-auto">
            <label for="price" class="form-label fw-bold">Room Price Per Day</label>
            <input type="text" value="<?php echo $room_price ?>" name="price" class="form-control">
        </div>

        <!-- Button -->
        <div class="form-outline mb-4 w-50 m-auto">
            <input type="submit" name="edit_rooms" class="btn btn-dark text-white mb-3 px-3" value="Update Room">
        </div>
    </form>
</div>

<?php

if (isset($_POST['edit_rooms'])) {
    $room_title = $_POST['name'];
    $room_desc = $_POST['description'];
    $room_keywords = $_POST['keywords'];
    $room_price = $_POST['price'];

    $room_image11 = $_FILES['image']['name'];
    $room_image22 = $_FILES['picture']['name'];

    $temp_image11 = $_FILES['image']['tmp_name'];
    $temp_image22 = $_FILES['picture']['tmp_name'];

    if ($room_image11 == '') {
        $room_image11 = $room_image1;
        $temp_image11 = $_FILES['image']['tmp_name'];
    }
    if ($room_image22 == '') {
        $room_image22 = $room_image2;
        $temp_image22 = $_FILES['picture']['tmp_name'];
    }

    move_uploaded_file($temp_image11, "../uploads/rooms/$room_image11");
    move_uploaded_file($temp_image22, "../uploads/rooms/$room_image22");

    $update_room = "UPDATE `rooms` SET 
        Name='$room_title',
        Description='$room_desc',
        Keywords='$room_keywords',
        Image='$room_image11', 
        Image2='$room_image22',
        Price='$room_price'
        WHERE room_id=$edit_id";

    if (mysqli_query($con, $update_room)) {
        echo "<script>alert('Room Updated Successfully!')</script>";
        echo "<script>window.open('./admin.php?view_rooms.php', '_self')</script>";
    } else {
        echo "ERROR: Could not able to execute " . mysqli_error($con);
    }
}

?>
