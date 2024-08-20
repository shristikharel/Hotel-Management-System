<?php
include('config.php');

if (isset($_GET['delete_facility'])) {
    $delete_id = $_GET['delete_facility'];

    // Delete query from the 'facilities' table
    $delete_query = "DELETE FROM `facilities` WHERE facility_id = $delete_id";
    $result_delete = mysqli_query($con, $delete_query);

    if ($result_delete) {
        echo "<script>alert('Facility Deleted Successfully!')</script>";
        echo "<script>window.open('./admin.php?view_facilities', '_self')</script>";
    } else {
        echo "<script>alert('Error deleting facility: " . mysqli_error($con) . "')</script>";
    }
}
?>
