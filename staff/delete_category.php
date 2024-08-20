<?php
if(isset($_GET['delete_category'])){
    $delete_id = $_GET['delete_category'];
    
    // Delete query
    $delete_query = "DELETE FROM `categories` WHERE id = $delete_id";
    
    $result_category = mysqli_query($con, $delete_query);
    
    if($result_category){
        echo "<script>alert('Category Deleted Successfully!')</script>";
        echo "<script>window.open('./staff.php?view_rooms', '_self')</script>";
    } else {
        echo "<script>alert('Error deleting category: " . mysqli_error($con) . "')</script>";
    }
}
