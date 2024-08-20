<?php

include 'config.php';
include('../functions/common_function.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .img{
            object-fit: contain;
            height: 100px;
            width: 100px;
        }
    </style>
</head>
<body>

<h3 class="text-center py-4 text-warning fs-4 fw-bold text-uppercase border-bottom"><i class="fas fa-edit fa-2x text-warning"></i> PENDING BOOKINGS</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-dark text-light text-center">
        <tr>
            <th>User ID</th>
            <th>User Email</th>
            <th>Room Name</th>
            <th>Room Image</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Price</th>
            <th>Status</th>
            <th colspan="2">Operations</th>
        </tr>
    </thead>
    <?php
    $query = "Select booking_id, book_details.user_id, email, Name, Image,  checkindate, checkoutdate, 
    DATEDIFF(checkoutdate, checkindate) * price as room_price, book_details.status
    from `book_details`, `rooms` 
    where book_details.room_id=rooms.room_id AND book_details.status='pending'";
$result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) { ?>
    <tbody class="text-center">
    <tr>
    <td><?php echo $row['user_id'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td><?php echo $row['Name'] ?></td>
    <td><?php echo "<img src='../uploads/rooms/{$row['Image']}' class='img' alt='{$row['Name']}'>" ?></td>
    <td><?php echo $row['checkindate'] ?></td>
    <td><?php echo $row['checkoutdate'] ?></td>
    <td>रु <?php echo $row['room_price'] ?></td> 
    <td><?php echo $row['status'] ?></td> 
    
    
    <td>
        <form action="admin.php?view_bookings" method="POST">
        <button type='submit' name='approve' value= <?php echo $row['booking_id'] ?>>Approve</button>
        <button type='submit' name='cancel' value=<?php echo $row['booking_id'] ?>>Cancel</button>
        </form>
    </td>
<?php
        }
    }else{
        echo "No Pending Requests!";
    }
?>

</table>
<?php
if(isset($_POST['approve']) && intval($_POST['approve'])){
    $booking_id = $_POST['approve'];
    // echo "<script>alert('$user_id')</script>";
    $update = "UPDATE book_details set status = 'approved' where booking_id = '$booking_id'";
    $result = mysqli_query($con, $update);
    
        
        if ($result===TRUE) {
            sendConfirmationEmail($booking_id);
            echo "<meta http-equiv='refresh' content='0'>";
    }
    else{
        echo "Not Updated!";
    }
}


if(isset($_POST['cancel']) && intval($_POST['cancel'])){
    $booking_id = $_POST['cancel'];
    $cancel = "UPDATE book_details set status = 'cancelled' where booking_id = '$booking_id'";
    $result = mysqli_query($con, $cancel);
    
        
        if ($result===TRUE) {
            sendCancellationEmail($booking_id);
            echo "<meta http-equiv='refresh' content='0'>";
    }
    else{
        echo "Not Cancelled!";
    }
    
}
?>






<h3 class="text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i class="fas fa-check-circle fa-2x"></i> APPROVED BOOKINGS</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-dark text-light text-center">
        <tr>
            <th>User ID</th>
            <th>User Email</th>
            <th>Room Name</th>
            <th>Room Image</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Price</th>
            <th>Status</th>
            
        </tr>
    </thead>
    <?php
    $query = "Select booking_id, book_details.user_id, email, Name, Image, checkindate, checkoutdate, 
    DATEDIFF(checkoutdate, checkindate) * price as room_price, book_details.status
        from `book_details`, `rooms` 
        where book_details.room_id=rooms.room_id AND book_details.status='approved'";
$result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) { ?>
    <tbody class="text-center">
    <tr>
    <td><?php echo $row['user_id'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td><?php echo $row['Name'] ?></td>
    <td><?php echo "<img src='../uploads/rooms/{$row['Image']}' class='img' alt='{$row['Name']}'>" ?></td>
    <td><?php echo $row['checkindate'] ?></td>
    <td><?php echo $row['checkoutdate'] ?></td>
    <td>रु <?php echo $row['room_price'] ?></td> 
    <td><?php echo $row['status'] ?></td> 
<?php
        }
    }else{
        echo "No Approved Bookings till Date!";
    }
?>
</table>
<h3 class="text-center py-4 text-danger fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-x-circle-fill fa-2x text-danger"></i> CANCELLED BOOKINGS</h3>
<table class="table table-bordered mt-5">
    <thead class="bg-dark text-light text-center">
        <tr>
            <th>User ID</th>
            <th>User Email</th>
            <th>Room Name</th>
            <th>Room Image</th>
            <th>Check In Date</th>
            <th>Check Out Date</th>
            <th>Price</th>
            <th>Status</th>
            
        </tr>
    </thead>
    <?php
    $query = "Select booking_id, book_details.user_id, email, Name, Image, checkindate, checkoutdate, 
    DATEDIFF(checkoutdate, checkindate) * price as room_price, book_details.status
        from `book_details`, `rooms` 
        where book_details.room_id=rooms.room_id AND book_details.status='cancelled'";
$result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) { ?>
    <tbody class="text-center">
    <tr>
    <td><?php echo $row['user_id'] ?></td>
    <td><?php echo $row['email'] ?></td>
    <td><?php echo $row['Name'] ?></td>
    <td><?php echo "<img src='../uploads/rooms/{$row['Image']}' class='img' alt='{$row['Name']}'>" ?></td>
    <td><?php echo $row['checkindate'] ?></td>
    <td><?php echo $row['checkoutdate'] ?></td>
    <td>रु <?php echo $row['room_price'] ?></td> 
    <td><?php echo $row['status'] ?></td> 
<?php
        }
    }else{
        echo "No Cancelled Bookings till Date!";
    }
?>
</table>
