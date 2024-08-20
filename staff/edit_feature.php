<?php
include('../admin/config.php');
include_once('../functions/common_function.php');

if (isset($_GET['edit_features'])) {
    $feature_id = $_GET['edit_features'];

    // Retrieve feature details from the database
    $select_query = "SELECT * FROM `features` WHERE `feature_id` = '$feature_id' AND `user_id` = '" . get_user_id_staff() . "'";
    $result_select = mysqli_query($con, $select_query);

    if ($result_select && mysqli_num_rows($result_select) > 0) {
        $row = mysqli_fetch_assoc($result_select);
        $feature_title = $row['feature_title'];
    } else {
        echo "<script>alert('Feature not found!')</script>";
        echo "<script>window.open('./staff.php?view_features', '_self')</script>";
        exit();
    }
} else {
    // Redirect to the feature list page if no feature ID is provided
    echo "<script>window.open('./staff.php?view_features', '_self')</script>";
    exit();
}

if (isset($_POST['update_feature'])) {
    $new_feature_title = $_POST['feat_title'];

    // Update feature in the database
    $update_query = "UPDATE `features` SET `feature_title` = '$new_feature_title' WHERE `feature_id` = '$feature_id'";
    $result_update = mysqli_query($con, $update_query);

    if ($result_update) {
        echo "<script>alert('Feature has been updated successfully')</script>";
        echo "<script>window.open('./staff.php?view_features', '_self')</script>";
    } else {
        echo "<script>alert('Error updating feature: " . mysqli_error($con) . "')</script>";
    }
}
?>

<!-- Your HTML form for editing features -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<h2 class="text-center"><i class="bi bi-arrow-down-circle-fill"></i> Edit Feature</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-dark text-white" id="basic-addon1"><i class="bi bi-receipt"></i></span>
        <input type="text" class="form-control" name="feat_title" placeholder="Edit Feature" aria-label="features" aria-describedby="basic-addon1" required="required" value="<?php echo $feature_title; ?>">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-dark text-white border-0 p-2 my-3" name="update_feature" value="Update Feature">
    </div>
</form>

<!-- Your additional styling and feature list table can be included here -->
