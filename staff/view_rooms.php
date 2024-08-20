<?php
include_once('../functions/common_function.php');
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
    



<h3 class="text-center py-4 text-dark fs-4 fw-bold text-uppercase border-bottom"><i class="bi bi-house-check-fill fa-2x"></i> Available Rooms</h3>
<table class="table table-bordered border-dark mt-5">
    <thead class="bg-dark text-center text-light">
        <tr>
            <th>S.No.</th>
            <th>Room Name</th>
            <th>Room Description</th>
            <th>Room Image</th>
            <th>Room Status</th>
            <th>Room Booking Price</th>
            <th colspan="2">Operations</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $user_id=get_user_id_staff();
            $pic = "SELECT * FROM `rooms` where user_id='$user_id'";
            $result_select=mysqli_query($con,$pic);
        if (mysqli_num_rows($result_select) > 0) {
                 
            $number=0;

            while($row = mysqli_fetch_array($result_select)){
                $room_id=$row['room_id'];
                $room_title = $row['Name'];
                $room_description = $row['Description'];
                $room_image1 = $row['Image'];
                $room_image2 = $row['Image2'];
                $room_price = $row['Price'];
                $number++;
                    echo "<tr class='text-center'>
                    <td>$number</td>
                    <td>$room_title</td>
                    <td>$room_description</td>
                    <td><img src='../uploads/rooms/$room_image1' class='img' alt='$room_title'></td>
                    <td><img src='../uploads/rooms/$room_image2' class='img' alt='$room_title'></td>
                    <td>Rs.$room_price/-</td>
                    <td><a href='staff.php?edit_rooms=$room_id' class='text-dark'><i class='fas fa-edit text-dark'></i></a></td>
                    <td><a href='staff.php?delete_rooms=$room_id' class='text-dark'><i class='fas fa-trash'></i></a></td>

                    </tr>";
            
                ?>
                
<?php
            }
        } else{
            echo "No Rooms Added :(";
        }
        

?>        
    </tbody>
</table>