<?php

require('../admin/config.php');
require('../inc/links.php');
require('../functions/common_function.php');

if (isset($_POST['delete'])) {
    $booking_id_to_delete = $_POST['booking_id'];

    // Perform the deletion query
    $delete_query = "DELETE FROM book_details WHERE booking_id = '$booking_id_to_delete'";
    $delete_result = mysqli_query($con, $delete_query);

    if ($delete_result) {
        echo "Booking removed successfully!";

    } else {
        // An error occurred during deletion
        echo "Error removing booking!";
    }
}

if (isset($_POST['book_now'])) {
    $user_id = get_user_id_fromsession();
    $room_id = $_POST['room_id'];
    $email = user_email();
    $checkin_date = $_POST['checkin'];
    $checkout_date = $_POST['checkout'];

    // Start a transaction
    mysqli_begin_transaction($con);

}

function get_room_id_from_booking_id($booking_id) {
    global $con;
    $booking_query = "SELECT room_id FROM book_details WHERE booking_id = '$booking_id'";
    $booking_result = mysqli_query($con, $booking_query);

    if ($booking_result && mysqli_num_rows($booking_result) > 0) {
        $row = mysqli_fetch_assoc($booking_result);
        return $row['room_id'];
    } else {
        // Handle the case where the booking_id is not found or an error occurs
        return null;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS</title>
    <?php require('../inc/links.php') ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <style>
        body {
            padding: 20px;
        }

        .img {
            object-fit: contain;
            height: 100px;
            width: 100px;
        }

        .table-container {
            margin: 0 auto;
            border: 1px solid #ddd; /* Add border on all sides */
            padding: 20px;
            max-width: 800px; /* Adjust the maximum width as needed */
        }

        .booked {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .booked th,
        .booked td {
            border: 1px solid #ddd; /* Add border on all sides */
            padding: 8px;
            text-align: left;
        }

        .bookend {
            margin-top: 20px;
            text-align: center;
        }

        .continue {
            padding: 10px 20px;
            background-color: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-right: 10px; /* Add margin to create space between buttons */
        }
        .custom-btn {
    color: black;
    text-decoration: none;
  }

  /* Styles for hover effect */
  .custom-btn:hover {
    color: white !important;
  }
    </style>
    <!-- header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top" style="margin-bottom: 20px;">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><strong> WELCOME </strong><?php echo $_SESSION['cust_name'] ?></a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active me-2" aria-current="page" href="userindex.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="facilities.php">Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="book_details.php"><i class="bi bi-building-check"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="book.php">Booking History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>

                </ul>
                <div class="d-flex">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2 custom-btn" data-bs-toggle="modal" data-bs-target="#loginModal" style="color: black; text-decoration: none;">
                        <a href="../admin/logout.php" style="color: inherit; text-decoration: none;">Logout</a>
                    </button>


                </div>
            </div>
        </div>
    </nav>
    <!-- end of header -->
</head>

<body>
    <div class="row">
        <div class="md col-12 table-container">
            <!-- Booking Details Table -->
            <form action="book_details.php" method="POST">
                <table class="booked">
                    <thead>
                        <!-- displaying dynamic data -->
                        <?php
                        global $con;
                        $user_id = get_user_id_fromsession();
                        $cart_query = "SELECT rooms.room_id, booking_id, Name, Image, checkindate, checkoutdate, price, 
                            DATEDIFF(checkoutdate, checkindate) * price as room_price
                            FROM `book_details`, `rooms` 
                            WHERE book_details.room_id = rooms.room_id 
                            AND book_details.user_id = $user_id
                            AND (status = 'approved' OR status = 'pending')";
                        $result = mysqli_query($con, $cart_query);
                        $result_count = mysqli_num_rows($result);
                        if (mysqli_num_rows($result) > 0) {
                            echo "<tr>
                                <th>Room Name</th>
                                <th>Room Image</th>
                                <th>Check In Date</th>
                                <th>Check Out Date</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>";
                            while ($row = mysqli_fetch_assoc($result)) {
                                $room_id = $row['room_id'];
                                $room_title = $row['Name'];
                                $room_image1 = $row['Image'];
                                $checkindate = $row['checkindate'];
                                $checkoutdate = $row['checkoutdate'];
                                $renting_price = $row['room_price'];
                                $price = $row['price'];
                                $booking_id = isset($row['booking_id']) ? $row['booking_id'] : '';
                        ?>
                                <tr>
                                    <td><?php echo $room_title ?></td>
                                    <td><img src="../uploads/rooms/<?php echo $room_image1 ?>" alt="" class="img"></td>
                                    <td><?php echo $checkindate ?></td>
                                    <td><?php echo $checkoutdate ?></td>
                                    <td>रु <?php echo $renting_price ?>/-</td>
                                    <td>
                                        <form action="book.php" method="POST">
                                            <input type="hidden" name="booking_id" value="<?php echo $booking_id ?>">
                                            <button type="submit" name="delete" class="continue">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                            echo "</tbody>";
                        } else {
                            echo "<h2 style='text-align:center;'>Booking List Is Empty!</h2>";
                        }
                        ?>
                </table>

                <div class="bookend">
                    <?php
                    $user_id = get_user_id_fromsession();
                    $cart_query = "SELECT Name, Image, checkindate, checkoutdate, DATEDIFF(checkoutdate,checkindate)*price*0.0076 as room_price
                                    FROM `book_details`, `rooms` 
                                    WHERE book_details.room_id=rooms.room_id AND book_details.user_id=$user_id";
                    $result = mysqli_query($con, $cart_query);
                    $result_count = mysqli_num_rows($result);

                    if (mysqli_num_rows($result) > 0) {
                        echo "<form action='rooms.php' method='POST' style='display: inline-block;'>
                                <input type='submit' value='Continue Booking' class='continue' name='continue_booking'>
                            </form>
                            <form action='checkout.php' method='POST' style='display: inline-block;'>
                                <input type='submit' value='Checkout' class='continue' name='checkout'>
                            </form>";
                    } else {
                        echo "<form action='rooms.php' method='POST'>
                                <input type='submit' value='Continue Booking' class='continue' name='continue_booking'>
                            </form>";
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
