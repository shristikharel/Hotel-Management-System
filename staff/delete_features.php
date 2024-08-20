<?php
include('config.php');

if (isset($_GET['delete_features'])) {
    $delete_id = $_GET['delete_features'];

    // Delete query from the 'features' table
    $delete_query = "DELETE FROM `features` WHERE feature_id = $delete_id";
    $result_delete = mysqli_query($con, $delete_query);

    if ($result_delete) {
        echo "<script>alert('Feature Deleted Successfully!')</script>";
        echo "<script>window.open('./staff.php?view_features', '_self')</script>";
    } else {
        echo "<script>alert('Error deleting feature: " . mysqli_error($con) . "')</script>";
    }
}
?>
