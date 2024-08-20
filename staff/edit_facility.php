<?php
include('../admin/config.php');
include_once('../functions/common_function.php');

if (isset($_GET['edit_facility'])) {
    $facility_id = $_GET['edit_facility'];

    // Retrieve facility details from the database
    $select_query = "SELECT * FROM `facilities` WHERE `facility_id` = '$facility_id' AND `user_id` = '" . get_user_id_staff() . "'";
    $result_select = mysqli_query($con, $select_query);

    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $facility_title = $row['facility_title'];
        $facility_image = $row['facility_image'];
    } else {
        echo "<script>alert('Facility not found!')</script>";
        echo "<script>window.open('./staff.php?view_facilities', '_self')</script>";
        exit();
    }
} else {
    // Redirect to the facility list page if no facility ID is provided
    echo "<script>window.open('./staff.php?view_facilities', '_self')</script>";
    exit();
}

if (isset($_POST['update_facility'])) {
    $new_facility_title = $_POST['fac_title'];

    // Handle image update
    if ($_FILES['fac_image']['size'] > 0) {
        // Handle image upload
        $upload_dir = '../uploads/facilities/';
        $new_facility_image = $upload_dir . basename($_FILES['fac_image']['name']);
        move_uploaded_file($_FILES['fac_image']['tmp_name'], $new_facility_image);
    } else {
        // Keep the existing image if no new image is provided
        $new_facility_image = $facility_image;
    }

    // Update facility in the database
    $update_query = "UPDATE `facilities` SET `facility_title` = '$new_facility_title', `facility_image` = '$new_facility_image' WHERE `facility_id` = '$facility_id'";
    $result_update = mysqli_query($con, $update_query);

    if ($result_update) {
        echo "<script>alert('Facility has been updated successfully')</script>";
        echo "<script>window.open('./staff.php?view_facilities', '_self')</script>";
    } else {
        echo "<script>alert('Error updating facility: " . mysqli_error($con) . "')</script>";
    }
}
?>

<!-- Your HTML form for editing facilities with image -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .img {
        object-fit: contain;
        height: 100px;
        width: 100px;
    }
</style>
<h2 class="text-center"><i class="bi bi-arrow-down-circle-fill"></i> Edit Facility</h2>
<form action="" method="post" class="mb-2" enctype="multipart/form-data">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-dark text-white" id="basic-addon1"><i class="bi bi-receipt"></i></span>
        <input type="text" class="form-control" name="fac_title" placeholder="Edit Facility Title" aria-label="facilities" aria-describedby="basic-addon1" required="required" value="<?php echo $facility_title; ?>">
    </div>
    <div class="input-group w-90 mb-2">
    <img src="../uploads/facilities/<?php echo $facility_image; ?>" class="img" alt="<?php echo $facility_title; ?>">
        <input type="file" class="form-control" name="fac_image" accept="image/*">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-dark text-white border-0 p-2 my-3" name="update_facility" value="Update Facility">
    </div>
</form>

<!-- Your additional styling and facility list table can be included here -->
