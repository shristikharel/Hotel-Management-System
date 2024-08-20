<?php

if(isset($_GET['delete_rooms'])){
    $delete_id=$_GET['delete_rooms'];
    // echo $delete_id;
    //delete query
    $delete_query="Delete from `rooms` where room_id=$delete_id";
    $result_product=mysqli_query($con,$delete_query);
    if($result_product){
        echo "<script>alert('Room Deleted Successfully!')</script>";
        echo "<script>window.open('./admin.php?view_room', '_self')</script>";
    }
}

?>
