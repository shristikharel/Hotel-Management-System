<?php
require('../admin/config.php');
require('../inc/links.php');
require('../functions/common_function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shristi - ROOMS</title>
    <style>
        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card .btn {
            font-size: 0.8rem;
        }

        .img {
            object-fit: contain;
            height: 100px;
            width: 100px;
        }

        .text-red {
            color: red;
        }

        .text-green {
            color: green;
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
</head>

<body class="bg-light">
    <!-- header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><strong> WELCOME </strong><?php echo $_SESSION['cust_name'] ?></a>
            <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active me-2" aria-current="page" href="index.php">Home</a>
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

    <!-- Start of Booking History Table -->
    <div class="container mt-5">
        <h2 class="fw-bold h-font text-center"><?php echo $_SESSION['cust_name'] ?>'s Booking History</h2>
        <div class="h-line bg-dark"></div>

        <div class="table-responsive mt-4">
            <table class="table table-bordered border-dark mx-auto">
                <thead class="bg-dark text-center text-light">
                    <tr>
                        <th>Room Name</th>
                        <th>Room Image</th>
                        <th>Check In Date</th>
                        <th>Check Out Date</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th> <!-- Added a new column for the Review button -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    global $con;
                    $user_id = get_user_id_fromsession();
                    $cart_query = "SELECT rooms.room_id, booking_id, Name, Image, checkindate, checkoutdate, price, status,
                                    DATEDIFF(checkoutdate, checkindate) * price as room_price
                                    FROM `book_details`, `rooms` 
                                    WHERE book_details.room_id=rooms.room_id AND book_details.user_id=$user_id";
                    $result = mysqli_query($con, $cart_query);
                    $result_count = mysqli_num_rows($result);
                    if ($result_count > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $room_id = $row['room_id'];
                            $room_title = $row['Name'];
                            $room_image1 = $row['Image'];
                            $checkindate = $row['checkindate'];
                            $checkoutdate = $row['checkoutdate'];
                            $renting_price = $row['room_price'];
                            $status = $row['status'];

                            echo "<tr>
                                    <td class='text-center'>$room_title</td>
                                    <td class='text-center'><img src='../uploads/rooms/$room_image1' alt='' class='img'></td>
                                    <td class='text-center'>$checkindate</td>
                                    <td class='text-center'>$checkoutdate</td>
                                    <td class='text-center'>रु $renting_price/-</td>
                                    <td class='text-center'>";

                            // Display status based on the value in the 'status' column
                            if ($status == 'approved') {
                                echo "<span class='text-green'><i class='bi bi-calendar-check-fill'></i></span> Booked";
                            } elseif ($status == 'cancelled') {
                                echo "<span class='text-red'><i class='bi bi-calendar-x-fill'></i></span> Cancelled";
                            } elseif ($status == 'pending') {
                                echo "<span class='text-red'><i class='bi bi-calendar-x-fill'></i></span> Pending";
                            }

                            echo "</td>
                                    <td class='text-center'>";

                            // Display Review button only if the status is 'approved'
                            if ($status == 'approved') {
                                echo "<a href='review.php?room_id=" . $room_id . "' class='btn btn-success'>Review</a><br>";
                                echo "<a href='complaint.php?room_id=" . $room_id . "' class='btn btn-danger mt-3'>Submit a Complaint</a>";
                            }

                            echo "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center'>Booking List Is Empty!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End of Booking History Table -->



</body>
<!-- footer -->
<?php require('../inc/footer.php') ?>

</html>
